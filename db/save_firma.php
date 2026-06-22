<?php
session_start();
header('Content-Type: application/json');

require_once '../sys/sys.conf.php';

if (!isset($_POST['imagen'])) {
    echo json_encode(['err' => true, 'msg' => 'No se recibió la imagen']);
    exit;
}

$idPersona = $_SESSION['pk_p'] ?? null;
$usuario   = $_SESSION['user'] ?? null;

if (!$idPersona || !$usuario) {
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;
}

/* ========= PROCESAR IMAGEN ========= */
$data = $_POST['imagen'];

$data = str_replace('data:image/png;base64,', '', $data);
$data = str_replace(' ', '+', $data);
$data = base64_decode($data);

if ($data === false) {
    echo json_encode(['err' => true, 'msg' => 'Imagen inválida']);
    exit;
}

// Crear carpeta si no existe
$carpeta = '../firmas';
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$nombre = 'firma_' . $idPersona . '_' . time() . '.png';
$ruta   = $carpeta . '/' . $nombre;

if (!file_put_contents($ruta, $data)) {
    echo json_encode(['err' => true, 'msg' => 'No se pudo guardar la imagen']);
    exit;
}

/* ========= IP Y UBICACIÓN ========= */
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';

$ubicacion = 'No definida';

/* ========= TRANSACCIÓN ========= */
try {
    $pdo->beginTransaction();

    // 1️⃣ UPDATE PERSONA (guardar firma)
    $sqlPersona = "
        UPDATE persona
            SET firm_p = :firma
            
        WHERE PK_persona = :id
    ";
    $stmt = $pdo->prepare($sqlPersona);
    $stmt->execute([
        ':firma' => $ruta,
        ':id'    => $idPersona
    ]);

    // 2️⃣ INSERT ACEPTACIÓN SERVICIO
    $sqlAceptacion = "
        INSERT INTO acpetacion_user (
            aceptacion_fromal,
            coments_acf,
            in_au_fc_acp,
            up_au_fc_acp,
            user_up_aut,
            ip_au_user,
            ub_au_user,
            FK_persona,
            FK_us_ser
        ) VALUES (
            'Acepto',
            'Se me compartió la información necesaria en el portal.',
            NOW(),
            NOW(),
            :usuario,
            :ip,
            :ubicacion,
            :persona,
            1
        )
    ";
    $stmt = $pdo->prepare($sqlAceptacion);
    $stmt->execute([
        ':usuario'   => $usuario,
        ':ip'        => $ip,
        ':ubicacion' => $ubicacion,
        ':persona'   => $idPersona
    ]);

    // ✅ Confirmar todo
    $pdo->commit();

    echo json_encode([
        'err'   => false,
        'msg'   => 'Firma guardada y aceptación registrada correctamente',
        'ruta'  => $ruta,
        'icon'  => 'success'
    ]);

} catch (Exception $e) {
   
error_log($e->getMessage());

echo json_encode([
    'err' => true,
    'msg' => 'Error al guardar la aceptación',
    'debug' => $e->getMessage() // 👈 AQUÍ SALE EL ERROR REAL
]);
exit;

}