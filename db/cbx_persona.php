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
       
        PK_persona as id, 
       CONCAT(persona.nom_p, ' ', persona.ap_p) AS nm

     FROM 

            persona
      
    ORDER BY

            nm ASC



    ");


    $stmt->execute();

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
