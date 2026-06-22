<?php
header('Content-Type: application/json');
session_start();

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true, 'msg' => 'Método no permitido']);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

// Sesión

$id = $_SESSION['pk_p'] ?? null;
$us = $_SESSION['user'] ?? null;
$img_sg = $_POST['imgId'] ?? null;

if (!$us || !$id) {
    echo json_encode(['err' => true, 'msg' => 'Sesión no válida']);
    exit;
}



try {

    $sql = "
        INSERT INTO img_persona (
            FK_img,
            FK_persona,
            est_img_p,
            fc_in_aut_img_p,
            fc_up_aut_img_p,
            us_in_aut_img_p,
            us_up_aut_img_p
   
     
        ) VALUES (
                :img_sg,
                :id,
                1,
                NOW(),
                NOW(),
                :us,
                'n/a'
        )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':img_sg'     => $img_sg,
        ':id'         => $id,
        ':us'         => $us
    ]);

    echo json_encode([
        'err'  => false,
        'msg'  => 'Acción registrada correctamente',
        'icon' => 'success'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}
