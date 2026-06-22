<div class="container main-content py-4">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-1">
                        <i class="bi bi-gear-fill me-2"></i>Configuración
                    </h4>
                    <small class="text-white-50">
                        Administra la seguridad de tu cuenta.
                    </small>
                </div>

                <div class="card-body p-4 p-lg-5">

                    <!-- BLOQUE CONTRASEÑA -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-key-fill me-2"></i>Cambiar contraseña
                        </h6>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Contraseña actual</label>
                                <input type="password" class="form-control" id="pass_actual" placeholder="Ingrese su contraseña actual">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Nueva contraseña</label>
                                <input type="password" class="form-control" id="pass_nueva" placeholder="Ingrese su nueva contraseña">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Confirmar nueva contraseña</label>
                                <input type="password" class="form-control" id="pass_confirmar" placeholder="Confirme la nueva contraseña">
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border small mb-4">
                        <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                        Por seguridad, debes ingresar tu contraseña actual antes de registrar una nueva.
                    </div>

                    <div class="d-grid d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-primary px-4" id="btn_up_pass">
                            <i class="bi bi-shield-lock-fill me-2"></i>Actualizar contraseña
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
