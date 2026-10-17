<?php
header('Content-Type: application/json');
session_start();

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido',
        'icon' => 'error'
    ]);
    exit;
}

// Conexión
require_once '../sys/sys.valoracion.php';

$id  = $_POST['id'] ?? null;
$res = $_POST['valor'] ?? null;
$us  = $_SESSION['user'] ?? null;

// Validar datos
if ($id === null || $id === '' ||
    $res === null || $res === '' ||
    !$us) {

    echo json_encode([
        'err' => true,
        'msg' => 'Datos incompletos',
        'icon' => 'error'
    ]);
    exit;
}

// Validar calificación
if (!is_numeric($res) || 
    !ctype_digit((string)$res) ||
    (int)$res < 0 || (int)$res > 100) {

    echo json_encode([
        'err' => true,
        'msg' => 'La calificación debe ser un número entero entre 0 y 100.',
        'icon' => 'warning'
    ]);
    exit;
}

try {

    $stmt = $pdo->prepare("
        UPDATE ev_v_des
        SET
            rp_ev_v_ds = :res,
            user_aut_up_ev = :us,
            FK_est_ev = 1,
            fc_aut_up_ev = NOW()
        WHERE PK_aut_ev_v_des = :id
    ");

    $stmt->execute([
        ':id'  => $id,
        ':res' => (int)$res,
        ':us'  => $us
    ]);

    if ($stmt->rowCount() === 0) {
        echo json_encode([
            'err' => true,
            'msg' => 'No se actualizó ningún registro. Verifica la respuesta o si ya estaba guardada.',
            'icon' => 'warning'
        ]);
        exit;
    }

    echo json_encode([
        'err' => false,
        'msg' => 'Respuesta guardada correctamente.',
        'icon' => 'success'
    ]);

} catch (Throwable $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al procesar la solicitud.',
        'icon' => 'error'
    ]);
}
