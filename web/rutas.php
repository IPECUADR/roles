<?php
/// restriccion de acceso desde navegador




// Obtener ruta
$ruta = $_GET['ruta'] ?? 'home';

// Definir rutas
$rutas = [
    'dashboard' => '../controller/dashboard.php',
    'logout' => '../controller/log_out.php',
    'roles' => '../controller/rol.php',
    'home' => '../controller/home.php',
    'vacaciones' => '../controller/vacaciones.php',
    'perfil' => '../controller/perfil.php',
    'configuracion' => '../controller/configuracion.php',
    'recuperar' => '../controller/recuperar-clave.php', 



    'verificar' => '../db/recuperar.php',
    'mail' => '../mail/mail.php',
    'total_personas' => '../db/ct_personas.php',
    'total_roles' => '../db/ct_roles.ad.php', 
    'total_aceptaciones' => '../db/ct_aceptaciones.php', 
    'validate' => '../views/kluane.info.php', 
    'token_validate' => '../db/validate_change.php', 
    'cambio' => '../db/up_pas_rcp.php', 
    'contar_roles' => '../db/ct_roles.php',
    'procesos' => '../db/cg_procesos.php',
    'mostar_vacaciones_periodo' => '../db/cg_vaciones_clbr.php', 
    'mostar_vacaciones_proceso' => '../db/cg_vaciones_proceso.php',
    'seleccion'    => '../db/cg_vaciones_clbr_selct.php',

     'Reglamneto'    => '../controller/reglamento.php'
    


   
  
];



// Validar ruta
if (array_key_exists($ruta, $rutas)) {
    require $rutas[$ruta];
} else {
    require '../views/404.php';
}