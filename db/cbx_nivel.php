<?php
header('Content-Type: application/json');

// Bloquear acceso directo opcional
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true]);
    exit;
}

// lalamamos a la conexion
require_once '../sys/sys.post.php';

// verficamos

try {
    $stmt = $pdo->prepare("




  SELECT 
       
        PK_nivel   as id, 
        nivel_edu as nv

     FROM 

            nivel_educativo
      
    ORDER BY

            id ASC



    ");


    $stmt->execute();

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
