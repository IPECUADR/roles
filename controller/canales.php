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
$Mail  = $_SESSION['email'] ?? 0; 




// Validación por rol
if ($FK_ROL == 1) { 
     // Admin

  // $rol = "Administrador";
//$js = '<script src="../js/home.ad.fn.js"></script>';
   

     // Cargar vistas  
  // require_once('../tem/header.php');
   //('../views/ad.home.php');
   //require_once('../tem/footer.php');
  


} else if ($FK_ROL == 3) { // colaborador
    
    // Redirige al módulo de roles para que el colaborador
    // ingrese directamente a su dashboard de role


    
      $rol = "Colaborador";
      $js = '<script src="../js/canales.clbr.fn.js"></script>';
      $css = '<link rel="stylesheet" href="../css/canales.css">';
      require_once('../tem/header.php');
      require_once('../views/canales.view.php');
      require_once('../tem/footer.php');


   }else if($FK_ROL == 4){

      $rol = "Líder Proceso";
      $js = '<script src="../js/canales.clbr.fn.js"></script>';
      $css = '<link rel="stylesheet" href="../css/canales.css">';
      require_once('../tem/header.php');
      require_once('../views/canales.view.php');
      require_once('../tem/footer.php');
   
   
   }else{

   require_once('../views/404.php');
 

   }
?>
