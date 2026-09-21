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

          experiencia.puesto_expert as p, 
          experiencia.emp_expert as em, 
          experiencia.descrip as des,
          t_experiencia.t_experiencia as t 
            
        FROM
        
           experiencia, 
           t_experiencia
        
        WHERE 
        
           t_experiencia.PK_t_experiencia = experiencia.FK_t_experiencia
           AND FK_postulante =:id

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