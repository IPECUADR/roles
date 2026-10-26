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
$ejecutadas = 0;
$totalPreguntas = 0;

foreach ($respuesta as $item) {
    $pendientes += (int) ($item['pendientes'] ?? 0);
    $ejecutadas += (int) ($item['ejecutadas'] ?? 0);
    $totalPreguntas += (int) ($item['total_preguntas'] ?? 0);
}

// Evitar que Excel interprete datos como fórmulas
function limpiarExcel($valor) {
    $valor = trim((string) $valor);

    if (preg_match('/^[=+\-@\t\r]/', $valor)) {
        return "'" . $valor;
    }

    return $valor;
}

function datoExcel($valor) {
    return htmlspecialchars(
        limpiarExcel($valor),
        ENT_QUOTES,
        'UTF-8'
    );
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

        .mixto {
            background-color: #FFF2CC;
            color: #7F6000;
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
        <td colspan="10" class="titulo">
            KLUANE DRILLING ECUADOR S.A.
        </td>
    </tr>

    <tr>
        <td colspan="10" class="subtitulo">
            REPORTE DE VALORACIÓN DEL DESEMPEÑO
        </td>
    </tr>

    <tr>
        <td colspan="10">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="2" class="resumen-titulo">
            TOTAL RELACIONES
        </td>

        <td colspan="2" class="resumen-titulo">
            TOTAL PREGUNTAS
        </td>

        <td colspan="3" class="resumen-titulo">
            PREGUNTAS PENDIENTES
        </td>

        <td colspan="3" class="resumen-titulo">
            PREGUNTAS EJECUTADAS
        </td>
    </tr>

    <tr>
        <td colspan="2" class="resumen">
            <?= $total ?>
        </td>

        <td colspan="2" class="resumen">
            <?= $totalPreguntas ?>
        </td>

        <td colspan="3" class="pendiente">
            <?= $pendientes ?>
        </td>

        <td colspan="3" class="ejecutado">
            <?= $ejecutadas ?>
        </td>
    </tr>

    <tr>
        <td colspan="10">&nbsp;</td>
    </tr>

    <tr class="encabezado">
        <td>N.º</td>
        <td>CI Evaluado</td>
        <td>Nombre del evaluado</td>
        <td>CI Evaluador</td>
        <td>Nombre del evaluador</td>
        <td>Tipo de evaluación</td>
        <td>Total preguntas</td>
        <td>Pendientes</td>
        <td>Ejecutadas</td>
        <td>Estado</td>
    </tr>

    <?php foreach ($respuesta as $i => $item): ?>

        <?php
            $totalItem = (int) ($item['total_preguntas'] ?? 0);
            $pendienteItem = (int) ($item['pendientes'] ?? 0);
            $ejecutadaItem = (int) ($item['ejecutadas'] ?? 0);

            if ($pendienteItem > 0 && $ejecutadaItem > 0) {
                $estado = 'PARCIAL';
                $claseEstado = 'mixto';
            } elseif ($pendienteItem > 0) {
                $estado = 'PENDIENTE';
                $claseEstado = 'pendiente';
            } elseif ($ejecutadaItem > 0) {
                $estado = 'EJECUTADO';
                $claseEstado = 'ejecutado';
            } else {
                $estado = 'SIN DATOS';
                $claseEstado = 'centro';
            }
        ?>

        <tr>
            <td class="dato centro">
                <?= $i + 1 ?>
            </td>

            <td class="dato centro" style="mso-number-format:'\@';">
                <?= datoExcel($item['ci_evaluado'] ?? '') ?>
            </td>

            <td class="dato">
                <?= datoExcel($item['evaluado'] ?? '') ?>
            </td>

            <td class="dato centro" style="mso-number-format:'\@';">
                <?= datoExcel($item['ci_evaluador'] ?? '') ?>
            </td>

            <td class="dato">
                <?= datoExcel($item['evaluador'] ?? '') ?>
            </td>

            <td class="dato centro">
                <?= datoExcel($item['EVALUACION'] ?? $item['t_ev'] ?? '') ?>
            </td>

            <td class="dato centro">
                <?= $totalItem ?>
            </td>

            <td class="dato pendiente">
                <?= $pendienteItem ?>
            </td>

            <td class="dato ejecutado">
                <?= $ejecutadaItem ?>
            </td>

            <td class="dato <?= $claseEstado ?>">
                <?= $estado ?>
            </td>
        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan="10">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="10" class="pie">
            Documento generado automáticamente por el sistema de valoración.
        </td>
    </tr>
</table>

</body>
</html>
