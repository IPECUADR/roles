   
$(document).ready(function () {


     sesion();
     roles_p_us_ser();
    


});

 

 
   function sesion(){

    $.post(
    '../db/sesion.php',
    {},
    function (json) {

        console.log(json);

        if (json.err) {
            // sesión caída
            sessionStorage.clear();
            location.href = '../index.php';
        }

        // si NO hay error → sigues normal (cargar tabla, etc.)

    },
    'json'
).fail(() => {
    location.href = '../index.php';
});

  }
 
 // para cerrar sesión,

  $('#btn_close').click(function(){
   
   
  Swal.fire({
            title: '¿Cerrar sesión?',
            text: "Se cerrará tu sesión actual.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige al logout PHP
                window.location.href = '../web/rutas.php?ruta=logout';
            }
        });
    
  
  
  });


  $('#btn_roles').click(function(){
    window.location.href = '../web/rutas.php?ruta=roles';
  });


    $('#home_sys').click(function(){
    window.location.href = '../web/rutas.php?ruta=home';
  });


/// aceptacion roles

function roles_p_us_ser(){

    $.post('../db/us_srv_rol.php', function (r) {

        console.log(r);



            if (r.err || !r.aceptado) {
                // ❌ No ha aceptado → mostrar modal
                modal_us_srv_rol_p();
            } else {
               
                p_us_firma();
                
                
            }


      
    }, 'json');

}

/// acciones modal


let pk_acp = 0;


function modal_us_srv_rol_p(){

    


$.post('../db/us_serv_rol.php', function (r) {

    console.log(r);

   
    if (!r.err) {
            $.each(r, function (i, item) {
                if (i !== 'err') {

                    pk_acp = item.id;

                    title =  `<i class="bi bi-info-circle-fill"></i>  ${item.con}  `;
                    content =  ` 

                        <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="small text-muted mb-3">
                            Por favor, revise la siguiente información:
                            </div>

                            <div class="card-text" style="white-space: pre-line;">
                            ${item.text}
                            </div>
                        </div>
                        </div>

                         <div class="form-check mb-3 mt-3">
                            <input class="form-check-input" type="checkbox" id="acepto_rol">
                            <label class="form-check-label" for="acepto_rol">
                                He leído y acepto
                            </label>
                            </div>


                    `;

                    accions =  `
                    <button type="button" class="btn btn-success col-12" id="btn_acp_rol">
                            Guardar Cambios
                    </button>


                `;

                
                
                modal_ensamble(title, content, accions );
                
                
                }
            });
   
    }else{

        console.log('Requisito Aceptado');

       
    }


}, 'json');







   

}



  function modal_ensamble(title, content, accions ){

        $('#modal_service').modal('show');
        /// limpiar elemntos del modal 

        $('#titulo_modal').empty();
        $('#contenido_modal').empty();
        $('#acciones_modal').empty();

        /// asignacion de elemntos 

        $('#titulo_modal').append(title);
        $('#contenido_modal').append(content);
        $('#acciones_modal').append(accions);


}








//mensajes

function mensaje (icon,  msg){

    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        }).fire({
        icon: icon,
        title: msg
        })

  }


  //// aceptaciones 

$(document).on('click', '#btn_acp_rol', function() {

    if (!$('#acepto_rol').is(':checked')) {
        mensaje('error', 'Debe aceptar los términos para continuar');
        return;
    }

   if(!pk_acp){
    
    mensaje('error', 'Error al tratar de aceptar ');

    return; 

   }

   aceptaciones(pk_acp);

  });


  function aceptaciones (elemnto){


  
    $.post('../db/in_acptaciones.php',elemnto, function (r) {
           
        console.log(r);

             if(!r.err){
               
                 mensaje ('success', r.msg);
                 $('#modal_service').modal('hide');
                 roles_p_us_ser();

                 location.reload();
               

             }
         


    }, 'json');
  

}


// ver si  el  usuario acepta el uso de firma 

function p_us_firma(){

    $.post('../db/us_srv_firma.php', function (r) {

        console.log(r);



            if (r.err || !r.aceptado) {
                // ❌ No ha aceptado → mostrar modal
                modal_us_srv_firma();
            } else {
               
               ver_cambio();
                
                
            }


      
    }, 'json');

}

/// cambio contraseña 

function ver_cambio(){

   $.post('../db/us_srv_pass.php', function (r) {

        console.log(r);



            if (r.err || !r.aceptado) {
                // ❌ No ha aceptado → mostrar modal
               modal_us_pass_c();
            } else {
               
                console.log('requisito aceptado');
                
                
            }


      
    }, 'json');



}

// CAMBIOS PASS

function modal_us_pass_c(){

    


$.post('../db/us_serv_pass.php', function (r) {

    console.log(r);

   
    if (!r.err) {
            $.each(r, function (i, item) {
                if (i !== 'err') {

                    pk_acp = item.id;

                    title =  `<i class="bi bi-info-circle-fill"></i>  ${item.con}  `;
                    content =  ` 

                        <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="small text-muted mb-3">
                            Por favor, revise la siguiente información:
                            </div>

                            <div class="card-text mb-3" style="white-space: pre-line;">
                            ${item.text}
                            </div>


                             
                              <div class="mb-3">
                                <label for="email" class="form-label"> <strong> <i class="bi bi-envelope-at-fill"></i> Correo electrónico de recuperación</strong></label>
                                <input type="email" class="form-control" placeholder="alguien@example.com" id="em_recu" >
                            </div>

                            <div class="mb-3">
                                    <label for="email" class="form-label"> <strong><i class="bi bi-lock-fill"></i> Nueva contraseña</strong></label>
                                    <input type="password" class="form-control" id="pass" >
                            </div>

                             <div class="mb-3">
                                    <label for="pass" class="form-label"> <strong><i class="bi bi-lock-fill"></i> Confirmar contraseña</strong></label>
                                    <input type="password" class="form-control" id="pass_conf" >
                            </div>



                            
                            <div class="form-check mb-3 mt-3">
                            <input class="form-check-input" type="checkbox" id="acepto">
                            <label class="form-check-label" for="acepto">
                                He leído y acepto
                            </label>
                            </div>


                        </div>
                        </div>


                    `;

                    accions =  `
                    <button type="button" class="btn btn-success col-12" id="btn_cambiar_pass">
                            Guardar Cambios
                    </button>


                `;

                
                
                modal_ensamble(title, content, accions );
                
                
                }
            });
   
    }else{

        console.log('Requisito Aceptado');

       
    }


}, 'json');







   

}


/// guardar cambios


$(document).on('click', '#btn_cambiar_pass', function() {

   console.log(pk_acp);

   email = $('#em_recu').val().trim();
   pass = $('#pass').val().trim();
   pass_conf = $('#pass_conf').val().trim();
   acepto = $('#acepto').is(':checked');
  
    if(!pk_acp || !email || !pass || !pass_conf || !acepto){
    
        mensaje('error', 'Por favor, complete todos los campos y acepte los términos');
        return;
    }

    if (pass.length < 6){
        mensaje('error', 'La contraseña debe tener al menos 6 caracteres');
        return;
    }
    if (!validateEmail(email)) {
        mensaje('error', 'Por favor, ingrese un correo electrónico válido');
        return;
    }

    if (pass !== pass_conf) {
        mensaje('error', 'Las contraseñas no coinciden');
        return;
    }

    if (!acepto) {
        mensaje('error', 'Debe aceptar los términos para continuar');
        return;
    }
   

   cambio_pas_up_email(email, pass, pk_acp);


});


// validate email 

 // validacion de email 
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}


/// afectacion en la base de datos para cambio de contraseña

function cambio_pas_up_email(email, pass, pk_acp){

    $.post('../db/up_pass_acep_terms.php',{

        email,
        pass,
        pk_acp

    }, function (r) {
           
        console.log(r);

             if(!r.err){{}
               
                 mensaje (r.icon, r.msg);


                 $('#modal_service').modal('hide');
                 roles_p_us_ser();

                 location.reload();
               

             }else{

                mensaje (r.icon, r.msg);
             }
         


    }, 'json');


}

// ufnciones firma 

let pk_firma = 0;

function modal_us_srv_firma(){




$.post('../db/us_serv_firma.php', function (r) {

    console.log(r);

   
    if (!r.err) {
            $.each(r, function (i, item) {
                if (i !== 'err') {

                    pk_firma = item.id;

                    title =  `<i class="bi bi-info-circle-fill"></i>  ${item.con}  `;
                    content =  ` 

                        <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="small text-muted mb-3">
                            Por favor, revise la siguiente información:
                            </div>

                            <div class="card-text" style="white-space: pre-line;">
                            ${item.text}
                            </div>

                        <div class="form-check mb-3 mt-3">
                            <input class="form-check-input" type="checkbox" id="acepto_firma">
                            <label class="form-check-label" for="acepto_firma">
                                He leído y acepto
                            </label>
                            </div>


                            
                            <div class="col-12" style="white-space: pre-line;">

                              <h3>Firma aquí 👇</h3>

                              <canvas class="col-12"  id="canvasFirma"></canvas>
                            
                              <button class="btn btn-clear btn-danger" id="limpiar">Repetir Firma</button>

                            </div>
                      
                             
                              
                          

                        </div>
                        </div>
                    







                    `;

                    accions =  `
                    <button type="button" class="btn btn-success col-12" id="btn_acp_firma">
                            Guardar Cambios
                    </button>


                `;

                
                
                 modal_ensamble(title, content, accions );
                 initFirmaCanvas() ;
                
                }
            });
   
    }else{

        console.log('Requisito Aceptado');

       
    }


}, 'json');







   

}










 function initFirmaCanvas() {

    const canvas = document.getElementById("canvasFirma");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");


    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        const ratio = window.devicePixelRatio || 1;

        canvas.width = rect.width * ratio;
        canvas.height = rect.height * ratio;

        ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
        ctx.lineCap = "round";
        ctx.lineJoin = "round";
        ctx.strokeStyle = "#0c0750";
    }

    resizeCanvas();

    // Si está en modal Bootstrap
    $('#modal_service').on('shown.bs.modal', resizeCanvas);

    let dibujando = false;
    let lastX = 0;
    let lastY = 0;

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }


    function iniciar(e) {
        e.preventDefault();
        canvas.setPointerCapture(e.pointerId); 

        const pos = getPos(e);
        dibujando = true;
        lastX = pos.x;
        lastY = pos.y;

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
    }


    function dibujar(e) {
        if (!dibujando) return;
        e.preventDefault();

        const pos = getPos(e);
        const dx = pos.x - lastX;
        const dy = pos.y - lastY;
        const distancia = Math.sqrt(dx * dx + dy * dy);

        // Grosor natural (rápido = más delgado)
        ctx.lineWidth = Math.max(1, 3.5 - distancia * 0.15);

        // 🔥 Interpolación
        const pasos = Math.max(1, Math.ceil(distancia / 2));
        for (let i = 0; i < pasos; i++) {
            ctx.lineTo(
                lastX + (dx * i / pasos),
                lastY + (dy * i / pasos)
            );
        }

        ctx.stroke();
        lastX = pos.x;
        lastY = pos.y;
    }

  
    function terminar(e) {
        if (!dibujando) return;
        dibujando = false;
        canvas.releasePointerCapture(e.pointerId);
        ctx.closePath();
    }

    
    canvas.addEventListener("pointerdown", iniciar);
    canvas.addEventListener("pointermove", dibujar);
    canvas.addEventListener("pointerup", terminar);
    canvas.addEventListener("pointercancel", terminar);
    canvas.addEventListener("pointerleave", terminar);


    $("#limpiar").off().on("click", function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.beginPath();
    });


    $("#btn_acp_firma").off().on("click", function () {

        if (!$('#acepto_firma').is(':checked')) {
            mensaje('error', 'Debe aceptar los términos para continuar');
            return;
        }

        if (!pk_firma) {
            mensaje('error', 'Error al tratar de aceptar');
            return;
        }

        const blank = document.createElement("canvas");
        blank.width = canvas.width;
        blank.height = canvas.height;

        if (canvas.toDataURL() === blank.toDataURL()) {
            mensaje('error', 'Debe firmar para continuar');
            return;
        }

        const dataURL = canvas.toDataURL("image/png");

        $.post('../db/save_firma.php', { imagen: dataURL }, function (res) {
            mensaje('success', res.msg);
            $('#modal_service').modal('hide');
            location.reload();
            roles_p_us_ser();
        }).fail(function (err) {
            console.error(err);
            mensaje('error', 'Error al guardar la firma');
        });
    });
}