 $(document).ready(function () {

 validate_Evaluaciones_Asignadas();



   
});
 
/// contar roles emitidos 

function validate_Evaluaciones_Asignadas(){

    $.post('../web/rutas.php?ruta=evaluaciones_ejecucion', function (r) {

   

        $('#seccion_evaluaciones').empty();
        
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

              if(item.id == 1){

                 icon = '<i class="bi bi-person-check-fill"></i>'; 

              }else if(item.id == 2){
                 
                 icon = '<i class="bi bi-person-workspace"></i>'; 

              }else if(item.id == 3){

                 icon = '<i class="bi bi-people-fill"></i>'; 

              }else{


              }

                $('#seccion_evaluaciones').append(


                    `
                         <!-- Evaluación de pares -->
            <div class="col-md-4 btn_resultados" id="${item.id}">

                <button type="button"
                        class="card-evaluacion w-100 text-start"
                        id="">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-pares">
                        ${icon}
                        </div>

                        <div class="flex-grow-1">

                                <h6 class="mb-1">
                                   ${item.t}
                                </h6>

                                <p class="mb-2">
                                    ${item.des_ev}
                                </p>

                               

                            </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

                    </div>

                </button>

            </div>
                       
                    
                    `
                );
         
            }
        });

                

    }, 'json');

}


$(document).on('click', '.btn_resultados', function () {

    const t_evaluacion = Number(this.id);

    tipo_evaluacion = t_evaluacion;


    console.log(tipo_evaluacion);


    switch (t_evaluacion) {
        case 1:
           
              cargar_auto_evaluacion_ejecucion (t_evaluacion);

            break;

        case 2:
                  
             cargar_ejecuacion_evaluadores(t_evaluacion);


            break;

        case 3:
             
             
              cargar_personas_a_evaluar(t_evaluacion);
           
              break;

        default:
            console.warn('Tipo de evaluación no válido:', t_evaluacion);
            break;
    }

});


let respuesta = [];

function cargar_auto_evaluacion_ejecucion(t_evaluacion) {

    $.post('../web/rutas.php?ruta=cargar_ejecucion', { t_evaluacion }, function (r) {

        $('#seccion_evaluaciones').empty();

        respuesta = r;

        $('#seccion_evaluaciones').append(`


             


            <!-- Botón Pendientes -->
            <div class="col-md-6">
                <button type="button"
                        class="card-evaluacion w-100 text-start btn_filtrar_evaluacion"
                        data-estado="2">

                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Ver Pendientes</h6>
                        </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>
                    </div>

                </button>
            </div>

            <!-- Botón Ejecutados -->
            <div class="col-md-6">
                <button type="button"
                        class="card-evaluacion w-100 text-start btn_filtrar_evaluacion"
                        data-estado="1">

                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Ver Ejecutados</h6>
                        </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>
                    </div>

                </button>
            </div>

            <div class="col-12 d-flex gap-2">
                
                <button type="button" id="btn_descargar_excel"
                    class="btn btn-success btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i>
                    Excel
                </button>

                <button type="button" id="btn_home"
                    class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-arrow-left-circle-fill me-1"></i>
                    Ver otras evaluaciones
                </button>

            </div>

            <!-- Listado -->
            <div class="col-12">
                <div class="row g-3" id="lista_evaluaciones"></div>
            </div>

            
       

        `);

        // Mostrar pendientes por defecto
        mostrar_evaluaciones(2);

    }, 'json');
}


// Filtrar evaluaciones por estado
function mostrar_evaluaciones(estado) {

    $('#lista_evaluaciones').empty();

    let filtrados = respuesta.filter(item =>
        Number(item.is_status) === Number(estado)
    );

    if (filtrados.length === 0) {

        $('#lista_evaluaciones').html(`
            <div class="col-12">
                <div class="alert alert-light border text-center">
                    <i class="bi bi-inbox me-2"></i>
                    No hay evaluaciones ${
                        Number(estado) === 2 ? 'pendientes' : 'ejecutadas'
                    }.
                </div>
            </div>
        `);

        return;
    }

    $.each(filtrados, function (i, item) {

        // Estado 2 = Pendiente | Estado 1 = Ejecutado
        let color = Number(estado) === 2 ? 'danger' : 'success';

        let icon = Number(estado) === 2
            ? '<i class="bi bi-person-dash"></i>'
            : '<i class="bi bi-person-check"></i>';

     

        $('#lista_evaluaciones').append(`
            <div class=" col-12 clbr_evaluar" id="${item.id}">

                <button type="button"
                        class="card-evaluacion w-100 text-start">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-pares text-${color}">
                            ${icon}
                        </div>

                        <div class="flex-grow-1">

                            <h6 class="mb-1">
                                ${item.nm} ${item.ap}
                            </h6>

                            <p class="mb-2">
                                ${item.tipo}
                            </p>

                            <span class="badge bg-${color}-subtle text-${color}-emphasis">
                                <i class="bi bi-clock-history me-1"></i>
                                ${item.estado}
                            </span>

                        </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

                    </div>

                </button>

            <div class="content mt-2 mb-2">
                <div class="row g-3" id="pendientes_${item.id}">

                   

                </div>
            </div>
            




            </div>
        `);

    });
}


// Eventos de los botones de filtro
$(document).on('click', '.btn_filtrar_evaluacion', function () {

    let estado = $(this).data('estado');

    mostrar_evaluaciones(estado);

});


$(document).on('click', '#btn_descargar_excel', function () {

    if (!respuesta.length) {
        alert('No hay datos para exportar.');
        return;
    }

    $.ajax({
        url: '../excel/auto_evaluacion_reporte.php',
        type: 'POST',
        data: {
            respuesta: JSON.stringify(respuesta)
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (archivo) {

            let url = URL.createObjectURL(archivo);
            let enlace = document.createElement('a');

            enlace.href = url;
            enlace.download = 'Reporte_Valoracion_Kluane.xls';

            document.body.appendChild(enlace);
            enlace.click();
            enlace.remove();

            URL.revokeObjectURL(url);
        },
        error: function () {
            alert('No se pudo generar el archivo.');
        }
    });

});






function cargar_ejecuacion_evaluadores(t_evaluacion) {

    console.log('Tipo de evaluación:', t_evaluacion);

    $.post('../web/rutas.php?ruta=ejecucion_evaluadores', { t_evaluacion }, function (r) {

        console.log('Respuesta PHP:', r);

        respuesta = r;

        $('#seccion_evaluaciones').empty();

        $('#seccion_evaluaciones').append(`
            <div class="col-md-6">
                <button type="button"
                        class="card-evaluacion w-100 text-start btn_filtrar_evaluacion"
                        data-estado="2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Ver Pendientes</h6>
                        </div>
                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>
                    </div>
                </button>
            </div>

            <div class="col-md-6">
                <button type="button"
                        class="card-evaluacion w-100 text-start btn_filtrar_evaluacion"
                        data-estado="1">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Ver Ejecutados</h6>
                        </div>
                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>
                    </div>
                </button>
            </div>

            <div class="col-12">
                <button type="button" id="btn_home"
                        class="btn btn-primary btn-sm px-3 py-2 shadow-sm col-2">
                 <i class="bi bi-arrow-left-circle-fill"></i>   
                Ver otras evaluaciones
                </button>
            </div>

            <div class="col-12">
                <div class="row g-3" id="lista_evaluaciones"></div>
            </div>
        `);

        mostrar_evaluaciones(2);

    }, 'json').fail(function (xhr, status, error) {

        console.error('Error AJAX:', status);
        console.error('Detalle:', error);
        console.error('Respuesta del servidor:', xhr.responseText);

        $('#seccion_evaluaciones').html(`
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No se pudieron cargar las evaluaciones.
                Revisa la consola para conocer el error.
            </div>
        `);

    });
}



let id_Evaludaor  = 0;
$(document).on('click', '.clbr_evaluar', function () {

    let id = this.id;


  cargar_personas_a_evaluar(id);
  console.log(id);

});


///  cargar  personas evaluador 


function cargar_personas_a_evaluar(id){

    console.log(id);

    
    $.post('../web/rutas.php?ruta=evaluador_pendientes',{id}, function (r) {

   

        $('#pendientes_'+id).empty();
        
         
        evaluado = r ; 
         console.log(r);


          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#pendientes_'+id).append(


                    `
                         <!-- Evaluación de pares -->
            <div class="col-md-4 clbr_evaluar" data-ci="${item.ci}">

                <button type="button"
                        class="card-evaluacion w-100 text-start"
                        id="">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-pares">
                        <i class="bi bi-person-fill-check"></i>
                        </div>

                        <div class="flex-grow-1">

                                <h6 class="mb-1">
                                   ${item.names}
                                </h6>

                                <p class="mb-2">
                                    ${item.ci}
                                </p>

                                <span class="badge bg-info-subtle text-info-emphasis">
                                    <i class="bi bi-check2-circle"></i>
                                   Preguntas:  ${item.total}
                                </span>

                            </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

                    </div>

                </button>

            </div>
                       
                    
                    `
                );
         
            }
        });

                

    }, 'json');



}




$(document).on('click', '#btn_home', function () {
    location.reload();
});
