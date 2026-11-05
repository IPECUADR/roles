 $(document).ready(function () {

 validate_Evaluaciones_Asignadas();
 


   
});
 
/// contarcargar 

function validate_Evaluaciones_Asignadas(){

    $.post('../web/rutas.php?ruta=evaluaciones', function (r) {

   

        $('#seccion_evaluaciones').empty();
        
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

                if(item.st == 2){

                    color = 'danger';

                     elemnt_acc = 'elemnt_evaluacion';


                     /// si  tiene evaluaciones pendientes
                      indicaciones_evaluar_kde();

                }else{


                      color = 'success';

                     elemnt_acc = 'secc_ejecutados';

                      validate_resultados_Evaluaciones();

                       $('#seccion_evaluar').empty().append();
                       $('#seccion_evaluaciones').empty().append();
                       felicitacionResultados();


                   
                    


                }


                $('#seccion_evaluaciones').append(


                    `
                         <!-- Evaluación de pares -->
            <div class="col-md-4 ${elemnt_acc}" id="${item.t_ev}">

                <button type="button"
                        class="card-evaluacion w-100 text-start"
                        id="">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-pares">
                         <i class="bi bi-clipboard2-check-fill"></i>
                        </div>

                        <div class="flex-grow-1">

                                <h6 class="mb-1">
                                   ${item.tipo}
                                </h6>

                                <p class="mb-2">
                                    ${item.text}
                                </p>

                                <span class="badge bg-${color}-subtle text-${color}-emphasis">
                                    <i class="bi bi-clock-history me-1"></i>
                                    ${item.stado}
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


let tipo_evaluacion = 0;

$(document).on('click', '.elemnt_evaluacion', function () {

    const t_evaluacion = Number(this.id);

    tipo_evaluacion = t_evaluacion;

    switch (t_evaluacion) {
        case 1:
           
              cargar_auto_evaluacion (t_evaluacion);

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


let evaluado = [];

// evaluador// cargar personas
function cargar_personas_a_evaluar(t_evaluacion){

    console.log(t_evaluacion);

    
    $.post('../web/rutas.php?ruta=evaluador',{t_evaluacion}, function (r) {

   

        $('#seccion_evaluar').empty();
        
         
        evaluado = r ; 
         console.log(r);


          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#seccion_evaluar').append(


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
















function indicaciones_evaluar_kde(){

    



         title =  ` <i class="bi bi-info-circle-fill"></i>  Informacion `;
                   
         
         content =  ` 


                <div class="alert bg-light border rounded-3 shadow-sm p-3">

                    <p class="mb-3 text-secondary">
                        Evalúa el desempeño según la frecuencia con la que se evidencia
                        el comportamiento, utilizando una calificación de
                        <strong class="text-dark">0 a 100</strong>:
                    </p>

                    <div class="list-group mb-3">

                        <div class="list-group-item d-flex align-items-center gap-3 py-3">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                90 - 100
                            </span>
                            <span>El comportamiento se evidencia <strong>siempre</strong>.</span>
                        </div>

                        <div class="list-group-item d-flex align-items-center gap-3 py-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                80 - 89
                            </span>
                            <span>El comportamiento se evidencia <strong>constantemente</strong>.</span>
                        </div>

                        <div class="list-group-item d-flex align-items-center gap-3 py-3">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                70 - 79
                            </span>
                            <span>El comportamiento se evidencia <strong>parcialmente</strong>.</span>
                        </div>

                        <div class="list-group-item d-flex align-items-center gap-3 py-3">
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                0 - 69
                            </span>
                            <span>El comportamiento <strong>no se evidencia</strong>.</span>
                        </div>

                    </div>

                    <div class="d-flex align-items-start gap-2 text-secondary">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <small>
                            <strong>Importante:</strong> Ingresa únicamente números enteros,
                            sin decimales ni el símbolo de porcentaje (%).
                        </small>
                    </div>

                </div>

                    
       


                    `;

                    accions =  `
                    
      

                 <div class="col-12">
                        <button type="button"
                                class="btn btn-success w-100 py-3 rounded-3 shadow-sm fw-semibold"
                                id="btn_close">
                           <i class="bi bi-chat-heart-fill"></i>
                            ¡Gracias por tus consejos y recomendaciones!
                        </button>
                    </div>

                `;


modal_ensamble(title, content, accions );

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


$(document).on('click', '#btn_close', function () {
   $('#modal_service').modal('hide'); 


}); 


$(document).on('click', '#btn_close', function () {
   $('#modal_evaluar_clbr').modal('hide'); 
  
}); 






////  carga de personas asignadas // evaluador 

let p  = 0;
$(document).on('click', '.clbr_evaluar', function () {

    const persona = $(this).data('ci');

    p = persona;

    ensamble_evaludor(persona);

});

function ensamble_evaludor(persona){


    $.post('../web/rutas.php?ruta=elemntos_valoracion',{persona, tipo_evaluacion}, function (r) {

   

        $('#elemnto_evaluacion').empty();
        
     console.log(r);
     

          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#elemnto_evaluacion').append(


                    `
                         
                <button type="button"
                        class="card-evaluacion w-100 text-start mt-2 mb-2 btn_cargar_preguntas"
                        id="${item.id}">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-auto">
                         <i class="bi bi-clipboard2-data-fill"></i>
                        </div>

                         <div class="flex-grow-1">

                                <h6 class="mb-1">
                                   ${item.b}
                                </h6>

                             

                              <span class="badge bg-info-subtle text-info-emphasis">
                                    <i class="bi bi-check2-circle"></i>
                                    Preguntas: <span class="contador-preguntas">${item.ct}</span>
                                </span>

                            </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

                    </div>

                </button>
             
                       
                    
                    `
                );
         
            }
        });

                

    }, 'json');



let item = evaluado.find(item => String(item.ci) === String(persona));

console.log(item);

   let  t =  ` 


  <div class="d-flex align-items-center justify-content-between w-100">

    <div class="d-flex align-items-center gap-3">

  

        <div>
            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 mb-2">
                <i class="bi bi-bar-chart-line-fill me-1"></i>
                Evaluación de Desempeño
            </span>

            <h4 class="modal-title fw-bold mb-1 text-dark">
                ${item.names}
            </h4>

            <small class="text-secondary">
                Valore objetivamente el desempeño del colaborador
            </small>
        </div>

    </div>

    <button type="button"
            class="btn btn-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm"
            data-bs-dismiss="modal"
            aria-label="Cerrar"
            style="width:42px;height:42px;">
        <i class="bi bi-x-lg"></i>
    </button>

</div>

   
   
   
   `;
                   
         
       let   b =  ` 

  
<div class="container-fluid bg-light">

    <div class="row align-items-start g-3">

        <div class="col-12 col-lg-5">

            <div class="col-12" id="elemnto_evaluacion" data-ci="${item.ci}">

            </div>

        </div>

        <div class="col-12 col-lg-7" id="preguntas_respuesta">

        </div>

    </div>

</div>



                    
       


                    `;

                    let f =  `
                    
      

                 <div class="col-3">
                        <button type="button"
                                class="btn btn-danger w-100  rounded-3 shadow-sm fw-semibold"
                                id="btn_close">
                         Cerrar
                           
                        </button>
                    </div>

                `;

         modal_Evaluador(t, b, f);

}

function modal_Evaluador(t, b, f){

          $('#modal_evaluar_clbr').modal('show'); 
          $('#titulo_modal').empty().append(t);
          $('#modal_body').empty().append(b);
          $('#modal_footer').empty().append(f);







}

///cargar preguntas


let id_base = 0;
$(document).on('click', '.btn_cargar_preguntas', function () {

    let id = this.id;
    id_base = id;

    $('#preguntas_respuesta').html(`
        <div class="d-flex flex-column align-items-center justify-content-center py-5">

            <div class="spinner-border text-primary mb-3"
                 role="status"
                 style="width: 2.5rem; height: 2.5rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>

            <h6 class="fw-semibold text-dark mb-1">
                Preparando evaluación
            </h6>

            <small class="text-muted">
                Cargando las preguntas, un momento...
            </small>

        </div>
    `);

   setTimeout(() => {
    cargar_preguntas_evaluador(p, id);
}, 500);

});


function cargar_preguntas_evaluador(p,id){

console.log(tipo_evaluacion);

$.post('../web/rutas.php?ruta=preguntas_evaluador', { p: p, id: id, tp: tipo_evaluacion }, function (r) {

    console.log(r);

    $('#preguntas_respuesta').empty();

    if (r.err) {
        console.log(r.msg);
        return;
    }
     
    contar = 1;

    $.each(r, function (i, item) {

        $('#preguntas_respuesta').append(`
           
          

<div class="card border-0 shadow  rounded-4 mb-3">
    <div class="card-body p-4" id="${item.id}">

        <div class="bg-light rounded-3 p-3 mb-4">

            <div class="d-flex justify-content-end mb-2">
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    Pregunta ${contar++}
                </span>
            </div>

            
                <h6 class="fw-semibold mb-0 lh-base d-flex align-items-start gap-2">
                    <i class="bi bi-chevron-right flex-shrink-0 mt-1"
                    style="-webkit-text-stroke: 1px;"></i>
                    <span>${item.p}</span>
                </h6>

        </div>

        <label for="respuesta_${item.id}" class="form-label fw-semibold">
            Tu calificación
        </label>

        <div class="input-group">
            <input
                type="number"
                class="form-control"
                id="respuesta_${item.id}"
                min="0"
                max="100"
                step="1"
                placeholder="Ingresa un valor de 0 a 100"
                aria-describedby="validacion_respuesta_${item.id}"
            >

            <span class="input-group-text bg-white fw-bold text-muted">
                / 100
            </span>
        </div>

        <button
            type="button"
            class="btn btn-success w-100 rounded-3 shadow-sm fw-semibold mt-3"
            id="btn_save_respuesta"
            data-id="${item.id}">
            <i class="bi bi-check-circle me-2"></i>
            Guardar respuesta
        </button>

        <div id="validacion_respuesta_${item.id}" class="form-text mt-2">
            <i class="bi bi-info-circle me-1"></i>
            Ingresa un número entero entre 0 y 100.
        </div>

    </div>
</div>


            
        `);
    });

}, 'json').fail(function (xhr) {
    console.error('Error en la petición:', xhr.responseText);
});


}


$(document).on('click', '#btn_save_respuesta', function () {

    let id = $(this).data('id');
    let valor = $(`#respuesta_${id}`).val();

    console.log(id);

    if (valor === '' || !Number.isInteger(Number(valor))) {
        mensaje('info', 'Ingresa un número entero válido.');
        return;
    }

    valor = Number(valor);

    if (valor < 0) {
        mensaje('info', 'No se permiten valores negativos.');
        return;
    }

    if (valor > 100) {
        mensaje('info', 'La calificación máxima es 100.');
        return;
    }

    save_respuesta(id, valor);

});


function save_respuesta(id, valor) {

    $.post('../web/rutas.php?ruta=up_item_evaluacion_des', {
        id: id,
        valor: valor
    }, function (r) {

        if (r.err) {
            mensaje('info', r.msg);
            return;
        }

        mensaje('success', 'Respuesta guardada correctamente.');

        // Buscar la tarjeta de la evaluación seleccionada
        let tarjeta = $('#elemnto_evaluacion')
            .find('button[id="' + id_base + '"]');

        // Obtener el contador actual
        let contador = tarjeta.find('.contador-preguntas');
        let pendientes = parseInt(contador.text(), 10);

        // Descontar una pregunta
        pendientes--;

        if (pendientes <= 0) {

            // Eliminar la tarjeta si ya no quedan preguntas
            tarjeta.remove();

        } else {

            // Actualizar el contador
            contador.text(pendientes);

        }

        // Eliminar la pregunta que acabamos de responder
        $('#preguntas_respuesta')
            .find('[id="' + id + '"]')
            .closest('.card')
            .remove();

        // Si no quedan preguntas visibles
        if ($('#preguntas_respuesta .card').length === 0) {

            $('#preguntas_respuesta').html(`
                <div class="alert alert-success text-center rounded-4 p-4">
                    <i class="bi bi-check-circle-fill fs-1"></i>
                    <h5 class="fw-bold mt-3">
                        ¡Evaluación completada!
                    </h5>
                    <p class="mb-0">
                        Has respondido todas las preguntas de esta evaluación.
                    </p>
                </div>
            `);

        }

    }, 'json').fail(function () {

        mensaje('error', 'No se pudo guardar la respuesta.');

    });

}





/// cargar auto evaluacion


let auto_evaluacion = 0;

function cargar_auto_evaluacion(t_evaluacion){

    auto_evaluacion = t_evaluacion;


      $('#seccion_evaluar').empty();



    $.post('../web/rutas.php?ruta=aut_ev_elementos',{t_evaluacion}, function (r) {

   

        $('#seccion_evaluar').append(


                `

                            <div class="container-fluid  mt-2">

                                <div class="row align-items-start g-3">

                                    <div class="col-12 col-lg-5">

                                        <div class="col-12" id="elemnto_evaluacion" >

                                        </div>

                                    </div>

                                    <div class="col-12 col-lg-7" id="preguntas_respuesta">

                                    </div>

                                </div>

                            </div>


                `
        );
        
        ;

        
         $('#elemnto_evaluacion').empty();
        
     console.log(r);
     

          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#elemnto_evaluacion').append(


                    `
                         
                <button type="button"
                        class="card-evaluacion w-100 text-start mt-2 mb-2 btn_cargar_preguntas_aut"
                        id="${item.id}">

                    <div class="d-flex align-items-center gap-3">

                        <div class="evaluacion-icono icono-auto">
                         <i class="bi bi-clipboard2-data-fill"></i>
                        </div>

                         <div class="flex-grow-1">

                                <h6 class="mb-1">
                                   ${item.b}
                                </h6>

                             

                             <span class="badge bg-info-subtle text-info-emphasis">
                                <i class="bi bi-check2-circle"></i>
                                Preguntas: <span class="contador-preguntas">${item.ct}</span>
                            </span>

                            </div>

                        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

                    </div>

                </button>
             
                       
                    
                    `
                );
         
            }
        });

                

    }, 'json');


}




/// seccion  cargar pregunstas auto evaluacion 



let id_base_aut = 0;
$(document).on('click', '.btn_cargar_preguntas_aut', function () {

    let id = this.id;
    id_base_aut = id;

    $('#preguntas_respuesta').html(`
        <div class="d-flex flex-column align-items-center justify-content-center py-5">

            <div class="spinner-border text-primary mb-3"
                 role="status"
                 style="width: 2.5rem; height: 2.5rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>

            <h6 class="fw-semibold text-dark mb-1">
                Preparando evaluación
            </h6>

            <small class="text-muted">
                Cargando las preguntas, un momento...
            </small>

        </div>
    `);

   setTimeout(() => {
    cargar_preguntas_auto_Evaluacion(id);
}, 500);

});




function cargar_preguntas_auto_Evaluacion(id){



 $('#preguntas_respuesta').empty();

 

$.post('../web/rutas.php?ruta=aut_cg_preguntas', {  id: id }, function (r) {

    console.log(r);


    if (r.err) {
        console.log(r.msg);
        return;
    }
     
    contar = 1;

    $.each(r, function (i, item) {

        $('#preguntas_respuesta').append(`
           
          

<div class="card border-0 shadow  rounded-4 mb-3">
    <div class="card-body p-4" id="${item.id}">

        <div class="bg-light rounded-3 p-3 mb-4">

            <div class="d-flex justify-content-end mb-2">
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    Pregunta ${contar++}
                </span>
            </div>

            
                <h6 class="fw-semibold mb-0 lh-base d-flex align-items-start gap-2">
                    <i class="bi bi-chevron-right flex-shrink-0 mt-1"
                    style="-webkit-text-stroke: 1px;"></i>
                    <span>${item.p}</span>
                </h6>

        </div>

        <label for="respuesta_${item.id}" class="form-label fw-semibold">
            Tu calificación
        </label>

        <div class="input-group">
            <input
                type="number"
                class="form-control"
                id="respuesta_${item.id}"
                min="0"
                max="100"
                step="1"
                placeholder="Ingresa un valor de 0 a 100"
                aria-describedby="validacion_respuesta_${item.id}"
            >

            <span class="input-group-text bg-white fw-bold text-muted">
                / 100
            </span>
        </div>

        <button
            type="button"
            class="btn btn-success w-100 rounded-3 shadow-sm fw-semibold mt-3"
            id="btn_save_respuesta_aut"
            data-id="${item.id}">
            <i class="bi bi-check-circle me-2"></i>
            Guardar respuesta
        </button>

        <div id="validacion_respuesta_${item.id}" class="form-text mt-2">
            <i class="bi bi-info-circle me-1"></i>
            Ingresa un número entero entre 0 y 100.
        </div>

    </div>
</div>


            
        `);
    });

}, 'json').fail(function (xhr) {
    console.error('Error en la petición:', xhr.responseText);
});


}




/// guardar respuestas auto_evaluacion 



$(document).on('click', '#btn_save_respuesta_aut', function () {

    let id = $(this).data('id');
    let valor = $(`#respuesta_${id}`).val();

    console.log(id);

    if (valor === '' || !Number.isInteger(Number(valor))) {
        mensaje('info', 'Ingresa un número entero válido.');
        return;
    }

    valor = Number(valor);

    if (valor < 0) {
        mensaje('info', 'No se permiten valores negativos.');
        return;
    }

    if (valor > 100) {
        mensaje('info', 'La calificación máxima es 100.');
        return;
    }

    save_respuesta_aut_ev(id, valor);

});


function save_respuesta_aut_ev(id, valor) {

    $.post('../web/rutas.php?ruta=up_item_evaluacion_des', {
        id: id,
        valor: valor
    }, function (r) {

        if (r.err) {
            mensaje('info', r.msg);
            return;
        }

        mensaje('success', 'Respuesta guardada correctamente.');

        // Buscar la tarjeta de autoevaluación seleccionada
        let tarjeta = $('#elemnto_evaluacion')
            .find('.btn_cargar_preguntas_aut')
            .filter(function () {
                return this.id == id_base_aut;
            });

        let contador = tarjeta.find('.contador-preguntas');

        console.log('Evaluación:', id_base_aut);
        console.log('Tarjeta encontrada:', tarjeta.length);
        console.log('Contador encontrado:', contador.length);

        // Actualizar contador
        if (contador.length) {

            let pendientes = parseInt(contador.text(), 10);

            if (!Number.isNaN(pendientes)) {

                pendientes--;

                if (pendientes <= 0) {

                    tarjeta.remove();

                    // Limpiar el panel si no quedan evaluaciones
                    if ($('#elemnto_evaluacion .btn_cargar_preguntas_aut').length === 0) {

                        $('#preguntas_respuesta').html(`
                            <div class="alert alert-success text-center rounded-4 p-4">
                                <i class="bi bi-check-circle-fill fs-1"></i>
                                <h5 class="fw-bold mt-3">
                                    ¡Autoevaluación completada!
                                </h5>
                                <p class="mb-0">
                                    Has respondido todas las preguntas pendientes.
                                </p>
                            </div>
                        `);

                    }

                } else {

                    contador.text(pendientes);

                }

            }
        }

        // Eliminar únicamente la pregunta respondida
        $('#preguntas_respuesta')
            .find('.card-body[id="' + id + '"]')
            .closest('.card')
            .remove();

        // Mostrar mensaje si ya no quedan preguntas en la evaluación
        if ($('#preguntas_respuesta .card').length === 0 &&
            $('#elemnto_evaluacion .btn_cargar_preguntas_aut').length > 0) {

            $('#preguntas_respuesta').html(`
                <div class="alert alert-success text-center rounded-4 p-4">
                    <i class="bi bi-check-circle-fill fs-1"></i>
                    <h5 class="fw-bold mt-3">
                        ¡Evaluación completada!
                    </h5>
                    <p class="mb-0">
                        Has respondido todas las preguntas de esta evaluación.
                    </p>
                </div>
            `);

        }

    }, 'json').fail(function () {

        mensaje('error', 'No se pudo guardar la respuesta.');

    });

}



/// /ver ejecutados // valordacion desempeño 


let ev_tip_ejecutado = 0;

$(document).on('click', '.secc_ejecutados', function () {


   

    const t_evaluacion_ej = Number(this.id);

    let ev_tip_ejecutado  = t_evaluacion_ej;


    console.log(t_evaluacion_ej);

    switch (t_evaluacion_ej) {
        case 1:
           
              cargar_auto_evaluacion_ejecutados (t_evaluacion_ej);

            break;

        case 2:
                  
             cargar_personas_evaluadas(t_evaluacion_ej);


            break;

        case 3:
             
             
              cargar_personas_evaluadas(t_evaluacion_ej);
           
              break;

        default:
            console.warn('Tipo de evaluación no válido:', t_evaluacion);
            break;
    }

});






function cargar_auto_evaluacion_ejecutados(t_evaluacion){

  


      $('#seccion_evaluar').empty();



    $.post('../web/rutas.php?ruta=aut_ev_elements_ejecutados',{t_evaluacion}, function (r) {

   

        $('#seccion_evaluar').append(


                `

                  <div class="container-fluid mt-2">

                    <div class="row align-items-start g-3">

                        <!-- Sección de evaluaciones realizadas -->
                        <div class="col-12" id="elemnto_evaluacion">

                           

                        </div>

                        <!-- Sección de preguntas y respuestas -->
                        <div class="col-12" id="preguntas_respuesta">
                        </div>

                    </div>

                </div>


                `
        );
        
        ;

        
         $('#elemnto_evaluacion').empty();
        
     console.log(r);
     

          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#elemnto_evaluacion').append(


                    `
                         
          
<button type="button"
        class="card-evaluacion w-100 text-start mt-2 mb-2 "
        id="${item.id}">

    <div class="d-flex align-items-center gap-3">

        <div class="evaluacion-icono icono-auto">
            <i class="bi bi-clipboard2-data-fill"></i>
        </div>

        <div class="flex-grow-1">

            <h6 class="mb-2">
                ${item.b}
            </h6>

            <span class="badge bg-info-subtle text-info-emphasis">
                <i class="bi bi-list-check me-1"></i>
                Preguntas: <span class="contador-preguntas">${item.ct}</span>
            </span>

            <div class="mt-2">
                <span class="badge bg-primary-subtle text-primary-emphasis border border-success-subtle rounded-pill px-3 py-2">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Autoevaluación completada
                </span>
            </div>

        </div>

        <i class="bi bi-arrow-right-circle flecha-evaluacion"></i>

    </div>

</button>

             
                       
                    
                    `
                );
         
            }
        });

                

    }, 'json');


}




///// evaluaciones ejecutadas


// evaluador// cargar personas
function cargar_personas_evaluadas(t_evaluacion_ej){

    console.log(t_evaluacion_ej);

    
    $.post('../web/rutas.php?ruta=evaluador_ejecutados',{t_evaluacion_ej}, function (r) {

   

        $('#seccion_evaluar').empty();
        
         
        evaluado = r ; 
         console.log(r);


          $.each(r, function (i, item) {
            if (i !== 'err') {

                


                $('#seccion_evaluar').append(


                    `
      
<!-- Evaluación de pares -->
<div class="col-md-4 " data-ci="${item.ci}">

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

                <p class="mb-2 text-muted">
                    ${item.ci}
                </p>

                <span class="badge bg-info-subtle text-info-emphasis">
                    <i class="bi bi-list-check me-1"></i>
                    Preguntas: ${item.total}
                </span>

                <div class="mt-2">
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill px-3 py-2">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Proceso completado
                    </span>
                </div>

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


//accciones de resultados valoracion de desempeño 


/// resultados evaluaciones 


function validate_resultados_Evaluaciones() {

    $.post('../web/rutas.php?ruta=resultados', function (r) {

        console.log(r);

        if (r.err) {
            console.log(r.msg);
            return;
        }

        $('#seccion_Resultados').html(`

            <div class="container-fluid py-3" id="valoracion_desempeno">

                <!-- ENCABEZADO -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">Resultados </h4>
                        <small class="text-muted">KLUANE DRILLING ECUADOR · 2026</small>
                    </div>

                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        <i class="bi bi-clipboard-check me-1"></i>
                        Evaluación 2026
                    </span>
                </div>

                <!-- RESULTADO GLOBAL -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <span class="text-muted fw-semibold small">
                                    RESULTADO GLOBAL
                                </span>

                                <div class="d-flex align-items-baseline gap-2">
                                    <h1 class="display-4 fw-bold text-success mb-0"
                                        id="total_evaluacion">0.00</h1>
                                    <span class="text-muted">/ 100 puntos</span>
                                </div>

                                <div class="progress mt-3" style="height: 9px;">
                                    <div class="progress-bar bg-success"
                                         id="barra_evaluacion"
                                         style="width: 0%">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="rounded-4 bg-secondary bg-opacity-10 p-3 d-inline-block">
                                   <i class="bi bi-trophy-fill fs-1 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INDICADORES -->
                <div class="row g-3">

                    <!-- HSE -->
                    <div class="col-md-4">
                        <div class="card indicador-card h-100 border-0 shadow-sm rounded-4" id="secc_hse">
                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between mb-3">
                                    <div class="indicador-icono bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary">
                                        Ponderación 30%
                                    </span>
                                </div>

                                <h6 class="fw-bold mb-1">HSE</h6>
                                <small class="text-muted">Seguridad, Salud y Ambiente</small>

                                <h2 class="fw-bold mt-3 mb-2" id="total_hse">0.00</h2>

                                <div class="progress mb-3" style="height: 7px;">
                                    <div class="progress-bar bg-primary" id="barra_hse"></div>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Autoevaluación</span>
                                    <strong id="auto_hse">0.00</strong>
                                </div>

                                <div class="d-flex justify-content-between small mt-2">
                                    <span class="text-muted">Jefe</span>
                                    <strong id="jefe_hse">0.00</strong>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- COMPETENCIAS -->
                    <div class="col-md-4">
                        <div class="card indicador-card h-100 border-0 shadow-sm rounded-4" id="secc_competencias">
                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between mb-3">
                                    <div class="indicador-icono bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <span class="badge bg-success-subtle text-success">
                                        Ponderación 30%
                                    </span>
                                </div>

                                <h6 class="fw-bold mb-1">Competencias</h6>
                                <small class="text-muted">Evaluación de competencias</small>

                                <h2 class="fw-bold mt-3 mb-2" id="total_competencias">0.00</h2>

                                <div class="progress mb-3" style="height: 7px;">
                                    <div class="progress-bar bg-success" id="barra_competencias"></div>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Autoevaluación</span>
                                    <strong id="auto_competencias">0.00</strong>
                                </div>

                                <div class="d-flex justify-content-between small mt-2">
                                    <span class="text-muted">Jefe</span>
                                    <strong id="jefe_competencias">0.00</strong>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- KPI -->
                    <div class="col-md-4">
                        <div class="card indicador-card h-100 border-0 shadow-sm rounded-4" id="secc_kpi">
                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between mb-3">
                                    <div class="indicador-icono bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-graph-up-arrow"></i>
                                    </div>
                                    <span class="badge bg-warning-subtle text-warning">
                                        Ponderación 40%
                                    </span>
                                </div>

                                <h6 class="fw-bold mb-1" >KPI</h6>
                                <small class="text-muted">Indicadores de desempeño</small>

                                <h2 class="fw-bold mt-3 mb-2" id="total_kpi">0.00</h2>

                                <div class="progress mb-3" style="height: 7px;">
                                    <div class="progress-bar bg-warning" id="barra_kpi"></div>
                                </div>

                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Autoevaluación</span>
                                    <strong id="auto_kpi">0.00</strong>
                                </div>

                                <div class="d-flex justify-content-between small mt-2">
                                    <span class="text-muted">Jefe</span>
                                    <strong id="jefe_kpi">2.00</strong>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>


<div class="container-fluid py-3" id="resultado_desempeno">

  
</div>


            

        `);

        // AHORA SÍ: LOS ELEMENTOS YA EXISTEN
        mostrar_valoracion(r);

    }, 'json');

}


function mostrar_valoracion(r) {

    console.log(r);
console.log(r.TOTAL_EVALUACION);
    $('#total_evaluacion').text(Number(r.TOTAL_EVALUACION || 0).toFixed(2));

    $('#total_hse').text(Number(r.TOTAL_HSE || 0).toFixed(2));
    $('#auto_hse').text(Number(r.AUTO_HSE_100 || 0).toFixed(2));
    $('#jefe_hse').text(Number(r.JEFE_HSE_100 || 0).toFixed(2));

    $('#total_competencias').text(Number(r.TOTAL_COMPETENCIAS || 0).toFixed(2));
    $('#auto_competencias').text(Number(r.AUTO_COMPETENCIAS_100 || 0).toFixed(2));
    $('#jefe_competencias').text(Number(r.JEFE_COMPETENCIAS_100 || 0).toFixed(2));

    $('#total_kpi').text(Number(r.TOTAL_KPI || 0).toFixed(2));
    $('#auto_kpi').text(Number(r.AUTO_KPI_100 || 0).toFixed(2));
    $('#jefe_kpi').text(Number(r.JEFE_KPI_100 || 0).toFixed(2));

    $('#barra_evaluacion').css('width', Math.min(100, Math.max(0, Number(r.TOTAL_EVALUACION) || 0)) + '%');

    $('#barra_hse').css('width', Math.min(100, Math.max(0, Number(r.TOTAL_HSE) || 0)) + '%');

    $('#barra_competencias').css('width', Math.min(100, Math.max(0, Number(r.TOTAL_COMPETENCIAS) || 0)) + '%');

    $('#barra_kpi').css('width', Math.min(100, Math.max(0, Number(r.TOTAL_KPI) || 0)) + '%');
}



function felicitacionResultados() {

    Swal.fire({

        html: `
            <div class="felicitacion-kde">

                <div class="trofeo-kde">
                    <i class="bi bi-trophy-fill"></i>
                </div>

                <span class="etiqueta-kde">
                    EVALUACIÓN COMPLETADA
                </span>

                <h2>¡Felicitaciones!</h2>

                <h6>Has completado tu evaluación</h6>

                <p>
                    Tu compromiso con el crecimiento y la
                    mejora continua es parte fundamental
                    de nuestro desarrollo.
                </p>

                <div class="resultado-kde">
                    <strong>Valoración de Desempeño 2026</strong>
                    <small>
                        Tu resultado se encuentra disponible
                        para consulta.
                    </small>
                </div>

            </div>
        `,

        showCancelButton: false,
        confirmButtonText: 'VER MIS RESULTADOS',
        cancelButtonText: 'Cerrar',
        cancelButtonText: false,
        confirmButtonColor: '#17365D',
        cancelButtonColor: '#64748B',

        reverseButtons: true,
        buttonsStyling: true,
        allowOutsideClick: false,

        customClass: {
            popup: 'popup-kde',
            confirmButton: 'btn-kde-resultados',
            cancelButton: 'btn-kde-cerrar'
        },



    }).then((result) => {

        if (result.isConfirmed) {

         

        }

    });

}
/// seccion  hse  resultados de evaluacion

$(document).on('click', '#secc_hse', function () {

    console.log('Cargando resultados de KPI individuales...');

    $.post('../web/rutas.php?ruta=hse_individual', function (r) {


        // si hay datos 
        cargar_grafica_hse();

        $('#resultado_desempeno').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#resultado_desempeno').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }

       // PROMEDIOS GENERALES
            let total_auto = datos.reduce((suma, item) => {
                return suma + (Number(item.aporte_auto) || 0);
            }, 0) / datos.length;

            let total_jefe = datos.reduce((suma, item) => {
                return suma + (Number(item.aporte_jefe) || 0);
            }, 0) / datos.length;

            // RESULTADO FINAL
            let total_general = total_auto + total_jefe;

        let detalle = '';

        datos.forEach(item => {

            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;
            let total = Number(item.total_general) || 0;

            detalle += `
                <div class="kpi-pregunta">

                    <!-- ENCABEZADO -->
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                        <div class="flex-grow-1">
                            <div class="kpi-pregunta-titulo">
                             <i class="bi bi-chevron-double-right" 
                             style="font-size: 1.5rem; font-weight: 900;"></i>
                              ${$('<div>').text(item.p).html()}
                            </div>
                        </div>

                        <div class="text-end flex-shrink-0">
                            <div class="kpi-resultado">
                                ${total.toFixed(2)}
                            </div>
                            <div class="kpi-resultado-label">
                                RESULTADO
                            </div>
                        </div>

                    </div>

                    <!-- COMPARATIVO -->
                    <div class="d-flex flex-column gap-3">

                        <!-- AUTOEVALUACIÓN -->
                        <div>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="kpi-label kpi-label-auto">
                                    AUTOEVALUACIÓN
                                </span>

                                <span class="kpi-valor-auto">
                                    ${auto.toFixed(2)}%
                                </span>

                            </div>

                            <div class="kpi-barra">
                                <div class="kpi-barra-auto"
                                     style="width: ${Math.min(Math.max(auto, 0), 100)}%">
                                </div>
                            </div>

                        </div>

                        <!-- JEFATURA -->
                        <div>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="kpi-label kpi-label-jefe">
                                    EVALUACIÓN DE JEFATURA
                                </span>

                                <span class="kpi-valor-jefe">
                                    ${jefe.toFixed(2)}%
                                </span>

                            </div>

                            <div class="kpi-barra">
                                <div class="kpi-barra-jefe"
                                     style="width: ${Math.min(Math.max(jefe, 0), 100)}%">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            `;
        });

        // CONSTRUIR VISTA
        $('#resultado_desempeno').append(`

            <div class="card resultado-desempeno border-0">

                <div class="card-body p-4">

                    <!-- ENCABEZADO -->
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h5 class="titulo-desempeno mb-1">
                                Resultados de desempeño - HSE
                            </h5>

                            <small class="subtitulo-desempeno">
                                Comparativo de valoración 2026
                            </small>
                        </div>

                        <span class="periodo-desempeno">
                            2026
                        </span>

                    </div>

                    <!-- RESUMEN DE RESULTADOS -->
                    <div class="row g-3 mb-4">

                        <!-- AUTOEVALUACIÓN -->
                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-auto">

                                <div class="indicador-titulo">
                                    <span class="indicador-punto punto-auto"></span>
                                    AUTOEVALUACIÓN
                                </div>

                                <div class="indicador-valor text-primary">
                                    ${total_auto.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Ponderación asignada <strong>25%</strong>
                                </div>

                            </div>
                        </div>

                        <!-- JEFATURA -->
                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-jefe">

                                <div class="indicador-titulo">
                                    <span class="indicador-punto punto-jefe"></span>
                                    EVALUACIÓN DE JEFATURA
                                </div>

                                <div class="indicador-valor text-success">
                                    ${total_jefe.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Ponderación asignada <strong>75%</strong>
                                </div>

                            </div>
                        </div>

                        <!-- RESULTADO FINAL -->
                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-final">

                                <div class="indicador-titulo">
                                    RESULTADO FINAL
                                </div>

                                <div class="indicador-valor valor-final">
                                    ${total_general.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Valoración ponderada
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- DETALLE -->
                    <div class="seccion-comparativo">

                        <div class="mb-3">
                            <h6 class="titulo-seccion mb-1">
                                Comparativo por competencias
                            </h6>

                            <small class="subtitulo-desempeno">
                                Percepción individual frente a evaluación de jefatura
                            </small>
                        </div>

                        <div id="detalle_resultados">
                            ${detalle}
                        </div>

                    </div>

                    <!-- REFERENCIAS -->
                    <div class="d-flex flex-wrap gap-4 mt-4 pt-3 border-top">

                        <small class="referencia-auto">
                            <span class="indicador-punto punto-auto"></span>
                            Autoevaluación
                        </small>

                        <small class="referencia-jefe">
                            <span class="indicador-punto punto-jefe"></span>
                            Evaluación de jefatura
                        </small>

                    </div>

                </div>

            </div>

            <div id="grafica_hse_reultados" class="mt-4 shadow-sm rounded-4 p-4 border border-light-subtle">
            </div>




        `);

    }, 'json');

});



/// reporte de resultados de evaluacion de desempeño



$(document).on('click', '#secc_kpi', function () {

    // 

    console.log('Cargando resultados de KPI individuales...');

    $.post('../web/rutas.php?ruta=kpi_individual', function (r) {

///  si  hay  resultados de evaluacion  de desempeño  mostrar  en  pantalla
    cargar_grafica_kpi();

        $('#resultado_desempeno').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#resultado_desempeno').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }
       
        // TOTALES
        let total_auto = 0;
        let total_jefe = 0;
        let total_general = 0;

        let detalle = '';

        datos.forEach(item => {

            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;

            let aporte_auto = Number(item.aporte_auto) || 0;
            let aporte_jefe = Number(item.aporte_jefe) || 0;
            let total = Number(item.total_general) || 0;

            total_auto += aporte_auto;
            total_jefe += aporte_jefe;
            total_general += total;

  detalle += `
    <div class="kpi-pregunta">

        <!-- ENCABEZADO -->
        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

            <div class="flex-grow-1">
                <div class="kpi-pregunta-titulo">
                    <i class="bi bi-chevron-double-right" 
                             style="font-size: 1.5rem; font-weight: 900;"></i> ${$('<div>').text(item.p).html()}
                </div>
            </div>

            <div class="text-end flex-shrink-0">
                <div class="kpi-resultado">
                    ${total.toFixed(2)}
                </div>
                <div class="kpi-resultado-label">
                    RESULTADO
                </div>
            </div>

        </div>

 <!-- COMPARATIVO -->
<div class="d-flex flex-column gap-3">

    <!-- AUTOEVALUACIÓN -->
    <div>

        <div class="d-flex justify-content-between align-items-center mb-2">

            <span class="kpi-label kpi-label-auto">
                AUTOEVALUACIÓN
            </span>

            <span class="kpi-valor-auto">
                ${auto.toFixed(2)}%
            </span>

        </div>

        <div class="kpi-barra">
            <div class="kpi-barra-auto"
                 style="width: ${Math.min(Math.max(auto, 0), 100)}%">
            </div>
        </div>

    </div>

    <!-- JEFATURA -->
    <div>

        <div class="d-flex justify-content-between align-items-center mb-2">

            <span class="kpi-label kpi-label-jefe">
                EVALUACIÓN DE JEFATURA
            </span>

            <span class="kpi-valor-jefe">
                ${jefe.toFixed(2)}%
            </span>

        </div>

        <div class="kpi-barra">
            <div class="kpi-barra-jefe"
                 style="width: ${Math.min(Math.max(jefe, 0), 100)}%">
            </div>
        </div>

    </div>

</div>

    </div>
`;
        });

        // CONSTRUIR VISTA
        $('#resultado_desempeno').append(`

<div class="card resultado-desempeno border-0">

    <div class="card-body p-4">

        <!-- ENCABEZADO -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h5 class="titulo-desempeno mb-1">
                    Resultados de desempeño - KPI
                </h5>

                <small class="subtitulo-desempeno">
                    Comparativo de valoración 2026
                </small>
            </div>

            <span class="periodo-desempeno">
                2026
            </span>

        </div>

        <!-- RESUMEN DE RESULTADOS -->
        <div class="row g-3 mb-4">

            <!-- AUTOEVALUACIÓN -->
            <div class="col-md-4">
                <div class="indicador-desempeno indicador-auto">

                    <div class="indicador-titulo">
                        <span class="indicador-punto punto-auto"></span>
                        AUTOEVALUACIÓN
                    </div>

                    <div class="indicador-valor text-primary">
                        ${total_auto.toFixed(2)}
                    </div>

                    <div class="indicador-pie">
                        Ponderación asignada <strong>20%</strong>
                    </div>

                </div>
            </div>

            <!-- JEFATURA -->
            <div class="col-md-4">
                <div class="indicador-desempeno indicador-jefe">

                    <div class="indicador-titulo">
                        <span class="indicador-punto punto-jefe"></span>
                        EVALUACIÓN DE JEFATURA
                    </div>

                    <div class="indicador-valor text-success">
                        ${total_jefe.toFixed(2)}
                    </div>

                    <div class="indicador-pie">
                        Ponderación asignada <strong>80%</strong>
                    </div>

                </div>
            </div>

            <!-- RESULTADO FINAL -->
            <div class="col-md-4">
                <div class="indicador-desempeno indicador-final">

                    <div class="indicador-titulo">
                        RESULTADO FINAL
                    </div>

                    <div class="indicador-valor valor-final">
                        ${total_general.toFixed(2)}
                    </div>

                    <div class="indicador-pie">
                        Valoración ponderada
                    </div>

                </div>
            </div>

        </div>

        <!-- DETALLE -->
        <div class="seccion-comparativo">

            <div class="mb-3">
                <h6 class="titulo-seccion mb-1">
                    Comparativo por competencias
                </h6>

                <small class="subtitulo-desempeno">
                    Percepción individual frente a evaluación de jefatura
                </small>
            </div>

            <div id="detalle_resultados">
                ${detalle}
            </div>

        </div>

        <!-- REFERENCIAS -->
        <div class="d-flex flex-wrap gap-4 mt-4 pt-3 border-top">

            <small class="referencia-auto">
                <span class="indicador-punto punto-auto"></span>
                Autoevaluación
            </small>

            <small class="referencia-jefe">
                <span class="indicador-punto punto-jefe"></span>
                Evaluación de jefatura
            </small>

        </div>

    </div>

</div>

<div id="grafica_kpi" class="mt-4 shadow-sm rounded-4 p-4 border border-light-subtle">
</div>

        `);

    }, 'json');

});



///  mosatrar resultados de competnecias 





$(document).on('click', '#secc_competencias', function () {

    console.log('Cargando resultados de competencias...');

    $.post('../web/rutas.php?ruta=competencias_individual', function (r) {


        // si haya datos de evaluacion de competencias  mostrar en pantalla
        cargar_grafica_competencias();

        $('#resultado_desempeno').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        console.log('DATOS DE COMPETENCIAS:', r.data);

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#resultado_desempeno').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }

        // =====================================
        // PROMEDIOS GENERALES
        // =====================================

        let total_auto = datos.reduce((suma, item) => {
            return suma + (Number(item.aporte_auto) || 0);
        }, 0) / datos.length;

        let total_jefe = datos.reduce((suma, item) => {
            return suma + (Number(item.aporte_jefe) || 0);
        }, 0) / datos.length;

        let total_pares = datos.reduce((suma, item) => {
            return suma + (Number(item.aporte_pares) || 0);
        }, 0) / datos.length;

        // RESULTADO FINAL
        let total_general = total_auto + total_jefe + total_pares;

        // VERIFICAR SI EXISTEN EVALUACIONES DE PARES
        let tiene_pares = datos.some(item =>
            Number(item.EXISTE_PARES) > 0
        );

        console.log('RESULTADOS GENERALES:', {
            autoevaluacion: total_auto,
            jefatura: total_jefe,
            pares: total_pares,
            resultado_final: total_general,
            tiene_pares: tiene_pares
        });

        let detalle = '';

        // =====================================
        // DETALLE POR COMPETENCIA
        // =====================================

        datos.forEach(item => {

            // CALIFICACIONES ORIGINALES
            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;
            let pares = Number(item.KPI_PARES) || 0;

            // RESULTADOS PONDERADOS
            let aporte_auto = Number(item.aporte_auto) || 0;
            let aporte_jefe = Number(item.aporte_jefe) || 0;
            let aporte_pares = Number(item.aporte_pares) || 0;

            let total = Number(item.total_general) || 0;

            // VERIFICAR EVALUACIÓN DE PARES POR PREGUNTA
            let tiene_pares_pregunta =
                Number(item.EXISTE_PARES) > 0;

            detalle += `
                <div class="kpi-pregunta">

                    <!-- ENCABEZADO -->
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                        <div class="flex-grow-1">
                            <div class="kpi-pregunta-titulo">
                             <i class="bi bi-chevron-double-right" 
                             style="font-size: 1.5rem; font-weight: 900;"></i>    ${$('<div>').text(item.p).html()}
                            </div>
                        </div>

                        <div class="text-end flex-shrink-0">
                            <div class="kpi-resultado">
                                ${total.toFixed(2)}
                            </div>

                            <div class="kpi-resultado-label">
                                RESULTADO
                            </div>
                        </div>

                    </div>

                    <!-- COMPARATIVO -->
                    <div class="d-flex flex-column gap-3">

                        <!-- AUTOEVALUACIÓN -->
                        <div>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="kpi-label kpi-label-auto">
                                    AUTOEVALUACIÓN
                                </span>

                                <span class="kpi-valor-auto">
                                    ${auto.toFixed(2)}%
                                </span>

                            </div>

                            <div class="kpi-barra">
                                <div class="kpi-barra-auto"
                                     style="width: ${Math.min(Math.max(auto, 0), 100)}%">
                                </div>
                            </div>

                        </div>

                        <!-- JEFATURA -->
                        <div>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="kpi-label kpi-label-jefe">
                                    EVALUACIÓN DE JEFATURA
                                </span>

                                <span class="kpi-valor-jefe">
                                    ${jefe.toFixed(2)}%
                                </span>

                            </div>

                            <div class="kpi-barra">
                                <div class="kpi-barra-jefe"
                                     style="width: ${Math.min(Math.max(jefe, 0), 100)}%">
                                </div>
                            </div>

                        </div>

                        <!-- EVALUACIÓN DE PARES -->
                        ${tiene_pares_pregunta ? `

                            <div>

                                <div class="d-flex justify-content-between align-items-center mb-2">

                                    <span class="kpi-label kpi-label-pares">
                                        EVALUACIÓN DE PARES
                                    </span>

                                    <span class="kpi-valor-pares">
                                        ${pares.toFixed(2)}%
                                    </span>

                                </div>

                                <div class="kpi-barra">
                                    <div class="kpi-barra-pares"
                                         style="width: ${Math.min(Math.max(pares, 0), 100)}%">
                                    </div>
                                </div>

                            </div>

                        ` : ''}

                    </div>

                </div>
            `;
        });

        // =====================================
        // REFERENCIA DE PARES
        // =====================================

        let referencia_pares = tiene_pares ? `
            <small class="referencia-pares">
                <span class="indicador-punto punto-pares"></span>
                Evaluación de pares
            </small>
        ` : '';

        // =====================================
        // CONSTRUIR VISTA
        // =====================================

        $('#resultado_desempeno').append(`

            <div class="card resultado-desempeno border-0">

                <div class="card-body p-4">

                    <!-- ENCABEZADO -->
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h5 class="titulo-desempeno mb-1">
                                Resultados de desempeño - Competencias
                            </h5>

                            <small class="subtitulo-desempeno">
                                Comparativo de valoración 2026
                            </small>
                        </div>

                        <span class="periodo-desempeno">2026</span>

                    </div>

                    <!-- RESUMEN DE RESULTADOS -->
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-auto">

                                <div class="indicador-titulo">
                                    <span class="indicador-punto punto-auto"></span>
                                    AUTOEVALUACIÓN
                                </div>

                                <div class="indicador-valor text-primary">
                                    ${total_auto.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Ponderación asignada <strong>25%</strong>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-jefe">

                                <div class="indicador-titulo">
                                    <span class="indicador-punto punto-jefe"></span>
                                    EVALUACIÓN DE JEFATURA
                                </div>

                                <div class="indicador-valor text-success">
                                    ${total_jefe.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Ponderación asignada <strong>75%</strong>
                                </div>

                            </div>
                        </div>

                        ${tiene_pares ? `

                            <div class="col-md-4">
                                <div class="indicador-desempeno indicador-pares">

                                    <div class="indicador-titulo">
                                        <span class="indicador-punto punto-pares"></span>
                                        EVALUACIÓN DE PARES
                                    </div>

                                    <div class="indicador-valor"
                                         style="color: #8b5cf6;">
                                        ${total_pares.toFixed(2)}
                                    </div>

                                    <div class="indicador-pie">
                                        Ponderación asignada <strong>5%</strong>
                                    </div>

                                </div>
                            </div>

                        ` : ''}

                        <div class="col-md-4">
                            <div class="indicador-desempeno indicador-final">

                                <div class="indicador-titulo">
                                    RESULTADO FINAL
                                </div>

                                <div class="indicador-valor valor-final">
                                    ${total_general.toFixed(2)}
                                </div>

                                <div class="indicador-pie">
                                    Valoración ponderada
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- DETALLE -->
                    <div class="seccion-comparativo">

                        <div class="mb-3">
                            <h6 class="titulo-seccion mb-1">
                                Comparativo por competencias
                            </h6>

                            <small class="subtitulo-desempeno">
                                Percepción individual frente a evaluación de jefatura
                                ${tiene_pares ? 'y evaluación de pares' : ''}
                            </small>
                        </div>

                        <div id="detalle_resultados">
                            ${detalle}
                        </div>

                    </div>

                    <!-- REFERENCIAS -->
                    <div class="d-flex flex-wrap gap-4 mt-4 pt-3 border-top">

                        <small class="referencia-auto">
                            <span class="indicador-punto punto-auto"></span>
                            Autoevaluación
                        </small>

                        <small class="referencia-jefe">
                            <span class="indicador-punto punto-jefe"></span>
                            Evaluación de jefatura
                        </small>

                        ${referencia_pares}

                    </div>

                </div>

            </div>

            <div id="grafica_competencias" class="mt-4 shadow-sm rounded-4 p-4 border border-light-subtle">
            </div>

        `);

    }, 'json');

});



// GREFICAS 




function cargar_grafica_kpi() {

    $.post('../web/rutas.php?ruta=kpi_individual', function (r) {

        $('#grafica_kpi').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#grafica_kpi').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }

        // TOTALES
        let total_auto = 0;
        let total_jefe = 0;
        let total_general = 0;

        let etiquetas = [];
        let valores_auto = [];
        let valores_jefe = [];

        datos.forEach(item => {

            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;

            let aporte_auto = Number(item.aporte_auto) || 0;
            let aporte_jefe = Number(item.aporte_jefe) || 0;
            let total = Number(item.total_general) || 0;

            total_auto += aporte_auto;
            total_jefe += aporte_jefe;
            total_general += total;

            // DATOS DE LA GRÁFICA
            etiquetas.push(item.p ||'KPI');

            valores_auto.push(auto);
            valores_jefe.push(jefe);

        });

        // CONTENEDOR
        $('#grafica_kpi').html(`
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h6 class="fw-bold mb-1">
                                Comparativo de percepción
                            </h6>

                            <small class="text-muted">
                                Autoevaluación vs evaluación de jefatura
                            </small>
                        </div>

                        <span class="badge bg-light text-secondary">
                            KPI 2026
                        </span>

                    </div>

                    <div style="height:380px; position:relative;">
                        <canvas id="grafica_kpi_individual"></canvas>
                    </div>

                    <hr class="my-3">

                    <div class="row text-center">

                        <div class="col-4">
                            <small class="text-muted d-block">
                                Mi percepción
                            </small>
                            <h5 class="fw-bold text-primary mb-0">
                                ${total_auto.toFixed(2)}%
                            </h5>
                        </div>

                        <div class="col-4 border-start border-end">
                            <small class="text-muted d-block">
                                Percepción de jefe
                            </small>
                            <h5 class="fw-bold text-success mb-0">
                                ${total_jefe.toFixed(2)}%
                            </h5>
                        </div>

                        <div class="col-4">
                            <small class="text-muted d-block">
                                Resultado final
                            </small>
                            <h5 class="fw-bold text-dark mb-0">
                                ${total_general.toFixed(2)}%
                            </h5>
                        </div>

                    </div>

                </div>
            </div>
        `);

        // DESTRUIR GRÁFICA ANTERIOR
        if (window.graficaKPI) {
            window.graficaKPI.destroy();
        }

        // GRAFICAR
        const ctx = document.getElementById('grafica_kpi_individual');

        window.graficaKPI = new Chart(ctx, {

            type: 'radar',

            data: {
                labels: etiquetas,

                datasets: [
                    {
                        label: 'Mi percepción',
                        data: valores_auto,

                        backgroundColor: 'rgba(37, 99, 235, 0.15)',
                        borderColor: '#2563eb',
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        borderWidth: 2
                    },
                    {
                        label: 'Percepción de mi jefe',
                        data: valores_jefe,

                        backgroundColor: 'rgba(22, 163, 74, 0.15)',
                        borderColor: '#16a34a',
                        pointBackgroundColor: '#16a34a',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        borderWidth: 2
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    r: {
                        beginAtZero: true,
                        min: 0,
                        max: 100,

                        ticks: {
                            stepSize: 20,
                            backdropColor: 'transparent'
                        },

                        pointLabels: {
                            color: '#475569',
                            font: {
                                size: 11,
                                weight: '500'
                            }
                        },

                        grid: {
                            color: '#e2e8f0'
                        },

                        angleLines: {
                            color: '#e2e8f0'
                        }
                    }
                },

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' +
                                    context.raw + '%';
                            }
                        }
                    }
                }
            }
        });

    }, 'json').fail(function(xhr) {
        console.error('Error al cargar KPI:', xhr.responseText);
    });
}



/// grefia competencias -



function cargar_grafica_competencias() {

    console.log('Cargando resultados de competencias...');

    $.post('../web/rutas.php?ruta=competencias_individual', function (r) {

        $('#grafica_competencias').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#grafica_competencias').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }

        // PROMEDIOS GENERALES
        let total_auto = datos.reduce((suma, item) =>
            suma + (Number(item.aporte_auto) || 0), 0
        ) / datos.length;

        let total_jefe = datos.reduce((suma, item) =>
            suma + (Number(item.aporte_jefe) || 0), 0
        ) / datos.length;

        let total_pares = datos.reduce((suma, item) =>
            suma + (Number(item.aporte_pares) || 0), 0
        ) / datos.length;

        let total_general = total_auto + total_jefe + total_pares;

        // VERIFICAR EVALUACIONES DE PARES
        let tiene_pares = datos.some(item =>
            Number(item.EXISTE_PARES) > 0
        );

        // DATOS PARA EL RADAR
        let etiquetas = [];
        let valores_auto = [];
        let valores_jefe = [];
        let valores_pares = [];

        datos.forEach(item => {

            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;
            let pares = Number(item.KPI_PARES) || 0;

            // TEXTO DE LA PREGUNTA
            let pregunta = item.p || 'Pregunta de competencia';

            // DIVIDIR TEXTO LARGO
            let etiqueta = pregunta.match(/.{1,30}(\s|$)/g) || [pregunta];

            etiquetas.push(etiqueta);

            valores_auto.push(auto);
            valores_jefe.push(jefe);

            if (tiene_pares) {
                valores_pares.push(pares);
            }

        });

        console.log('RESULTADOS GENERALES:', {
            autoevaluacion: total_auto,
            jefatura: total_jefe,
            pares: total_pares,
            resultado_final: total_general,
            tiene_pares: tiene_pares
        });

        // CONTENEDOR
        $('#grafica_competencias').html(`
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h6 class="fw-bold mb-1">
                                Evaluación de competencias
                            </h6>

                            <small class="text-muted">
                                Comparativo de percepción 2026
                            </small>
                        </div>

                        <span class="badge bg-light text-secondary">
                            Competencias
                        </span>

                    </div>

                    <div style="height:420px; position:relative;">
                        <canvas id="grafica_resultados_competencias"></canvas>
                    </div>

                    <hr class="my-3">

                    <div class="row text-center">

                        <div class="col-${tiene_pares ? '4' : '6'}">
                            <small class="text-muted d-block">
                                Mi percepción
                            </small>

                            <h5 class="fw-bold text-primary mb-0">
                                ${total_auto.toFixed(2)}%
                            </h5>
                        </div>

                        <div class="col-${tiene_pares ? '4' : '6'} border-start ${tiene_pares ? 'border-end' : ''}">
                            <small class="text-muted d-block">
                                Jefatura
                            </small>

                            <h5 class="fw-bold text-success mb-0">
                                ${total_jefe.toFixed(2)}%
                            </h5>
                        </div>

                        ${tiene_pares ? `
                            <div class="col-4">
                                <small class="text-muted d-block">
                                    Pares
                                </small>

                                <h5 class="fw-bold text-warning mb-0">
                                    ${total_pares.toFixed(2)}%
                                </h5>
                            </div>
                        ` : ''}

                    </div>

                </div>
            </div>
        `);

        // DESTRUIR GRÁFICA ANTERIOR
        if (window.graficaCompetencias) {
            window.graficaCompetencias.destroy();
        }

        // DATASETS
        let datasets = [

            {
                label: 'Mi percepción',
                data: valores_auto,
                backgroundColor: 'rgba(37, 99, 235, 0.15)',
                borderColor: '#2563eb',
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#fff',
                pointRadius: 4,
                borderWidth: 2
            },

            {
                label: 'Percepción de mi jefe',
                data: valores_jefe,
                backgroundColor: 'rgba(22, 163, 74, 0.15)',
                borderColor: '#16a34a',
                pointBackgroundColor: '#16a34a',
                pointBorderColor: '#fff',
                pointRadius: 4,
                borderWidth: 2
            }

        ];

        // AGREGAR PARES SI EXISTEN
        if (tiene_pares) {

            datasets.push({
                label: 'Percepción de mis pares',
                data: valores_pares,
                backgroundColor: 'rgba(245, 158, 11, 0.12)',
                borderColor: '#f59e0b',
                pointBackgroundColor: '#f59e0b',
                pointBorderColor: '#fff',
                pointRadius: 4,
                borderWidth: 2
            });

        }

        // GRAFICAR
        const ctx = document.getElementById('grafica_resultados_competencias');

        window.graficaCompetencias = new Chart(ctx, {

            type: 'radar',

            data: {
                labels: etiquetas,
                datasets: datasets
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                scales: {

                    r: {

                        beginAtZero: true,
                        min: 0,
                        max: 100,

                        ticks: {
                            stepSize: 20,
                            backdropColor: 'transparent'
                        },

                        pointLabels: {
                            color: '#475569',
                            padding: 10,
                            font: {
                                size: 10,
                                weight: '500'
                            }
                        },

                        grid: {
                            color: '#e2e8f0'
                        },

                        angleLines: {
                            color: '#e2e8f0'
                        }

                    }

                },

                plugins: {

                    legend: {
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    tooltip: {

                        callbacks: {

                            title: function(context) {
                                return datos[context[0].dataIndex].p || 'Pregunta de competencia';
                            },

                            label: function(context) {
                                return context.dataset.label + ': ' +
                                    context.raw + '%';
                            }

                        }

                    }

                }

            }

        });

    }, 'json').fail(function(xhr) {

        console.error(
            'Error al cargar competencias:',
            xhr.responseText
        );

    });

}


/// grafica hse {}


function cargar_grafica_hse() {

    console.log('Cargando resultados HSE...');

    $.post('../web/rutas.php?ruta=hse_individual', function (r) {

        $('#grafica_hse_reultados').empty();

        if (r.err) {
            console.log(r.msg);
            return;
        }

        let datos = r.data;

        if (!datos || datos.length === 0) {
            $('#grafica_hse_reultados').html(`
                <div class="alert alert-light text-center">
                    No existen resultados de evaluación.
                </div>
            `);
            return;
        }

        // PROMEDIOS GENERALES
        let total_auto = datos.reduce((suma, item) =>
            suma + (Number(item.aporte_auto) || 0), 0
        ) / datos.length;

        let total_jefe = datos.reduce((suma, item) =>
            suma + (Number(item.aporte_jefe) || 0), 0
        ) / datos.length;

        let total_general = total_auto + total_jefe;

        // DATOS PARA EL RADAR
        let etiquetas = [];
        let valores_auto = [];
        let valores_jefe = [];

        datos.forEach(item => {

            let auto = Number(item.KPI_AUTO_EVALUACION) || 0;
            let jefe = Number(item.KPI_JEFE) || 0;

            let pregunta = item.p || 'Pregunta HSE';

            // DIVIDIR PREGUNTAS LARGAS
            let etiqueta = pregunta.match(/.{1,30}(\s|$)/g) || [pregunta];

            etiquetas.push(etiqueta);

            valores_auto.push(auto);
            valores_jefe.push(jefe);

        });

        // CONTENEDOR
        $('#grafica_hse_reultados').html(`
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="mb-3">
                        <h6 class="fw-bold mb-1">
                            Evaluación HSE
                        </h6>
                        <small class="text-muted">
                            Comparativo de percepción 2026
                        </small>
                    </div>

                    <div style="height:420px; position:relative;">
                        <canvas id="grafica_hse_individual"></canvas>
                    </div>

                    <hr class="my-3">

                    <div class="row text-center">

                        <div class="col-4">
                            <small class="text-muted d-block">
                                Mi percepción
                            </small>
                            <h5 class="fw-bold text-primary mb-0">
                                ${total_auto.toFixed(2)}%
                            </h5>
                        </div>

                        <div class="col-4 border-start border-end">
                            <small class="text-muted d-block">
                                Jefatura
                            </small>
                            <h5 class="fw-bold text-success mb-0">
                                ${total_jefe.toFixed(2)}%
                            </h5>
                        </div>

                        <div class="col-4">
                            <small class="text-muted d-block">
                                Resultado final
                            </small>
                            <h5 class="fw-bold text-dark mb-0">
                                ${total_general.toFixed(2)}%
                            </h5>
                        </div>

                    </div>

                </div>
            </div>
        `);

        // DESTRUIR GRÁFICA ANTERIOR
        if (window.graficaHSE) {
            window.graficaHSE.destroy();
        }

        // GRAFICAR
        const ctx = document.getElementById('grafica_hse_individual');

        window.graficaHSE = new Chart(ctx, {

            type: 'radar',

            data: {
                labels: etiquetas,

                datasets: [
                    {
                        label: 'Mi percepción',
                        data: valores_auto,
                        backgroundColor: 'rgba(37, 99, 235, 0.15)',
                        borderColor: '#2563eb',
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 4,
                        borderWidth: 2
                    },
                    {
                        label: 'Percepción de mi jefe',
                        data: valores_jefe,
                        backgroundColor: 'rgba(22, 163, 74, 0.15)',
                        borderColor: '#16a34a',
                        pointBackgroundColor: '#16a34a',
                        pointRadius: 4,
                        borderWidth: 2
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                scales: {
                    r: {
                        beginAtZero: true,
                        min: 0,
                        max: 100,

                        ticks: {
                            stepSize: 20,
                            backdropColor: 'transparent'
                        },

                        pointLabels: {
                            color: '#475569',
                            padding: 10,
                            font: {
                                size: 10,
                                weight: '500'
                            }
                        },

                        grid: {
                            color: '#e2e8f0'
                        },

                        angleLines: {
                            color: '#e2e8f0'
                        }
                    }
                },

                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return datos[context[0].dataIndex].p || 'Pregunta HSE';
                            },
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });

    }, 'json').fail(function(xhr) {
        console.error('Error al cargar HSE:', xhr.responseText);
    });

}
