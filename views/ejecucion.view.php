
<style>

/* =========================================
   VALORACIÓN DEL DESEMPEÑO - KDE 2026
========================================= */

.main-content {
    padding-top: 25px;
    padding-bottom: 35px;
}

/* Encabezado principal */
.vacaciones-header {
    position: relative;
    overflow: hidden;
    padding: 35px;
    border-radius: 18px;
    background: linear-gradient(120deg, #102a43 0%, #174a78 60%, #2369a1 100%);
    color: #fff;
    box-shadow: 0 8px 25px rgba(16, 42, 67, 0.14);
}

/* Detalle decorativo */
.vacaciones-header::after {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    right: -75px;
    top: -110px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    pointer-events: none;
}

.vacaciones-header::before {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    right: 100px;
    bottom: -125px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.04);
    pointer-events: none;
}

.vacaciones-header > div {
    position: relative;
    z-index: 1;
}

/* Título */
.vacaciones-header h2 {
    font-size: clamp(1.65rem, 3vw, 2.25rem);
    font-weight: 750;
    letter-spacing: -0.6px;
    line-height: 1.3;
    color: #fff;
}

/* Descripción */
.vacaciones-header p {
    max-width: 780px;
    font-size: 0.98rem;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.84);
}

/* Etiqueta superior */
.vacaciones-header .badge {
    border-radius: 7px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.6px;
}

/* Indicadores del encabezado */
.vacaciones-header .d-flex.flex-wrap {
    row-gap: 10px;
}

.vacaciones-header .d-flex.flex-wrap span {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.07);
    color: rgba(255, 255, 255, 0.94);
}

.vacaciones-header .d-flex.flex-wrap i {
    color: #8ed8ff;
    font-size: 1rem;
}

/* Círculo del icono principal */
.vacaciones-header .rounded-circle {
    border: 5px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12) !important;
    transition: transform 0.25s ease;
}

.vacaciones-header .rounded-circle:hover {
    transform: translateY(-4px);
}

.vacaciones-header .mt-2 {
    color: #fff;
}

.vacaciones-header .small {
    color: rgba(255, 255, 255, 0.72);
}

/* Títulos de sección */
.main-content > .d-flex h5 {
    color: #193b59;
    font-size: 1.08rem;
    letter-spacing: -0.2px;
}

.main-content > .d-flex p {
    font-size: 0.86rem;
    line-height: 1.6;
}

/* Separación visual de secciones */
#sec_procesos,
#secc_per_vac {
    align-items: stretch;
}

/* Tarjetas cargadas dinámicamente */
#sec_procesos > [class*="col-"] > .card,
#secc_per_vac > [class*="col-"] > .card {
    height: 100%;
    border: 1px solid #e8edf3;
    border-radius: 13px;
    box-shadow: 0 3px 12px rgba(31, 55, 80, 0.05);
    transition: transform 0.22s ease,
                box-shadow 0.22s ease,
                border-color 0.22s ease;
}

#sec_procesos > [class*="col-"] > .card:hover,
#secc_per_vac > [class*="col-"] > .card:hover {
    transform: translateY(-4px);
    border-color: #c7dced;
    box-shadow: 0 10px 24px rgba(31, 55, 80, 0.10);
}

/* Contenido de las tarjetas */
#sec_procesos .card-body,
#secc_per_vac .card-body {
    padding: 22px;
}

#sec_procesos .card-title,
#secc_per_vac .card-title {
    color: #193b59;
    font-weight: 700;
}

/* Botones dentro de las tarjetas */
#sec_procesos .btn,
#secc_per_vac .btn {
    border-radius: 7px;
    font-weight: 600;
    transition: all 0.2s ease;
}

/* Diseño adaptable a móviles */
@media (max-width: 767.98px) {
    .main-content {
        padding-top: 15px;
    }

    .vacaciones-header {
        padding: 25px 20px;
        border-radius: 13px;
    }

    .vacaciones-header h2 {
        font-size: 1.65rem;
    }

    .vacaciones-header p {
        font-size: 0.91rem;
    }

    .vacaciones-header .d-flex.flex-wrap span {
        padding: 7px 9px;
        font-size: 0.78rem;
    }

    .vacaciones-header .rounded-circle {
        width: 90px !important;
        height: 90px !important;
    }

    .vacaciones-header .rounded-circle i {
        font-size: 2.7rem !important;
    }

    .main-content > .d-flex h5 {
        font-size: 1rem;
    }
}

/* Respeta la preferencia de movimiento del usuario */
@media (prefers-reduced-motion: reduce) {
    #sec_procesos .card,
    #secc_per_vac .card,
    .vacaciones-header .rounded-circle {
        transition: none;
    }
}



/* CONTENEDOR */
.main-content {
    padding-top: 18px;
    padding-bottom: 30px;
}

/* ENCABEZADO */
.vacaciones-header {
    position: relative;
    overflow: hidden;
    padding: 25px 28px;
    border-radius: 14px;
    background: linear-gradient(120deg, #102a43, #174a78 65%, #2369a1);
    color: #fff;
    box-shadow: 0 5px 18px rgba(16, 42, 67, .12);
}

.vacaciones-header h2 {
    font-size: 1.55rem;
    font-weight: 700;
    letter-spacing: -.3px;
    margin-bottom: 10px;
}

.vacaciones-header p {
    max-width: 700px;
    font-size: .88rem;
    line-height: 1.65;
    color: rgba(255,255,255,.83);
}

.vacaciones-header .badge {
    font-size: .67rem;
    letter-spacing: .4px;
    border-radius: 6px;
}

.vacaciones-header .d-flex.flex-wrap span {
    display: inline-flex;
    align-items: center;
    padding: 6px 9px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 6px;
    background: rgba(255,255,255,.07);
    color: #fff;
    font-size: .75rem;
}

.vacaciones-header .d-flex.flex-wrap i {
    color: #8ed8ff;
}

.vacaciones-header .rounded-circle {
    width: 76px !important;
    height: 76px !important;
    border: 3px solid rgba(255,255,255,.15);
}

.vacaciones-header .rounded-circle i {
    font-size: 2.1rem !important;
}

.vacaciones-header .mt-2 {
    font-size: .83rem;
}

.vacaciones-header .small {
    font-size: .75rem;
    color: rgba(255,255,255,.75);
}

/* TÍTULOS DE SECCIÓN */
.titulo-seccion {
    color: #193b59;
    font-size: 1rem;
    font-weight: 700;
}

.main-content > div p.text-muted {
    font-size: .81rem;
}

/* TARJETAS DE EVALUACIÓN */
.card-evaluacion {
    display: block;
    padding: 19px;
    border: 1px solid #e2eaf2;
    border-radius: 12px;
    background: #fff;
    color: #193b59;
    box-shadow: 0 3px 12px rgba(31,55,80,.045);
    cursor: pointer;
    transition: border-color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
}

.card-evaluacion h6 {
    font-size: .95rem;
    font-weight: 700;
    color: #193b59;
}

.card-evaluacion p {
    font-size: .79rem;
    line-height: 1.5;
    color: #6c7a89;
}

.card-evaluacion:hover {
    border-color: #9fc5e4;
    box-shadow: 0 7px 20px rgba(31,55,80,.09);
    background: #bed4f0;
    color: white;
    transform: translateY(-2px);


}

.card-evaluacion:focus-visible {
    outline: 3px solid rgba(35,105,161,.25);
    outline-offset: 3px;
}

.evaluacion-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 52px;
    height: 52px;
    border-radius: 11px;
    font-size: 1.45rem;
}

.icono-pares {
    background: #eaf3fc;
    color: #2369a1;
}

.icono-auto {
    background: #e9f7ef;
    color: #23834d;
}

.flecha-evaluacion {
    color: #9aabba;
    font-size: 1.25rem;
    transition: transform .2s ease, color .2s ease;
}

.card-evaluacion:hover .flecha-evaluacion {
    color: #2369a1;
    transform: translateX(3px);
}

/* INDICACIONES */
.tarjeta-informacion,
.tarjeta-excel {
    border: 1px solid #e5ebf1;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(31,55,80,.045);
}

.tarjeta-informacion h6,
.tarjeta-excel h6 {
    color: #193b59;
    font-size: .92rem;
}

.lista-indicaciones {
    list-style: none;
    padding-left: 0;
}

.lista-indicaciones li {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 12px;
    color: #526273;
    font-size: .82rem;
    line-height: 1.5;
}

.lista-indicaciones li:last-child {
    margin-bottom: 0;
}

.lista-indicaciones i {
    color: #29945a;
    margin-top: 2px;
}

/* EXCEL */
.excel-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 47px;
    height: 47px;
    flex-shrink: 0;
    border-radius: 10px;
    background: #e7f5eb;
    color: #218449;
    font-size: 1.6rem;
}

.tarjeta-excel .btn {
    padding: 9px 12px;
    font-size: .8rem;
    font-weight: 600;
    border-radius: 7px;
}

/* TARJETAS AJAX EXISTENTES */
#sec_procesos > [class*="col-"] > .card,
#secc_per_vac > [class*="col-"] > .card {
    height: 100%;
    border: 1px solid #e5ebf1;
    border-radius: 11px;
    box-shadow: 0 3px 12px rgba(31,55,80,.045);
    transition: box-shadow .2s ease, transform .2s ease;
}

#sec_procesos > [class*="col-"] > .card:hover,
#secc_per_vac > [class*="col-"] > .card:hover {
    box-shadow: 0 7px 18px rgba(31,55,80,.09);
    transform: translateY(-2px);
}

#sec_procesos .card-body,
#secc_per_vac .card-body {
    padding: 18px;
}

#sec_procesos .card-title,
#secc_per_vac .card-title {
    color: #193b59;
    font-size: .92rem;
    font-weight: 700;
}

/* MÓVILES */
@media (max-width: 767.98px) {
    .vacaciones-header {
        padding: 21px 18px;
    }

    .vacaciones-header h2 {
        font-size: 1.3rem;
    }

    .vacaciones-header p {
        font-size: .82rem;
    }

    .card-evaluacion {
        padding: 15px;
    }

    .evaluacion-icono {
        width: 44px;
        height: 44px;
        font-size: 1.2rem;
    }
}

/* ACCESIBILIDAD */
@media (prefers-reduced-motion: reduce) {
    .card-evaluacion,
    .flecha-evaluacion,
    #sec_procesos .card,
    #secc_per_vac .card {
        transition: none;
    }
}

.indicadores{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
}

.indicadores span{
    display:flex;
    align-items:center;
    gap:8px;
    padding:8px 14px;
    border-radius:12px;
    font-size:.85rem;
    font-weight:600;
    transition:.3s ease;
    cursor:pointer;
    border:1px solid rgba(0,0,0,.08);
}

.indicadores span i{
    font-size:1rem;
}

.item-kpi{
    background:#eef6ff;
    color:#0d6efd;
}

.item-hse{
    background:#ecfdf3;
    color:#198754;
}

.item-comp{
    background:#fff4e5;
    color:#fd7e14;
}

.indicadores span:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(0,0,0,.12);
}


/* CONTENEDOR PRINCIPAL */
.main-content {
    padding-top: 20px;
    padding-bottom: 30px;
}

/* ENCABEZADOS DE SECCIÓN */
.titulo-seccion {
    color: #25364b;
    font-weight: 700;
    font-size: 17px;
}

/* TARJETAS DE RESULTADOS */
.card-resultados {
    border: 1px solid #e5e9f0;
    border-radius: 12px;
    background: #fff;
    transition: all .25s ease;
}

.card-resultados:hover {
    border-color: #b8c9df;
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
}

.card-resultados .card-body {
    padding: 25px;
}

.resultado-icono {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #edf3fa;
    color: #244b78;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
    margin-bottom: 18px;
}

.card-resultados h5 {
    color: #202b3c;
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 9px;
}

.card-resultados p {
    color: #778294;
    font-size: 13px;
    line-height: 1.6;
    margin-bottom: 22px;
}

/* BOTONES RESULTADOS */
.btn-ver-resultados {
    background: #1d3557;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 10px 17px;
    font-size: 13px;
    font-weight: 600;
    transition: all .2s ease;
}

.btn-ver-resultados:hover {
    background: #294c78;
    color: #fff;
}

/* REPORTE */
.card-reporte {
    border-radius: 12px;
    overflow: hidden;
}

.card-reporte .card-header {
    border-bottom: 1px solid #edf0f4 !important;
}

/* EXCEL */
.btn-excel {
    background: #198754;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 600;
    transition: .2s ease;
}

.btn-excel:hover {
    background: #146c43;
    color: #fff;
}

/* TABLA */
.tabla-resultados {
    font-size: 13px;
    margin-bottom: 0;
}

.tabla-resultados thead th {
    background: #f5f7fa;
    color: #536174;
    font-weight: 700;
    font-size: 12px;
    padding: 14px 12px;
    border-bottom: 1px solid #e5e9f0;
    white-space: nowrap;
}

.tabla-resultados tbody td {
    padding: 14px 12px;
    color: #465366;
    border-bottom: 1px solid #edf0f4;
}

.tabla-resultados tbody tr:last-child td {
    border-bottom: none;
}

/* INDICADORES */
.valor-indicador {
    font-weight: 600;
    color: #475569;
}

.valor-total {
    display: inline-block;
    background: #edf3fa;
    color: #1d3557;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 6px;
    min-width: 65px;
}

/* OPCIONES */
.tabla-resultados .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 6px;
}

/* RESPONSIVE */
@media (max-width: 768px) {

    .main-content {
        padding-left: 12px;
        padding-right: 12px;
    }

    .card-resultados .card-body {
        padding: 20px;
    }

    .card-reporte .card-header {
        padding: 20px !important;
    }

}


.resultados-dashboard {
    padding: 10px 0;
}

.resultados-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 22px 25px;
    margin-bottom: 22px;
    background: #fff;
    border: 1px solid #e9edf2;
    border-left: 5px solid #17365d;
    border-radius: 10px;
}

.resultados-empresa {
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
}

.resultados-header h4 {
    color: #17365d;
    font-weight: 800;
    margin: 5px 0;
    letter-spacing: .4px;
}

.resultados-header p {
    color: #8491a3;
    font-size: 13px;
    margin: 0;
}

.resultados-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #edf3f9;
    color: #17365d;
    border-radius: 10px;
    font-size: 23px;
}

.resultado-card {
    background: #fff;
    border: 1px solid #e9edf2;
    border-radius: 10px;
    padding: 18px;
    height: 100%;
    box-shadow: 0 2px 8px rgba(15, 35, 60, .04);
}

.resultado-card .resultado-titulo {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.resultado-card .resultado-valor {
    display: block;
    color: #172b4d;
    font-size: 27px;
    font-weight: 800;
    margin: 10px 0 12px;
}

.resultado-card .resultado-escala {
    color: #94a3b8;
    font-size: 11px;
}

.resultado-card .progress {
    height: 7px;
    background: #edf1f5;
    border-radius: 20px;
    overflow: hidden;
}

.resultado-card .progress-bar {
    border-radius: 20px;
}

.resultado-chart-card {
    border: 1px solid #e9edf2;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(15, 35, 60, .04);
}

.grafica-triangular {
    position: relative;
    width: 100%;
    height: 330px;
}

.resultado-final {
    border-top: 1px solid #edf0f4;
    margin-top: 15px;
    padding-top: 18px;
    text-align: center;
}

.resultado-final span,
.resultado-final small {
    display: block;
    color: #8491a3;
    font-size: 11px;
    letter-spacing: .7px;
}

.resultado-final strong {
    display: block;
    color: #17365d;
    font-size: 34px;
    font-weight: 800;
    margin: 5px 0;
}

@media (max-width: 576px) {
    .resultados-header {
        padding: 17px;
    }

    .resultados-header h4 {
        font-size: 17px;
    }

    .grafica-triangular {
        height: 280px;
    }
}


.percepcion-card {
    height: 100%;
    padding: 18px;
    background: #fff;
    border: 1px solid #e9edf2;
    border-radius: 10px;
    transition: .2s ease;
}

.percepcion-card:hover {
    box-shadow: 0 4px 14px rgba(15, 35, 60, .07);
}

.percepcion-titulo {
    color: #17365d;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: .5px;
    margin-bottom: 16px;
}

.percepcion-item {
    margin-bottom: 15px;
}

.percepcion-item:last-child {
    margin-bottom: 0;
}

.percepcion-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-size: 12px;
    color: #64748b;
}

.percepcion-valor {
    color: #172b4d;
    font-weight: 800;
    font-size: 14px;
}

.percepcion-progress {
    height: 6px;
    background: #edf1f5;
    border-radius: 20px;
    overflow: hidden;
}

.percepcion-progress-bar {
    height: 100%;
    border-radius: 20px;
}

.percepcion-auto {
    background: #24476B;
}

.percepcion-jefe {
    background: #198754;
}

.percepcion-pares {
    background: #D6A84F;
}

.percepcion-brecha {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #edf0f4;
    margin-top: 16px;
    padding-top: 12px;
    font-size: 11px;
    color: #8491a3;
}

.percepcion-brecha strong {
    color: #17365d;
    font-size: 13px;
}

.percepcion-sin-datos {
    color: #adb5bd;
    font-size: 12px;
    font-style: italic;
}

</style>



<div class="container main-content">

    <!-- ENCABEZADO -->
    <div class="vacaciones-header mb-4">

        <div class="row align-items-center g-3">

            <div class="col-lg-9">

                <h2>
                    <i class="bi bi-award"></i>
                    Ejecución de valoración de desempeño
                </h2>

                <p class="mb-3">
                    Participa en el proceso de evaluación del desempeño,
                    valida las valoraciones registradas y contribuye
                    a la mejora continua del equipo.
                </p>

                <div class="indicadores">

                    <span class="item-kpi">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        KPI
                    </span>

                    <span class="item-hse">
                        <i class="bi bi-shield-check"></i>
                        HSE
                    </span>

                    <span class="item-comp">
                        <i class="bi bi-graph-up-arrow"></i>
                        COMPETENCIAS
                    </span>

                </div>

            </div>

            <div class="col-lg-3 text-lg-end text-center">

                <div class="d-inline-flex align-items-center justify-content-center
                            rounded-circle bg-light text-primary"
                     style="width: 85px; height: 85px;">

                    <i class="bi bi-clipboard2-data-fill"
                       style="font-size: 2.5rem;"></i>

                </div>

                <div class="mt-2 fw-semibold">
                    Ciclo de evaluación
                </div>

                <span class="small">Periodo 2026</span>

            </div>

        </div>

    </div>


    <!-- RESULTADOS DE EVALUACIÓN -->
    <div class="mb-4">

        <h5 class="titulo-seccion mb-1">
            <i class="bi bi-ui-checks-grid me-2"></i>
            Resultados de evaluación
        </h5>

        <p class="text-muted small mb-3">
            Consulta los resultados del proceso de evaluación del desempeño,
            incluyendo indicadores clave y métricas de valoración.
        </p>

        <div class="row g-3">

            <!-- EVALUACIÓN 180° -->
            <div class="col-md-6">

                <div class="card card-resultados h-100">

                    <div class="card-body">

                        <div class="resultado-icono">
                            <i class="bi bi-people"></i>
                        </div>

                        <h5>Evaluación 180°</h5>

                        <p>
                            Consulta los resultados de la autoevaluación
                            y evaluación de jefatura.
                        </p>

                        <button type="button"
                                id="btn_resultado_180"
                                class="btn btn-ver-resultados">

                            Ver resultados
                            <i class="bi bi-arrow-right ms-2"></i>

                        </button>

                    </div>

                </div>

            </div>


            <!-- EVALUACIÓN 90° -->
            <div class="col-md-6">

                <div class="card card-resultados h-100">

                    <div class="card-body">

                        <div class="resultado-icono">
                            <i class="bi bi-person-check"></i>
                        </div>

                        <h5>Evaluación 90°</h5>

                        <p>
                            Consulta los resultados de la evaluación
                            realizada por jefatura.
                        </p>

                        <button type="button"
                                id="btn_resultado_90"
                                class="btn btn-ver-resultados">

                            Ver resultados
                            <i class="bi bi-arrow-right ms-2"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>


<div class="row g-3 mb-2 mt-2" id ="graficas_resultados">



</div>




<div class="card border-0 shadow-sm mb-4" id="percepcion_organizacional">

</div>




    <!-- REPORTE GENERAL -->
    <div class="card shadow-sm border-0 card-reporte mb-4 mt-4">

        <!-- HEADER -->
        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3">


                <button type="button"
                        id="btn_descargar_excel_de_califiaciones"
                        class="btn btn-excel">

                    <i class="bi bi-file-earmark-excel me-2"></i>
                    Descargar Excel

                </button>

                
                <button type="button"
                        id="btn_pdf_informe_resultados"
                        class="btn btn-danger text-white">

                     <i class="bi bi-file-earmark-pdf"></i>
                    Descargar Informe

                </button>

            </div>

        </div>


        <!-- BODY -->
        <div class="card-body pt-0" mt-2 mb-4>

       


            <!-- TABLA -->
            <div class="table-responsive">

            <div class="d-flex justify-content-end mb-3 mt-2">
                <div class="input-group" style="max-width: 350px;">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="buscar_resultado" 
                        placeholder="Buscar colaborador..."
                    >
                    <button class="btn btn-outline-secondary" type="button" id="limpiar_busqueda">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

                <table class="table table-hover align-middle tabla-resultados">

                    <thead>

                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cargo</th>
                            <th class="text-center">KPI</th>
                            <th class="text-center">HSE</th>
                            <th class="text-center">Competencias</th>
                            <th class="text-center">Total valoración</th>
                            <th class="text-center">Opciones</th>
                        </tr>

                    </thead>

                    <tbody id="tabla_resultados">

                  

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- VERIFICACIÓN DEL PROCESO -->
    <div class="mb-4 mt-4">

        <h5 class="titulo-seccion mb-1">
            <i class="bi bi-ui-checks-grid me-2"></i>
            Verificación | Proceso de evaluación
        </h5>

        <p class="text-muted small mb-3">
            Selecciona el tipo de evaluación que deseas realizar.
        </p>

        <div class="row g-3" id="seccion_evaluaciones">

        </div>

    </div>


</div>










<!-- Modal -->
<div class="modal fade modal-xl" id="modal_evaluar_clbr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-danger" id="titulo_modal">
        
      </div>
      <div class="modal-body" id="modal_body">
        
      </div>
      <div class="modal-footer" id="modal_footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



