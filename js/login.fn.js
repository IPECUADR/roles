
// LOGIN.JS

// evento presionar enter inicia la funcion validate_login

    window.addEventListener("keydown",(e)=>{
        if(e.keyCode == 13){
            validate_login();
        }
    });



// boton de accicones de login
  

    $('#btn_login').click(function(){
        validate_login();
    });


/// funciones para validar los campos de login


function validate_login(){

    user = $('#user').val().trim();
    pass = $('#pass').val().trim();

            if (!user && !pass) { mensaje('info', 'No has ingresado nada');   return; }   
            if (!user) { mensaje('error', 'No ingresó su usuario'); return; }
            if (!pass) { mensaje('error','No ingresó su contraseña'); return; }

    // si todo esta correcto se llama a la funcion consulta para verificar los datos en la base de datos

    login_consulta (user,  pass);
}

  // funcion mensaje de alerta

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
  

  function login_consulta (user, pass){

$.post(
            'db/login.php',
            { 
              
              user, 
              pass

            },
            function (json) {

                console.log(json);

                if (!json.err) {

                    mensaje( json.icon, json.msg);

                          location.href = 'web/rutas.php?ruta=home';

                 

                } else {
                    mensaje( json.icon, json.msg);
                }

            },
            'json'
        ).fail(() => {
            mensaje('error', 'Error de servidor');
        });
        
  }