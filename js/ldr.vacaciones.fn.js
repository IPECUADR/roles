 $(document).ready(function () {
    procesos_lider();
    vacaciones_periodo();
   
});
 
/// contar roles emitidos 

function procesos_lider(){

    $.post('../web/rutas.php?ruta=procesos', function (r) {

   

        $('#sec_procesos').empty()
         .append( `
            
                <div class="col-md-3" id="user_vacaciones">
                        <div class="card-clbr card-blue"><h6> Mis Vacaciones</h6><h3 id="vac_clbr_sec"><i class=" text-success   bi bi-calendar2-week"></i> </h3></div>
                </div>

                 
            
            `);
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {
                $('#sec_procesos').append(


                    `
    
                       <div class="col-md-3 elemnto_proceso" id="${item.id}">
                            <div class="card-clbr card-blue"><h6 > Proceso  ${item.a}</h6><h3 id="roles_p">    <i class="bi bi-calendar2-check-fill me-1"></i>
    <i class="bi bi-people-fill me-2"></i></h3></div>
                      </div>
                    
                    `
                );
         
            }
        });

                

    }, 'json');

}



$(document).on('click', '.elemnto_proceso', function () {
    let area = this.id;
    console.log(area);
    cargar_proceso_vacaciones(area);
}); 


// buscar registros de vacaciones por proceso

function cargar_proceso_vacaciones(area) {

    


    $.post('../web/rutas.php?ruta=mostar_vacaciones_proceso',{ area },function (r) {

        $('#secc_per_vac').empty()
        .append( `
            
      <div class="container mt-4 mb-4 shadow border-0 bg-light p-0 rounded overflow-hidden" id="contenedor">

    <!-- Encabezado -->
    <div class="header-gradient p-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">

           <div>
            <h4 class="fw-bold text-white mb-1">
                <i class="bi bi-calendar2-check-fill me-2"></i>
                Gestión de Vacaciones
            </h4>
            <small class="text-white-50">
                Colaboradores asignados a su proceso y estado de sus períodos vacacionales.
            </small>
        </div>

         

        </div>

    </div>

</div>
            
            
            `);

        if (r.err) {
            $('#secc_per_vac').html(`
                <div class="alert alert-warning">
                    ${r.err}
                </div>
            `);
            return;
        }

        console.log(r);

        $.each(r, function (i, item) {

            $('#secc_per_vac').append(`
<div class="col-md-4 mb-4"    >
     <div class="card border-0 shadow rounded-4 h-100 position-relative vac-card  detalle"  id="${item.id}"  names="${item.nom_p} ${item.ap}" title="Ver detalle">

        <!-- Gozados -->
        <span class="position-absolute top-0 end-0 m-3 badge bg-danger px-3 py-1 fs-9">
            ${item.dg} Gozados
        </span>

        <div class="card-body">

            <!-- Proceso -->
            <h6 class="text-uppercase text-secondary fw-bold mb-1">
                ${item.a}
            </h6>

            <!-- Colaborador -->
            <h6 class="fw-bold text-dark mb-4">
                ${item.nom_p} ${item.ap}
            </h6>

            <div class="text-center">

                <div class="display-6 fw-bold text-primary">
                    ${item.dp}
                </div>

                <div class="text-muted fs-5">
                    Total disponibles
                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <span class="fw-semibold">
                 Total Dias
                </span>

                <span class="fw-bold text-dark">
                    ${item.t_vc} días
                </span>
            </div>

            <div class="progress mt-2" style="height:12px;">
                <div class="progress-bar bg-success"
                     style="width:${(item.dp/item.t_vc)*100}%">
                </div>
            </div>

        </div>

    </div>
</div>
            `);

        });

    }, 'json');

}








// ver las vaciones del  lider 

$(document).on('click', '#user_vacaciones', function () {


  vacaciones_periodo();

})





/// vacaciones del lider 

function vacaciones_periodo(){

    $.post('../web/rutas.php?ruta=mostar_vacaciones_periodo', function (r) {

   

        $('#secc_per_vac').empty()
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

                let estado = validate_asg(item.t_vc);


                $('#secc_per_vac').append(
                    `
                    
                    
                      <!-- Periodo -->

                        <div class="col-lg-6">

                            <div class="vac-card">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>

                                                <small class="text-uppercase text-secondary">
                                                Período
                                                </small>

                                                <h4 class="mb-0 text-dark">
                                               ${item.pr}
                                                </h4>

                                        </div>

                                        <span >
                                                <i class="fas fa-circle me-1"></i>
                                                ${estado}
                                        </span>

                            </div>

                                <hr>

                                <div class="row text-center">

                                    <div class="col">

                                        <h2>${item.dp}</h2>

                                        <small>Pendientes</small>

                                    </div>

                                    <div class="col">

                                        <h2>${item.dg}</h2>

                                        <small>Tomadas</small>

                                    </div>

                                    <div class="col">

                                        <h2>${item.t_vc}</h2>

                                        <small >Disponibles</small>

                                    </div>

                                </div>

                                

                            </div>

                        </div>

    
                    
                    
                    
                    
                    
                    
                    `
                );
         
            }
        });

                

    }, 'json');

}

function validate_asg(valor){

    if (valor == null || valor === '') {
        return `<span class="badge bg-warning text-dark">No existen registros de este período</span>`;
    }

    if (Number(valor) === 0) {
        return `<span class="estado estado-finalizado">Sin días pendientes</span>`;
    }

    return `<span class="estado estado-vigente"> Tienes día(s) pendientes</span>`;
}




/// ver detalles


$(document).on('click', '.detalle', function () {
    let bs = this.id;
 

    vacaciones_proceso_persona_detalle(bs);
   
}); 


function vacaciones_proceso_persona_detalle(bs){

    



    $.post('../web/rutas.php?ruta=seleccion', {bs}, function (r) {

   

        $('#respuesta_modal').empty()
           
         console.log(r);

          $.each(r, function (i, item) {
            if (i !== 'err') {

                let estado = validate_asg(item.t_vc);


                $('#respuesta_modal').append(
                    `
                    
                    
                      <!-- Periodo -->

                        <div class="col-12 mt-4 mb-4">

                            <div class="vac-card">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>

                                                <small class="text-uppercase text-secondary">
                                                  Período | ${item.pr}
                                               
                                                </small>

                                                <h6 class="mb-0 text-dark">
                                                 ${item.name}
                                                </h6>

                                        </div>

                                        <span >
                                                <i class="fas fa-circle me-1"></i>
                                                ${estado}
                                        </span>

                            </div>

                                <hr>

                                <div class="row text-center">

                                    <div class="col">

                                        <h2>${item.dp}</h2>

                                        <small>Pendientes</small>

                                    </div>

                                    <div class="col">

                                        <h2>${item.dg}</h2>

                                        <small>Tomadas</small>

                                    </div>

                                    <div class="col">

                                        <h2>${item.t_vc}</h2>

                                        <small >Disponibles</small>

                                    </div>

                                </div>

                                

                            </div>

                        </div>

    
                    
                    
                    
                    
                    
                    
                    `
                );
         
            }
        });

                

    }, 'json');















         title =  ` <i class="bi bi-info-circle-fill"></i>  Informacion `;
                    content =  ` 

              
                       
                     <div class="card-body" id="respuesta_modal">
                           

                         

                      


                        </div>
        


                    `;

                    accions =  `
                    
      

                 <div class="col-12">
                            <button type="button"
                                    class="btn btn-dark w-100"
                                    id="btn_close">
                                    Cerrar
                            </button>
                        </div>
                    </div>
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