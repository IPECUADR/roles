<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([]);
    exit;
}

require_once '../sys/sys.conf.php';


$id = $_SESSION['pk_p'] ?? null;

if (!$id) {
    echo json_encode([]);
    exit;
}

try {

    $stmt = $pdo->prepare("

        SELECT 
        
         PK_t_evaluacion as id, 
         t_evaluacion as t, 
         t_evaluacion.text_ev as des_ev
         
        FROM 
        
        `t_evaluacion`


    ");

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);


} catch (PDOException $e) {

    error_log($e->getMessage());

    echo json_encode([]);
}