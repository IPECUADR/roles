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
$id = $_SESSION['pk_p'] ?? null;

if(!$id){

   
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;

}

// verficamos

try {
    $stmt = $pdo->prepare("



        SELECT 
        
            PK_area as id , 
            area as a 
            
        from  
        
        
            area_persona, 
            area 
            
        
        where  
        
        
            
            area_persona.FK_persona =  :id 
            
            and area.PK_area = area_persona.FK_area;



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
