  $(document).ready(function () {
    // carga dinamica de datos
    let url ='../db/b_rol.php';
    let params = {};


    anio_actual();
    cbx_mes();
    cargar_rol_user(url, params);
    contar_roles();
    
    contar_dowload();
    
  });

  // cargar mes

  function cbx_mes(){

$.post('../db/cbx_mes.php', function (r) {

    console.log(r);

    $('#cbx_mes').empty()
        .append('<option value="">Selecione</option>');

    $.each(r, function (i, item) {
        if (i !== 'err') {
            $('#cbx_mes').append(
                `<option value="${item.id}">${item.m}</option>`
            );
        }
    });

}, 'json');



}
  
  // Función para mostrar el año actual en el pie de página
  function anio_actual(){

    const fecha = new Date();
    const anio = fecha.getFullYear();   

    $('#year_ac').append(anio);

}

// funcion para contar los roles registrados en la base de datos


 // carga dinamica de datos
    let roles_pdf = [];
    let url ='../db/b_rol.php';
    let params = {};





 function cargar_rol_user(url, params){
  
  

    $.post(url,params, function (r) {
      
        roles_pdf = r;

  console.log(r);    

       
    if (!r.err) {

     

        $('#rol_digital').empty();

        $.each(r, function (i, item) {
            if (i !== 'err') {
                $('#rol_digital').append(
                    `
<div class="container my-4 rol-container p-4 shadow rounded">

    <!-- HEADER -->
    <div class="row align-items-center mb-4 border-bottom pb-3">
        <div class="col-md-3 text-center text-md-start">
            <img src="../img/logo.png" class="img-fluid" style="max-height:60px;">
        </div>

        <div class="col-md-6 text-center">
            <h5 class="fw-bold mb-0 text-uppercase">Kluane Drilling Ecuador</h5>
            <small class="text-muted">ROL DE PAGOS</small>
        </div>

        <div class="col-md-3 text-md-end text-center mt-2 mt-md-0">
            <span class="badge bg-dark px-3 py-2">${item.mes} 2026</span><br>
            
        </div>
    </div>

  <!-- DATOS -->
<div class="card shadow-sm mb-4 border-0">
    <div class="card-body">

        <div class="row align-items-center">

            <!-- Información personal -->
            <div class="col-md-8">
                <h6 class="fw-semibold mb-2 text-uppercase text-secondary">
                    Información del colaborador
                </h6>

                <div class="row small">
                    <div class="col-md-6 mb-2">
                        <span class="text-muted">Nombre</span>
                        <div class="fw-semibold">
                            ${item.nom_p} ${item.ap_p}
                        </div>
                    </div>

                

                    <div class="col-md-6 mb-2">
                        <span class="text-muted">Cargo</span>
                        <div class="fw-semibold">
                            ${item.cargo_cg}
                        </div>

                        </div>
                        <div class="col-md-6 mb-2">
                            <span class="text-muted">Cédula</span>
                            <div class="fw-semibold">
                                ${item.ci_p}
                            </div>
                        </div>
                         <div class="col-md-6 mb-2">
                            <span class="text-muted">PROYECTO</span>
                            <div class="fw-semibold">
                                ${item.agencia}
                            </div>
                        </div>

                        


                </div>
            </div>

            <!-- Días del mes -->
            <div class="col-md-4 text-center border-start">
                <div class="py-3">
                    <div class="text-muted small text-uppercase">
                        Días del mes
                    </div>
                    <div class="display-6 fw-bold text-primary">
                        ${item.dias}
                    </div>
                </div>
            </div>

        </div>

    </div>



















    
</div>



<div class="container-fluid mt-3 mb-4">

    <div class="card border rounded-3 p-3 bg-light resumen-box shadow">

        <div class="text-center text-secondary fw-semibold small mb-3">
            Resumen de Días
        </div>

        <div class="row g-2 text-center small">

            <!-- TURNOS -->
            <div class="col-12 col-md">
                <div class="resumen-card">
                    <div class="resumen-title">TURNOS</div>
                    <div class="resumen-values">
                        <span>D <span class="badge badge-dia">${item.dias_dia}</span></span>
                        <span>N <span class="badge badge-noche">${item.dias_noche}</span></span>
                    </div>
                </div>
            </div>

            <!-- FESTIVOS -->
            <div class="col-12 col-md">
                <div class="resumen-card">
                    <div class="resumen-title">FESTIVOS</div>
                    <div class="resumen-values">
                        <span>D <span class="badge badge-festivo">${item.d_fest_dia}</span></span>
                        <span>N <span class="badge badge-noche">${item.d_fest_noche}</span></span>
                    </div>
                </div>
            </div>

            <!-- PENDIENTES -->
            <div class="col-12 col-md">
                <div class="resumen-card">
                    <div class="resumen-title">PENDIENTES</div>
                    <div class="resumen-values">
                        <span>D <span class="badge badge-noche">0</span></span>
                        <span>N <span class="badge badge-noche">0</span></span>
                    </div>
                </div>
            </div>

            <!-- REP -->
            <div class="col-6 col-md">
                <div class="resumen-card simple">
                    <div class="resumen-title">REP</div>
                    <span class="badge badge-noche">${item.d_reposo}</span>
                </div>
            </div>

            <!-- IESS -->
            <div class="col-6 col-md">
                <div class="resumen-card simple">
                    <div class="resumen-title">IESS</div>
                    <span class="badge badge-noche">${item.d_iess}</span>
                </div>
            </div>

            <!-- VAC -->
            <div class="col-6 col-md">
                <div class="resumen-card simple">
                    <div class="resumen-title">VAC</div>
                    <span class="badge badge-noche">${item.d_vacaciones}</span>
                </div>
            </div>

            <!-- TOTAL -->
            <div class="col-6 col-md">
                <div class="resumen-card total">
                    <div class="resumen-title">TOTAL</div>
                    <span class="badge badge-total">${item.t_dia}</span>
                </div>
            </div>

        </div>

    </div>

</div>




    <!-- TABLAS -->
    <div class="row">

        <!-- INGRESOS -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-semibold">INGRESOS</div>

                <table class="table table-sm mb-0 align-middle">
                    <tbody>
                        <tr><td>Sueldo Básico</td><td class="text-end">$${item.sueldo_basico}</td></tr>
                        <tr><td>Sueldo Mensual</td><td class="text-end">$${item.sueldo_mensual}</td></tr>
                        <tr><td>Horas Extras</td><td class="text-end">$${item.horas_extra}</td></tr>
                        <tr><td>Horas Adicionales</td><td class="text-end">$${item.horas_adicionales}</td></tr>
                        <tr><td>Jornada Nocturna</td><td class="text-end">$${item.jornada_nocturna}</td></tr>
                        <tr><td>Subsidio Reposo KDE 50%</td><td class="text-end">$${item.sub_reposo_50}</td></tr>
                        <tr><td>Subsidio Reposo KDE 25%</td><td class="text-end">$${item.sub_reposo_25}</td></tr>
                        <tr><td>Subsidio Reposo KDE 75%</td><td class="text-end">$${item.sub_reposo_75}</td></tr>
                        <tr><td>Bonos por Avance de Obra</td><td class="text-end">$${item.bn_avance_obra}</td></tr>
                        <tr><td>Bonos por Cumplimiento</td><td class="text-end">$${item.bn_cumplimiento}</td></tr>
                        <tr><td>Bonos de Produccion</td><td class="text-end">$${item.bn_produccion}</td></tr>
                        <tr><td>Bonos de Navidad</td><td class="text-end">$${item.bn_navidad}</td></tr>
                        <tr><td>Vacaciones</td><td class="text-end">$${item.vacaciones}</td></tr>
                        <tr><td>Otros ingresos ajuste sueldo</td><td class="text-end">$${item.ot_ing_ajust_sl}</td></tr>
                        <tr><td>Otros ingresos</td><td class="text-end">$${item.ot_ingresos}</td></tr>

                        <tr class="table-light fw-bold">
                            <td>Total Remuneración</td>
                            <td class="text-end text-success">$${item.total_remuneracion}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DESCUENTOS -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-semibold">DESCUENTOS</div>

                <table class="table table-sm mb-0 align-middle">
                    <tbody>
                        <tr><td>IESS</td><td class="text-end">$${item.aportes_iess}</td></tr>
                        <tr><td>Impuesto Renta</td><td class="text-end">$${item.imp_renta}</td></tr>
                        <tr><td>Préstamos Quirafario</td><td class="text-end">$${item.prestamo_quirografario}</td></tr>
                        <tr><td>Préstamos Hipotecario</td><td class="text-end">$${item.prestamo_hipotecario}</td></tr>
                        <tr><td>Préstamos Empresa</td><td class="text-end">$${item.prestamo_empresa}</td></tr>
                        <tr><td>Anticipos Sueldo</td><td class="text-end">$${item.anticipo_sueldo}</td></tr>
                        <tr><td>Otros Descuentos Contable</td><td class="text-end">$${item.otrs_des_contable}</td></tr>
                        <tr><td>Pension de Alimentos</td><td class="text-end">$${item.pension_alimentos}</td></tr>
                        <tr><td>Extencion Salud</td><td class="text-end">$${item.ext_salud_conyuge}</td></tr>
                        <tr><td>Multas</td><td class="text-end">$${item.multas}</td></tr>
                        <tr><td>Descuentos Ajustes de Sueldo</td><td class="text-end">$${item.des_ajuste_suledo}</td></tr>
                        <tr><td>Descuentos subsidio IESS 75%</td><td class="text-end">$${item.des_subcidio_iess_75}</td></tr>

                        <tr class="table-light fw-bold">
                            <td>Total Descuentos</td>
                            <td class="text-end text-danger">$${item.total_descuentos}</td>
                        </tr>
                          <tr class="table-light fw-bold">
                            <td>Valor Día</td>
                            <td class="text-end text-danger">$${item.valor_dia}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- BENEFICIOS + INFO -->
    <div class="row mt-4 g-3">

        <!-- BENEFICIOS -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-semibold">BENEFICIOS</div>

                <table class="table table-sm mb-0 align-middle">
                    <tbody>
                        <tr><td>Transporte</td><td class="text-end">$${item.transporte}</td></tr>
                        <tr><td>Devoluciones IESS</td><td class="text-end">$${item.devoluciones}</td></tr>
                        <tr><td>Bono</td><td class="text-end">$${item.bono}</td></tr>
                        <tr><td>Votaciones</td><td class="text-end">$${item.votaciones}</td></tr>
                        <tr><td>Fondo Reserva Pend Tercero</td><td class="text-end">$${item.fondo_reserva_p}</td></tr>
                        <tr><td>Fondo Reserva</td><td class="text-end">$${item.fon_reserva}</td></tr>
                        <tr><td>Decimo Tercero</td><td class="text-end">$${item.decimo_t}</td></tr>
                        <tr><td>Decimo Cuarto</td><td class="text-end">$${item.decim_c}</td></tr>

                        <tr class="table-light fw-bold">
                            <td>Total Beneficios</td>
                            <td class="text-end text-primary">$${item.total_beneficios}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- INFO PAGO -->
        <div class="col-md-6">

            <div class="mb-3">
                <label class="form-label fw-semibold">Forma de Pago</label>
                <input type="text" class="form-control bg-light" value="${item.forma_pago}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea class="form-control bg-light" rows="2" disabled>${item.observaciones} /   ${item.coment_2}
                 
               
                
                </textarea>
            </div>

            <div class="p-3 rounded-3 bg-dark text-white text-center shadow-sm">
                <small>Líquido a Pagar</small>
                <h4 class="fw-bold text-warning mb-0">$${Number(item.liquido_pagar).toFixed(2)}</h4>
            </div>

        </div>

    </div>
    
    
       <!-- FOOTER -->
    <div class="footer-doc mt-5 pt-4">
        <div class="row text-center text-md-start align-items-end g-4">

            <div class="col-12 col-md-4">
                <div class="firma-box">
                    <div class="firma-imagen">
                        <img src="" class="img-fluid">
                    </div>
                    <div class="firma-linea"></div>
                    <small>Elaborado por</small><br>
                    <strong>${item.nom_firma}</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 text-center">
                <div class="firma-box">
                    <div class="firma-imagen">
                        <img src="" class="img-fluid">
                    </div>
                    <div class="firma-linea"></div>
                    <small>Aprobado por</small><br>
                    <strong>${item.nom_firma}</strong>
                </div>
            </div>

            <div class="col-12 col-md-4 text-md-end text-center">
                <div class="firma-box">
                    <div class="firma-imagen">
                     <img src="${item.firm_p}" class="img-fluid">
                    </div>
                    <div class="firma-linea"></div>
                    <small>Recibí Conforme</small><br>
                    <strong> ${item.nom_p} ${item.ap_p}</strong>
                </div>
            </div>

        </div>
    </div>

</div>

    
                    
                    
                    `
                );
            }
        });

    }else{

              mensaje('info', r.msg);

               $('#rol_digital').empty();

        
    }

    }, 'json');



}

// genrar pdf

$(document).on('click', '#gen_pdf', function() {


    verificar_imagen_seguridad();

 

});
//mensajes


//funcion logs 

function mensaje (icon,  msg){

    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        }).fire({
        icon: icon,
        title: msg
        })

  }

// buscar roles por mes 
$('#cbx_mes').on('change', function() {

    let mes = $(this).val();
    let url ='../db/fil_rol.php';
    let params = {mes};
   

    cargar_rol_user(url, params);

});


function contar_roles(){

    $.post('../db/ct_roles.php', function (r) {

        console.log(r);

        $('#count').empty()
           

        $.each(r, function (i, item) {
            if (i !== 'err') {
                $('#count').append(
                    `${item.t} <i class="bi bi-file-earmark-fill"></i>`
                );
            }
        });

    }, 'json');

}



function contar_dowload(){

    $.post('../db/ct_logs_dow.php', function (r) {

        console.log(r);

        $('#count_cert').empty()
           

        $.each(r, function (i, item) {
            if (i !== 'err') {
                $('#count_cert').append(
                    `${item.t} <i class="bi bi-cloud-download-fill"></i>`
                );
            }
        });

    }, 'json');

}

function log(accion, status){
console.log('Registrando acción:', accion);
    $.post('../db/in_logs.php', {accion, status}, function (r) {

        console.log(r);

        contar_dowload();

    }, 'json');

}


function generar_pdf(){

    
   
   let  rp = roles_pdf;



  console.log(rp);

if (!Array.isArray(rp) || rp.length === 0) {
    mensaje('error', 'No existen datos');
    return;
}





$.ajax({
    url: "../pdf/consumo.php",
    method: "POST",
    data: { cp: JSON.stringify(rp) },
    xhrFields: {
        responseType: "blob"
    },
    success: function(blob){

         log('Generación de PDF exitosa', 'Exitoso');

        console.log("Blob size:", blob.size);

        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = "rol_pago.pdf";
        a.click();

        window.URL.revokeObjectURL(url);
    },
    error: function(xhr, status, error) {

          
            log('Error al generar PDF', 'Error');
            mensaje('error', 'Error al generar PDF');

    }
});

}


/// verficar si el colaborador tiene imagen de seguridad para mostrarla en el rol de pago

function verificar_imagen_seguridad(){


  $.post('../db/us_ser_img.php', function (r) {

        console.log(r);

                
            if (!r.err) {
            mostrar_imagen_seguridad();
            return;
            }

            if (r.code === 'NO_ACEPTADO') {
            seleccionar_imagen_seguridad();
            return;
            }

            if (r.code === 'INHABILITADO') {
             mensaje('error', r.msg);
             log('Usuario inhabilitado para generar rol de pago por superar intentos de validación de imagen de seguridad', 'Error');
             $('#gen_pdf').prop('disabled', true);
            return;
            }


    }, 'json');


}





// function imagen de seguridad 

function mostrar_imagen_seguridad() {

  title = 'Imagen de verificación de seguridad';
  content = `<div class="row" id="formulario_img_seguridad"></div>`;
  accions = `
  <div class="container mb-3">

  <div class="row">
            <!-- Col 6 -->
            <div class="col-lg-6 col-sm-12 mb-2">
                <button data-bs-dismiss="modal" class="btn btn-dark w-100" id="btn_cerrar">
                Cerrar
                </button>
            </div>

        <!-- Col 6 -->
        <div class="col-lg-6 col-sm-12 ">
            <button class="btn btn-outline-danger w-100" id="generar_doc_pdf">
            Generar rol de pago <i class="bi bi-file-earmark-pdf-fill"></i>
            </button>
        </div>
    
    </div>

</div>
        `;

  modal_ensamble(title, content, accions);

  $.post('../db/cg_img_sg.php', function (r) {

    let bloques = [];

    $.each(r, function (i, item) {

      let code = `
        <div class="col-4 mt-1 mb-3">
          <label class="img-option">
            <input type="radio" name="imagen" value="${item.PK_img}">
            <img src="../im/${item.img_validate}.png" class="img-fluid rounded">
          </label>
        </div>
      `;

      bloques.push(code);
    });

    
    bloques.sort(() => Math.random() - 0.5);

    $('#formulario_img_seguridad').html(bloques.join(''));

  }, 'json');

}



/// selecion y  guardar imagen de seguridad para mostrarla en el rol de pago

function seleccionar_imagen_seguridad(){

  title = 'Imagen de Seguridad';
  content = `
<h5 class="fw-bold text-danger mb-2"><i class="bi bi-info-circle-fill"></i> Importante</h5>
<p class="shadow-sm text-dark p-3 bg-light rounded">
  Debe seleccionar una imagen de seguridad. 
  <br>Esta imagen se utilizará para validar tu identidad y permitir la descarga de tus roles de pago.
</p>

  
  <div class="row" id="form_select_img"></div>
  
  
  `;
  accions = `
  <div class="container mb-3">

  <div class="row">
            <!-- Col 6 -->
            <div class="col-lg-6 col-sm-12 mb-2">
                <button data-bs-dismiss="modal" class="btn btn-dark w-100" id="btn_cerrar">
                Cerrar
                </button>
            </div>

        <!-- Col 6 -->
        <div class="col-lg-6 col-sm-12 ">
         <button class="btn btn-primary w-100" id="g_img_sg">
            Guardar Imagen 
            </button>
        </div>
    
    </div>

</div>
        `;

  modal_ensamble(title, content, accions);

  $.post('../db/cg_img_sg.php', function (r) {

    let bloques = [];

    $.each(r, function (i, item) {

      let code = `
        <div class="col-4 mt-1 mb-3">
          <label class="img-option">
            <input type="radio" name="imagen" value="${item.PK_img}">
            <img src="../im/${item.img_validate}.png" class="img-fluid rounded">
          </label>
        </div>
      `;

      bloques.push(code);
    });

    
    bloques.sort(() => Math.random() - 0.5);

    $('#form_select_img').html(bloques.join(''));

  }, 'json');



}
///funcion para guar imagen de seguridad selecionada
$(document).on('click', '#g_img_sg', function() {

  let imgId = $('input[name="imagen"]:checked').val();

  console.log(imgId);

    if (!imgId) {
        mensaje('error', 'Por favor, seleccione una imagen de seguridad');
        return;
    }

    $.post('../db/in_img_seg.php', { imgId }, function (r) {

        if (!r.err) {

            $('#modal_service').modal('hide');
            mensaje('success', r.msg);

            log('Registro de imagen de seguridad','Exitoso');
            mostrar_imagen_seguridad();
        } else {
            mensaje('error', r.msg);
            console.log('Error al guardar imagen de seguridad:', r.msg);
        }

    }, 'json');

});



/// ENSAMBLE DE MODAL PARA MOSTRAR IMAGEN DE SEGURIDAD Y SELECCIONARLA

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



const seguridad = {
  intentosMax: 3,
  intentos: 0
};


$(document).on('click', '#generar_doc_pdf', function() {   






  let imgId = $('input[name="imagen"]:checked').val();

  if (!imgId) {
    mensaje('error', 'Por favor, seleccione una imagen de seguridad');
    return;
  }

  $.post('../db/us_validate_img.php', { imgId }, function (r) {

    if (!r.err) {
      $('#modal_service').modal('hide');

      generar_pdf();
      
    } else {

      mensaje('error', r.msg);
      log('Error al validar imagen de seguridad, para generarr rol de pago', 'Error');
      mostrar_imagen_seguridad();   



      //// incrementar intentos y verificar si se supera el máximo permitido

      seguridad.intentos++;

            if (seguridad.intentos > seguridad.intentosMax) {
            
                mensaje('error', 'Has superado el número máximo de intentos. Por favor, inténtalo más tarde.');
                log('Número máximo de intentos superado para validar imagen de seguridad', 'Error');
                desactivar_imagen_seguridad();
                $('#generar_doc_pdf').prop('disabled', true);
            
            
            
                return;
            }

    
    }   



    }, 'json');



 });

 // funcion para desactivar la imgen 

       function desactivar_imagen_seguridad() {


        $.post('../db/des_img_user.php', function (r) {
            console.log(r);

          let timerInterval;
            Swal.fire({
            title: "Has superado el número máximo de intentos",
            html: "Se cerrará la sesión en <b></b> milisegundos.",
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) console.log("Finalizando sesión...");
              //log de cierre de sesión por superar intentos de validación de imagen de seguridad
              log('Finaliza sesion, por superar intentos de validación de imagen de seguridad', 'Error');
             // redireccionar a logout para cerrar sesión y evitar intentos posteriores
              window.location.href = '../web/rutas.php?ruta=logout';
            });
           

        }, 'json');
    }
        