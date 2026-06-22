 
 
 let rcu = 0;

 $('#btn_recuperar_c').click(function(){

      
     

     email = $('#em_recu').val();



     if(email == ''){
        
        mensaje('error', 'Ingrese un correo electrónico');
        return false;
     }

     
    if (!validateEmail(email)) {
        mensaje('error', 'Ingrese un correo electrónico válido');
        return false;
    }

 
    const btn = $(this);

    btn.prop('disabled', true).text('Enviando...');


      $.post(
            '../web/rutas.php?ruta=verificar',
            { 
              
              email


            },
            function (json) {

               
                 
                if (!json.error) {

               
                   
            
                        let nombres = json[0].nombres;
                        let mail = json[0].email;
                        let id = json[0].id;
                        let us = json[0].user_p;

                         
                          rcu = id = json[0].id;






                        gen_token_mail(nombres, mail, id, us);
       


                 

                } else {
                    mensaje( json.icon, json.msg);
                }

            },
            'json'
        ).fail(() => {
            mensaje('error', 'Error de servidor');
        });

     
     

        
  
  });

/// mensaje del  servicios
  function mensaje(icon, mensaje){

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
        title: mensaje
        });


  }

  function mesg_modal(icon, msg){

            Swal.fire({
            title: msg,
            icon: icon
            });

  }


 // validacion de email 
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}


// generar token y enviar correo
function gen_token_mail(nombres, mail, id, us){



    $.post(
    '../mail/mail.php',
    {
        nombres,
        mail, 
        id, 
        us
    },
    function (json) {



        if (!json.err) {


            mesg_modal('success', json.msg);



            getToken();


        } else {
            mensaje('error', json.msg); // ← ERROR REAL DEL PHP
        }

    },
    'json'
).fail(() => {
    mensaje('error', 'No se pudo conectar con el servidor');
});




}   


function getToken() {

    let email = $('#em_recu').val();

    if(email === ''){
        alert('Ingresa tu correo');
        return;
    }

    // 🔒 Bloquear input de email
    $('#em_recu').prop('disabled', true);

    // 🔄 Cambiar botón a VERIFICAR
    $('#btn_recuperar_c')
        .text('VERIFICAR')
        .prop('disabled', false)
        .removeClass('btn-success')
        .addClass('btn-success')
        .off('click') // quitar evento anterior
        .on('click', verificarToken);

    // 🧼 Limpiar contenedor
    $('#token').empty();

    // ➕ Agregar input de token
    $('#token').append(`
        <div class="mt-3 text-start">
            <label class="form-label">Código de verificación</label>
            <input 
                type="text"
                id="token_input"
                class="form-control text-center"
                maxlength="6"
                inputmode="numeric"
                placeholder="000000"
            >
            <small class="text-muted">
                Código de 6 dígitos (vence en 10 minutos)
            </small>
        </div>
    `);

    // 🔢 Solo números
    $('#token_input').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}


function verificarToken() {

  
     
    email = $('#em_recu').val();

    console.log(email);

    let token = $('#token_input').val();

    if(token.length !== 6){
        mensaje('error','El código debe tener 6 dígitos');
        return;
    }

    if(!email){
        mensaje('error','Email incorrecto');
        return;
    }

      if(!rcu){
        mensaje('error','Error de recuperacion');
        return;
    }

    
// verifdicacion  en back 
validate_renew(rcu, token, email);

}


function validate_renew(rcu, token, email){


     $.post(
            '../web/rutas.php?ruta=token_validate',
            { 
              
              rcu, 
              token, 
              email



            },
            function (json) {

               
                 
                if (!json.error) {

               
                   $('#form_recu').empty();



                      $('#form_recu').append(`
                         <div class="icon-lock">🔐</div>

                                <h4>Cambio de contraseña</h4>

                                <p class="mb-4">
                                Ingresa una nueva contraseña.
                                </p>


                                    <div class="mb-3">
                                            <label for="email" class="form-label"> <strong><i class="bi bi-lock-fill"></i> Nueva contraseña</strong></label>
                                            <input type="password" class="form-control" id="pass" >
                                    </div>

                                    <div class="mb-3">
                                            <label for="pass" class="form-label"> <strong><i class="bi bi-lock-fill"></i> Confirmar contraseña</strong></label>
                                            <input type="password" class="form-control" id="pass_conf" >
                                    </div>


                          
                            

                                <div class="d-grid mt-3">
                                    <button id="guardar_new_clave" class="btn btn-dark-blue">
                                        Guardar Cambios
                                    </button>
                                </div>

                    `);
            
       


                 

                } else {
                    mensaje( json.icon, json.msg);
                }

            },
            'json'
        ).fail(() => {
            mensaje('error', 'Error de servidor');
        });


}


// 
$(document).on('click', '#guardar_new_clave', function() {

   pass = $('#pass').val().trim();
   pass_conf = $('#pass_conf').val().trim();

    
   
   
    if (pass !== pass_conf) {
        mensaje('error', 'Las contraseñas no coinciden');
        return;
    }

      if (pass.length < 6){
        mensaje('error', 'La contraseña debe tener al menos 6 caracteres');
        return;
    }

    if (pass.length < 6){
        mensaje('error', 'La contraseña debe tener al menos 6 caracteres');
        return;
    }

      if(!rcu){
        mensaje('error','Error de recuperacion');
        return;
    }


      
    if( !pass && !pass_conf ){
    
        mensaje('error', 'Por favor, complete todos los campos ');
        return;
    }


    cambio_pas(pass, rcu);

})

// change pass


function cambio_pas( pass, rcu){
 

    console.log(pass, rcu);

    console.log('ingreso funcion ');
    $.post('../web/rutas.php?ruta=cambio',{

   
        pass,
        rcu

    }, function (r) {
           
        console.log(r);

             if(!r.err){
               
                 mensaje (r.icon, r.msg);


                     location.href = '../index.php';
                
               

             }else{

                mensaje (r.icon, r.msg);
             }
         


    }, 'json');


}
