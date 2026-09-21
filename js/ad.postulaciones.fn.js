 $(document).ready(function () {
 
    cargar_postulaciones();

});
 
//// verificcion de postulciones desde la web
 let datos_postulacion = []; 

function cargar_postulaciones(){

   

    $.post('../web/rutas.php?ruta=mostar_postulaciones', function (r) {

         console.log(r);

          datos_postulacion = r;
            $('#tblPostulaciones').empty();

          $.each(r, function (i, item) {
            if (i !== 'err') {

                let contar = 1;

                if(item.est == 1 ){
   
                   elmento = `
                            <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Pendiente
                            </span>
                        `;

                }else if(item.est == 2){

                   elmento = `
                            <span class="badge bg-dark-subtle text-dark border border-dark px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Revisado
                            </span>
                        `;


                }else if(item.est == 3){

                    elmento = `
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Descartado
                            </span>
                        `;


                }else if(item.est == 4){

                    elmento = `
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Aprobado
                            </span>
                        `;


                }


                $('#tblPostulaciones').append(
                    `
                    
                    
                   <tr>
                   <td> ${contar ++}</td>
                   <td> ${item.nm} ${item.ap}</td>
                   <td>  ${item.pl}</td>
                   <td> ${item.fc}</td>
             
                    <td>
                        ${item.cv
                            ? `<a href="http://200.105.244.50/ARCHIVO/DOC/CV/${item.cv}" 
                                  target="_blank"
                                  class="btn btn-outline-danger btn-sm"
                                  title="Ver documento">
                                    <i class="bi bi-file-pdf-fill"></i>
                               </a>`
                            : '-'
                        }
                    </td>
                  

                     <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold text-dark">
                                ${elmento}
                            </span>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            <!-- Ver información -->
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm px-3"
                                    id="ver_mas"
                                    name="${item.id_post}"
                                    title="Ver información">
                                <i class="bi bi-file-earmark-richtext me-1"></i>
                                Ver
                            </button>

                          

                        </div>
                    </td>


                   
                   </tr>
                    
                    
                    
                    `
                );
         
            }
        });

                

    }, 'json');

}
// cambio de estado 

function cambio_estado (id_postulacion, st){

   $.post('../db/up_post_sis.php',{id_postulacion, st}, function (r) {

        console.log(r);


 
       cargar_postulaciones();

      
    }, 'json');

}


 let id_postulacion = 0;
///
$(document).on('click', '#ver_mas', function () {
    

    let id = this.name;
    let st = 2;


        let data = datos_postulacion.find(function(item) {
        return item.id_post == id;
      });

      
    id_postulacion = data.id_post;
    id_postulante = data.id;
    id_post = data.id;
     cargar_educacion(id_postulante);
     cargar_experiencia(id_post);
     cambio_estado(id_postulacion, st);


      let title =`
      
        <h5 class="modal-title text-dark">Información de la Postulación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      
      `;

      let content =`


    <div class="card border-0 shadow-sm overflow-hidden"
         style="border-radius: 16px;">

        <!-- =========================
             CABECERA DEL POSTULANTE
        ========================== -->
        <div class="p-4"
             style="
                background: linear-gradient(135deg, #0b1f3a 0%, #123b68 100%);
                color: white;
             ">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="
                                width: 64px;
                                height: 64px;
                                background: rgba(255,255,255,.12);
                                border: 1px solid rgba(255,255,255,.25);
                             ">

                            <i class="bi bi-person fs-2"></i>

                        </div>

                        <div>

                            <div class="small opacity-75 mb-1">
                                POSTULANTE
                            </div>

                            <h4 class="fw-bold mb-1">
                                ${data.nm} ${data.ap}
                            </h4>

                            <div class="d-flex align-items-center gap-2">

                                <span class="badge rounded-pill bg-white text-dark">
                                    <i class="bi bi-briefcase me-1"></i>
                                    ${data.pl}
                                </span>

                                <span class="badge rounded-pill bg-success">
                                    ${data.est}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <div class="small opacity-75">
                        FECHA DE POSTULACIÓN
                    </div>

                    <div class="fw-semibold fs-6">
                        <i class="bi bi-calendar3 me-1"></i>
                        ${data.fc}
                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             CUERPO
        ========================== -->
        <div class="card-body p-4">


            <!-- =========================
                 DATOS PERSONALES
            ========================== -->
            <div class="mb-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-3 d-flex align-items-center justify-content-center me-2"
                         style="
                            width: 38px;
                            height: 38px;
                            background: #eef4fb;
                            color: #0d6efd;
                         ">

                        <i class="bi bi-person-vcard"></i>

                    </div>

                    <div>

                        <h6 class="fw-bold mb-0">
                            Información personal
                        </h6>

                        <small class="text-muted">
                            Datos de contacto y ubicación
                        </small>

                    </div>

                </div>


                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-person-badge me-1"></i>
                                Cédula
                            </small>

                            <span class="fw-semibold">
                                ${data.ci}
                            </span>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-phone me-1"></i>
                                Celular
                            </small>

                            <span class="fw-semibold">
                                ${data.cel}
                            </span>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-geo-alt me-1"></i>
                                Email
                            </small>

                            <span class="fw-semibold">
                                ${data.emi}
                            </span>

                        </div>



                        

                    </div>


                    <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-person-badge me-1"></i>
                                Fecha Nacimineto
                            </small>

                            <span class="fw-semibold">
                                ${data.f_na}
                            </span>

                        </div>

                    </div>

                    
                    <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-person-badge me-1"></i>
                                Nacinalidad 
                            </small>

                            <span class="fw-semibold">
                                ${data.nan}
                            </span>

                        </div>

                    </div>


                        <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-geo-alt-fill"></i>
                                Provincia
                            </small>

                            <span class="fw-semibold">
                                ${data.provi}
                            </span>

                        </div>

                    </div>

             

                    
                 <div class="col-md-4">

                        <div class="border rounded-3 p-3 h-100">

                            <small class="text-muted d-block mb-1">
                                 <i class="bi bi-geo-alt-fill"></i>
                                Canton
                            </small>

                            <span class="fw-semibold">
                                ${data.cant}
                            </span>

                        </div>

                    </div>




                    <div class="col-12">

                        <div class="border rounded-3 p-3">

                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-house me-1"></i>
                                Dirección
                            </small>

                            <span class="fw-semibold">
                                ${data.dir}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================
                 FORMACIÓN ACADÉMICA
            ========================== -->
            <div class="mb-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-3 d-flex align-items-center justify-content-center me-2"
                         style="
                            width: 38px;
                            height: 38px;
                            background: #eef8f3;
                            color: #198754;
                         ">

                        <i class="bi bi-mortarboard"></i>

                    </div>

                    <div>

                        <h6 class="fw-bold mb-0">
                            Formación académica
                        </h6>

                        <small class="text-muted">
                            Información educativa del postulante
                        </small>

                    </div>

                </div>


                <div class="card border-0"
                     style="background: #f8fafc; border-radius: 12px;">

                    <div class="card-body">

                        <div class="row g-4" id="sec_mod_edu">

                          

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================
                 EXPERIENCIA
            ========================== -->
            <div class="mb-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="rounded-3 d-flex align-items-center justify-content-center me-2"
                         style="
                            width: 38px;
                            height: 38px;
                            background: #fff5e8;
                            color: #fd7e14;
                         ">

                        <i class="bi bi-briefcase"></i>

                    </div>

                    <div>

                        <h6 class="fw-bold mb-0">
                            Experiencia profesional
                        </h6>

                        <small class="text-muted">
                            Trayectoria laboral registrada
                        </small>

                    </div>

                </div>


                <div class="card border-0 shadow-sm"
                     style="
                        border-radius: 12px;
                        border-left: 4px solid #123b68 !important;
                        background: #fff;
                     ">

                    <div class="card-body p-4">

                        <div class="row g-4" id="secc_experiencia">

                      

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================
                 CV
            ========================== -->
            <div>

                <div class="card border-0"
                     style="
                        background: linear-gradient(135deg, #f8f9fa, #eef2f6);
                        border-radius: 12px;
                     ">

                    <div class="card-body p-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center">

                                <div class="rounded-3 d-flex align-items-center justify-content-center me-3"
                                     style="
                                        width: 46px;
                                        height: 46px;
                                        background: #fff;
                                        color: #dc3545;
                                     ">

                                    <i class="bi bi-file-earmark-pdf fs-4"></i>

                                </div>

                                <div>

                                    <div class="fw-bold">
                                        Hoja de vida
                                    </div>

                                    <small class="text-muted">
                                        Documento CV del postulante
                                    </small>

                                </div>

                            </div>


                            <a href="http://200.105.244.50/ARCHIVO/DOC/CV/${data.cv}"
                               target="_blank"
                               class="btn btn-danger px-3">

                                <i class="bi bi-eye me-1"></i>
                                Ver CV

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             PIE
        ========================== -->
        <div class="card-footer bg-white border-top px-4 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Información registrada en el sistema de postulaciones
                </small>

                <span class="small text-muted">
                    ID: ${data.id_post}
                </span>

            </div>

        </div>

    </div>

`

      let accions  =`
      

<div class="d-flex justify-content-end gap-2">

    <button 
        type="button" 
        class="btn btn-light border px-3"
        data-bs-dismiss="modal">

        <i class="bi bi-x-circle me-1"></i>
        Cancelar

    </button>

    <button 
        type="button" 
        class="btn btn-outline-danger px-3"
        id="btn_descartar">

        <i class="bi bi-person-x-fill me-1"></i>
      Marcar como "No apto"

    </button>

    <button 
        type="button" 
        class="btn btn-success px-3"
        id="btn_aprobar">

        <i class="bi bi-person-check-fill me-1"></i>
        Marcar como "Apto"

    </button>

</div>


      `;


     modal_ensambl(title, content, accions );

   
    
}); 


$(document).on('click', '#btn_descartar', function () {
 let st = 3; 

  cambio_estado(id_postulacion, st);

  $('#modal_post').modal('hide');
  cargar_postulaciones();

});


function modal_ensambl(title, content, accions ){

        $('#modal_post').modal('show');
        /// limpiar elemntos del modal 

        $('#titulo_modal').empty();
        $('#contenido_modal').empty();
        $('#acciones_modal').empty();

        /// asignacion de elemntos 

        $('#titulo_modal').append(title);
        $('#contenido_modal').append(content);
        $('#acciones_modal').append(accions);


}

function cargar_experiencia(id_post){



   $.post('../db/cg_exp_select.php',{id: id_post}, function (r) {

        console.log(r);



            $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#secc_experiencia').empty()
            .append(
                `
                
                   <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    TIEMPO DE EXPERIENCIA
                                </small>

                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                    ${item.t}
                                </span>

                            </div>


                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    PUESTO
                                </small>

                                <div class="fw-bold fs-6">
                                    ${item.p}
                                </div>

                            </div>


                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    EMPRESA
                                </small>

                                <div class="fw-bold fs-6">
                                    ${item.em}
                                </div>

                            </div>


                            <div class="col-12">

                                <div class="border-top pt-3">

                                    <small class="text-muted d-block mb-2">
                                        DESCRIPCIÓN DE FUNCIONES
                                    </small>

                                    <div class="text-secondary"
                                         style="line-height: 1.6;">

                                        ${item.des}

                                    </div>

                                </div>

                            </div>
                
                `
            
            
            
            
            
            
            );
        }
    });
      
    }, 'json');



}


function cargar_educacion(id_postulante){


$.post('../db/cg_edu_select.php', {id: id_postulante},function (r) {

    console.log(r);

    

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#sec_mod_edu').empty()
            .append(
                `
                
                
                  <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    NIVEL EDUCATIVO
                                </small>

                                <div class="fw-bold">
                                    ${item.nv}
                                </div>

                            </div>


                            <div class="col-md-5">

                                <small class="text-muted d-block mb-1">
                                    Titulo
                                </small>

                                <div class="fw-bold">
                                    ${item.inst}
                                </div>

                            </div>


                            <div class="col-md-3">

                                <small class="text-muted d-block mb-1">
                                    AÑO DE GRADUACIÓN
                                </small>

                                <div class="fw-bold">
                                    ${item.an}
                                </div>

                            </div>
                
                
                
                `
            
            
            
            
            
            
            );
        }
    });

}, 'json');



}
/// colaborado aptop btn_aprobar


/// genera excel

$(document).on('click', '#btn_aprobar', function () {
 let st = 4; 

  cambio_estado(id_postulacion, st);

  $('#modal_post').modal('hide');
  cargar_postulaciones();

});



// Cuando recibes los datos desde tu AJAX
// datos_postulacion = r;


$('#btnGenerarExcel').on('click', function () {

    if (!datos_postulacion || datos_postulacion.length === 0) {

        mensaje(
            'warning',
            'No existen postulaciones para generar el reporte.'
        );

        return;
    }


    // Crear formulario temporal
    let form = $('<form>', {
        method: 'POST',
        action: '../excel/postulaciones_excel.php',
        target: '_blank'
    });


    // Convertir los datos a JSON
    let input = $('<input>', {
        type: 'hidden',
        name: 'datos',
        value: JSON.stringify(datos_postulacion)
    });


    form.append(input);

    $('body').append(form);

    form.submit();

    form.remove();

});

