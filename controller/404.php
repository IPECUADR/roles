<?php
session_start();

// Evitar cache del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Validar sesión
if (!isset($_SESSION['username'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}

// Variables locales
$USUARIO = $_SESSION['username'];
$FK_ROL  = $_SESSION['rol'] ?? 0;



// Validación por rol
if ($FK_ROL == 3)
     {

          require_once('../views/4004.php');

     } else if ($FK_ROL == 2) 
    
     { // Supervisor
          require_once('../views/4004.php');
          
     }


