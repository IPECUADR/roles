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
  
   COUNT(rol_p.PK_rol) as total
  FROM 
  
    rol_p
    
  
    
     WHERE 
     
       up_aut_rol_in >= :f_in
       and up_aut_rol_in <= :f_fin

    ");



  $stmt->execute([


        
        ':f_in'  => $inicio, 
        ':f_fin'  => $fin

        
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
