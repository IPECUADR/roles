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



// CONTAR dias de vacaciones

function contar_vacaciones(){

    $.post('../web/rutas.php?ruta=total_roles', function (r) {

   

        $('#count_roles').empty()
           
        

                $('#count_roles').append(
                    `${r.t} <i class="bi bi-filetype-pdf"></i>`
                );
         

    }, 'json');

}

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


