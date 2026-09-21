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
       
        PK_datos  as id, 
        text_us_datos as c, 
        t_text as t

     FROM 

            datos
      
   where

            PK_datos = 1


    ");


    $stmt->execute();

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
