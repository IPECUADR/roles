<?php
require_once '../sys/sys.conf.php';

header('Content-Type: application/json');
session_start();

try {

    //========================================
    // VALIDAR SESIÓN
    //========================================

    $us = $_SESSION['user'] ?? null;

    if (empty($us)) {
        throw new Exception("La sesión ha expirado.");
    }

    //========================================
    // VALIDAR ARCHIVO
    //========================================

    if (
        !isset($_FILES['archivo']) ||
        $_FILES['archivo']['error'] !== UPLOAD_ERR_OK
    ) {
        throw new Exception("No se recibió el archivo.");
    }

    $archivo = fopen($_FILES['archivo']['tmp_name'], "r");

    if (!$archivo) {
        throw new Exception("No fue posible leer el archivo.");
    }

    //========================================
    // CONTADORES
    //========================================

    $insertados = 0;
    $actualizados = 0;
    $noEncontrados = 0;
    $errores = [];

    //========================================
    // CONSULTAS
    //========================================

    $qPersona = $pdo->prepare("
        SELECT PK_persona
        FROM persona
        WHERE PK_persona  = :ci
        LIMIT 1
    ");

    $qExiste = $pdo->prepare("
        SELECT FK_vc
        FROM vacaciones
        WHERE FK_persona = :persona
        AND FK_perido = :periodo
        LIMIT 1
    ");

    $qInsert = $pdo->prepare("
        INSERT INTO vacaciones(

            FK_persona,
            FK_area,
            FK_perido,
            dias_gozados,
            dias_pendientes,
            t_per_v,
            ob_vc,
            fc_aut_reg,
            fc_up_reg,
            us_up_aut_vc,
            delete_us_vc,
            status_service

        )

        VALUES(

            :persona,
            :area,
            :periodo,
            :gozados,
            :pendientes,
            :total,
            :obs,
            NOW(),
            NOW(),
            :usuario,
            1,
            1

        )
    ");

    $qUpdate = $pdo->prepare("
        UPDATE vacaciones
        SET

            FK_area = :area,
            dias_gozados = :gozados,
            dias_pendientes = :pendientes,
            t_per_v = :total,
            ob_vc = :obs,
            us_up_aut_vc = :usuario,
            fc_up_reg = NOW()

        WHERE FK_persona = :persona
        AND FK_perido = :periodo
    ");

    //========================================
    // SALTAR CABECERA
    //========================================

    fgetcsv($archivo, 1000, ";");

    $pdo->beginTransaction();

    while (($fila = fgetcsv($archivo, 1000, ";")) !== false) {

        if (count($fila) < 7) {
            continue;
        }

        $ci         = trim($fila[0]);
        $area       = trim($fila[1]);
        $periodo    = trim($fila[2]);
        $gozados    = trim($fila[3]);
        $pendientes = trim($fila[4]);
        $total      = trim($fila[5]);
        $obs        = trim($fila[6]);

        if ($ci == "") {
            continue;
        }

        //========================================
        // BUSCAR PERSONA
        //========================================

        $qPersona->execute([
            ':ci' => $ci
        ]);

        $persona = $qPersona->fetch();

        if (!$persona) {

            $noEncontrados++;

            $errores[] = [
                'ci' => $ci,
                'mensaje' => 'No existe el colaborador.'
            ];

            continue;
        }

        $idPersona = $persona['PK_persona'];

        //========================================
        // EXISTE EL REGISTRO?
        //========================================

        $qExiste->execute([
            ':persona' => $idPersona,
            ':periodo' => $periodo
        ]);

        if ($qExiste->fetch()) {

            //======================
            // UPDATE
            //======================

            $qUpdate->execute([
                ':area'       => $area,
                ':gozados'    => $gozados,
                ':pendientes' => $pendientes,
                ':total'      => $total,
                ':obs'        => $obs,
                ':usuario'    => $us,
                ':persona'    => $idPersona,
                ':periodo'    => $periodo
            ]);

            $actualizados++;

        } else {

            //======================
            // INSERT
            //======================

            $qInsert->execute([
                ':persona'    => $idPersona,
                ':area'       => $area,
                ':periodo'    => $periodo,
                ':gozados'    => $gozados,
                ':pendientes' => $pendientes,
                ':total'      => $total,
                ':obs'        => $obs,
                ':usuario'    => $us
            ]);

            $insertados++;
        }

    }

    fclose($archivo);

    $pdo->commit();

    echo json_encode([
        'err' => false,
        'msg' => 'Carga masiva finalizada correctamente.',
        'insertados' => $insertados,
        'actualizados' => $actualizados,
        'no_encontrados' => $noEncontrados,
        'detalle' => $errores
    ]);

} catch (Exception $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}