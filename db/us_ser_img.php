<?php
session_start();
header('Content-Type: application/json');
require_once '../sys/sys.conf.php';

$us = $_SESSION['user'] ?? null;
$id = $_SESSION['pk_p'] ?? null;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$us) {
    echo json_encode([
        'err' => true,
        'msg' => 'Acceso no válido'
    ]);
    exit;
}

try {
    $sql = "
        SELECT *
        FROM img_persona
        WHERE FK_persona = :id
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    /**
     * ❌ NO EXISTE REGISTRO
     */
    if (!$data) {
        echo json_encode([
            'err' => true,
            'code' => 'NO_ACEPTADO',
            'msg' => 'Debe aceptar primero'
        ]);
        exit;
    }

    /**
     * ⛔ EXISTE PERO ESTÁ DESACTIVADO
     * est_img_p = 0
     */
    if ((int)$data['est_img_p'] === 0) {
        echo json_encode([
            'err' => true,
            'code' => 'INHABILITADO',
            'msg' => 'Esta función está inhabilitada por seguridad'
        ]);
        exit;
    }

    /**
     * ✅ TODO CORRECTO
     */
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