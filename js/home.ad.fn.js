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


 $('#btn_subir_vc').click(function(){

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
                                    id="bt_import_vaciones">
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


$(document).on('click', '#bt_import_vaciones', function () {

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
            url: '../db/import_vacaciones.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (r) {
               
                alert(r.msg);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error al procesar el archivo (ver consola)');
            }
        });

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



        $('#count_personas').empty()
           
        

                $('#count_personas').append(
                    `${r.total} <i class="bi bi-people-fill"></i>`
                );
         

    }, 'json');

}

// CONTAR ROLES

function contar_roles(){

    $.post('../web/rutas.php?ruta=total_roles', function (r) {

   

        $('#count_roles').empty()
           
        

                $('#count_roles').append(
                    `${r.total} <i class="bi bi-filetype-pdf"></i>`
                );
         

    }, 'json');

}

function contar_aceptaciones(){

    $.post('../web/rutas.php?ruta=total_aceptaciones', function (r) {

   

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

 <div class="mb-4 text-dark d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
    
    <!-- Título -->
    <div>
        <h4 class="fw-semibold mb-1">Usuarios activos</h4>
        <small class="text-secondary">Listado general del sistema</small>
    </div>

    <!-- Botones -->
    <div class="mt-3 mt-md-0 d-flex gap-2">
        <button class="btn btn-danger btn-sm" id="generar_pedf_masivo_roles">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </button>
        <button class="btn btn-success btn-sm" id="reporte_aceptacion">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>
    </div>

</div>

         
          

          <div class="row" id="response_result">
      
          </div>
  
        </div>
        
        `
    );
}



$(document).on('click', '#user_aceptacion', function () {
    usuario_aceptan();
})


let  res_acp = [];
/// cargar usuarios
function usuario_aceptan(){

    // Realizar la solicitud AJAX para obtener los datos de los usuarios activos



    console.log('Cargando usuarios activos...');

      $.post('../db/cg_clbr_aceptan_service.php', function (r) {


        
         res_acp = r;  

   

        contenedor_carga();
        $('#response_result').empty()
           


        
             $.each(r, function (i, item) {

            if (i !== 'err') {
                $('#response_result').append(
                    `
                    
                    
                    
                    

                  
                 <div class="col-md-6 col-lg-4 mt-1 mb-1  text-white">
                        <div class=" card shadow-sm rounded-4 h-100 bg-primary bg-opacity-10 border-0" >
                            <div class="card-body" id ="${item.id}">
                            <div class="d-flex align-items-center mb-3" >
                                <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                                    style="width:45px;height:45px;">
                                  ${item.ini ?? 'N/A'}
                                </div>
                                <div class="ms-3">
                                <h6 class="mb-0 fw-semibold"> ${item.nm ?? 'N/A'}</h6>
                                 <small class="text-muted"> ${item.p ?? 'N/A'}</small>
                                </div>
                            </div>

                            <p class="mb-1 text-dark"><i class="bi bi-backpack2-fill"></i> ${item.cg ?? 'N/A'}</p>
                          
                            <p class="mb-0 text-dark"><i class="bi bi-pc-display"></i> ${item.cnd ?? 'N/A'}</p>
                             <p class="mb-1  text-success"><i class="bi bi-check-circle-fill "></i> ${item.acp ?? 'N/A'}</p>
                           
                            <button id="btn_constancia" class="btn btn-sm btn-outline-dark mt-3 w-20 "> <i class="bi bi-file-earmark-pdf-fill"></i> Descargar Constancia </button>
                      
                       

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
////// gerear constancia servicio

$(document).on('click', '#btn_constancia', function() {

 var  constancias  = $(this)[0].parentElement;
 let id = $(constancias).attr("id");
 buscar_contancia(id);









})
//

function buscar_contancia(id){

let cp = res_acp.find(item => item.id == parseInt(id));



 if(!cp){
   console.error('No se encontró el registro c');
    return;
  }

  $.ajax({
    url: '../pdf/constancia.php',
    type: 'POST',
    data: { cp: JSON.stringify(cp) },
    xhrFields: { responseType: 'blob' },
    success: function(blob) {



      if(blob.size === 0){
        alert('Error: PDF vacío o contenido inválido');
        return;
      }

      const url = window.URL.createObjectURL(blob);
     
      const a = document.createElement('a');
      a.href = url;
      a.download = 'Contancia'+id+'.pdf';
      document.body.appendChild(a);
      a.click();
      a.remove();
      window.URL.revokeObjectURL(url);
    },
    error: function(xhr, status, error){
      console.error('Error AJAX:', error);
    }
  });


}


// GENERAR EL REPORTE MACRO 

$(document).on('click', '#reporte_aceptacion', function() {


    $.ajax({
        url: "../ex/aceptacion_roles.php",
        type: "POST",
        data: { data: JSON.stringify(res_acp) },
        xhrFields: { responseType: "blob" },

        success: function (blob) {
            const link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "EC-HSE-F-53-NO_RESIDUOS_PELIGROSOS.xls";
            link.click();
        }
    });

});


/// roles report 


$(document).on('click', '#roles_report', function() {

  
      cbx_mes();
      cbx_persona();

    $('#contenedor').empty()
    $('#contenedor').append(
        `
      <div class="container mt-4 shadow border-0 bg-light p-4 rounded" id="contenedor">

 <div class="mb-4 text-dark d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
    
    <!-- Título -->
    <div>
        <h4 class="fw-semibold mb-1">Desargar Roles - Autorizados </h4>
        <small class="text-secondary">Listado general del sistema</small>
    </div>

   <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">

    <!-- Filtros -->
    <div class="row g-2 flex-grow-1">

        <div class="col-md-6">
            <label class="form-label fw-semibold">Colaborador</label>
            <select class="form-select form-select-sm" id="filtro_colaborador">
                <option value="">Todos los colaboradores</option>
                <!-- Cargar dinámicamente -->
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Mes</label>
            <select class="form-select form-select-sm" id="filtro_mes">
                <option value="">Todos</option>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>

    </div>

    <!-- Botones -->
    <div class="d-flex gap-2">
        <button class="btn btn-danger btn-sm" id="generar_pdf_roles">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </button>

        <button class="btn btn-success btn-sm" id="reporte_aceptacion">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>
    </div>

</div>

</div>

         
          

     <div class="row" id="response_result">
      
          </div>
  
        </div>
        
        `
    );

});



//generarl roles de forma masiva 

$(document).on('click', '#generar_pdf_roles', function() {

    let mes  = $('#filtro_mes').val();
    let clbr = $('#filtro_colaborador').val();


 
    // Colaborador sin mes
    if(clbr !== '' && mes === ''){

        mensaje('warning','Debe seleccionar un mes');
        return;

    }

    // Reporte General
    if(mes === '' && clbr === ''){

        Swal.fire({
            title: 'Reporte General',
            text: '¿Deseas generar el reporte de todos los colaboradores?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {

            if(result.isConfirmed){

                cargarReporte('general', '', '');

            }

        });

        return;
    }

    // Reporte por Mes
    if(mes !== '' && clbr === ''){

        cargarReporte('mes', mes, '');
        return;

    }

    // Reporte por Colaborador
    if(mes !== '' && clbr !== ''){

        cargarReporte('colaborador', mes, clbr);
        return;

    }

});




 let roles_pdf =  [];

 function cargarReporte(tipo, mes, colaborador){

    let url ='../db/b_rol_masivo.php';

    let params = {
        tipo: tipo,
        mes: mes,
        colaborador: colaborador
    };

    $.post(url, params, function (r) {

      
    

        if (!r.err) {

       

              if(r.error == true){

               mensaje(r.icon, r.msg);     

              }else{
              
                generar_pdf(r);

              }
         

     

        } else {

            mensaje('warning', r.msg);

        }

    }, 'json');

}






  

 

function generar_pdf(r){








if (!Array.isArray(r) || r.length === 0) {
    mensaje('error', 'No existen datos');
    return;
}





$.ajax({
    url: "../pdf/roles_masivo_firmado.php",
    method: "POST",
    data: { cp: JSON.stringify(r) },
    xhrFields: {
        responseType: "blob"
    },
    success: function(blob){

         
   

        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "rol_pago.pdf";
        a.click();





        window.URL.revokeObjectURL(url);

            
           mensaje('success', 'Reporte generado');

    },
    error: function(xhr, status, error) {

          
            log('Error al generar PDF', 'Error');
            mensaje('error', 'Error al generar PDF');

    }
});

}


  function cbx_mes(){

$.post('../db/cbx_mes.php', function (r) {



    $('#filtro_mes').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#filtro_mes').append(
                `<option value="${item.id}">${item.m}</option>`
            );
        }
    });

}, 'json');



}

function cbx_persona(){

$.post('../db/cbx_persona.php', function (r) {

    

    $('#filtro_colaborador').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#filtro_colaborador').append(
                `<option value="${item.id}">${item.nm}</option>`
            );
        }
    });

}, 'json');



}