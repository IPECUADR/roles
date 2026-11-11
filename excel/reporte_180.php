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

// FUNCIONES
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

function numeroExcel($valor) {
    return number_format((float) ($valor ?? 0), 2, '.', '');
}

// CLASIFICACIÓN DE RESULTADOS
function clasificarResultado($valor) {

    $valor = (float) ($valor ?? 0);

    if ($valor < 0 || $valor > 125) {
        return [
            'nombre' => 'FUERA DE ESCALA',
            'color' => '#667085',
            'fondo' => '#EAECF0'
        ];
    }

    if ($valor >= 100) {
        return [
            'nombre' => 'SOBRESALIENTE',
            'color' => '#217346',
            'fondo' => '#E2F0D9'
        ];
    }

    if ($valor >= 80) {
        return [
            'nombre' => 'CUMPLE CON LAS EXPECTATIVAS',
            'color' => '#245A91',
            'fondo' => '#DDEBF7'
        ];
    }

    if ($valor >= 70) {
        return [
            'nombre' => 'NECESITA MEJORAR',
            'color' => '#9C6500',
            'fondo' => '#FFF2CC'
        ];
    }

    return [
        'nombre' => 'NO CUMPLE',
        'color' => '#C00000',
        'fondo' => '#FCE4D6'
    ];
}

// RESUMEN EJECUTIVO
$total = count($respuesta);

$resumen = [
    'SOBRESALIENTE' => 0,
    'CUMPLE CON LAS EXPECTATIVAS' => 0,
    'NECESITA MEJORAR' => 0,
    'NO CUMPLE' => 0,
    'FUERA DE ESCALA' => 0
];

foreach ($respuesta as $item) {

    $clasificacion = clasificarResultado(
        $item['TOTAL_EVALUACION'] ?? 0
    );

    $resumen[$clasificacion['nombre']]++;
}

$fecha = date('d/m/Y');
$hora = date('H:i');

header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="Reporte_Valoracion_Desempeno_2026.xls"');
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
        font-size: 10px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .principal {
        background-color: #142D4E;
        color: #FFFFFF;
        font-size: 19px;
        font-weight: bold;
        text-align: center;
        height: 45px;
    }

    .secundario {
        background-color: #24476B;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        height: 30px;
    }

    .seccion {
        background-color: #E9EFF5;
        color: #17365D;
        font-weight: bold;
        height: 27px;
    }

    .introduccion {
        background-color: #F7F9FC;
        color: #46576A;
        font-size: 11px;
        height: 55px;
        vertical-align: middle;
    }

    .resumen-titulo {
        background-color: #E9EFF5;
        color: #526579;
        font-weight: bold;
        text-align: center;
        height: 27px;
    }

    .resumen-valor {
        background-color: #F7F9FC;
        color: #17365D;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        height: 40px;
    }

    .resumen-detalle {
        background-color: #F7F9FC;
        color: #66788A;
        font-size: 10px;
        text-align: center;
        height: 23px;
    }

    .tabla-encabezado {
        background-color: #24476B;
        color: #FFFFFF;
        font-weight: bold;
        text-align: center;
        height: 32px;
    }

    .dato {
        border: 1px solid #DCE3EB;
        height: 26px;
    }

    .centro {
        text-align: center;
    }

    .resultado {
        font-weight: bold;
        text-align: center;
        border: 1px solid #DCE3EB;
    }

    .clasificacion {
        font-weight: bold;
        text-align: center;
        border: 1px solid #DCE3EB;
        font-size: 9px;
    }

    .leyenda-titulo {
        background-color: #24476B;
        color: #FFFFFF;
        font-weight: bold;
        text-align: center;
        height: 28px;
    }

    .leyenda {
        font-weight: bold;
        text-align: center;
        height: 28px;
        border: 1px solid #DCE3EB;
    }

    .nota {
        background-color: #F7F9FC;
        color: #526579;
        font-size: 10px;
        height: 43px;
        vertical-align: middle;
    }

    .pie {
        color: #718096;
        font-size: 9px;
        text-align: right;
    }

    .espacio {
        height: 15px;
    }

</style>

</head>

<body>

<table>

    <!-- ENCABEZADO INSTITUCIONAL -->

    <tr>
        <td colspan="9" class="principal">
            KLUANE DRILLING ECUADOR S.A.
        </td>
    </tr>

    <tr>
        <td colspan="9" class="secundario">
            REPORTE INSTITUCIONAL DE VALORACIÓN DEL DESEMPEÑO | 2026
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- INTRODUCCIÓN -->

    <tr>
        <td colspan="9" class="seccion">
            INFORME DE RESULTADOS
        </td>
    </tr>

    <tr>
        <td colspan="9" class="introduccion">
            El presente informe consolida los resultados del proceso de
            Valoración del Desempeño 2026 de Kluane Drilling Ecuador S.A.
            Su propósito es proporcionar una visión integral del desempeño
            de los colaboradores, considerando los indicadores KPI,
            los resultados HSE y la evaluación de competencias.
            Esta información constituye un insumo para el seguimiento,
            análisis y fortalecimiento de la gestión del talento humano.
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- RESUMEN -->

    <tr>
        <td colspan="9" class="seccion">
            RESUMEN EJECUTIVO
        </td>
    </tr>

    <tr>
        <td colspan="9" class="resumen-titulo">
            TOTAL DE COLABORADORES EVALUADOS
        </td>
    </tr>

    <tr>
        <td colspan="9" class="resumen-valor">
            <?= $total ?>
        </td>
    </tr>

    <tr>
        <td colspan="9" class="resumen-detalle">
            Consolidado general de resultados de valoración del desempeño
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- DISTRIBUCIÓN DE RESULTADOS -->

    <tr>
        <td colspan="9" class="seccion">
            DISTRIBUCIÓN POR NIVEL DE DESEMPEÑO
        </td>
    </tr>

    <tr class="tabla-encabezado">
        <td colspan="2">SOBRESALIENTE</td>
        <td colspan="2">CUMPLE EXPECTATIVAS</td>
        <td colspan="2">NECESITA MEJORAR</td>
        <td colspan="2">NO CUMPLE</td>
        <td>FUERA DE ESCALA</td>
    </tr>

    <tr>
        <td colspan="2" class="leyenda"
            style="background-color:#E2F0D9;color:#217346;">
            <?= $resumen['SOBRESALIENTE'] ?>
        </td>

        <td colspan="2" class="leyenda"
            style="background-color:#DDEBF7;color:#245A91;">
            <?= $resumen['CUMPLE CON LAS EXPECTATIVAS'] ?>
        </td>

        <td colspan="2" class="leyenda"
            style="background-color:#FFF2CC;color:#9C6500;">
            <?= $resumen['NECESITA MEJORAR'] ?>
        </td>

        <td colspan="2" class="leyenda"
            style="background-color:#FCE4D6;color:#C00000;">
            <?= $resumen['NO CUMPLE'] ?>
        </td>

        <td class="leyenda"
            style="background-color:#EAECF0;color:#667085;">
            <?= $resumen['FUERA DE ESCALA'] ?>
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- DETALLE -->

    <tr>
        <td colspan="9" class="seccion">
            DETALLE DE RESULTADOS POR COLABORADOR
        </td>
    </tr>

    <tr class="tabla-encabezado">
        <td>N.º</td>
        <td>ID</td>
        <td>NOMBRES</td>
        <td>APELLIDOS</td>
        <td>KPI</td>
        <td>HSE</td>
        <td>COMPETENCIAS</td>
        <td>VALORACIÓN FINAL</td>
        <td>CLASIFICACIÓN</td>
    </tr>

    <?php foreach ($respuesta as $i => $item): ?>

        <?php
            $valor = (float) ($item['TOTAL_EVALUACION'] ?? 0);
            $clasificacion = clasificarResultado($valor);
        ?>

        <tr style="<?= $i % 2 !== 0 ? 'background-color:#F5F8FB;' : '' ?>">

            <td class="dato centro">
                <?= $i + 1 ?>
            </td>

            <td class="dato centro" style="mso-number-format:'\@';">
                <?= datoExcel($item['PK_persona'] ?? '') ?>
            </td>

            <td class="dato">
                <?= datoExcel($item['nom_p'] ?? '') ?>
            </td>

            <td class="dato">
                <?= datoExcel($item['ap_p'] ?? '') ?>
            </td>

            <td class="dato centro">
                <?= numeroExcel($item['TOTAL_KPI'] ?? 0) ?>
            </td>

            <td class="dato centro">
                <?= numeroExcel($item['TOTAL_HSE'] ?? 0) ?>
            </td>

            <td class="dato centro">
                <?= numeroExcel($item['TOTAL_COMPETENCIAS'] ?? 0) ?>
            </td>

            <!-- RESULTADO CON RESTRICCIÓN VISUAL -->

            <td class="resultado"
                style="
                    background-color:<?= $clasificacion['fondo'] ?>;
                    color:<?= $clasificacion['color'] ?>;
                ">
                <?= numeroExcel($valor) ?>
            </td>

            <!-- CLASIFICACIÓN -->

            <td class="clasificacion"
                style="
                    background-color:<?= $clasificacion['fondo'] ?>;
                    color:<?= $clasificacion['color'] ?>;
                ">
                <?= $clasificacion['nombre'] ?>
            </td>

        </tr>

    <?php endforeach; ?>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- ESCALA DE VALORACIÓN -->

    <tr>
        <td colspan="9" class="seccion">
            ESCALA INSTITUCIONAL DE VALORACIÓN
        </td>
    </tr>

    <tr class="tabla-encabezado">
        <td colspan="3">RANGO DE RESULTADO</td>
        <td colspan="6">NIVEL DE DESEMPEÑO</td>
    </tr>

    <tr>
        <td colspan="3" class="leyenda"
            style="background-color:#E2F0D9;color:#217346;">
            100% - 125%
        </td>

        <td colspan="6" class="leyenda"
            style="background-color:#E2F0D9;color:#217346;">
            SOBRESALIENTE
        </td>
    </tr>

    <tr>
        <td colspan="3" class="leyenda"
            style="background-color:#DDEBF7;color:#245A91;">
            80% - 99.99%
        </td>

        <td colspan="6" class="leyenda"
            style="background-color:#DDEBF7;color:#245A91;">
            CUMPLE CON LAS EXPECTATIVAS
        </td>
    </tr>

    <tr>
        <td colspan="3" class="leyenda"
            style="background-color:#FFF2CC;color:#9C6500;">
            70% - 79.99%
        </td>

        <td colspan="6" class="leyenda"
            style="background-color:#FFF2CC;color:#9C6500;">
            NECESITA MEJORAR
        </td>
    </tr>

    <tr>
        <td colspan="3" class="leyenda"
            style="background-color:#FCE4D6;color:#C00000;">
            0% - 69.99%
        </td>

        <td colspan="6" class="leyenda"
            style="background-color:#FCE4D6;color:#C00000;">
            NO CUMPLE
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- METODOLOGÍA -->

    <tr>
        <td colspan="9" class="seccion">
            METODOLOGÍA Y CONSIDERACIONES
        </td>
    </tr>

    <tr>
        <td colspan="9" class="nota">
            La valoración final considera los siguientes componentes:
            KPI (40%), HSE (30%) y Competencias (30%).
            La clasificación se determina automáticamente de acuerdo
            con la escala institucional establecida para el proceso
            de Valoración del Desempeño 2026.
        </td>
    </tr>

    <tr>
        <td colspan="9" class="espacio">&nbsp;</td>
    </tr>

    <!-- PIE -->

    <tr>
        <td colspan="5" class="pie">
            Documento generado automáticamente por el sistema institucional.
        </td>

        <td colspan="4" class="pie">
            Fecha: <?= $fecha ?> | Hora: <?= $hora ?>
        </td>
    </tr>

    <tr>
        <td colspan="9" class="pie">
            KLUANE DRILLING ECUADOR S.A. | VALORACIÓN DEL DESEMPEÑO 2026
        </td>
    </tr>

</table>

</body>
</html>
