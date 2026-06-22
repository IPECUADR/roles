<div class="container main-content py-4">

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10 col-xxl-9">

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                
                <!-- HEADER -->
                <div class="card-header bg-dark text-white py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="bi bi-person-badge-fill me-2"></i>Mi perfil
                            </h4>
                            <small class="text-white-50">
                                Consulta y actualiza tu información personal.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-lg-5">

                    <!-- BLOQUE EDITABLE -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-pencil-square me-2"></i>Datos editables
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre</label>
                                <input type="text" class="form-control" id="nom_p" value="#N/D">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellido</label>
                                <input type="text" class="form-control" id="ap_p" value="#N/D">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Dirección</label>
                                <input type="text" class="form-control" id="dir_p" value="#N/D">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Correo</label>
                                <input type="text" class="form-control" id="email" value="#N/D">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Teléfono</label>
                                <input type="text" class="form-control" id="telf_p" value="#N/D">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- BLOQUE SOLO LECTURA -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-shield-lock-fill me-2"></i>Datos del sistema
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Cédula</label>
                                <input type="text" class="form-control bg-light" id="ci_p" value="#N/D" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Usuario</label>
                                <input type="text" class="form-control bg-light" id="user_p" value="#N/D" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Cargo</label>
                                <input type="text" class="form-control bg-light" id="cargo_cg" value="#N/D" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Proyecto</label>
                                <input type="text" class="form-control bg-light" id="proyecto" value="#N/D" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipo de usuario</label>
                                <input type="text" class="form-control bg-light" id="t_user" value="#N/D" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- ALERTA PEQUEÑA -->
                    <div class="alert alert-light border small mb-4">
                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                        Puedes actualizar tus datos personales. Los datos del sistema son solo informativos.
                    </div>

                    <!-- BOTÓN -->
                    <div class="d-grid d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-primary px-4" id="btn_up_perfil">
                            <i class="bi bi-floppy-fill me-2"></i>Actualizar información
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>