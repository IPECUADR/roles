<?php
session_start();
header('Content-Type: application/json');
require_once '../sys/sys.conf.php';

$us = $_SESSION['user'] ?? null;
$id = $_SESSION['pk_p'] ?? null;
$imgId = $_POST['imgId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$us) {
    echo json_encode(['err' => true, 'msg' => 'Acceso no válido']);
    exit;
}

try {
    $sql = "
        SELECT *
        FROM img_persona
        
        WHERE
            img_persona.FK_img  = :imgId
            AND  FK_persona = :id

        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':imgId' => $imgId, ':id' => $id    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // ❌ NO HAY ACEPTACIÓN
    if (!$data) {
        echo json_encode([
            'err' => true,
            'aceptado' => false,
            'msg' => 'No se reconoce la imagen seleccionada'
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
