
<?php

session_start();

date_default_timezone_set('America/Guayaquil');

    // Bloquear acceso directo opcional
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['err' => true]);
        exit;
    }
///bajo la veriable de sesion 



require_once '../sys/sys.conf.php';

$id = $_SESSION['pk_p'] ?? null;

if (!$id) {
    echo json_encode(['err' => true, 'msg' => 'Usuario no autenticado']);
    exit;
}




// verficamos

try {
    $stmt = $pdo->prepare("

  UPDATE
  
        img_persona
        
     SET
     
     img_persona.est_img_p = 0

     WHERE 
     
      img_persona.FK_persona = :id
      and img_persona.est_img_p = 1

    ");
  
 



  $stmt->execute([


        
        ':id'  => $id
  

        
    ]);

    $data = $stmt->fetchAll();


    echo json_encode([
        'err' => false,
        'msg' => 'Imagen desactivada, por supuerar el límite de intentos'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
