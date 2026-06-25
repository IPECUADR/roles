<?php
session_start();

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Aceptacion_Roles_" . date('Y-m-d_H-i-s') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

$datos_c = isset($_POST['data'])
    ? json_decode($_POST['data'], true)
    : [];

$us = $_SESSION['user'] ?? 'Sistema';
$fecha_gen = date('d/m/Y H:i');

$total_registros = count($datos_c);
$total_aceptados = 0;

foreach ($datos_c as $item) {

    $estado = strtoupper(trim($item['acp'] ?? ''));

    if ($estado === 'ACEPTO') {
        $total_aceptados++;
    }
}

$porcentaje = $total_registros > 0
    ? round(($total_aceptados / $total_registros) * 100, 2)
    : 0;
?>

<html>

<head>
<meta charset="UTF-8">

<style>

body{
    font-family: Calibri, Arial, sans-serif;
    color:#1e293b;
}

table{
    border-collapse:collapse;
    width:100%;
}

th{
    background:#0F2D5C;
    color:#FFFFFF;
    border:1px solid #0F2D5C;
    padding:7px;
    font-size:11px;
    text-align:center;
    font-weight:bold;
}

td{
    border:1px solid #CBD5E1;
    padding:5px;
    font-size:11px;
}

tbody tr:nth-child(even){
    background:#F8FAFC;
}

.header-title{
    font-size:22px;
    font-weight:bold;
    color:#0F2D5C;
    text-align:center;
}

.header-subtitle{
    font-size:11px;
    color:#64748B;
    text-align:center;
}

.barra{
    background:#0F2D5C;
    height:4px;
}

.info-box{
    background:#F8FAFC;
    border:1px solid #CBD5E1;
    padding:8px;
    text-align:center;
}

.info-title{
    font-size:10px;
    font-weight:bold;
    color:#64748B;
}

.info-value{
    font-size:12px;
    font-weight:bold;
    color:#0F172A;
}

.kpi{
    background:#EFF6FF;
    border:1px solid #BFDBFE;
    text-align:center;
    padding:6px;
}

.kpi-num{
    font-size:16px;
    font-weight:bold;
    color:#2563EB;
}

.kpi-title{
    font-size:10px;
    color:#64748B;
}

.estado-ok{
    background:#16A34A;
    color:#FFFFFF;
    font-weight:bold;
    text-align:center;
}

.estado-pendiente{
    background:#DC2626;
    color:#FFFFFF;
    font-weight:bold;
    text-align:center;
}

.fecha{
    background:#DBEAFE;
    color:#1E40AF;
    font-weight:bold;
    text-align:center;
}

.total{
    background:#E0E7FF;
    color:#1E3A8A;
    font-weight:bold;
}

.footer{
    text-align:center;
    font-size:10px;
    color:#64748B;
}

.titulo-seccion{
    font-size:14px;
    font-weight:bold;
    text-align:center;
    color:#0F2D5C;
}

</style>

</head>

<body>

<!-- ENCABEZADO -->

<table>

<tr>

<td style="border:none;width:140px;text-align:center;vertical-align:middle;">

<img src="https://kluane.itdospuntocero.net/PTH/IMG/kdeValores.png"
     style="width:90px;height:90px;">

</td>

<td style="border:none;text-align:center;vertical-align:middle;">

<div class="header-title">
REPORTE DE ACEPTACIÓN DE ROLES DE PAGO
</div>

<br>

<div class="header-subtitle">
KLUANE DRILLING ECUADOR
</div>

</td>

</tr>

</table>

<table>
<tr>
<td class="barra"></td>
</tr>
</table>

<br>

<!-- INFORMACIÓN GENERAL -->

<table width="70%" align="center">

<tr>

<td class="info-box">

<div class="info-title">
USUARIO GENERADOR
</div>

<div class="info-value">
<?= htmlspecialchars($us) ?>
</div>

</td>

<td class="info-box">

<div class="info-title">
FECHA DE GENERACIÓN
</div>

<div class="info-value">
<?= $fecha_gen ?>
</div>

</td>

<td class="info-box">

<div class="info-title">
TOTAL REGISTROS
</div>

<div class="info-value">
<?= $total_registros ?>
</div>

</td>

</tr>

</table>

<br>

<!-- KPI -->

<table width="50%" align="center">

<tr>

<td class="kpi">

<div class="kpi-num">
<?= $total_registros ?>
</div>

<div class="kpi-title">
TOTAL REGISTROS
</div>

</td>

<td class="kpi">

<div class="kpi-num">
<?= $total_aceptados ?>
</div>

<div class="kpi-title">
ACEPTADOS
</div>

</td>

<td class="kpi">

<div class="kpi-num">
<?= $porcentaje ?>%
</div>

<div class="kpi-title">
PORCENTAJE DE ACEPTACIÓN
</div>

</td>

</tr>

</table>

<br>

<div class="titulo-seccion">
DETALLE DE ACEPTACIÓN
</div>

<br>

<!-- TABLA PRINCIPAL -->

<table>

<thead>

<tr>
    <th width="5%">#</th>
    <th width="22%">COLABORADOR</th>
    <th width="28%">COMENTARIO</th>
    <th width="12%">FECHA</th>
    <th width="10%">ESTADO</th>
    <th width="13%">SERVICIO</th>
    <th width="10%">CARGO</th>
</tr>

</thead>

<tbody>

<?php if(!empty($datos_c)): ?>

<?php
$contador = 1;

foreach($datos_c as $item):

$estado = trim($item['acp'] ?? '');

$clase_estado = strtoupper($estado) === 'ACEPTO'
    ? 'estado-ok'
    : 'estado-pendiente';
?>

<tr>

<td align="center">
<?= $contador++ ?>
</td>

<td>
<?= htmlspecialchars($item['nm'] ?? '') ?>
</td>

<td>
<?= htmlspecialchars($item['cmt'] ?? '') ?>
</td>

<td class="fecha">
<?= htmlspecialchars($item['fc_acp'] ?? '') ?>
</td>

<td class="<?= $clase_estado ?>">
<?= htmlspecialchars($estado) ?>
</td>

<td>
<?= htmlspecialchars($item['cnd'] ?? '') ?>
</td>

<td>
<?= htmlspecialchars($item['cg'] ?? '') ?>
</td>

</tr>

<?php endforeach; ?>

<tr class="total">

<td colspan="6" align="right">
TOTAL GENERAL
</td>

<td align="center">
<?= $total_registros ?>
</td>

</tr>

<?php else: ?>

<tr>

<td colspan="7" align="center">

NO EXISTEN REGISTROS DISPONIBLES

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

<br>

<!-- RESUMEN -->

<table width="40%" align="center">

<tr class="total">

<td colspan="2">
RESUMEN EJECUTIVO
</td>

</tr>

<tr>
<td>Total Registros</td>
<td><?= $total_registros ?></td>
</tr>

<tr>
<td>Total Aceptados</td>
<td><?= $total_aceptados ?></td>
</tr>

<tr>
<td>Porcentaje de Aceptación</td>
<td><?= $porcentaje ?>%</td>
</tr>

</table>

<br><br>

<!-- PIE -->

<table>

<tr>

<td class="footer" style="border:none;">

REPORTE GENERADO AUTOMÁTICAMENTE POR EL SISTEMA DE GESTIÓN DOCUMENTAL<br>
KLUANE DRILLING ECUADOR - <?= date('Y') ?>

</td>

</tr>

</table>

</body>
</html>