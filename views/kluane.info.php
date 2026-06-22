<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GH  | Verificación de Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="../IMAGE/kdeValores.png" href="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" />
    <style>
        body {
            background: #f4f6f8;
        }
        .card-verificacion {
            max-width: 520px;
            margin: 80px auto;
            border-top: 6px solid #0a3d62;
        }
        .logo {
            max-width: 130px;
        }
        .rol-ok {
            color: #27ae60;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card shadow card-verificacion">
        <div class="card-body">

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png" alt="Logo institucional" class="logo">
            </div>

            <!-- Nombre -->
            <h5 class="text-center mb-1">
                Kluane Drilling Ecuador S.A.
            </h5>

            <p class="text-center text-muted mb-4">
                Verificación de rol y acceso
            </p>

            <!-- Datos -->
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">
                    <strong>Dirección:</strong><br>
                    Juan Barrezueta, 170310 – Quito
                </li>
                <li class="list-group-item">
                    <strong>Teléfono:</strong><br>
                    (02) 500-1007
                </li>
                <li class="list-group-item">
                    <strong>Estado de la empresa:</strong><br>
                    <span class="rol-ok">Operativa</span>
                </li>
            </ul>

            <!-- Rol -->
            <div class="alert alert-success text-center">
                ✅ Rol verificado correctamente
            </div>

            <!-- Botón -->
            <div class="d-grid">
                <button class="btn btn-success" id="whatsapp-btn">
                    <i class="bi bi-whatsapp"></i> CHAT CON | KLUANE DRILLING ECUADOR S.A.
                </button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../js/info.kde.js"></script>
</body>
</html>