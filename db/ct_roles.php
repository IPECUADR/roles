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
$us = $_SESSION['user'] ?? null;

// verficamos

try {
    $stmt = $pdo->prepare("



 SELECT 

      COUNT(rol_p.PK_rol) as t
  
  FROM 
  
        persona, 
        rol_p
    
     WHERE 
     
      persona.PK_persona = rol_p.FK_persona 
      and persona.user_p= :us



    ");


     $stmt->execute([


        ':us'    => $us
       

        
    ]);

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
