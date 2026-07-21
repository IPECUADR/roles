<div class="container main-content">

    <!-- Hero -->

    <div class="vacaciones-header mb-5">

        <div>

            <span class="badge bg-light text-primary mb-3">
              <i class="bi bi-bookmark-check-fill"></i> Informativo
            </span>

            <h2>
                <i class="fas fa-umbrella-beach me-2"></i>
                Reglamento Interno
            </h2>

        

        </div>

    </div>




      
<div class="container py-3 text-dark">

    <div class="card shadow border-0 rounded-4">

        <!-- Encabezado -->
        <div class="card-header bg-dark bg-gradient text-white rounded-top-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                

                    <small class="text-white-50">
                        Documento PDF cargado desde una URL
                    </small>

                </div>

                <span class="badge bg-light text-danger fs-6">
                    <i class="bi bi-filetype-pdf"></i> PDF
                </span>

            </div>

        </div>

        <!-- Cuerpo -->
        <div class="card-body p-2 bg-light">

            <iframe
                id="visor_pdf"
                src="https://kluane.itdospuntocero.net/QR-TH/DOC/REGLAMENTO_KLUANE_DRILLING.pdf"
                width="100%"
                height="750"
                style="
                    border:none;
                    border-radius:12px;
                    background:#fff;
                ">
            </iframe>

        </div>

        <!-- Pie -->
        <div class="card-footer bg-white">

            <div class="d-flex justify-content-end">

                <a id="descargar_pdf"
                   href="https://kluane.itdospuntocero.net/QR-TH/DOC/REGLAMENTO_KLUANE_DRILLING.pdf"
                   target="_blank"
                   class="btn btn-danger">

                    <i class="bi bi-download"></i>
                    Descargar PDF

                </a>

            </div>

        </div>

    </div>

</div>



       




   

</div>

<style>

body{

background:#f4f7fb;

}

.vacaciones-header{
    background: linear-gradient(135deg,#0f172a,#1e3a8a);

    margin-top: 20px;

    padding: 20px;

    border-radius: 25px;

    color: white;

    box-shadow: 0 15px 40px rgba(0,0,0,.18);
}

.vac-card{

background:white;

border-radius:20px;

padding:30px;

box-shadow:0 15px 30px rgba(0,0,0,.08);

transition:.35s;

}

.vac-card:hover{

transform:translateY(-8px);

box-shadow:0 20px 45px rgba(0,0,0,.15);

}

.vac-card h2{

font-size:42px;

font-weight:700;

color:#0d6efd;

}

.vac-card h4{

font-weight:700;

}

.vac-card small{

color:#6c757d;

text-transform:uppercase;

}

.acciones{

background:white;

padding:30px;

border-radius:20px;

box-shadow:0 15px 30px rgba(0,0,0,.08);

}

.btn{

border-radius:12px;

padding:14px;

font-weight:600;

}



.estado{

    display:inline-flex;
    align-items:center;

    padding:6px 14px;

    border-radius:30px;

    font-size:.82rem;

    font-weight:600;

}

.estado i{

    font-size:8px;

}

.estado-finalizado{

    background:#fde8ea;
    color:#c62828;

}

.estado-vigente{

    background:#e7f8ec;
    color:#198754;

}
</style>