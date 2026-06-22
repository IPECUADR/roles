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
       
        PK_us_ser  as id,
        condicion_us_ser as con, 
        text_us_serv as text

     FROM 

            us_service
      
     WHERE 

           PK_us_ser = 3



    ");


    $stmt->execute();

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
