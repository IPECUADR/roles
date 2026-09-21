
<div class="container main-content">

    <!-- HERO -->
    <div class="vacaciones-header mb-5">

        <div>

            <span class="badge bg-light text-primary mb-3">
                <i class="bi bi-bookmark-check-fill me-1"></i>
                Gestión Humana
            </span>

            <h2 class="fw-bold">
                <i class="bi bi-person-lines-fill  me-2"></i>
                KDE | Gestión de Postulaciones
            </h2>

            <p class="mb-0 text-secondary">
                Visualice el seguimiento de las postulaciones que se encuentran pendientes de atención.
            </p>

        </div>

    </div>


    <!-- CONTENIDO -->
    <div class="card border-0 shadow-sm">

        <!-- HEADER DE TABLA -->
        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                <!-- TÍTULO -->
                <div>

                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Listado de postulaciones
                    </h5>

                    <small class="text-secondary">
                        Consulte la información y estado de cada candidato.
                    </small>

                </div>


                <!-- ACCIONES -->
                <div>

                    <button
                        type="button"
                        class="btn btn-success px-3 shadow-sm"
                        id="btnGenerarExcel">

                        <i class="bi bi-file-earmark-excel-fill me-2"></i>
                        Generar Excel

                    </button>

                </div>

            </div>

        </div>


        <!-- TABLA -->
        <div class="card-body pt-0">

            <div class="table-responsive border rounded-3">

                <table class="table table-hover align-middle mb-0">

                    <!-- CABECERA -->
                    <thead class="table-light">

                        <tr>

                            <th class="text-center px-3">
                                N°
                            </th>

                            <th>
                                Postulante
                            </th>

                            <th>
                                Puesto Aplicado
                            </th>

                            <th>
                                Fecha de Postulación
                            </th>

                            <th class="text-center">
                                CV
                            </th>

                            <th class="text-center">
                                Estado
                            </th>

                            <th class="text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <!-- DATOS AJAX -->
                    <tbody id="tblPostulaciones">

                        <!-- Registros cargados mediante AJAX -->

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>




<div class="modal modal-lg" id="modal_post" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" id="titulo_modal">
        
      </div>
      <div class="modal-body" id="contenido_modal">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer" id="acciones_modal">
       
      </div>
    </div>
  </div>
</div>

