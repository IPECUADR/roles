<?php
session_start();


// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

require_once '../sys/sys.post.php';




try {

    $stmt = $pdo->prepare("
    
SELECT 
        

            PK_postulante as id, 
            postulante.nom_pst as nm, 
            postulante.ap_pst as ap, 
            postulante.email as emi, 
            postulante.fc_nan_pst as f_na,
            postulante.nacinalidad_pst as nan,
            plaza.plaza_t as pl, 
            p_postulacion.fc_post_aut as fc,
            p_postulacion.cv_postulacion as cv, 
            p_postulacion.est_postulacion as est, 
            PK_postulacion as id_post,

            
            
            postulante.direccion_pst as dir, 
            postulante.cel_pst as cel, 
            postulante.ci_post as ci, 
            provincia.provincia as provi, 
            canton.canton as cant
            
       
        
        FROM 
        
        
            postulante, 
            p_postulacion, 
            plaza, 
             
            provincia, 
            canton
        
        WHERE 
        
            plaza.PK_plaza = p_postulacion.FK_plaza 
            and postulante.PK_postulante = p_postulacion.FK_postulante
           
            AND provincia.PK_provincia = postulante.FK_provincia
          
            and canton.PK_canton = postulante.FK_canton

      




    ");

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}