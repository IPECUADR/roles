 $(document).ready(function () {
    contar_personas();
    contar_roles();
    contar_aceptaciones();
});
 
 
 
 $('#cg_masiva').click(function(){

         title =  `<i class="bi bi-cloud-upload-fill"></i> Carga Masiva de Informacion `;
                    content =  ` 

                <div class="card shadow-sm border-0">
                       
                     <div class="card-body">
                           

                         

                        <form id="form_import_data" enctype="multipart/form-data" >

                           <label>Subir Archivo .csv </label>
                            <input type="file" class="form-control" name="archivo"  id="archivo" accept=".csv" required>

                        
                        </form>



                        </div>
                 </div>


                    `;

                    accions =  `
                    
                <div class="w-100">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-2">
                            <button type="button"
                                    class="btn btn-success w-100"
                                    id="bt_import_data">
                             <i class="bi bi-floppy"></i>    Guardar 
                            </button>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <button type="button"
                                    class="btn btn-danger w-100"
                                    id="btn_cancel">
                              <i class="bi bi-x-circle-fill"></i>  Cerrar 
                            </button>
                        </div>
                    </div>
                </div>

                `;


     modal_ensamble(title, content, accions )
  
  });


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

$(document).on('click', '#bt_import_data', function () {

    const form = document.getElementById('form_import_data');
    if (!form) {
        alert('Formulario no encontrado');
        return;
    }

    const fileInput = document.getElementById('archivo').files[0];
    if (!fileInput) {
        alert('Seleccione un archivo CSV');
        return;
    }

    if (!fileInput.name.toLowerCase().endsWith('.csv')) {
        alert('Solo se permiten archivos CSV');
        return;
    }

    const formData = new FormData(form);

        $.ajax({
            url: '../db/import_data.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (r) {
                console.log(r);
                alert(r.mensaje);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error al procesar el archivo (ver consola)');
            }
        });

});



$(document).on('click', '#btn_cancel', function () {


 $('#modal_service').modal('hide');

})
// CONTAR USUARIOS 
function contar_personas(){

    $.post('../web/rutas.php?ruta=total_personas', function (r) {

        console.log(r);

        $('#count_personas').empty()
           
        

                $('#count_personas').append(
                    `${r.total} <i class="bi bi-people-fill"></i>`
                );
         

    }, 'json');

}

// CONTAR ROLES

function contar_roles(){

    $.post('../web/rutas.php?ruta=total_roles', function (r) {

        console.log(r);

        $('#count_roles').empty()
           
        

                $('#count_roles').append(
                    `${r.total} <i class="bi bi-filetype-pdf"></i>`
                );
         

    }, 'json');

}

function contar_aceptaciones(){

    $.post('../web/rutas.php?ruta=total_aceptaciones', function (r) {

        console.log(r);

        $('#count_aceptaciones').empty()
           
        

                $('#count_aceptaciones').append(
                    `${r.total} <i class="bi bi-person-check-fill"></i>`
                );
         

    }, 'json');

}


/// cargar usuarios
function cargar_usuarios(){

    // Realizar la solicitud AJAX para obtener los datos de los usuarios activos

    console.log('Cargando usuarios activos...');

      $.post('../db/cg_colboradores.php', function (r) {

        console.log(r);

        contenedor_carga();
        $('#response_result').empty()
           


        
             $.each(r, function (i, item) {

            if (i !== 'err') {
                $('#response_result').append(
                    `
                    
                    
                    
                    

                  
                 <div class="col-md-6 col-lg-4 mt-1 mb-1  text-white">
                        <div class=" card shadow-sm rounded-4 h-100 bg-primary bg-opacity-10 border-0">
                            <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                                    style="width:45px;height:45px;">
                                  ${item.ini ?? 'N/A'}
                                </div>
                                <div class="ms-3">
                                <h6 class="mb-0 fw-semibold"> ${item.nm ?? 'N/A'}</h6>
                                <small class="text-muted"> ${item.p ?? 'N/A'}</small>
                                </div>
                            </div>

                            <p class="mb-1"><i class="bi bi-briefcase"></i> ${item.cg ?? 'N/A'}</p>
                            <p class="mb-1"><i class="bi bi-envelope"></i> ${item.email ?? 'N/A'}</p>
                            <p class="mb-0"><i class="bi bi-telephone"></i> ${item.telefono ?? 'N/A'}</p>
                           
                           
                            <button class="btn btn-sm btn-outline-dark mt-3 w-20 "> <i class="bi bi-archive"></i> Rol de Pago</button>
                            <button class="btn btn-sm btn-outline-primary mt-3 w-20"><i class="bi bi-envelope-at-fill"></i> Notificar  </button>
                            <button class="btn btn-sm btn-outline-danger mt-3 w-20 " > Desactivar  </button>

                            </div>
                        </div>
                     </div>

                        











                    
                    
                    
                    
                    
                    
                    
                    
                    `
        
                );
        
        
        
            }
           
        
        });
         
        
    

     }
        , 'json');  





}

$(document).on('click', '#users_activos', function () {
    cargar_usuarios();
})


function contenedor_carga(){
    $('#contenedor').empty()
    $('#contenedor').append(
        `
      <div class="container mt-4 shadow border-0 bg-light p-4 rounded" id="contenedor">

        <div class="mb-4 text-dark">
                <h4 class="fw-semibold mb-1">Usuarios activos</h4>
                <small class="text-secondary">Listado general del sistema</small>
        </div>


          <div class="row" id="response_result">
      
          </div>
  
        </div>
        
        `
    );
}

