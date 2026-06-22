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

if (!$us || !$id) {
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;
}

/* ========= OBTENER IP ========= */
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';

/* ========= UBICACIÓN (placeholder simple) ========= */
/*
 * Para producción puedes usar:
 * - País / Ciudad desde frontend
 * - Servicio externo
 * Aquí guardamos algo básico
 */
$ubicacion = 'No definida';

try {

    $sql = "
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
            :user,
            :ip,
            :ubicacion,
            :persona,
            :servicio
        )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user'      => $us,
        ':ip'        => $ip,
        ':ubicacion' => $ubicacion,
        ':persona'   => $id,
        ':servicio'  => 2
    ]);

    echo json_encode([
        'err'  => false,
        'msg'  => 'Aceptación registrada correctamente',
        'icon' => 'success'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}
