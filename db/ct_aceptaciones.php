<?php
session_start();

header('Content-Type: application/json');

// Bloquear acceso directo opcional
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true]);
    exit;
}

// lalamamos a la conexion
require_once '../sys/sys.conf.php';




$inicio = date('Y-m-01') . ' 00:00:00';
$fin = date('Y-m-t') . ' 23:59:59';

// verficamos

try {
     $stmt = $pdo->prepare("

SELECT 

   COUNT(acpetacion_user.PK_acptacion) as total
  
  FROM 
  
        acpetacion_user
   
   WHERE
   
       FK_us_ser = 2


    ");



  $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
