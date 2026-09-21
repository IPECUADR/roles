<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Acceso Denegado | KLUANE DRILLING ECUADOR</title>

<!-- Favicon -->
<link rel="icon" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;

        display: flex;
        align-items: center;
        justify-content: center;

        font-family: "Segoe UI", Arial, sans-serif;

        background:
            radial-gradient(circle at top left, rgba(0, 83, 140, 0.35), transparent 35%),
            radial-gradient(circle at bottom right, rgba(245, 158, 11, 0.15), transparent 35%),
            linear-gradient(135deg, #001a33, #0f172a);

        color: #ffffff;
    }

    .error-container {
        width: 100%;
        max-width: 600px;
        padding: 20px;
    }

    .error-card {
        text-align: center;

        padding: 50px 35px;

        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);

        border-radius: 24px;

        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);

        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    }

    .error-icon {
        width: 100px;
        height: 100px;

        margin: 0 auto 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: rgba(245, 158, 11, 0.12);

        color: #f59e0b;

        font-size: 48px;

        box-shadow:
            0 0 0 10px rgba(245, 158, 11, 0.04);
    }

    .error-number {
        font-size: clamp(80px, 15vw, 120px);
        line-height: 1;

        font-weight: 800;

        letter-spacing: -5px;

        color: #f59e0b;

        margin-bottom: 10px;
    }

    .error-title {
        font-size: 28px;
        font-weight: 700;

        margin-bottom: 15px;
    }

    .error-message {
        color: rgba(255, 255, 255, 0.75);

        font-size: 16px;
        line-height: 1.7;

        margin-bottom: 30px;
    }

    .btn-home {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 12px 28px;

        border-radius: 50px;

        background: #f59e0b;

        border: none;

        color: #111827;

        font-weight: 600;

        text-decoration: none;

        transition: all 0.25s ease;
    }

    .btn-home:hover {
        background: #fbbf24;

        color: #111827;

        transform: translateY(-2px);

        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);
    }

    .system-name {
        margin-top: 30px;

        font-size: 13px;

        color: rgba(255, 255, 255, 0.45);

        letter-spacing: 0.5px;
    }

    @media (max-width: 576px) {

        .error-container {
            padding: 15px;
        }

        .error-card {
            padding: 40px 22px;
        }

        .error-title {
            font-size: 24px;
        }

        .error-message {
            font-size: 15px;
        }

        .error-icon {
            width: 85px;
            height: 85px;

            font-size: 40px;
        }

    }

</style>


</head>

<body>


<main class="error-container">

    <div class="error-card">

        <!-- Icono -->
        <div class="error-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <!-- Código -->
        <div class="error-number">
            403
        </div>

        <!-- Título -->
        <h1 class="error-title">
            Acceso Denegado
        </h1>

        <!-- Mensaje -->
        <p class="error-message">
            No tienes los permisos necesarios para acceder a este módulo.
            <br>
            Si consideras que se trata de un error, comunícate con el
            administrador del sistema.
        </p>

        <!-- Botón -->
        <a href="../web/rutas.php?ruta=home" class="btn-home">
            <i class="bi bi-house-door-fill"></i>
            Volver al inicio
        </a>

        <!-- Sistema -->
        <div class="system-name">
            KLUANE DRILLING ECUADOR
        </div>

    </div>

</main>


</body>
</html>
