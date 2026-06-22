<?php
session_start();

// Evitar cache del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Validar sesión
if (!isset($_SESSION['user'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}

// Variables locales
$USUARIO = $_SESSION['usuario'] ?? 'Invitado';
$FK_ROL  = $_SESSION['t_user'] ?? 0;

// JS del módulo configuración
$js = '<script src="../js/configuracion.js"></script>';

// Nombre de rol según tipo de usuario
if ($FK_ROL == 1) {
    $rol = "Administrador";
} else if ($FK_ROL == 2) {
    $rol = "Dev";
} else if ($FK_ROL == 3) {
    $rol = "Colaborador";
} else {
    $rol = "Usuario";
}

// Cargar módulo configuración para cualquier usuario autenticado
require_once(__DIR__ . '/../tem/header.php');
require_once(__DIR__ . '/../views/configuracion.php');
require_once(__DIR__ . '/../tem/footer.php');
?>