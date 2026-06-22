<?php
session_start();

header('Content-Type: application/json');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido',
        'icon' => 'error'
    ]);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

// Usuario en sesión
$us = $_SESSION['user'] ?? null;

if (!$us) {
    echo json_encode([
        'err' => true,
        'msg' => 'Sesión no válida',
        'icon' => 'error'
    ]);
    exit;
}

// Datos recibidos
$nom_p  = trim($_POST['nom_p'] ?? '');
$ap_p   = trim($_POST['ap_p'] ?? '');
$dir_p  = trim($_POST['dir_p'] ?? '');
$email  = trim($_POST['email'] ?? '');
$telf_p = trim($_POST['telf_p'] ?? '');

// Validaciones básicas
if ($nom_p === '' || $ap_p === '' || $dir_p === '' || $email === '' || $telf_p === '') {
    echo json_encode([
        'err' => true,
        'msg' => 'Complete todos los campos editables',
        'icon' => 'info'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'err' => true,
        'msg' => 'Ingrese un correo válido',
        'icon' => 'error'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("

        UPDATE persona
        SET
            nom_p = :nom_p,
            ap_p = :ap_p,
            dir_p = :dir_p,
            email = :email,
            telf_p = :telf_p

        WHERE
            user_p = :us

    ");

    $stmt->execute([
        ':nom_p'  => $nom_p,
        ':ap_p'   => $ap_p,
        ':dir_p'  => $dir_p,
        ':email'  => $email,
        ':telf_p' => $telf_p,
        ':us'     => $us
    ]);

    echo json_encode([
        'err' => false,
        'msg' => 'Información actualizada correctamente',
        'icon' => 'success'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al actualizar la información del perfil',
        'icon' => 'error'
    ]);
}