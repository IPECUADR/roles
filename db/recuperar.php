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
$email = $_POST['email'] ?? '';

// verficamos

try {
    $stmt = $pdo->prepare("



 SELECT 
      PK_persona AS id,
      email, 
      CONCAT(TRIM(nom_p), ' ', TRIM(ap_p)) AS nombres, 
      user_p
  
  FROM 
  
        persona 
       
     WHERE 
     
      persona.email= :email



    ");


     $stmt->execute([


        ':email'    => $email
       

        
    ]);

    $data = $stmt->fetchAll();

         if (empty($data)) {
            echo json_encode([
                'error' => true,
                'msg' => 'Su solicitud no se pudo procesar.', 
                'icon' => 'error'
            ]);
            exit;
        }

echo json_encode($data);


} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
