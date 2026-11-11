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




let t_ev = 0;

$(document).on('click', '.btn_resultados', function () {

    const t_evaluacion = Number(this.id);

    tipo_evaluacion = t_evaluacion;


    t_ev = tipo_evaluacion;

    console.log(tipo_evaluacion);


    switch (t_evaluacion) {
        case 1:
           
              cargar_auto_evaluacion_ejecucion (t_evaluacion);

            break;

        case 2:
                  
             cargar_ejecuacion_evaluadores(t_evaluacion);


            break;

        case 3:
             
             
              cargar_ejecuacion_evaluadores(t_evaluacion);
           
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
              <button type="button" id="btn_home"
                    class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-arrow-left-circle-fill me-1"></i>
                    Ver otras evaluaciones
                </button>
                
                <button type="button" id="btn_descargar_excel"
                    class="btn btn-success btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i>
                    Excel
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

//



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
            <div class=" col-md-4  clbr_evaluar" id="${item.id}">

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




// Filtrar evaluaciones por estado
function mostrar_evaluaciones_2(estado) {

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
                                ${item.nm}
                            </h6>

                            <p class="mb-2">
                                ${item.tipo_ev}
                            </p>

                            <span class="badge bg-${color}-subtle text-${color}-emphasis">
                                <i class="bi bi-clock-history me-1"></i>
                                ${item.est}
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

         <div class="col-12 d-flex gap-2">
                
            

                <button type="button" id="btn_home"
                    class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-arrow-left-circle-fill me-1"></i>
                    Ver otras evaluaciones
                </button>

               <button type="button" id="btn_excel_evaluadores"
                    class="btn btn-success btn-sm px-3 py-2 shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill me-1"></i>
                    Excel
                </button>

            </div>

            <div class="col-12">
                <div class="row g-3" id="lista_evaluaciones"></div>
            </div>
        `);

        mostrar_evaluaciones_2(2);

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

    
    $.post('../web/rutas.php?ruta=evaluador_pendientes',{id, t_ev}, function (r) {

   

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

///  genracion de reporte de ejecucion evaluadores

$(document).on('click', '#btn_excel_evaluadores', function () {



         $.post('../web/rutas.php?ruta=reporte_ejecucion_evaluador',{t_ev}, function (r) {
           
            genrar_reporte_evaluador(r);


            

        
          }, 'json');


});


function genrar_reporte_evaluador(r){


    if(t_ev == 2){
    
        c = 'evaluador';

    }else{

       c = 'pares';

    }

   if (!r.length) {
        alert('No hay datos para exportar.');
        return;
    }


    $.ajax({
        url: '../excel/reporte_evaluadores_ejecucion.php',
        type: 'POST',
        data: {
            respuesta: JSON.stringify(r)
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (archivo) {

            let url = URL.createObjectURL(archivo);
            let enlace = document.createElement('a');

            enlace.href = url;
            enlace.download = 'Reporte_'+c+'_ejecucion.xls';

            document.body.appendChild(enlace);
            enlace.click();
            enlace.remove();

            URL.revokeObjectURL(url);
        },
        error: function () {
            alert('No se pudo generar el archivo.');
        }
    });


}


  


$(document).on('click', '#btn_resultado_180', function () {

    console.log('Consultar resultados 180°');
    cargar_resultados_180();

});

$(document).on('click', '#btn_resultado_90', function () {

    console.log('Consultar resultados 90°');
    cargar_resultados_90();
});


results = [];
function cargar_resultados_90(){

   


  $.post('../web/rutas.php?ruta=reporte_Admin_90', function (r) {
           
            mostar_dato(r);

            results = r;
            t = '90°';
            cargar_grafica_general(t);
            $('#percepcion_organizacional').empty();


  }, 'json');





    }




///  function  cargar resultados 180 °

results = [];
function cargar_resultados_180(){

   


  $.post('../web/rutas.php?ruta=reporte_Admin', function (r) {
           
            mostar_dato(r);

            results = r;
            t = '180°';
            cargar_grafica_general(t);
            cargar_grafica_percepcion();


  }, 'json');





    }



function mostar_dato(r) {

    console.log(r);

    $('#tabla_resultados').empty();

    if (!r || r.length === 0) {
        $('#tabla_resultados').html(`
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    No existen resultados de valoración.
                </td>
            </tr>
        `);
        return;
    }

    contar = 0;
    let html = r.map(item => `

        <tr>

             <td>${++contar}</td>
            <td>${item.nom_p ?? ''}</td>
            <td>${item.ap_p ?? ''}</td>
            <td>${item.cargo ?? ''}</td>

            <td class="text-center">
                <span class="valor-indicador">
                    ${Number(item.TOTAL_KPI ?? 0).toFixed(2)}
                </span>
            </td>

            <td class="text-center">
                <span class="valor-indicador">
                    ${Number(item.TOTAL_HSE ?? 0).toFixed(2)}
                </span>
            </td>

            <td class="text-center">
                <span class="valor-indicador">
                    ${Number(item.TOTAL_COMPETENCIAS ?? 0).toFixed(2)}
                </span>
            </td>

            <td class="text-center">
                <span class="valor-total">
                    ${Number(item.TOTAL_EVALUACION ?? 0).toFixed(2)}
                </span>
            </td>

            <td>
                <div class="d-flex justify-content-center gap-2">

                    <button type="button"
                            class="btn btn-sm btn-outline-primary btn_informe_individual"
                            data-id="${item.PK_persona}"
                            title="Descargar informe individual">

                        <i class="bi bi-file-earmark-pdf"></i>

                    </button>

                    <button type="button"
                            class="btn btn-sm btn-outline-secondary btn_ver_mas"
                            data-id="${item.PK_persona}"
                            title="Ver más">

                        <i class="bi bi-eye"></i>

                    </button>

                </div>
            </td>

        </tr>

    `).join('');

    $('#tabla_resultados').html(html);

}


// BUSCAR EN LA TABLA
$(document).on('input', '#buscar_resultado', function () {

    let valor = $(this).val().toLowerCase().trim();

    $('#tabla_resultados tr').each(function () {

        let contenido = $(this).text().toLowerCase();

        $(this).toggle(contenido.includes(valor));

    });

});

// LIMPIAR BÚSQUEDA
$(document).on('click', '#limpiar_busqueda', function () {

    $('#buscar_resultado').val('');
    $('#tabla_resultados tr').show();

});

$(document).on('click', '#btn_pdf_informe_resultados', function () {

 generar_informe_desempeno();


})




$(document).on('click', '#btn_descargar_excel_de_califiaciones', function () {

    if (!results || results.length === 0) {
        mensaje('warning', 'No existen registros para exportar.');
        return;
    }

    $.ajax({
        url: '../excel/reporte_180.php',
        type: 'POST',
        data: {
            respuesta: JSON.stringify(results)
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (respuesta) {

            let blob = new Blob([respuesta], {
                type: 'application/vnd.ms-excel'
            });

            let url = window.URL.createObjectURL(blob);

            let enlace = document.createElement('a');
            enlace.href = url;
            enlace.download = 'Reporte_Valoracion_Desempeno_2026.xls';

            document.body.appendChild(enlace);
            enlace.click();

            document.body.removeChild(enlace);
            window.URL.revokeObjectURL(url);

        },
        error: function () {
            mensaje('error', 'No se pudo generar el reporte.');
        }
    });

});




function cargar_grafica_general(t){


    $('#graficas_resultados').empty().append(`

<div class="resultados-dashboard">

    <div class="resultados-header">
        <div>
            <span class="resultados-empresa">KLUANE DRILLING EC</span>
            <h4>RESULTADOS GENERALES EVALUACIÓN ${t} </h4>
            <p>Valoración del Desempeño 2026</p>
        </div>
        <div class="resultados-icon">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
    </div>

    <div class="row g-3 mb-4" id="resumen_general"></div>

    <div class="card resultados-chart-card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-1">Valoración de Desempeño</h6>
                    <small class="text-muted">Promedio general por componente</small>
                </div>
                <span class="badge bg-light text-dark">2026</span>
            </div>

            <div class="grafica-triangular">
                <canvas id="grafica_resultados_general"></canvas>
            </div>

            <div class="resultado-final">
                <span>VALORACIÓN FINAL PROMEDIO</span>
                <strong id="promedio_valoracion">0.00</strong>
                <small>Sobre una escala de 125 puntos</small>
            </div>

        </div>
    </div>

</div>


    `);

    if (!results || results.length === 0) {
        $('#resumen_general').empty();
        $('#promedio_valoracion').text('0.00');
        return;
    }

    let total = results.length;

    let kpi = 0;
    let hse = 0;
    let competencias = 0;
    let valoracion = 0;

    results.forEach(item => {

        kpi += Number(item.TOTAL_KPI || 0);
        hse += Number(item.TOTAL_HSE || 0);
        competencias += Number(item.TOTAL_COMPETENCIAS || 0);
        valoracion += Number(item.TOTAL_EVALUACION || 0);

    });

    let promedio = {
        KPI: kpi / total,
        HSE: hse / total,
        COMPETENCIAS: competencias / total,
        VALORACION: valoracion / total
    };

    $('#promedio_valoracion').text(promedio.VALORACION.toFixed(2));


    // TARJETAS DE RESULTADOS

    let tarjetas = [
        {
            titulo: 'KPI',
            valor: promedio.KPI,
            color: '#24476B',
            icono: 'bi-speedometer2'
        },
        {
            titulo: 'HSE',
            valor: promedio.HSE,
            color: '#198754',
            icono: 'bi-shield-check'
        },
        {
            titulo: 'COMPETENCIAS',
            valor: promedio.COMPETENCIAS,
            color: '#64748b',
            icono: 'bi-people'
        },
        {
            titulo: 'VALORACIÓN FINAL',
            valor: promedio.VALORACION,
            color: '#17365d',
            icono: 'bi-award'
        }
    ];

    let html = '';

    tarjetas.forEach(item => {

        let avance = Math.max(0, Math.min((item.valor / 125) * 100, 100));

        html += `
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="resultado-card">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="resultado-titulo">${item.titulo}</span>
                        <i class="bi ${item.icono}" style="color:${item.color};font-size:19px"></i>
                    </div>

                    <strong class="resultado-valor">
                        ${item.valor.toFixed(2)}
                    </strong>

                    <div class="progress mb-2">
                        <div class="progress-bar"
                             role="progressbar"
                             style="width:${avance}%;background:${item.color}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="resultado-escala">Avance</span>
                        <span class="resultado-escala fw-bold">
                            ${avance.toFixed(1)}%
                        </span>
                    </div>

                </div>
            </div>
        `;

    });

    $('#resumen_general').html(html);


    // GRÁFICA TRIANGULAR

    let canvas = document.getElementById('grafica_resultados_general');

    if (window.graficaGeneral) {
        window.graficaGeneral.destroy();
    }

    window.graficaGeneral = new Chart(canvas, {

        type: 'radar',

        data: {
            labels: ['KPI', 'HSE', 'COMPETENCIAS'],

            datasets: [{
                label: 'Promedio general',

                data: [
                    promedio.KPI,
                    promedio.HSE,
                    promedio.COMPETENCIAS
                ],

                backgroundColor: 'rgba(23, 54, 93, 0.15)',
                borderColor: '#17365d',
                borderWidth: 2,
                pointBackgroundColor: '#17365d',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                r: {
                    min: 0,
                    max: 125,
                    ticks: {
                        stepSize: 25,
                        backdropColor: 'transparent'
                    },
                    grid: {
                        color: '#e5eaf0'
                    },
                    angleLines: {
                        color: '#e5eaf0'
                    },
                    pointLabels: {
                        color: '#475569',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            }
        }

    });

}








function cargar_grafica_percepcion() {

$('#percepcion_organizacional').empty().append(`


       <div class="card-body">

        <div class="mb-4">
            <h6 class="fw-bold mb-1">Análisis de percepción organizacional</h6>
            <small class="text-muted">
                Comparativa de resultados entre autoevaluación, jefatura y pares
            </small>
        </div>

        <div class="row g-3" id="cuadros_percepcion"></div>

    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="mb-3">
            <h6 class="fw-bold mb-1">Gráfica de valoración</h6>
            <small class="text-muted">
                Comportamiento comparativo de las percepciones por componente
            </small>
        </div>

        <div style="height:370px;">
            <canvas id="grafica_percepcion"></canvas>
        </div>

    </div>
        
        
        
        `);


    if (!Array.isArray(results) || results.length === 0) {

        $('#cuadros_percepcion').empty();

        if (window.graficaPercepcion) {
            window.graficaPercepcion.destroy();
        }

        return;
    }


    // ACUMULADORES
    let datos = {
        auto: {
            HSE: 0,
            COMPETENCIAS: 0,
            KPI: 0
        },
        jefe: {
            HSE: 0,
            COMPETENCIAS: 0,
            KPI: 0
        },
        pares: {
            COMPETENCIAS: 0
        }
    };


    // CONTADORES
    let conteo = {
        auto: {
            HSE: 0,
            COMPETENCIAS: 0,
            KPI: 0
        },
        jefe: {
            HSE: 0,
            COMPETENCIAS: 0,
            KPI: 0
        },
        pares: {
            COMPETENCIAS: 0
        }
    };


    // RECORRER RESULTADOS
    results.forEach(item => {

        // AUTOEVALUACIÓN Y JEFATURA
        ['HSE', 'COMPETENCIAS', 'KPI'].forEach(tipo => {

            ['auto', 'jefe'].forEach(origen => {

                let campo = origen.toUpperCase() + '_' + tipo;
                let valor = item[campo];

                if (valor !== null && valor !== undefined && valor !== '') {

                    valor = Number(valor);

                    if (Number.isFinite(valor)) {

                        datos[origen][tipo] += valor;
                        conteo[origen][tipo]++;

                    }

                }

            });

        });


        // EVALUACIÓN DE PARES
        if (Number(item.EXISTE_PARES) > 0) {

            let valor = Number(item.PARES_COMPETENCIAS);

            if (Number.isFinite(valor)) {

                datos.pares.COMPETENCIAS += valor;
                conteo.pares.COMPETENCIAS++;

            }

        }

    });


    // CALCULAR PROMEDIOS
    function promedio(origen, tipo) {

        if (conteo[origen][tipo] === 0) {
            return null;
        }

        return datos[origen][tipo] / conteo[origen][tipo];

    }


    let percepcion = {

        HSE: {
            auto: promedio('auto', 'HSE'),
            jefe: promedio('jefe', 'HSE'),
            pares: null
        },

        COMPETENCIAS: {
            auto: promedio('auto', 'COMPETENCIAS'),
            jefe: promedio('jefe', 'COMPETENCIAS'),
            pares: promedio('pares', 'COMPETENCIAS')
        },

        KPI: {
            auto: promedio('auto', 'KPI'),
            jefe: promedio('jefe', 'KPI'),
            pares: null
        }

    };


    // CONSTRUIR CUADROS COMPARATIVOS
    let componentes = [
        {
            nombre: 'HSE',
            descripcion: 'Seguridad, salud y ambiente',
            datos: percepcion.HSE
        },
        {
            nombre: 'COMPETENCIAS',
            descripcion: 'Evaluación de competencias',
            datos: percepcion.COMPETENCIAS
        },
        {
            nombre: 'KPI',
            descripcion: 'Indicadores de desempeño',
            datos: percepcion.KPI
        }
    ];


    let html = '';

    componentes.forEach(componente => {

        let auto = componente.datos.auto;
        let jefe = componente.datos.jefe;
        let pares = componente.datos.pares;

        let diferencia = (auto !== null && jefe !== null)
            ? Math.abs(auto - jefe)
            : null;


        html += `
            <div class="col-12 col-md-6 col-xl-4">

                <div class="percepcion-card">

                    <div class="percepcion-titulo">
                        ${componente.nombre}
                    </div>

                    <small class="text-muted d-block mb-3">
                        ${componente.descripcion}
                    </small>

                    ${crearFilaPercepcion(
                        'Autoevaluación',
                        auto,
                        'percepcion-auto'
                    )}

                    ${crearFilaPercepcion(
                        'Jefatura',
                        jefe,
                        'percepcion-jefe'
                    )}

                    ${crearFilaPercepcion(
                        'Evaluación de pares',
                        pares,
                        'percepcion-pares'
                    )}

                    <div class="percepcion-brecha">
                        <span>Brecha auto / jefatura</span>

                        <strong>
                            ${diferencia !== null
                                ? diferencia.toFixed(2)
                                : 'N/D'}
                        </strong>
                    </div>

                </div>

            </div>
        `;

    });


    $('#cuadros_percepcion').html(html);


    // GRÁFICA DE VALORACIÓN
    let canvas = document.getElementById('grafica_percepcion');

    if (window.graficaPercepcion) {
        window.graficaPercepcion.destroy();
    }


    window.graficaPercepcion = new Chart(canvas, {

        type: 'radar',

        data: {

            labels: [
                'HSE',
                'Competencias',
                'KPI'
            ],

            datasets: [

                {
                    label: 'Autoevaluación',

                    data: [
                        percepcion.HSE.auto,
                        percepcion.COMPETENCIAS.auto,
                        percepcion.KPI.auto
                    ],

                    backgroundColor: 'rgba(36, 71, 107, 0.12)',
                    borderColor: '#24476B',
                    pointBackgroundColor: '#24476B',
                    borderWidth: 2,
                    pointRadius: 4
                },

                {
                    label: 'Jefatura',

                    data: [
                        percepcion.HSE.jefe,
                        percepcion.COMPETENCIAS.jefe,
                        percepcion.KPI.jefe
                    ],

                    backgroundColor: 'rgba(25, 135, 84, 0.10)',
                    borderColor: '#198754',
                    pointBackgroundColor: '#198754',
                    borderWidth: 2,
                    pointRadius: 4
                },

                {
                    label: 'Pares',

                    data: [
                        null,
                        percepcion.COMPETENCIAS.pares,
                        null
                    ],

                    backgroundColor: 'rgba(214, 168, 79, 0.10)',
                    borderColor: '#D6A84F',
                    pointBackgroundColor: '#D6A84F',
                    borderWidth: 2,
                    pointRadius: 5
                }

            ]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    position: 'bottom',

                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }

            },

            scales: {

                r: {

                    beginAtZero: true,
                    min: 0,
                    max: 125,

                    ticks: {
                        stepSize: 25,
                        backdropColor: 'transparent'
                    },

                    grid: {
                        color: '#e5eaf0'
                    },

                    angleLines: {
                        color: '#e5eaf0'
                    },

                    pointLabels: {
                        color: '#475569',

                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }

                }

            }

        }

    });

}


// FUNCIÓN PARA CONSTRUIR CADA FILA
function crearFilaPercepcion(titulo, valor, clase) {

    if (valor === null) {

        return `
            <div class="percepcion-item">

                <div class="percepcion-label">
                    <span>${titulo}</span>
                    <span class="percepcion-sin-datos">Sin evaluación</span>
                </div>

            </div>
        `;

    }

    let avance = Math.max(0, Math.min((valor / 125) * 100, 100));

    return `
        <div class="percepcion-item">

            <div class="percepcion-label">

                <span>${titulo}</span>

                <strong class="percepcion-valor">
                    ${valor.toFixed(2)}
                </strong>

            </div>

            <div class="percepcion-progress">

                <div class="percepcion-progress-bar ${clase}"
                     style="width:${avance}%">
                </div>

            </div>

        </div>
    `;

}



function generar_informe_desempeno() {

     if (!results || results.length === 0) {
        mensaje('warning', 'No existen registros para exportar.');
        return;
    }


    let ventana = window.open('', '_blank');

    $.ajax({
        url: '../pdf/informe_general.php',
        type: 'POST',
        data: {
            respuesta: JSON.stringify(results)
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(blob) {

            let url = URL.createObjectURL(blob);
            ventana.location.href = url;

            setTimeout(() => URL.revokeObjectURL(url), 60000);
        },
        error: function() {
            ventana.close();
            mensaje('error', 'Error al generar el informe PDF.');
        }
    });
}