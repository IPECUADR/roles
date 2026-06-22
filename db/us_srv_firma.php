<?php
session_start();
header('Content-Type: application/json');
require_once '../sys/sys.conf.php';

$us = $_SESSION['user'] ?? null;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$us) {
    echo json_encode(['err' => true, 'msg' => 'Acceso no válido']);
    exit;
}

try {
    $sql = "
        SELECT acpetacion_user.*
        FROM acpetacion_user
        INNER JOIN persona
            ON persona.PK_persona = acpetacion_user.FK_persona
        WHERE
            acpetacion_user.FK_us_ser = 1
            AND persona.user_p = :us
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':us' => $us]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ❌ NO HAY ACEPTACIÓN
    if (!$data) {
        echo json_encode([
            'err' => true,
            'aceptado' => false,
            'msg' => 'Debe aceptar primero'
        ]);
        exit;
    }

    // ✅ YA ACEPTÓ
    echo json_encode([
        'err' => false,
        'aceptado' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'err' => true,
        'msg' => 'Error interno'
    ]);
}
