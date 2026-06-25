<?php
session_start();

header('Content-Type: application/json');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

try {

    $stmt = $pdo->prepare("

  SELECT 
          
          CONCAT(LEFT(persona.nom_p, 1),LEFT(persona.ap_p, 1)) AS ini, 
          CONCAT(persona.nom_p, ' ', persona.ap_p) AS nm, 
          cargo.cargo_cg as cg, 
          proyecto.proyecto as p, 
          ci_p, 
          email,
          telf_p, 
          aceptacion_fromal as acp, 
          coments_acf as cmt, 
          in_au_fc_acp as fc_acp,
          condicion_us_ser as cnd, 
          text_us_serv as text,
          firm_p as fr, 
          ip_au_user as ip, 
          PK_acptacion  as id


          
        
        FROM 
        
            persona, 
            t_user, 
            proyecto, 
            cargo, 
            acpetacion_user,
            us_service

        where
            t_user.PK_t_user =persona.FK_t_user
            and FK_t_user = 3
            and proyecto.PK_pro  = persona.FK_pro 
            and cargo.PK_cg = persona.FK_cg
            and persona.PK_persona = acpetacion_user.FK_persona
            and us_service.PK_us_ser = acpetacion_user.FK_us_ser
            and acpetacion_user.FK_us_ser = 2
            ORDER BY ini ASC
            

    ");

    $stmt->execute();

  
    $data = $stmt->fetchAll();

        if (empty($data)) {
            echo json_encode([
                'error' => true,
                'message' => 'No hay datos'
            ]);
            exit;
        }

echo json_encode($data);


  

      
} catch (Exception $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al obtener el total'
    ]);
}