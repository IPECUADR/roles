<?php
session_start();

header('Content-Type: application/json');

date_default_timezone_set('America/Guayaquil');

    // Bloquear acceso directo opcional
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['err' => true]);
        exit;
    }
///bajo la veriable de sesion 



require_once '../sys/sys.conf.php';

$us = $_SESSION['user'] ?? null;

$mes = $_POST['mes'] ?? null;


// verficamos

try {
    $stmt = $pdo->prepare("

  SELECT * 
  
  FROM 
  
        persona, 
        rol_p, 
        proyecto, 
        mes, 
        cargo, 
        firma_rol
    
     WHERE 
     
      persona.PK_persona = rol_p.FK_persona 
      and cargo.PK_cg = persona.FK_cg 
      and mes.PK_mes = rol_p.FK_mes
      and firma_rol.PK_firma  = rol_p.FK_firma 
      and proyecto.PK_pro = persona.FK_pro
      and persona.user_p = :us
      and FK_mes = :mes

    ");



  $stmt->execute([


        ':us'    => $us,
        ':mes'  => $mes
  

        
    ]);

    $data = $stmt->fetchAll();

    if (empty($data)) {
        echo json_encode([
            "err" => true,
            "msg" => "No se encontaron resultados"
        ]);
    exit;
    }
    

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
