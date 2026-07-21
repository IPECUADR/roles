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

    FK_vc AS id,
    ROUND(dias_pendientes, 2) AS dp,
    ROUND(dias_gozados, 2) AS dg,
    ROUND(t_per_v, 2) AS t_vc,
    ob_vc,
    periodo AS pr

    FROM vacaciones, periodo
    WHERE FK_persona = :id
    AND periodo.PK_pr = vacaciones.FK_perido
    AND t_per_v > 0;


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
