<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KDE | GESTION HUMANA </title>
<link rel="icon" type="../IMAGE/kdeValores.png" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../css/tem.css">


  <?php
        // Imprime css dinámico si existe
        if (!empty($css)) {
     
            
        echo $css;


        }
        ?>




</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-pro fixed-top">
<div class="container-fluid">

<a class="navbar-brand text-white fw-bold" href="#" id="home_sys">
<i class="bi bi-cpu-fill me-2"></i> GESTION HUMANA
</a>

<button class="navbar-toggler bg-light" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="nav">

<ul class="navbar-nav me-auto">

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Gestión</a>
<ul class="dropdown-menu">

<li><a class="dropdown-item" id="btn_roles">Roles de Pago</a></li>
<li><a class="dropdown-item" data-ruta="certificados">Certificados</a></li>
<li><a class="dropdown-item" data-ruta="firma">Firma</a></li>
</ul>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Perfil</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="../web/rutas.php?ruta=perfil" >Ver Perfil</a></li>
<li><a class="dropdown-item" href="../web/rutas.php?ruta=configuracion">Configuración</a></li>
</ul>
</li>

</ul>

<div class="d-flex align-items-center gap-3">

<!-- USER -->
<div class="dropdown">
<button class="user-pill dropdown-toggle border-0" data-bs-toggle="dropdown">

<div class="avatar">
<i class="bi bi-person-fill"></i>
<span class="status"></span>
</div>

<div class="user-info">
<span class="name"><?php echo $USUARIO; ?></span>

<small class="role mt-2"><i class="bi bi-unlock2-fill"></i> <?php echo $rol; ?></small>
</div>

</button>

<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="../web/rutas.php?ruta=perfil"><i class="bi bi-person me-2"></i> Mi perfil</a></li>
<li><a class="dropdown-item" href="../web/rutas.php?ruta=configuracion"><i class="bi bi-gear me-2"></i> Configuración</a></li>
<li><hr class="dropdown-divider"></li>



</ul>
</div>

<button id="btn_close" class="btn-logout-pro">
<i class="bi bi-power"></i>
</button>

</div>

</div>
</div>
</nav>