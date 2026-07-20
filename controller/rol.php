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



$css = '<link rel="stylesheet" href="../css/roles.css">';

// Validación por rol
if ($FK_ROL == 1) { 
     // variables de rol

       $rol = "Administrador";
       $js = '<script src="../js/roles.js"></script>';
   

     // Cargar vistas  
   require_once('../tem/header.php');
   require_once('../views/rol.php');
   require_once('../tem/footer.php');


} else if ($FK_ROL == 3  || $FK_ROL == 4 ) { // colaborador

    // Variables para colaborador
    $rol = "Colaborador";
    $js = '<script src="../js/roles.js"></script>';

    // Cargar el mismo módulo de roles pero con vistas adaptadas para el colaborador
    require_once('../tem/header.php');
    require_once('../views/rol.php');
    require_once('../tem/footer.php');

   }else{

   require_once('../views/dev.php');
 

   }
?>
