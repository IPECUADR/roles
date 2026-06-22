<?php
header('Content-Type: application/json');
session_start();

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

// Sesión
$us = $_SESSION['user'] ?? null;
$id = $_SESSION['pk_p'] ?? null;
$accion = $_POST['accion'] ?? 'Acción no definida';
$usuario = $_SESSION['usuario'] ?? 'Usuario desconocido';
$status =  $_POST['status'] ?? 'Desconocido';
if (!$us || !$id) {
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;
}

/* ========= OBTENER IP ========= */
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';


$ubicacion = 'No definida';

try {

    $sql = "
        INSERT INTO logs (
            user_log_aut,
            user_au_sesion_reg,
            accion_user_log,
            fc_user_log_aut,
            fc_user_dow_info,
            ip_acces,
            ub_user_acces, 
            status_log
     
        ) VALUES (
           :user,
           :usuario,
           :accion,
            NOW(),
            NOW(),
            :ip,
            :ubicacion,
            :status
        )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user'      => $us,
        ':ip'        => $ip,
        ':ubicacion' => $ubicacion,
        ':accion'    => $accion,
        ':usuario'   => $usuario, 
        ':status'    => $status

    ]);

    echo json_encode([
        'err'  => false,
        'msg'  => 'Acción registrada correctamente',
        'icon' => 'success'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}
