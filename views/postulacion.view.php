<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Postulación Laboral | KLUANE DRILLING ECUADOR</title>

<link rel="icon" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../css/job_post.css">
</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4 p-md-5">

                    <!-- ENCABEZADO -->

                    <div class="text-center mb-4">

                        <img
                            src="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png"
                            alt="Kluane"
                            class="img-fluid mb-3"
                            style="max-height:70px;"
                        >

                        <h2 class="fw-bold">
                            Formulario de Postulación
                        </h2>

                        <p class="text-muted">
                            Complete cada sección para continuar
                        </p>

                    </div>


                    <!-- PROGRESO -->

                    <div class="mb-5">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">
                                Progreso
                            </span>

                            <span
                                id="progressText"
                                class="fw-bold">
                                0%
                            </span>

                        </div>

                        <div
                            class="progress"
                            style="height:10px;">

                            <div
                                id="progressBar"
                                class="progress-bar progress-bar-striped progress-bar-animated"
                                style="width:0%">
                            </div>

                        </div>

                        <div
                            id="progressMessage"
                            class="text-muted small mt-2">

                            Comience aceptando el tratamiento de datos personales.

                        </div>

                    </div>


                    <!-- CONTENEDOR DE SECCIONES -->

                    <div id="secciones">


                        <!-- ========================================== -->
                        <!-- 1. TRATAMIENTO DE DATOS PERSONALES -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="1">

                            <div
                                class="card border"
                                id="cardPaso1">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <div>

                                        <span class="me-2">
                                       
                                        </span>

                                        <strong>
                                            Tratamiento de Datos Personales
                                        </strong>

                                    </div>

                                    <span
                                        id="estadoPaso1"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">

                                    <div
                                        id="content_datos_personales"
                                        class="mt-4 mb-4">
                                    </div>


                                    <div class="text-end">

                                        <button
                                            type="button"
                                            class="btn btn-primary btnContinuar"
                                            data-step="1">

                                            Acepto

                                            <i class="fa-solid fa-arrow-right"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 2. DATOS PERSONALES -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="2"
                            style="display:none;">

                            <div
                                class="card border"
                                id="cardPaso2">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <div>

                                        <span class="me-2">
                                            
                                        </span>

                                        <strong>
                                            Datos Personales
                                        </strong>

                                    </div>

                                    <span
                                        id="estadoPaso2"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Nombres
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control campo"
                                                name="nombres"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Apellidos
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control campo"
                                                name="apellidos"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Número de identificación
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control campo"
                                                name="cedula"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Fecha de nacimiento
                                            </label>

                                            <input
                                                type="date"
                                                id ="fechaNacimiento"
                                                class="form-control campo"
                                                name="fechaNacimiento"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Nacionalidad
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control campo"
                                                name="nacionalidad"
                                                required>

                                        </div>

                                    </div>


                                    <div class="d-flex justify-content-between">

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btnAnterior">

                                            ← Anterior

                                        </button>


                                        <button
                                            type="button"
                                            class="btn btn-primary btnContinuar"
                                            data-step="2">

                                            Continuar

                                            <i class="fa-solid fa-arrow-right"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 3. CONTACTO -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="3"
                            style="display:none;">

                            <div class="card border">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <strong>
                                      Datos de Contacto
                                    </strong>

                                    <span
                                        id="estadoPaso3"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Celular
                                            </label>

                                            <input
                                                type="number"
                                                class="form-control campo"
                                                name="celular"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Email
                                            </label>

                                            <input
                                                type="email"
                                                class="form-control campo"
                                                name="email"
                                                required>

                                        </div>


                                        <div class="col-md-6 mb-3">





                                            <label class="form-label">
                                                Provincia
                                            </label>

                                        <select id="cbx_provincia"   class="form-select campo"  name="provincia" required></select>











                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Cantón
                                            </label>


                                               <select id="cbx_canton"   class="form-select campo"  name="canton" required></select>

                                         

                                        </div>


                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Dirección
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control campo"
                                                name="direccion"
                                                required>

                                        </div>

                                    </div>


                                    <div class="d-flex justify-content-between">

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btnAnterior">

                                            ← Anterior

                                        </button>


                                        <button
                                            type="button"
                                            class="btn btn-primary btnContinuar"
                                            data-step="3">

                                            Continuar →

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 4. CARGO -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="4"
                            style="display:none;">

                            <div class="card border">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <strong>
                                         KLUANE EC | Ofertas de trabajo disponibles
                                    </strong>

                                    <span
                                        id="estadoPaso4"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">

                                        <form id="formPostulacion" enctype="multipart/form-data">

                                            <label class="form-label mt-3 mb-3">
                                                Cargo al que desea postularse
                                            </label>

                                            <select 
                                                id="cbx_cargo"
                                                class="form-select campo mt-3 mb-3"
                                                name="cargo"
                                                required>
                                            </select>


                                            <label class="form-label mt-3 mb-3">
                                                Currículum Vitae (PDF, máximo 2MB)
                                            </label>

                                            <input 
                                                type="file"
                                                class="form-control campo"
                                                name="cv"
                                                accept=".pdf"
                                                required>

                                        </form>


                                





                             

                                    <div class="d-flex justify-content-between mt-4">

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btnAnterior">

                                            ← Anterior

                                        </button>


                                        <button
                                            type="button"
                                            class="btn btn-primary btnContinuar"
                                            data-step="4">

                                            Continuar →

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 5. EXPERIENCIA -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="5"
                            style="display:none;">

                            <div class="card border">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <strong>
                                     Experiencia Laboral
                                    </strong>

                                    <span
                                        id="estadoPaso5"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">

                                 <div class="row">

                                    <div class="mb-3 col-md-8">

                                        <label class="form-label">
                                            Ultima experiencia laboral
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control campo"
                                            name="cargo_Experiencia"
                                            required>

                                    </div>


                                    <div class="mb-3 col-md-4">

                                        <label class="form-label">
                                           Tiempo de experiencia 
                                        </label>

                                        
                                       <select id="cbx_t_expereiencia"   class="form-select campo"  name="tiempo_Experiencia" required></select>

                                    </div>

                                        <div class="mb-3 col-md-12">

                                        <label class="form-label">
                                         Empresa Experiencia 
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control campo"
                                            name="empresa_Experiencia"
                                            required>

                                    </div>


                                         <div class="mb-3 col-md-12">

                                        <label class="form-label">
                                         Descripción de funciones desempeñadas maximo 500 caracteres. 
                                        </label>

                                        <textarea
                                            class="form-control campo"
                                            name="descripcion_Experiencia"
                                            rows="4"
                                            maxlength="500"
                                            required></textarea>

                                    

                                    </div>


                                   </div>
                             


                                    <div class="d-flex justify-content-between">

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btnAnterior">

                                            ← Anterior

                                        </button>


                                        <button
                                            type="button"
                                            class="btn btn-primary btnContinuar"
                                            data-step="5">

                                            Continuar →

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 6. EDUCACIÓN -->
                        <!-- ========================================== -->

                        <div
                            class="seccion mb-3"
                            data-step="6"
                            style="display:none;">

                            <div class="card border">

                                <div
                                    class="card-header bg-white d-flex justify-content-between align-items-center">

                                    <strong>
                                      Educación
                                    </strong>

                                    <span
                                        id="estadoPaso6"
                                        class="badge bg-secondary">

                                        Pendiente

                                    </span>

                                </div>


                                <div class="card-body">
                                
                                 <div class="row">


                                   <div class="mb-3 col-md-12">

                                         <label class="form-label">
                                                  Intruccion Academica
                                          </label>

                                            <select id="cbx_nivel"   class="form-select campo"  name="nivel" required></select>



                                             
                                            </div>

                                            <div class="mb-3 col-md-8">

                                                <label class="form-label">
                                                  Institucion Educativa
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control campo"
                                                    name="institucion_Educativa"
                                                    required>

                                            </div>


                                            <div class="mb-3 col-md-4">

                                                <label class="form-label">
                                                Año de Graduacion
                                                </label>

                                                <input
                                                    type="number"
                                                    class="form-control campo"
                                                    name="a_Graduacion"
                                                    required>

                                            </div>


                                    </div>


                                    <div class="d-flex justify-content-between mt-4">

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btnAnterior">

                                            ← Anterior

                                        </button>


                                        <button
                                            type="button"
                                            class="btn btn-success btnFinalizar"
                                            data-step="6">

                                            Finalizar ✓

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================== -->
                        <!-- 7. RESUMEN -->
                        <!-- ========================================== -->

                        <div
                            class="seccion"
                            data-step="7"
                            style="display:none;">

                            <div class="alert alert-success">

                                <strong>
                                 ¡Formulario completado!
                                </strong>

                                <br>

                                Revise la información antes de enviar su postulación.

                            </div>


                            <div id="resumenPostulacion">
                            </div>


                            <div class="form-check mt-4">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="confirmarDatos">

                                <label
                                    class="form-check-label"
                                    for="confirmarDatos">

                                    Confirmo que la información ingresada
                                    es correcta.

                                </label>

                            </div>


                            <div class="d-flex justify-content-between mt-4">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary btnAnterior">

                                    ← Modificar datos

                                </button>


                                <button
                                    type="button"
                                    id="btnEnviar"
                                    class="btn btn-success"
                                    disabled>

                                    Enviar postulación ✓

                                </button>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="../js/job_post.js"></script>


</body>
</html>