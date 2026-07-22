
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


