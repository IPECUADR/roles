<?php


require_once('../core/security.php');

// db/checkSession.php
session_start();

header('Content-Type: application/json; charset=utf-8');

// Respuesta base
$response = [
    'err'  => true,
    'msg'  => 'Sesión no válida',
    'icon' => 'warning'
];

// Validación real
if (isset($_SESSION['sesion_activa']) && $_SESSION['sesion_activa'] === true) {

    $response = [
        'err'  => false,
        'msg'  => 'Sesión válida',
        'icon' => 'success'
    ];
}

echo json_encode($response);
exit;
