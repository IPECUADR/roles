<?php

header('Content-Type: application/json; charset=utf-8');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido'
    ]);
    exit;
}

// Conexión
require_once '../sys/sys.post.php';

// ===============================
// OBTENER DATOS
// ===============================

$plaza      = $_POST['cargo'] ?? null;
$postulante = $_POST['id'] ?? null;

// ===============================
// VALIDACIONES
// ===============================

if (!$plaza) {
    echo json_encode([
        'err' => true,
        'msg' => 'No se recibió la plaza'
    ]);
    exit;
}

if (!isset($_FILES['cv'])) {
    echo json_encode([
        'err' => true,
        'msg' => 'No se recibió el CV'
    ]);
    exit;
}

// ===============================
// CONFIGURAR CARPETA
// ===============================

$directorioCV = __DIR__ . '/../cv/';

if (!is_dir($directorioCV)) {
    mkdir($directorioCV, 0777, true);
}

// ===============================
// VALIDAR ARCHIVO
// ===============================

$archivoOriginal = $_FILES['cv']['name'];
$tmpArchivo      = $_FILES['cv']['tmp_name'];
$tamanoArchivo   = $_FILES['cv']['size'];

$extension = strtolower(pathinfo($archivoOriginal, PATHINFO_EXTENSION));

$permitidos = ['pdf'];

if (!in_array($extension, $permitidos)) {
    echo json_encode([
        'err' => true,
        'msg' => 'Solo se permiten archivos PDF'
    ]);
    exit;
}

// Máximo 5MB
$maxSize = 5 * 1024 * 1024;

if ($tamanoArchivo > $maxSize) {
    echo json_encode([
        'err' => true,
        'msg' => 'El archivo supera los 5 MB permitidos'
    ]);
    exit;
}

// ===============================
// GENERAR NOMBRE ÚNICO
// ===============================

$codigoCV = 'CV_' .
            date('YmdHis') . '_' .
            $postulante . '_' .
            bin2hex(random_bytes(5)) .
            '.pdf';

$rutaDestino = $directorioCV . $codigoCV;

// ===============================
// MOVER ARCHIVO
// ===============================

if (!move_uploaded_file($tmpArchivo, $rutaDestino)) {

    echo json_encode([
        'err' => true,
        'msg' => 'No se pudo guardar el archivo'
    ]);
    exit;
}

try {

    // ===============================
    // VALIDAR POSTULACIÓN EXISTENTE
    // ===============================

    $sqlValidar = "
        SELECT COUNT(*)
        FROM p_postulacion
        WHERE FK_postulante = :postulante
        AND FK_plaza = :plaza
    ";

    $stmtValidar = $pdo->prepare($sqlValidar);

    $stmtValidar->execute([
        ':postulante' => $postulante,
        ':plaza'      => $plaza
    ]);

    $existe = $stmtValidar->fetchColumn();

    if ($existe > 0) {

        unlink($rutaDestino);

        echo json_encode([
            'err' => true,
            'msg' => 'Ya has postulado a esta plaza anteriormente',
            'icon' => 'warning'
        ]);
        exit;
    }

    // ===============================
    // INSERTAR POSTULACIÓN
    // ===============================

    $sql = "
        INSERT INTO p_postulacion
        (
            FK_postulante,
            FK_plaza,
            fc_post_aut,
            est_postulacion,
            fc_up_aut_post,
            us_aut_post,
            cv_postulacion
        )
        VALUES
        (
            :postulante,
            :plaza,
            NOW(),
            :estado,
            NOW(),
            'N/A',
            :cv
        )
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':postulante' => $postulante,
        ':plaza'      => $plaza,
        ':estado'     => 1,
        ':cv'         => $codigoCV
    ]);

    echo json_encode([
        'err' => false,
        'msg' => 'Postulación registrada correctamente',
        'archivo' => $codigoCV,
        'icon' => 'success'
    ]);

} catch (PDOException $e) {

    if (file_exists($rutaDestino)) {
        unlink($rutaDestino);
    }

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'No se pudo registrar la postulación',
        'detalle' => $e->getMessage(),
        'icon' => 'error'
    ]);
}