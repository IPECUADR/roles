<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GESTION HUMANA</title>
<link rel="icon" type="../IMAGE/kdeValores.png" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/login.css">
</head>

<body>

<div class="container-login">

 <div class="left-panel">

  <div class="left-card">
    <div class="container">
        <div class="row justify-content-center">

            <!-- IMAGEN -->
            <div class="col-12 text-center">
                <img src="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" 
                     class="img-fluid img-card" 
                     alt="Imagen">
            </div>

            <!-- TEXTO -->
            <div class="col-12 text-center mt-3">
                <h3>KLUANE DRILLING ECUADOR S.A</h3>
                <p>Servicio de Roles de Pago</p>
            </div>

        </div>
    </div>
</div>

</div>

    <!-- ⚪ DERECHA -->
    <div class="right-panel p-3">
        <div class="login-box">

    <div class="container">
        <div class="row justify-content-center">

            <!-- LOGO -->
            <div class="col-12 text-center mb-3">
                <img src="https://kluane.itdospuntocero.net/VALORACION-2025/IMAGE/logo.png" 
                     class="img-fluid logo-form" 
                     alt="Logo Empresa">
            </div>

            <!-- TITULO -->
            <div class="col-12 text-center">
                <h5 class="login-title">Iniciar Sesión</h5>
            </div>

            <!-- FORM -->
            <div class="col-12">
                <form id="loginForm" class="p-1 mt-3 mb-3">

                    <div class="mb-3">
                        <input type="text" class="form-control"  id="user" placeholder="Usuario">
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" id="pass"    placeholder="Contraseña">
                    </div>
                </form>
                 
                <button class="btn btn-login w-100 mt-4 mb-3" id="btn_login">Ingresar</button>

                Recuperar contraseña? <a href="web/rutas.php?ruta=recuperar" class="link-primary">Haz clic aquí</a>
            
            </div>

        </div>
    </div>

    </div>
        
      

    </div>
    

</div>


<footer class="text-center w-100 mt-3">
    <small class="text-white-50">
       © 2026 | DEVELOPED BY KLUANE DRILLING ECUADOR S.A 
    </small>
</footer>


</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/login.fn.js"></script>

</html>