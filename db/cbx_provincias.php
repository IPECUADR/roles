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
       
        PK_provincia  as id, 
        provincia as p

     FROM 

            provincia
      
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
