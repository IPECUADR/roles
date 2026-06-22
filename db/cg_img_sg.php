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

// Obtener datos de sesión
$id = $_SESSION['pk_p'] ?? null;


try {

    $stmt = $pdo->prepare("
      
    
        SELECT DISTINCT img.*
        FROM img
        LEFT JOIN img_persona 
        ON img.PK_img = img_persona.FK_img
        ORDER BY 
        (img_persona.FK_persona = :id) DESC,
        RAND()
        LIMIT 6;


    ");

    $stmt->execute([':id' => $id]);

  
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