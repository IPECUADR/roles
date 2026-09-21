<?php
header('Content-Type: application/json');

// Bloquear acceso directo opcional
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true]);
    exit;
}

// lalamamos a la conexion
require_once '../sys/sys.post.php';


$id = $_POST['valor'] ?? null;

// verficamos

try {
    $stmt = $pdo->prepare("




  SELECT 
       
        PK_canton   as id, 
        canton as c

     FROM 

            canton


      WHERE

            FK_provincia  = :id
      
    ORDER BY

            id ASC



    ");


    $stmt->execute([

         ':id' => $id

    ]);

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
