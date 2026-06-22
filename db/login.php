<?php

require_once('../core/security.php');
require_once '../sys/sys.conf.php';



$user = $_POST['user'] ?? '';
$pass = $_POST['pass'] ?? '';

if ($user === '' || $pass === '') {
    echo json_encode(['ok' => false, 'msg' => 'Complete los campos',  'icon'=>'info']);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT 
        PK_persona AS id_p,
        user_p, 
        clave_p, 
        FK_t_user AS t_user, 
        CONCAT(nom_p, ' ', ap_p) AS nm
     
     FROM 
       persona
     WHERE 
     
      user_p = :user
     
     LIMIT 1"
);

$stmt->execute(['user' => $user]);
$row = $stmt->fetch();

if (!$row || !password_verify($pass, $row['clave_p'])) {
    echo json_encode(['ok' => false, 'msg' => 'Usuario o contraseña incorrectos' , 'icon'=>'error']);
    exit;
}

session_start();
$_SESSION['user'] = $row['user_p'];
$_SESSION['pk_p'] = $row['id_p'];
$_SESSION['t_user']      = $row['t_user'];
$_SESSION['usuario']      = $row['nm'];
$_SESSION['sesion_activa'] = true;
echo json_encode(['ok' => true, 'msg' => 'Bienvenido', 'icon'=>'success'] );
