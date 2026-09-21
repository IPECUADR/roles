<?php

header('Content-Type: application/json');
session_start();

/* ========= VALIDAR MÉTODO ========= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err'  => true,
        'msg'  => 'Método no permitido',
        'icon' => 'warning'
    ]);
    exit;
}

/* ========= CONEXIÓN ========= */
require_once '../sys/sys.post.php';

/* ========= SESIÓN ========= */
$us      = $_SESSION['user'] ?? null;
$id_user = $_SESSION['pk_p'] ?? null;
$usuario = $_SESSION['usuario'] ?? 'Usuario desconocido';

/* ========= VALIDAR SESIÓN ========= */
if (!$us || !$id_user) {
    echo json_encode([
        'err'  => true,
        'msg'  => 'Sesión no válida',
        'icon' => 'warning'
    ]);
    exit;
}

/* ========= VALIDAR ID ========= */
$pk = $_POST['id_postulacion'];

$st = $_POST['st'];


if (!$pk) {
    echo json_encode([
        'err'  => true,
        'msg'  => 'ID de postulación no válido',
        'icon' => 'warning'
    ]);
    exit;
}

/* ========= OBTENER IP ========= */
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';

try {

    $sql = "
        UPDATE p_postulacion
        SET
            est_postulacion = :st,
            us_aut_post = :usuario,
            fc_up_aut_post = NOW()
        WHERE PK_postulacion  = :id
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':usuario' => $usuario,
        ':id'      => $pk, 
        ':st'      => $st
    ]);

    /* ========= VALIDAR ACTUALIZACIÓN ========= */
    if ($stmt->rowCount() === 0) {

        echo json_encode([
            'err'  => true,
            'msg'  => 'No se encontró la postulación o ya fue actualizada'.$pk,
            'icon' => 'warning'
        ]);

        exit;
    }

    echo json_encode([
        'err'  => false,
        'msg'  => 'Postulación actualizada correctamente',
        'icon' => 'success'
    ]);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err'  => true,
        'msg'  => 'No fue posible actualizar la postulación'.$pk,
        'icon' => 'error'
    ]);
}