<?php
session_start();

header('Content-Type: application/json');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

try {

    $stmt = $pdo->prepare("
        SELECT COUNT(PK_persona) AS total
        FROM persona
    ");

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

      echo json_encode($data);

      
} catch (Exception $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al obtener el total'
    ]);
}