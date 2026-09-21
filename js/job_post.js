$(document).ready(function () {


    uso_de_datos();

      function uso_de_datos() {

       

                $.post('../db/us_srv_post.php', function (r) {

                console.log(r);

            
                if (!r.err) {
                        $.each(r, function (i, item) {
                            if (i !== 'err') {

                                pk_acp = item.id;

                                title =  `<i class="bi bi-info-circle-fill"></i>  ${item.t}  `;
                                content =  ` 

                                    <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="small text-muted mb-3">
                                        Por favor, revise la siguiente información:
                                        </div>

                                        <div class="card-text" style="white-space: pre-line;">
                                        ${item.c}
                                        </div>
                                    </div>
                                    </div>

                              

                                `;

                          

                             $('#text_datos_personales').empty()
                             .append(title);

                             $('#content_datos_personales').empty()
                             .append(content);
                            
       
                            
                            
                            }
                        });
            
                }else{

                    console.log('Requisito Aceptado');

                
                }


            }, 'json');


    }






let pasoActual = 1;
const totalPasos = 7;


// ==========================================
// MOSTRAR PASO
// ==========================================

function mostrarPaso(paso) {

    $('.seccion').hide();

    $('.seccion[data-step="' + paso + '"]').fadeIn(250);

    actualizarProgreso(paso);
}


// ==========================================
// PROGRESO
// ==========================================

function actualizarProgreso(paso) {

    let porcentaje = Math.round(
        ((paso - 1) / (totalPasos - 1)) * 100
    );

    $('#progressBar').css(
        'width',
        porcentaje + '%'
    );

    $('#progressText').text(
        porcentaje + '%'
    );

}


// ==========================================
// VALIDAR PASO
// ==========================================

function validarPaso(paso) {

    let valido = true;

    $('.seccion[data-step="' + paso + '"]')
        .find('.campo[required]')
        .each(function () {

            if ($.trim($(this).val()) === '') {

                $(this).addClass('is-invalid');

                valido = false;

            } else {

                $(this).removeClass('is-invalid');

            }

        });


    if (!valido) {

        Swal.fire({
            icon: 'warning',
            title: 'Información incompleta',
            text: 'Complete todos los campos para continuar.'
        });

    }

    return valido;
}


// ==========================================
// CONTINUAR
// ==========================================

$('.btnContinuar').click(function () {

    let paso = parseInt(
        $(this).data('step')
    );

    if (!validarPaso(paso)) {
        return;
    }

    $('#estadoPaso' + paso)
        .removeClass('bg-secondary')
        .addClass('bg-success')
        .text('Completado ✓');

    pasoActual = paso + 1;

    mostrarPaso(pasoActual);

});


// ==========================================
// ANTERIOR
// ==========================================

$('.btnAnterior').click(function () {

    pasoActual--;

    mostrarPaso(pasoActual);

});


// ==========================================
// FINALIZAR EDUCACIÓN
// ==========================================

$('.btnFinalizar').click(function () {

    // Educación = paso 6
    if (!validarPaso(6)) {
        return;
    }

    // Marcar educación como completada
    $('#estadoPaso6')
        .removeClass('bg-secondary')
        .addClass('bg-success')
        .text('Completado ✓');

    // Ir al resumen
    pasoActual = 7;

    generarResumen();

    mostrarPaso(pasoActual);

    // Forzar 100% en el resumen
    $('#progressBar')
        .css('width', '100%');

    $('#progressText')
        .text('100%');

    $('#progressMessage')
        .text('¡Postulación completada! Revise el resumen.');

});


// ==========================================
// GENERAR DETALLE
// ==========================================

function obtenerDetalle() {

  let detalle = {};

$('#secciones')
    .find('input[name], select[name], textarea[name]')
    .each(function () {

        let nombre = $(this).attr('name');
        let valor;

        if ($(this).is('select')) {

            let selected = $(this).find('option:selected');

            valor = {
                value: selected.val(),
                text: selected.text()
            };

        } else {

            valor = $(this).val();

        }

        detalle[nombre] = valor;

    });

return detalle;

}



// ==========================================
// RESUMEN
// ==========================================

function generarResumen() {

    let detalle = obtenerDetalle();

    let html = `


<div class="card border-0 shadow-sm text-uppercase">

    <!-- CABECERA -->
    <div class="card-header bg-dark text-white py-3">

        <div class="d-flex align-items-center">

            <div class="me-3 fs-3">
                <i class="fa-solid fa-file-lines"></i>
            </div>

            <div>
                <h5 class="mb-0 fw-bold">
                    Resumen de Postulación
                </h5>

                <small class="opacity-75">
                    Revise la información ingresada antes de enviar
                </small>
            </div>

        </div>

    </div>


    <div class="card-body p-4">

        <!-- ========================= -->
        <!-- DATOS PERSONALES -->
        <!-- ========================= -->

        <div class="mb-4">

            <div class="d-flex align-items-center border-bottom pb-2 mb-3">

                <i class="fa-solid fa-user text-primary me-2"></i>

                <h6 class="fw-bold mb-0">
                    Datos personales
                </h6>

            </div>


            <div class="row g-3">

                <div class="col-md-6">
                    <div class="bg-light rounded p-3 h-100">
                        <small class="text-muted d-block">
                            Nombres
                        </small>

                        <span class="fw-semibold">
                            ${detalle.nombres || '-'}
                        </span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="bg-light rounded p-3 h-100">
                        <small class="text-muted d-block">
                            Apellidos
                        </small>

                        <span class="fw-semibold">
                            ${detalle.apellidos || '-'}
                        </span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="bg-light rounded p-3 h-100">
                        <small class="text-muted d-block">
                            Número de identificación
                        </small>

                        <span class="fw-semibold">
                            ${detalle.cedula || '-'}
                        </span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="bg-light rounded p-3 h-100">
                        <small class="text-muted d-block">
                            Fecha de nacimiento
                        </small>

                        <span class="fw-semibold">
                            ${detalle.fechaNacimiento || '-'}
                        </span>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="bg-light rounded p-3 h-100">
                        <small class="text-muted d-block">
                            Nacionalidad
                        </small>

                        <span class="fw-semibold">
                            ${detalle.nacionalidad || '-'}
                        </span>
                    </div>
                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- CONTACTO -->
        <!-- ========================= -->

        <div class="mb-4">

            <div class="d-flex align-items-center border-bottom pb-2 mb-3">

                <i class="fa-solid fa-address-book text-primary me-2"></i>

                <h6 class="fw-bold mb-0">
                    Información de contacto
                </h6>

            </div>


            <div class="row g-3">

                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            <i class="fa-solid fa-mobile-screen me-1"></i>
                            Celular
                        </small>

                        <span class="fw-semibold">
                            ${detalle.celular || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            <i class="fa-solid fa-envelope me-1"></i>
                            Correo electrónico
                        </small>

                        <span class="fw-semibold">
                            ${detalle.email || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Provincia
                        </small>

                        <span class="fw-semibold">
                            ${detalle.provincia.text|| '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Cantón
                        </small>

                        <span class="fw-semibold">
                            ${detalle.canton.text || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="bg-light rounded p-3">

                        <small class="text-muted d-block">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            Dirección
                        </small>

                        <span class="fw-semibold">
                            ${detalle.direccion || '-'}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- POSTULACIÓN -->
        <!-- ========================= -->

        <div class="mb-4">

            <div class="d-flex align-items-center border-bottom pb-2 mb-3">

                <i class="fa-solid fa-briefcase text-primary me-2"></i>

                <h6 class="fw-bold mb-0">
                    Información de postulación
                </h6>

            </div>


            <div class="row g-3">

                <div class="col-md-12">

                    <div class="border rounded p-3 bg-success ">

                        <small class="text-white d-block">
                            Cargo al que desea postularse
                        </small>

                        <span class="fw-bold text-white fs-5">
                            ${detalle.cargo.text || '-'}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- EXPERIENCIA -->
        <!-- ========================= -->

        <div class="mb-4">

            <div class="d-flex align-items-center border-bottom pb-2 mb-3">

                <i class="fa-solid fa-business-time text-primary me-2"></i>

                <h6 class="fw-bold mb-0">
                    Experiencia laboral
                </h6>

            </div>


            <div class="row g-3">

                <div class="col-md-8">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Cargo anterior
                        </small>

                        <span class="fw-semibold">
                            ${detalle.cargo_Experiencia || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Tiempo de experiencia
                        </small>

                        <span class="fw-semibold">
                        

                             ${detalle.tiempo_Experiencia.text|| '-'} años
                        </span>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="bg-light rounded p-3">

                        <small class="text-muted d-block">
                            Empresa
                        </small>

                        <span class="fw-semibold">
                            ${detalle.empresa_Experiencia || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="bg-light rounded p-3">

                        <small class="text-muted d-block">
                            Descripción de funciones
                        </small>

                        <div class="mt-1">
                            ${detalle.descripcion_Experiencia || '-'}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ========================= -->
        <!-- EDUCACIÓN -->
        <!-- ========================= -->

        <div>

            <div class="d-flex align-items-center border-bottom pb-2 mb-3">

                <i class="fa-solid fa-graduation-cap text-primary me-2"></i>

                <h6 class="fw-bold mb-0">
                    Formación académica
                </h6>

            </div>


            <div class="row g-3">

                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Nivel académico
                        </small>

                        <span class="fw-semibold">
                            ${detalle.nivel.text || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-6">

                    <div class="bg-light rounded p-3 h-100">

                        <small class="text-muted d-block">
                            Año de graduación
                        </small>

                        <span class="fw-semibold">
                            ${detalle.a_Graduacion || '-'}
                        </span>

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="bg-light rounded p-3">

                        <small class="text-muted d-block">
                            Institución educativa
                        </small>

                        <span class="fw-semibold">
                            ${detalle.institucion_Educativa || '-'}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- CONFIRMACIÓN -->
    <!-- ========================= -->

    <div class="card-footer bg-white border-top p-4">

        <div class="alert alert-warning d-flex align-items-start mb-0">

            <i class="fa-solid fa-circle-exclamation me-3 mt-1"></i>

            <div>

                <strong>
                    Antes de continuar
                </strong>

                <div class="small mt-1">
                    Verifique que todos los datos ingresados sean correctos.
                    Una vez enviada la postulación, la información será procesada.
                </div>

            </div>

        </div>

    </div>

</div>


    `;

    $('#resumenPostulacion').html(html);

}


// ==========================================
// CONFIRMACIÓN
// ==========================================

$('#confirmarDatos').change(function () {

    $('#btnEnviar').prop(
        'disabled',
        !$(this).is(':checked')
    );

});


// ==========================================
// INICIO
// ==========================================

mostrarPaso(1);




/// funciones  elemenros visuales
cbx_bs_pro();

function cbx_bs_pro(){

$.post('../db/cbx_provincias.php', function (r) {

    console.log(r);

    $('#cbx_provincia').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_provincia').append(
                `<option value="${item.id}">${item.p}</option>`
            );
        }
    });

}, 'json');



}



function cbx_bs_pro(){

$.post('../db/cbx_provincias.php', function (r) {

    console.log(r);

    $('#cbx_provincia').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_provincia').append(
                `<option value="${item.id}">${item.p}</option>`
            );
        }
    });

}, 'json');



}


$('#cbx_provincia').on('change', function () {

    let valor = $(this).val();

    console.log(valor);

    cbx_bs_canton(valor);

});





function cbx_bs_canton(valor){

    console.log(valor);

$.post('../db/cbx_canton.php',{valor}, function (r) {

    console.log(r);

    $('#cbx_canton').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_canton').append(
                `<option value="${item.id}">${item.c}</option>`
            );
        }
    });

}, 'json');



}


// cargar ofertas disponibles 

cbx_cargo();

function cbx_cargo(){

$.post('../db/cbx_cargo.php', function (r) {

    console.log(r);

    $('#cbx_cargo').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_cargo').append(
                `<option value="${item.id}">${item.cg}</option>`
            );
        }
    });

}, 'json');



}

/// nivel 


cbx_nivel();


function cbx_nivel(){

$.post('../db/cbx_nivel.php', function (r) {

    console.log(r);

    $('#cbx_nivel').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_nivel').append(
                `<option value="${item.id}">${item.nv}</option>`
            );
        }
    });

}, 'json');



}


// cbx t experiencia 



cbx_t_expereiencia();


function cbx_t_expereiencia(){

$.post('../db/cbx_t_experiencia.php', function (r) {

    console.log(r);

    $('#cbx_t_expereiencia').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_t_expereiencia').append(
                `<option value="${item.id}">${item.t_ex}</option>`
            );
        }
    });

}, 'json');



}


$('#btnEnviar').on('click', function () {


    let detalle = obtenerDetalle();

    var  register = JSON.stringify(detalle);

    console.log(register);


   $.post('../db/in_postulacion.php', {register}, function (r) {

console.log(r);

         if (!r.err) {

               let id = r.id_postulante;

               console.log(id);

               guardarHojaVida(id);

               //window.location.href = '../web/rutas.php?ruta=mensaje';


           

        }

   });



});






});



$('#fechaNacimiento').on('change', function () {
    let fechaNacimiento = new Date($(this).val());
    let hoy = new Date();

    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    let mes = hoy.getMonth() - fechaNacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    if (edad < 18) {
        Swal.fire({
            icon: 'error',
            title: 'Debes ser mayor de edad, para continuar',})




    }
});



function guardarHojaVida(id) {

 // gurdar hoja de vida postulacion 


let formData = new FormData($('#formPostulacion')[0]);


console.log('FormData:', formData);

// Agregar ID del postulante
formData.append('id', id);

$.ajax({

    url: '../db/in_cv_postulacion.php',

    type: 'POST',

    data: formData,

    processData: false,

    contentType: false,

    dataType: 'json',

    success: function(r) {

        console.log(r);

        if (r.err) {
            Swal.fire({
                icon: r.icon || 'warning',
                title: 'Atención',
                text: r.msg
            });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: '¡Listo!',
            text: r.msg
        });

    },

    error: function(xhr, status, error) {

        console.error('Error AJAX:', error);
        console.error('Respuesta:', xhr.responseText);

    }

});




}

 