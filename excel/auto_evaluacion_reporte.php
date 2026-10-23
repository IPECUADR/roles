<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$respuesta = json_decode($_POST['respuesta'] ?? '[]', true);

if (!is_array($respuesta)) {
    http_response_code(400);
    exit('Datos inválidos');
}

// Resumen
$total = count($respuesta);
$pendientes = 0;
$ejecutados = 0;

foreach ($respuesta as $item) {
    if (($item['estado'] ?? '') === 'PENDIENTE') {
        $pendientes++;
    } elseif (($item['estado'] ?? '') === 'EJECUTADO') {
        $ejecutados++;
    }
}

// Evitar que Excel interprete datos como fórmulas
function limpiarExcel($valor) {
    $valor = trim((string) $valor);

    if (preg_match('/^[=+\-@\t\r]/', $valor)) {
        return "'" . $valor;
    }

    return $valor;
}

header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Reporte_Valoracion_Kluane.xls"');
header('Cache-Control: no-store');

echo "\xEF\xBB\xBF";

?>

<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #263445;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .titulo {
            background-color: #17365D;
            color: #FFFFFF;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            height: 35px;
        }

        .subtitulo {
            background-color: #D9EAF7;
            color: #17365D;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .resumen-titulo {
            background-color: #EAF0F6;
            color: #17365D;
            font-weight: bold;
            text-align: center;
        }

        .resumen {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }

        .pendiente {
            background-color: #FCE4D6;
            color: #C00000;
            font-weight: bold;
            text-align: center;
        }

        .ejecutado {
            background-color: #E2F0D9;
            color: #38761D;
            font-weight: bold;
            text-align: center;
        }

        .encabezado {
            background-color: #24476B;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
        }

        .dato {
            border: 1px solid #D6DEE8;
        }

        .centro {
            text-align: center;
        }

        .pie {
            color: #66788A;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>

<body>

<table>
    <tr>
        <td colspan="5" class="titulo">
            KLUANE DRILLING ECUADOR S.A.
        </td>
    </tr>

    <tr>
        <td colspan="5" class="subtitulo">
            REPORTE DE VALORACIÓN DEL DESEMPEÑO
        </td>
    </tr>

    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2" class="resumen-titulo">
            TOTAL EVALUACIONES
        </td>
        <td class="resumen-titulo">PENDIENTES</td>
        <td colspan="2" class="resumen-titulo">EJECUTADAS</td>
    </tr>

    <tr>
        <td colspan="2" class="resumen">
            <?= $total ?>
        </td>

        <td class="pendiente">
            <?= $pendientes ?>
        </td>

        <td colspan="2" class="ejecutado">
            <?= $ejecutados ?>
        </td>
    </tr>

    <tr>
        <td colspan="5">&nbsp;</td>
    </tr>

    <tr class="encabezado">
        <td> N.º </td>
        <td> Identificación </td>
        <td> Nombres </td>
        <td> Apellidos </td>
        <td> Tipo de evaluación </td>
        <td> Estado </td>
    </tr>

    <?php foreach ($respuesta as $i => $item): ?>

        <?php
            $estado = $item['estado'] ?? '';
            $claseEstado = $estado === 'PENDIENTE'
                ? 'pendiente'
                : ($estado === 'EJECUTADO' ? 'ejecutado' : 'centro');
        ?>

        <tr>
            <td class="dato centro">
                <?= $i + 1 ?>
            </td>

            <td class="dato" style="mso-number-format:'\@';">
                <?= htmlspecialchars(limpiarExcel($item['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td class="dato">
                <?= htmlspecialchars(limpiarExcel($item['nm'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td class="dato">
                <?= htmlspecialchars(limpiarExcel($item['ap'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td class="dato">
                <?= htmlspecialchars(limpiarExcel($item['tipo'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td class="<?= $claseEstado ?> dato">
                <?= htmlspecialchars(limpiarExcel($estado), ENT_QUOTES, 'UTF-8') ?>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan="6">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="6" class="pie">
            Documento generado automáticamente por el sistema de valoración.
        </td>
    </tr>
</table>

</body>
</html>
