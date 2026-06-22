<?php
header('Content-Type: application/json');

// Bloquear acceso directo opcional
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true]);
    exit;
}

// lalamamos a la conexion
require_once '../sys/sys.conf.php';

// verficamos

try {
    $stmt = $pdo->prepare("




  SELECT 
       
        PK_mes as id, 
        mes as m

     FROM 

            mes
      
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
