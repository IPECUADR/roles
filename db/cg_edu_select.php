<?php

header('Content-Type: application/json; charset=utf-8');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido'
    ]);
    exit;
}

// Llamamos a la conexión
require_once '../sys/sys.post.php';

// Validar ID
$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode([
        'err' => true,
        'msg' => 'ID del postulante no recibido'
    ]);
    exit;
}

try {

    $stmt = $pdo->prepare("
        SELECT 

            educacion.institucion_edu AS inst,
            nivel_educativo.nivel_edu AS nv,
            educacion.an_graduacion AS an
            
        FROM
        
            educacion, 
            nivel_educativo
        
        WHERE 
        
            nivel_educativo.PK_nivel = educacion.FK_nivel
            AND educacion.FK_postulante = :id
        
        ORDER BY 
        
            educacion.an_graduacion ASC
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (Exception $e) {

    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al consultar la educación del postulante'
    ]);
}