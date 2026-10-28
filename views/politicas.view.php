
<div class="container main-content">

    <!-- BANNER -->
    <div class="politicas-header mb-4">
        <div class="politicas-header-contenido">

            <span class="badge bg-light text-primary mb-3">
                <i class="bi bi-shield-check me-1"></i>
                GESTIÓN HUMANA
            </span>

            <h2>
                <i class="bi bi-journal-bookmark-fill me-2"></i>
                Políticas Kluane Drilling
            </h2>

            <p class="mb-3">
                La información correcta, en el momento oportuno.
            </p>

            <small>
                Consulta nuestras políticas, conoce los lineamientos internos
                y comparte la información a tiempo. El compromiso de todos
                fortalece nuestra cultura organizacional.
            </small>

        </div>

        <div class="politicas-header-icono">
            <i class="bi bi-journals"></i>
        </div>
    </div>


    <!-- BIBLIOTECA -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3 mb-4">

                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-collection-fill text-primary me-2"></i>
                        Biblioteca documental
                    </h5>

                    <small class="text-muted">
                        Selecciona un documento para visualizar su contenido.
                    </small>
                </div>

                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    Documentos PDF
                </span>

            </div>


            <!-- DOCUMENTOS -->
            <div class="row g-3" id="biblioteca_politicas">

          

            




              

            </div>

        </div>

    </div>


    <!-- VISOR PDF -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-white p-3 p-md-4">

            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="visor-icono">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1" id="titulo_pdf">
                            Reglamento Interno
                        </h5>

                        <small class="text-muted">
                            <i class="bi bi-eye me-1"></i>
                            Visor de documentos institucionales
                        </small>
                    </div>

                </div>

                <a id="descargar_pdf"
                   href="https://kluane.itdospuntocero.net/QR-TH/DOC/REGLAMENTO_KLUANE_DRILLING.pdf"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-danger">

                    <i class="bi bi-download me-1"></i>
                    Abrir / Descargar PDF

                </a>

            </div>

        </div>


        <div class="card-body p-2 bg-light">

            <iframe
                id="visor_pdf"
                src="https://drive.google.com/file/d/1eWKk2_TC8uDpJjwTDQ1HTR72wBIVnyKd/preview"
                title="Visor de políticas Kluane Drilling"
                width="100%"
                height="750"
                style="border:0; border-radius:12px; background:#fff;">
            </iframe>

        </div>

        <div class="card-footer bg-white text-muted small py-3">
            <i class="bi bi-info-circle me-1"></i>
            Gestión Humana · Consulta la versión publicada de cada documento.
        </div>

    </div>

</div>


<style>
/* FONDO Y BANNER */

.main-content {
    padding-bottom: 35px;
}

.politicas-header {
    margin-top: 20px;
    padding: 30px;
    border-radius: 22px;
    color: #fff;
    background: linear-gradient(120deg, #0f172a, #1e3a8a);
    box-shadow: 0 12px 30px rgba(15, 23, 42, .15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    overflow: hidden;
    position: relative;
}

.politicas-header h2 {
    font-weight: 750;
    font-size: clamp(1.5rem, 3vw, 2.1rem);
    margin-bottom: 12px;
}

.politicas-header p {
    font-size: 1.05rem;
    font-weight: 600;
}

.politicas-header small {
    color: #dbeafe;
    display: block;
    max-width: 680px;
    line-height: 1.7;
}

.politicas-header-icono {
    font-size: 95px;
    color: rgba(255, 255, 255, .13);
    padding: 0 15px;
}


/* HOJAS DE LA BIBLIOTECA */

.politica-documento {
    width: 100%;
    height: 100%;
    min-height: 230px;
    padding: 16px 12px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 9px;
    transition: .2s ease;
    cursor: pointer;
}

.politica-documento:hover {
    border-color: #93c5fd;
    box-shadow: 0 8px 22px rgba(37, 99, 235, .10);
    transform: translateY(-4px);
}

.politica-documento.activo {
    border: 2px solid #2563eb;
    background: #f8fbff;
    box-shadow: 0 5px 18px rgba(37, 99, 235, .10);
}

.documento-hoja {
    width: 105px;
    height: 125px;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    border-radius: 7px;
    position: relative;
    padding: 15px 12px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    box-shadow: 3px 4px 0 #e2e8f0;
    overflow: hidden;
}

.documento-hoja > i {
    font-size: 34px;
    color: #dc2626;
    margin-bottom: 5px;
}

.documento-esquina {
    position: absolute;
    top: 0;
    right: 0;
    width: 22px;
    height: 22px;
    background: linear-gradient(225deg, #e2e8f0 50%, #fff 50%);
}

.documento-tipo {
    font-size: 9px;
    font-weight: 800;
    color: #b91c1c;
    letter-spacing: 1px;
}

.documento-lineas {
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 100%;
    margin-top: 7px;
}

.documento-lineas span {
    height: 3px;
    background: #fecaca;
    border-radius: 5px;
    width: 100%;
}

.documento-lineas span:nth-child(2) {
    width: 75%;
}

.documento-lineas span:nth-child(3) {
    width: 88%;
}

.documento-azul {
    background: #eff6ff;
    border-color: #bfdbfe;
}

.documento-azul > i {
    color: #2563eb;
}

.documento-azul .documento-tipo {
    color: #1d4ed8;
}

.documento-azul .documento-lineas span {
    background: #bfdbfe;
}

.documento-verde {
    background: #ecfdf5;
    border-color: #a7f3d0;
}

.documento-verde > i {
    color: #059669;
}

.documento-verde .documento-tipo {
    color: #047857;
}

.documento-verde .documento-lineas span {
    background: #a7f3d0;
}

.documento-morado {
    background: #f5f3ff;
    border-color: #ddd6fe;
}

.documento-morado > i {
    color: #7c3aed;
}

.documento-morado .documento-tipo {
    color: #6d28d9;
}

.documento-morado .documento-lineas span {
    background: #ddd6fe;
}

.documento-titulo {
    color: #1e293b;
    font-weight: 700;
    font-size: .93rem;
    line-height: 1.35;
}

.documento-descripcion {
    color: #64748b;
    font-size: .77rem;
    line-height: 1.45;
}


/* VISOR */

.visor-icono {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: #fee2e2;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

#visor_pdf {
    display: block;
}


/* RESPONSIVE */

@media (max-width: 576px) {

    .politicas-header {
        padding: 22px;
        border-radius: 17px;
    }

    .politicas-header-icono {
        display: none;
    }

    .politica-documento {
        min-height: 215px;
        padding: 12px 8px;
    }

    .documento-hoja {
        width: 90px;
        height: 112px;
    }

    #visor_pdf {
        height: 550px;
    }

    #descargar_pdf {
        width: 100%;
    }
}
</style>


