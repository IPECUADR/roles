 $(document).ready(function () {
    vacaciones_periodo();
    //contar_vacaciones();

});
 
 









/// contar roles emitidos 

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