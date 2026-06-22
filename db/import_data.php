<?php

require_once '../sys/sys.conf.php';

header('Content-Type: application/json');

if (!isset($_FILES['archivo'])) {
    echo json_encode(['err' => 1, 'mensaje' => 'Archivo no recibido']);
    exit;
}

$archivo = $_FILES['archivo']['tmp_name'];
$handle = fopen($archivo, 'r');

if (!$handle) {
    echo json_encode(['err' => 1, 'mensaje' => 'No se pudo abrir archivo']);
    exit;
}

// Saltar encabezado
fgetcsv($handle, 0, ';');

$pdo->beginTransaction();

try {

    $sql = "
    INSERT INTO rol_p (
        dias, valor_dia, sueldo_basico, sueldo_mensual,
        horas_extra, horas_adicionales, jornada_nocturna,
        sub_reposo_50, sub_reposo_25, sub_reposo_75,
        bn_avance_obra, bn_cumplimiento, bn_produccion, bn_navidad,
        vacaciones, ot_ing_ajust_sl, ot_ingresos, total_remuneracion,
        transporte, devoluciones, bono, votaciones,
        fondo_reserva_p, fon_reserva, decimo_t, decim_c, total_beneficios,
        aportes_iess, imp_renta, prestamo_quirografario,
        prestamo_hipotecario, prestamo_empresa, anticipo_sueldo,
        otrs_des_contable, pension_alimentos, ext_salud_conyuge, multas,
        des_ajuste_suledo, des_subcidio_iess_75, total_descuentos,
        liquido_pagar, FK_mes, observaciones, forma_pago,
        FK_persona, FK_firma, dias_dia, dias_noche, d_fest_dia,
        d_fest_noche, d_reposo, d_iess, d_vacaciones, t_dia,
        agencia, coment_2,
        up_aut_rol_in, up_aut_rol_up
    )
    VALUES (
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,
        NOW(), NOW()
    )";

    $stmt = $pdo->prepare($sql);

    $fila = 1;

    while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {

        $fila++;

        // ✅ Validar columnas
        if (count($data) != 56) {
            throw new Exception("Error en fila $fila: se esperaban 56 columnas y llegaron " . count($data));
        }

        // ✅ LIMPIAR DECIMALES AUTOMÁTICAMENTE
        foreach ($data as $k => $v) {
            if (is_string($v)) {
                $data[$k] = str_replace(',', '.', $v);
            }
        }

        [
            $dias,
            $valor_dia,
            $sueldo_basico,
            $sueldo_mensual,
            $horas_extra,
            $horas_adicionales,
            $jornada_nocturna,
            $sub_reposo_50,
            $sub_reposo_25,
            $sub_reposo_75,
            $bn_avance_obra,
            $bn_cumplimiento,
            $bn_produccion,
            $bn_navidad,
            $vacaciones,
            $ot_ing_ajust_sl,
            $ot_ingresos,
            $total_remuneracion,
            $transporte,
            $devoluciones,
            $bono,
            $votaciones,
            $fondo_reserva_p,
            $fon_reserva,
            $decimo_t,
            $decim_c,
            $total_beneficios,
            $aportes_iess,
            $imp_renta,
            $prestamo_quirografario,
            $prestamo_hipotecario,
            $prestamo_empresa,
            $anticipo_sueldo,
            $otrs_des_contable,
            $pension_alimentos,
            $ext_salud_conyuge,
            $multas,
            $des_ajuste_suledo,
            $des_subcidio_iess_75,
            $total_descuentos,
            $liquido_pagar,
            $FK_mes,
            $observaciones,
            $forma_pago,
            $FK_persona,
            $FK_firma,
            $dias_dia,
            $dias_noche,
            $d_fest_dia,
            $d_fest_noche,
            $d_reposo,
            $d_iess,
            $d_vacaciones,
            $t_dia,
            $agencia,
            $coment_2
        ] = $data;

        $stmt->execute([
            $dias,$valor_dia,$sueldo_basico,$sueldo_mensual,
            $horas_extra,$horas_adicionales,$jornada_nocturna,
            $sub_reposo_50,$sub_reposo_25,$sub_reposo_75,
            $bn_avance_obra,$bn_cumplimiento,$bn_produccion,$bn_navidad,
            $vacaciones,$ot_ing_ajust_sl,$ot_ingresos,$total_remuneracion,
            $transporte,$devoluciones,$bono,$votaciones,
            $fondo_reserva_p,$fon_reserva,$decimo_t,$decim_c,$total_beneficios,
            $aportes_iess,$imp_renta,$prestamo_quirografario,
            $prestamo_hipotecario,$prestamo_empresa,$anticipo_sueldo,
            $otrs_des_contable,$pension_alimentos,$ext_salud_conyuge,$multas,
            $des_ajuste_suledo,$des_subcidio_iess_75,$total_descuentos,
            $liquido_pagar,$FK_mes,$observaciones,$forma_pago,
            $FK_persona,$FK_firma,$dias_dia,$dias_noche,$d_fest_dia,
            $d_fest_noche,$d_reposo,$d_iess,$d_vacaciones,$t_dia,
            $agencia,$coment_2
        ]);
    }

    $pdo->commit();

    echo json_encode([
        'err' => 0,
        'mensaje' => 'Roles importados correctamente'
    ]);

} catch (Exception $e) {

    $pdo->rollBack();

    echo json_encode([
        'err' => 1,
        'mensaje' => $e->getMessage()
    ]);
}

fclose($handle);