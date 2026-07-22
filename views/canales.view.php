
<div class="container main-content">

    <div class="landing-denuncias">

        <!-- HERO -->

    <div class="hero-denuncia" id="heroDenuncia">

                <div class="hero-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <h2>Canal de Denuncias</h2>

                <p>
                    Reporta de forma confidencial cualquier situación que contravenga las políticas,
                    normas o principios éticos de la organización.
                </p>

            </div>

        <!-- TIPOS DE DENUNCIA -->

        <div class="row g-4 mt-3" id="cardsDenuncias">

            <!-- SOBORNO -->

            <div class="col-lg-4">

                <div class="tipo-card">

                    <div class="icon bg-danger">
                        <i class="bi bi-person-exclamation"></i>
                    </div>

                    <h4 class="text-dark">ACOSO, DISCRIMINACIÓN Y CUALQUIER FORMA DE VIOLENCIA </h4>

                    <p class="text-justify text-corporativo">
                        Toda conducta hostil en los lugares de trabajo, independientemente de que la persona que comete el acoso y la persona que lo sufre sean del mismo sexo, del sexo opuesto, de niveles jerárquicos diferentes y de capacidades distintas. 
                    </p>

                    <button
                        class="btn btn-outline-danger abrirFormulario"
                        data-titulo="ACOSO, DISCRIMINACIÓN Y CUALQUIER FORMA DE VIOLENCIA"
                        data-url="https://forms.office.com/pages/responsepage.aspx?id=X9mXjHSk_0meXjnl1GPcVOxSWp0ZSbBNqi2hWtWplPtUREU0V0k4QlZQUkREUFozOFVCT0VKSldITy4u&origin=QRCode&qrcodeorigin=presentation&route=shorturl">

                        Denunciar

                    </button>

                </div>

            </div>

            <!-- ACOSO -->

            <div class="col-lg-4">

                <div class="tipo-card">

                    <div class="icon bg-warning">
                    <i class="bi bi-people-fill"></i>
                    </div>

                    <h4 class="text-dark">CONFLICTO DE INTERESES</h4>

                      <p class="text-justify text-corporativo">
                       
                      Cualquier situación potencial, real o aparente de ser o generar un conflicto de interés.  

                       
                    </p>

                    <button
                        class="btn btn-outline-warning abrirFormulario"
                        data-titulo="CONFLICTO DE INTERESES"
                        data-url="https://forms.office.com/pages/responsepage.aspx?id=X9mXjHSk_0meXjnl1GPcVLZBkbYalLFIgiQY2-qJSLVUMEVSN1Q2RU1QNkxFVVg3NVM1QzdEUzAwVi4u&origin=QRCode&qrcodeorigin=presentation&route=shorturl">

                        Denunciar

                    </button>

                </div>

            </div>

            <!-- CONFLICTO -->

            <div class="col-lg-4">

                <div class="tipo-card">

                    <div class="icon bg-success">
                           <i class="bi bi-cash-coin"></i>
                    </div>

                    <h4 class="text-dark">CORRUPCIÓN, SOBORNO, ESTAFA O EXTORSIÓN</h4>

                   <p class="text-justify text-corporativo">
                        Toda conducta sospechosa de corrupción, soborno, estafa o extorsión de cualquier miembro de la organización (empleados, directivos y/o representantes), así como terceras personas en relación (proveedores y/o contratistas) y otras personas que actúen en nombre de la Organización.  
                    </p>

                    <button
                        class="btn btn-outline-success abrirFormulario"
                        data-titulo="CORRUPCIÓN, SOBORNO, ESTAFA O EXTORSIÓN "
                        data-url="https://forms.office.com/pages/responsepage.aspx?id=X9mXjHSk_0meXjnl1GPcVLZBkbYalLFIgiQY2-qJSLVUQ0gzWk9IOVA3UlhJTUpTTlNVQkEzT09ROS4u&origin=QRCode&qrcodeorigin=presentation&route=shorturl">

                        Denunciar

                    </button>

                </div>

            </div>

        </div>

        <!-- INFORMACIÓN -->

        <div class="info-box mt-5 text-dark">

            <h3>

                <i class="bi bi-info-circle-fill"></i>

                ¿Cuándo debo presentar una denuncia?

            </h3>

            <div class="row mt-4">

                <div class="col-md-6">

                    <ul>

                        <li>Soborno o corrupción.</li>

                        <li>Acoso laboral.</li>

                        <li>Acoso sexual.</li>

                        <li>Fraudes.</li>

                    </ul>

                </div>

                <div class="col-md-6">

                    <ul>

                        <li>Conflicto de interés.</li>

                        <li>Robo de activos.</li>

                        <li>Incumplimiento de políticas.</li>

                        <li>Otros actos indebidos.</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- FORMULARIO -->

        <div id="visorFormulario" class="mt-5">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">

                        <i class="bi bi-file-earmark-text"></i>

                        <span id="tituloFormulario">

                            Formulario

                        </span>

                    </h5>

                    <button
                        class="btn btn-light btn-sm"
                        id="cerrarFormulario">

                        <i class="bi bi-x-lg"></i>

                    </button>

                </div>

                <div class="card-body p-0">

                    <iframe

                        id="frmDenuncia"

                        src=""

                        loading="lazy"

                        frameborder="0"

                        width="100%"

                        height="800">

                    </iframe>

                </div>

            </div>

        </div>

    </div>

</div>



<style>

/*==================================================
=            CONTENEDOR PRINCIPAL
==================================================*/

.landing-denuncias{

    max-width:1300px;
    margin:auto;

}

/*==================================================
=            HERO
==================================================*/



.hero-icon{

    width:110px;
    height:110px;

    margin:auto;

    border-radius:50%;

    background:rgba(255,255,255,.12);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:55px;

    margin-bottom:20px;

}

.hero-denuncia h2{

    font-size:42px;

    font-weight:700;

}

.hero-denuncia p{

    max-width:720px;

    margin:auto;

    margin-top:20px;

    opacity:.9;

    font-size:18px;

}

/* Hero oculto */

.hero-denuncia.ocultar{

    opacity:0;

    max-height:0;

    padding:0;

    margin:0;

    overflow:hidden;

    transform:translateY(-40px);

}

/*==================================================
=            TARJETAS
==================================================*/

.tipo-card{

    background:#fff;

    border-radius:22px;

    padding:30px;

    text-align:center;

    height:100%;

    box-shadow:0 12px 35px rgba(0,0,0,.08);

    cursor:pointer;

    transition:all .45s ease;

}

.tipo-card:hover{

    transform:translateY(-10px);

    box-shadow:0 18px 45px rgba(0,0,0,.16);

}

.tipo-card .icon{

    width:80px;

    height:80px;

    margin:auto;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#fff;

    font-size:34px;

    margin-bottom:20px;

}

.tipo-card h4{

    font-weight:700;

}

.tipo-card p{

    color:#666;

    min-height:70px;

}

/*==================================================
=            CAJA DE INFORMACIÓN
==================================================*/

.info-box{

    background:#fff;

    border-radius:20px;

    padding:40px;

    box-shadow:0 12px 35px rgba(0,0,0,.08);

    transition:.5s;

}

.info-box.ocultar{

    opacity:0;

    max-height:0;

    padding:0;

    overflow:hidden;

    margin:0;

}

/*==================================================
=            MODO FORMULARIO
==================================================*/

.modoFormulario .tipo-card{

    padding:14px;

    border-radius:14px;

}

.modoFormulario .tipo-card p{

    display:none;

}

.modoFormulario .tipo-card button{

    display:none;

}

.modoFormulario .tipo-card .icon{

    width:45px;

    height:45px;

    font-size:22px;

    margin-bottom:8px;

}

.modoFormulario .tipo-card h4{

    font-size:15px;

    margin-bottom:0;

}

/* Tarjeta activa */

.tipo-card.activa{

    background:#0d6efd;

    color:#fff;

    transform:scale(1.03);

}

.tipo-card.activa p{

    color:#fff;

}

/*==================================================
=            IFRAME
==================================================*/

#visorFormulario{

    display:none;

    opacity:0;

    transform:translateY(30px);

    transition:.45s;

}

#visorFormulario.activo{

    display:block;

    opacity:1;

    transform:translateY(0);

}

#frmDenuncia{

    width:100%;

    height:75vh;

    border:none;

}

/*==================================================
=            RESPONSIVE
==================================================*/

@media(max-width:768px){

.hero-denuncia{

    padding:35px 20px;

}

.hero-icon{

    width:80px;

    height:80px;

    font-size:38px;

}

.hero-denuncia h2{

    font-size:28px;

}

.hero-denuncia p{

    font-size:15px;

}

.tipo-card{

    margin-bottom:15px;

}

.modoFormulario .tipo-card{

    padding:10px;

}

#frmDenuncia{

    height:70vh;

}

}



.hero-denuncia{

    position: relative;

    overflow: hidden;

    border-radius: 25px;

    padding: 70px 50px;

    text-align: center;

    color: #fff;

    background-image: url("https://kluane.itdospuntocero.net/PTH/IMG/FN4.png"); /* Cambia la ruta */

    background-size: cover;

    background-position: center;

    background-repeat: no-repeat;

    box-shadow: 0 20px 45px rgba(0,0,0,.25);

}

.hero-denuncia::before{

    content:"";

    position:absolute;

    inset:0;

    background:linear-gradient(
        rgba(10,30,50,.75),
        rgba(20,45,70,.75)
    );

    z-index:1;

}

.hero-denuncia>*{

    position:relative;

    z-index:2;

}

.hero-icon{

    width:110px;

    height:110px;

    margin:auto;

    border-radius:50%;

    background:rgba(255,255,255,.18);

    backdrop-filter: blur(8px);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:55px;

    margin-bottom:25px;

    border:1px solid rgba(255,255,255,.25);

}

.hero-denuncia h2{

    font-size:42px;

    font-weight:700;

    text-shadow:0 3px 15px rgba(0,0,0,.4);

}

.hero-denuncia p{

    max-width:700px;

    margin:20px auto 0;

    font-size:18px;

    line-height:1.7;

    text-shadow:0 2px 10px rgba(0,0,0,.35);

}

.text-justify{

    text-align: justify;

    line-height: 1.8;

    text-wrap: pretty; /* Navegadores modernos */

}

.text-corporativo{

    text-align:left;

    line-height:1.8;

    font-size:17px;

    color:#555;

}
</style>