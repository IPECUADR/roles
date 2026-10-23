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
    'Valoración/Ejecución' => '../controller/ejecucion.php',


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

    'evaluaciones' => '../db/cg_evaluaciones_asignadas.php',



    'evaluador' => '../db/cg_evaluados_evaluador.php',

/// ejecucion de valoracion

     'evaluador_ejecutados' => '../db/cg_evaluados_evaluador_ejecutados.php',
     'evaluaciones_ejecucion' => '../db/cg_tipos_ev_admin.php',
     'cargar_ejecucion' => '../db/cg_listado_ejecucion.php',

 //fin ejecucion


    'elemntos_valoracion' => '../db/cg_elentos_valoracion.php',

    'preguntas_evaluador' => '../db/cg_preguntas_evaluador.php',

    'up_item_evaluacion_des' => '../db/up_item_val_des.php',

    'aut_ev_elementos' => '../db/cg_elementos_auto_evaluacion.php',

    'aut_ev_elements_ejecutados' => '../db/cg_elementos_auto_evaluacion_ejecutados.php',

    'aut_cg_preguntas' => '../db/cg_preguntas_aut_evaluacio.php',


    




    'mostar_vacaciones_periodo' => '../db/cg_vaciones_clbr.php', 
    'mostar_vacaciones_proceso' => '../db/cg_vaciones_proceso.php',
    'seleccion'    => '../db/cg_vaciones_clbr_selct.php',

     'Reglamneto'    => '../controller/reglamento.php',
     'Canales'    => '../controller/canales.php', 
     'KD'    => '../controller/kd_tescucha.php',
     'areas'    =>'/../../KDE/DATABASE/cargar_areas.php',

     'postulacion' => '../controller/postulacion.php', 

     'evaluar' => '../controller/valoracion.php', 

     'mensaje' => '../controller/msg.postulacion.php', 
     'postulaciones' => '../controller/postulaciones.php', 


      'mostar_postulaciones' => '../db/cg_postulaciones.php'

   
  
];



// Validar ruta
if (array_key_exists($ruta, $rutas)) {
    require $rutas[$ruta];
} else {
    require '../views/404.php';
}