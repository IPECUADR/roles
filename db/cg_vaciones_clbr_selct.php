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
$id = $_POST['bs']; 
if(!$id){

   
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;

}

// verficamos

try {
    $stmt = $pdo->prepare("



 SELECT 

     FK_vc as id,
     ROUND(dias_pendientes, 2) AS dp,
     ROUND(dias_gozados, 2) AS dg,
     ROUND(t_per_v, 2) AS t_vc,
     ob_vc, 
     periodo as pr,
     CONCAT(persona.nom_p, ' ', persona.ap_p) AS name
  
  FROM 
  
       vacaciones, 
       periodo, 
       persona 
    
     WHERE 
     
  
       persona.PK_persona = vacaciones.FK_persona 

       and  FK_persona = :id

       and periodo.PK_pr  = vacaciones.FK_perido  
       AND t_per_v > 0;




    ");


     $stmt->execute([


        ':id'    => $id
       

        
    ]);

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
