<?php

header('Content-Type: application/json; charset=utf-8');

// ========================================
// BLOQUEAR ACCESO DIRECTO
// ========================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido',
        'icon' => 'error'
    ]);

    exit;
}

// ========================================
// CONEXIÓN
// ========================================

require_once '../sys/sys.post.php';

// ========================================
// DATOS FTP
// ========================================

$ftp_server = "200.105.244.50";
$ftp_user   = "Administrador";
$ftp_pass   = "@Kde.2024";
$ftp_ruta   = "/DOC/ACTIVIDADES/";

// ========================================
// DATOS DEL FORMULARIO
// ========================================

$plaza      = $_POST['cargo'] ?? null;
$postulante = $_POST['id'] ?? null;

// ========================================
// VALIDACIONES
// ========================================

if (!$plaza) {

    echo json_encode([
        'err' => true,
        'msg' => 'No se recibió la plaza',
        'icon' => 'warning'
    ]);

    exit;
}

if (!$postulante) {

    echo json_encode([
        'err' => true,
        'msg' => 'No se recibió el postulante',
        'icon' => 'warning'
    ]);

    exit;
}

if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {

    echo json_encode([
        'err' => true,
        'msg' => 'No se recibió correctamente el CV',
        'icon' => 'warning'
    ]);

    exit;
}

// ========================================
// DATOS DEL ARCHIVO
// ========================================

$archivoOriginal = $_FILES['cv']['name'];
$tmpArchivo      = $_FILES['cv']['tmp_name'];
$tamanoArchivo   = $_FILES['cv']['size'];

$extension = strtolower(
    pathinfo($archivoOriginal, PATHINFO_EXTENSION)
);

// ========================================
// VALIDAR PDF
// ========================================

if ($extension !== 'pdf') {

    echo json_encode([
        'err' => true,
        'msg' => 'Solo se permiten archivos PDF',
        'icon' => 'warning'
    ]);

    exit;
}

// ========================================
// VALIDAR TAMAÑO
// ========================================

// Máximo 5 MB
$maxSize = 5 * 1024 * 1024;

if ($tamanoArchivo > $maxSize) {

    echo json_encode([
        'err' => true,
        'msg' => 'El archivo supera los 5 MB permitidos',
        'icon' => 'warning'
    ]);

    exit;
}

// ========================================
// CARPETA LOCAL CV
// ========================================

$directorioCV = __DIR__ . '/../cv/';

if (!is_dir($directorioCV)) {

    if (!mkdir($directorioCV, 0775, true)) {

        echo json_encode([
            'err' => true,
            'msg' => 'No se pudo crear la carpeta CV',
            'icon' => 'error'
        ]);

        exit;
    }
}

// ========================================
// VALIDAR POSTULACIÓN EXISTENTE
// ========================================

try {

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

        echo json_encode([
            'err' => true,
            'msg' => 'Ya has postulado a esta plaza anteriormente',
            'icon' => 'warning'
        ]);

        exit;
    }

    // ========================================
    // GENERAR NOMBRE
    // ========================================

    $codigoCV = 'CV_' .
                date('YmdHis') . '_' .
                $postulante . '_' .
                bin2hex(random_bytes(5)) .
                '.pdf';

    // ========================================
    // RUTA LOCAL
    // ========================================

    $rutaLocal = $directorioCV . $codigoCV;

    // ========================================
    // GUARDAR LOCALMENTE
    // ========================================

    if (!move_uploaded_file($tmpArchivo, $rutaLocal)) {

        echo json_encode([
            'err' => true,
            'msg' => 'No se pudo guardar el CV localmente',
            'icon' => 'error'
        ]);

        exit;
    }

    // ========================================
    // CONECTAR FTP
    // ========================================

    if (!function_exists('ftp_connect')) {

        // Eliminar archivo local si FTP no está disponible
        if (file_exists($rutaLocal)) {
            unlink($rutaLocal);
        }

        echo json_encode([
            'err' => true,
            'msg' => 'La extensión FTP de PHP no está habilitada en el servidor',
            'icon' => 'error'
        ]);

        exit;
    }

    $conn_id = ftp_connect($ftp_server);

    if (!$conn_id) {

        if (file_exists($rutaLocal)) {
            unlink($rutaLocal);
        }

        echo json_encode([
            'err' => true,
            'msg' => 'No se pudo conectar al servidor FTP',
            'icon' => 'error'
        ]);

        exit;
    }

    // ========================================
    // LOGIN FTP
    // ========================================

    if (!ftp_login($conn_id, $ftp_user, $ftp_pass)) {

        ftp_close($conn_id);

        if (file_exists($rutaLocal)) {
            unlink($rutaLocal);
        }

        echo json_encode([
            'err' => true,
            'msg' => 'No se pudo iniciar sesión en el servidor FTP',
            'icon' => 'error'
        ]);

        exit;
    }

    // ========================================
    // MODO PASIVO
    // ========================================

    ftp_pasv($conn_id, true);

    // ========================================
    // RUTA REMOTA
    // ========================================

    $rutaRemota = $ftp_ruta . $codigoCV;

    // ========================================
    // SUBIR AL FTP
    // ========================================

    $subida = ftp_put(
        $conn_id,
        $rutaRemota,
        $rutaLocal,
        FTP_BINARY
    );

    ftp_close($conn_id);

    // ========================================
    // VALIDAR SUBIDA
    // ========================================

    if (!$subida) {

        if (file_exists($rutaLocal)) {
            unlink($rutaLocal);
        }

        echo json_encode([
            'err' => true,
            'msg' => 'No se pudo subir el CV al servidor FTP',
            'icon' => 'error'
        ]);

        exit;
    }

    // ========================================
    // INSERTAR POSTULACIÓN
    // ========================================

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

    // ========================================
    // RESPUESTA
    // ========================================

    echo json_encode([
        'err' => false,
        'msg' => 'Postulación registrada correctamente',
        'archivo' => $codigoCV,
        'icon' => 'success'
    ]);

} catch (PDOException $e) {

    // Eliminar archivo local si algo falla en BD
    if (isset($rutaLocal) && file_exists($rutaLocal)) {
        unlink($rutaLocal);
    }

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'No se pudo registrar la postulación',
        'icon' => 'error'
    ]);
}

