 $(document).ready(function () {

 validate_Evaluaciones_Asignadas();
 indicaciones_evaluar_kde();


   
});
 
/// contar roles emitidos 

function validate_Evaluaciones_Asignadas(){

    $.post('../web/rutas.php?ruta=evaluaciones', function (r) {

   

        $('#seccion_evaluaciones').empty();
        
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

                if(item.st == 2){

                    color = 'danger';


                }else{


                    color = 'success';



                }


                $('#seccion_evaluaciones').append(


                    `
                         <!-- Evaluación de pares -->
            <div class="col-md-4 elemnt_evaluacion" id="${item.t_ev}">

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
                                   Preguntas:  ${item.ct}
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

        cargar_preguntas_evaluador(p, id_base);
        ensamble_evaludor(p);
         cargar_personas_a_evaluar(tipo_evaluacion);
    

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
                                   Preguntas:  ${item.ct}
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

         cargar_preguntas_auto_Evaluacion(id_base_aut);
         
    
    

    }, 'json').fail(function () {

        mensaje('error', 'No se pudo guardar la respuesta.');

    });

}

