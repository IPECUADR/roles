<?php

// Generar archivo Excel sin librerías
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=Reporte_Postulaciones_" . date('Y-m-d_H-i-s') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Recibir datos enviados por AJAX
$datos = $_POST['datos'] ?? '';

if (empty($datos)) {
    exit('No existen datos para generar el reporte.');
}

// Convertir JSON a array
$datos_postulacion = json_decode($datos, true);

if (!is_array($datos_postulacion)) {
    exit('Los datos recibidos no son válidos.');
}


/**
 * Calcular edad
 */
function calcularEdad($fechaNacimiento)
{
    if (empty($fechaNacimiento)) {
        return '';
    }

    try {

        $fechaNacimiento = new DateTime($fechaNacimiento);
        $hoy = new DateTime();

        return $fechaNacimiento->diff($hoy)->y;

    } catch (Exception $e) {

        return '';

    }
}


/**
 * Convertir estado
 */
function estadoPostulacion($estado)
{
    switch ((int)$estado) {

        case 1:
            return 'Pendiente';

        case 2:
            return 'Revisado';

        case 3:
            return 'Rechazado';

        case 4:
            return 'Apto';

        default:
            return 'Sin estado';
    }
}

?>

<html>

<head>

    <meta charset="UTF-8">

    <style>

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #1f4e78;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
            padding: 8px;
        }

        td {
            border: 1px solid #cccccc;
            padding: 6px;
        }

        .titulo {
            font-size: 16px;
            font-weight: bold;
        }

        .fecha {
            font-size: 11px;
        }

    </style>

</head>

<body>

    <!-- ENCABEZADO -->

    <table>

        <tr>
            <td colspan="14" class="titulo">
                KDE | REPORTE DE POSTULACIONES
            </td>
        </tr>

        <tr>
            <td colspan="14" class="fecha">
                Fecha de generación:
                <?= date('d/m/Y H:i:s'); ?>
            </td>
        </tr>

    </table>

    <br>


    <!-- REPORTE -->

    <table>

        <thead>

            <tr>

                <th>N°</th>

                <th>Cédula</th>

                <th>Postulante</th>

                <th>Email</th>

                <th>Celular</th>

                <th>Fecha de nacimiento</th>

                <th>Edad</th>

                <th>Nacionalidad</th>

                <th>Dirección</th>

                <th>Provincia</th>

                <th>Cantón</th>

                <th>Puesto aplicado</th>

                <th>Fecha de postulación</th>

                <th>Estado</th>

            </tr>

        </thead>


        <tbody>

            <?php foreach ($datos_postulacion as $index => $item): ?>

                <tr>

                    <td>
                        <?= $index + 1; ?>
                    </td>

                    <td style="mso-number-format:'@';">
                        <?= htmlspecialchars($item['ci'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            ($item['nm'] ?? '') . ' ' . ($item['ap'] ?? '')
                        ); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['emi'] ?? ''); ?>
                    </td>

                 <td style="mso-number-format:'@';">
                        <?= htmlspecialchars($item['cel'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['f_na'] ?? ''); ?>
                    </td>

                    <td>
                        <?= calcularEdad($item['f_na'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['nan'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['dir'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['provi'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['cant'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['pl'] ?? ''); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['fc'] ?? ''); ?>
                    </td>

                    <td>
                        <?= estadoPostulacion($item['est'] ?? 0); ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</body>

</html>
