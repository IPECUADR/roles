 $(document).ready(function () {
    roles_p();
    //contar_vacaciones();

});
 
 



$(document).on('click', '#user_vacaciones', function () {


  location.href = '../web/rutas.php?ruta=vacaciones';

})
/// roles 
$(document).on('click', '#roles_service_clbr', function () {


  location.href = '../web/rutas.php?ruta=roles';

}); 


$(document).on('click', '#user_capacitacion', function () {


        window.open(
            'https://kluane.itdospuntocero.net/',
            'Capacitaciones',
            'width=1200,height=800,resizable=yes,scrollbars=yes'
        );

})


/// roles 
$(document).on('click', '#user_reglamento', function () {


  location.href = '../web/rutas.php?ruta=Reglamneto';

}); 


/// acciones canales - kde 

$(document).on('click', '#user_denuncia', function () {


      location.href = '../web/rutas.php?ruta=Canales';
})


$(document).on('click', '#user_kd_escucha', function () {


      location.href = '../web/rutas.php?ruta=KD';
})





/// contar roles emitidos 

function roles_p(){

    $.post('../web/rutas.php?ruta=contar_roles', function (r) {

   

        $('#roles_p').empty()
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {
                $('#roles_p').append(
                    `${item.t} <i class="bi bi-card-text"></i>`
                );
         
            }
        });

                

    }, 'json');

}


/// acciones canales - kde 

$(document).on('click', '#user_denuncia', function () {


      location.href = '../web/rutas.php?ruta=Canales';
})
