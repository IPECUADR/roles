<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Recuperar contraseña</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="../IMAGE/kdeValores.png" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" />
<link rel="stylesheet" href="../css/recu.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="glass-card text-center" id ="form_recu">

    <div class="icon-lock">🔐</div>

    <h4>Recuperar contraseña</h4>

    <p class="mb-4">
     Ingresa tu correo para continuar.
    </p>

    <div class="mb-3 text-start">
        <label class="form-label">Correo electrónico</label>
        <input type="email" id="em_recu" class="form-control" placeholder="usuario@empresa.com">
    </div>


    <div id="token"></div>
  

    <div class="d-grid mt-3">
        <button id="btn_recuperar_c" class="btn btn-dark-blue">
            CONTINUAR
        </button>
    </div>


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/recuperar.fn.js"></script>

</body>
</html>