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

$us = $_SESSION['user'] ?? null;

$inicio = date('Y-m-01') . ' 00:00:00';
$fin = date('Y-m-t') . ' 23:59:59';

require_once '../sys/sys.conf.php';

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
      and up_aut_rol_in >= :f_in
      and up_aut_rol_in <= :f_fin

    ");



  $stmt->execute([


        ':us'    => $us,
        ':f_in'  => $inicio, 
        ':f_fin'  => $fin

        
    ]);

    $data = $stmt->fetchAll();

    echo json_encode($data);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['err' => true]);
}
