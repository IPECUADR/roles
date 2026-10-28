$(document).ready(function () {

   cargar_politicas();
   us_serv_politicas();

    });


    // funcioon  cargar politicas 


    function cargar_politicas(){

    $.post('../web/rutas.php?ruta=cargar_politicas', function (r) {

   

        $('#biblioteca_politicas').empty();
        
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

              if(item.i == 1){

                 c = 'documento-azul'; 

              }else if(item.i == 2){
                 
                 c = 'documento-verde'; 

              }else if(item.i == 3){

                 c = 'documento-morado'; 

              }else{

                 c = ''; 

              }

                $('#biblioteca_politicas').append(


                    `
                       
                <!-- DOCUMENTO 3: EJEMPLO -->
                <div class="col-6 col-md-4 col-xl-3">

                    <button type="button"
                            class="politica-documento"
                            data-titulo="Gestión Humana"
                            data-url="${item.url}">

                        <div class="documento-hoja ${c} ">
                            <span class="documento-esquina"></span>

                            <i class="bi bi-file-earmark-pdf-fill"></i>

                            <span class="documento-tipo">PDF</span>

                            <div class="documento-lineas">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                        <span class="documento-titulo">
                            ${item.pm}
                        </span>

                    

                    </button>

                </div>
                    
                    `
                );
         
            }
        });

                

    }, 'json');

}





    $(document).on('click', '.politica-documento', function () {

    const titulo = $(this).data('titulo');
    const url = $(this).data('url');

    if (!url) {
        alert('Este documento todavía no tiene una URL configurada.');
        return;
    }

    $('.politica-documento').removeClass('activo');
    $(this).addClass('activo');

    $('#titulo_pdf').text(titulo);
    $('#visor_pdf').attr('src', url);
    $('#descargar_pdf').attr('href', url);

});





function us_serv_politicas() {

    $.post('../db/us_serv_politicas.php', {}, function (r) {

        console.log('Respuesta PHP:', r);
        console.log('err:', r.err);
        console.log('aceptado:', r.aceptado);

        if (r.aceptado === true) {

            console.log('Aceptación exitosa');

        } else if (r.aceptado === false) {

            modal_serv_politicas();

        } else {

            console.error('No se pudo verificar la aceptación:', r.msg);
        }

    }, 'json').fail(function (xhr) {

        console.error('Error PHP:', xhr.responseText);

    });
}


let pk_acp_politica = 0;

function modal_serv_politicas(){

    


$.post('../db/us_srv_politica.php', function (r) {

    console.log(r);

   
    if (!r.err) {
            $.each(r, function (i, item) {
                if (i !== 'err') {

                    pk_acp_politica = item.id;

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
                    <button type="button" class="btn btn-success col-12" id="btn_cap_politica">
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



$(document).on('click', '#btn_cap_politica', function() {

    if (!$('#acepto_rol').is(':checked')) {
        mensaje('error', 'Debe aceptar los términos para continuar');
        return;
    }

   if(!pk_acp_politica){
    
    mensaje('error', 'Error al tratar de aceptar ');

    return; 

   }

   aceptaciones(pk_acp_politica);

  });


  function aceptaciones (pk_acp_politica){

     elemnto = pk_acp_politica 

     console.log(elemnto);
  
    $.post('../db/in_acp_politica.php',elemnto, function (r) {
           
        console.log(r);

             if(!r.err){
               
                 mensaje ('success', r.msg);
                 $('#modal_service').modal('hide');
                
               

             }
         


    }, 'json');
  

}







   

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

