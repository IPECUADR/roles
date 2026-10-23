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
                  
             cargar_personas_a_evaluar(t_evaluacion);


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
            <div class="col-md-4">

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

            </div>
        `);

    });
}


// Eventos de los botones de filtro
$(document).on('click', '.btn_filtrar_evaluacion', function () {

    let estado = $(this).data('estado');

    mostrar_evaluaciones(estado);

});
