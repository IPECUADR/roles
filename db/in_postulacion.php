<?php

header('Content-Type: application/json; charset=utf-8');
session_start();

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido'
    ]);
    exit;
}

require_once '../sys/sys.post.php';

try {

    /*
    |--------------------------------------------------------------------------
    | VALIDAR DATOS RECIBIDOS
    |--------------------------------------------------------------------------
    */

    if (!isset($_POST['register'])) {
        throw new Exception('No se recibió información del postulante');
    }

    $rg = json_decode($_POST['register'], true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception(
            'JSON inválido: ' . json_last_error_msg()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LIMPIAR DATOS
    |--------------------------------------------------------------------------
    */

    $nombres   = trim($rg['nombres'] ?? '');
    $apellidos = trim($rg['apellidos'] ?? '');
    $celular   = trim($rg['celular'] ?? '');
    $direccion = trim($rg['direccion'] ?? '');
    $cedula    = trim($rg['cedula'] ?? '');
    $email     = trim($rg['email'] ?? '');

    // NUEVOS CAMPOS
    $fechaNacimiento = trim($rg['fechaNacimiento'] ?? '');
    $nacionalidad    = trim($rg['nacionalidad'] ?? '');

    $provincia = isset($rg['provincia']['value'])
        ? (int)$rg['provincia']['value']
        : null;

    $canton = isset($rg['canton']['value'])
        ? (int)$rg['canton']['value']
        : null;

    /*
    |--------------------------------------------------------------------------
    | VALIDACIONES
    |--------------------------------------------------------------------------
    */

    if (
        empty($nombres) ||
        empty($apellidos) ||
        empty($cedula) ||
        empty($email)
    ) {
        throw new Exception(
            'Complete todos los campos obligatorios'
        );
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception(
            'Correo electrónico inválido'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATOS GENERALES
    |--------------------------------------------------------------------------
    */

    $ip =
        $_SERVER['HTTP_CF_CONNECTING_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? null;

    $usuario   = 'PORTAL_WEB';
    $ubicacion = 'no data';

    /*
    |--------------------------------------------------------------------------
    | INICIAR TRANSACCIÓN
    |--------------------------------------------------------------------------
    */

    $pdo->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | BUSCAR POSTULANTE
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT PK_postulante
        FROM postulante
        WHERE ci_post = :cedula
        LIMIT 1
    ");

    $stmt->execute([
        ':cedula' => $cedula
    ]);

    $postulante = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR POSTULANTE
    |--------------------------------------------------------------------------
    */

    if ($postulante) {

        $id_postulante = $postulante['PK_postulante'];

        $sql = "
            UPDATE postulante SET
                nom_pst = :nombres,
                ap_pst = :apellidos,
                cel_pst = :celular,
                direccion_pst = :direccion,
                email = :email,
                FK_provincia = :provincia,
                FK_canton = :canton,
                FK_datos = 1,
                acptacion_pst = 2,
                ip_aut_pst_acp = :ip,
                ub_aut_pst_acp = :ubicacion,
                FK_est_post = 1,
                fc_aut_pst_up = NOW(),
                us_up_info_aut = :usuario,
                fc_up_us = NOW(),
                fc_nan_pst = :fc_nan,
                nacinalidad_pst = :nan
            WHERE PK_postulante = :id
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombres'   => $nombres,
            ':apellidos' => $apellidos,
            ':celular'   => $celular,
            ':direccion' => $direccion,
            ':email'     => $email,
            ':provincia' => $provincia,
            ':canton'    => $canton,
            ':ip'        => $ip,
            ':ubicacion' => $ubicacion,
            ':usuario'   => $usuario,
            ':id'        => $id_postulante,

            // NUEVOS CAMPOS
            ':fc_nan'    => $fechaNacimiento ?: null,
            ':nan'       => $nacionalidad ?: null
        ]);

        $accion = 'actualizada';

    } else {

        /*
        |--------------------------------------------------------------------------
        | INSERTAR POSTULANTE
        |--------------------------------------------------------------------------
        */

        $sql = "
            INSERT INTO postulante
            (
                nom_pst,
                ap_pst,
                cel_pst,
                direccion_pst,
                email,
                FK_provincia,
                FK_canton,
                FK_datos,
                acptacion_pst,
                ip_aut_pst_acp,
                ub_aut_pst_acp,
                ci_post,
                FK_est_post,
                fc_aut_pst_rg,
                fc_aut_pst_up,
                us_up_info_aut,
                fc_up_us,
                fc_del_us,
                fc_nan_pst,
                nacinalidad_pst
            )
            VALUES
            (
                :nombres,
                :apellidos,
                :celular,
                :direccion,
                :email,
                :provincia,
                :canton,
                1,
                2,
                :ip,
                :ubicacion,
                :cedula,
                1,
                NOW(),
                NOW(),
                :usuario,
                NOW(),
                NOW(),
                :fc_nan,
                :nan
            )
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombres'   => $nombres,
            ':apellidos' => $apellidos,
            ':celular'   => $celular,
            ':direccion' => $direccion,
            ':email'     => $email,
            ':provincia' => $provincia,
            ':canton'    => $canton,
            ':ip'        => $ip,
            ':ubicacion' => $ubicacion,
            ':cedula'    => $cedula,
            ':usuario'   => $usuario,

            // NUEVOS CAMPOS
            ':fc_nan'    => $fechaNacimiento ?: null,
            ':nan'       => $nacionalidad ?: null
        ]);

        $id_postulante = $pdo->lastInsertId();

        $accion = 'registrada';
    }

    /*
    |--------------------------------------------------------------------------
    | EXPERIENCIA
    |--------------------------------------------------------------------------
    */

    $puesto = trim(
        $rg['cargo_Experiencia'] ?? ''
    );

    $tiempo = $rg['tiempo_Experiencia']['value'] ?? null;

    $empresa = trim(
        $rg['empresa_Experiencia'] ?? ''
    );

    $descripcion = trim(
        $rg['descripcion_Experiencia'] ?? ''
    );

    $stmt = $pdo->prepare("
        SELECT FK_postulante
        FROM experiencia
        WHERE FK_postulante = :postulante
        LIMIT 1
    ");

    $stmt->execute([
        ':postulante' => $id_postulante
    ]);

    if ($stmt->fetch()) {

        $sql = "
            UPDATE experiencia SET
                puesto_expert = :puesto,
                FK_t_experiencia = :tiempo,
                emp_expert = :empresa,
                descrip = :descripcion
            WHERE FK_postulante = :postulante
        ";

    } else {

        $sql = "
            INSERT INTO experiencia
            (
                FK_postulante,
                puesto_expert,
                FK_t_experiencia,
                emp_expert,
                descrip
            )
            VALUES
            (
                :postulante,
                :puesto,
                :tiempo,
                :empresa,
                :descripcion
            )
        ";
    }

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':postulante'  => $id_postulante,
        ':puesto'      => $puesto,
        ':tiempo'      => $tiempo,
        ':empresa'     => $empresa,
        ':descripcion' => $descripcion
    ]);

    /*
    |--------------------------------------------------------------------------
    | EDUCACIÓN
    |--------------------------------------------------------------------------
    */

    $institucion = trim(
        $rg['institucion_Educativa'] ?? ''
    );

    $nivel = $rg['nivel']['value'] ?? null;

    $anioGraduacion = $rg['a_Graduacion'] ?? null;

    $stmt = $pdo->prepare("
        SELECT FK_postulante
        FROM educacion
        WHERE FK_postulante = :postulante
        LIMIT 1
    ");

    $stmt->execute([
        ':postulante' => $id_postulante
    ]);

    if ($stmt->fetch()) {

        $sql = "
            UPDATE educacion SET
                institucion_edu = :institucion,
                FK_nivel = :nivel,
                an_graduacion = :graduacion
            WHERE FK_postulante = :postulante
        ";

    } else {

        $sql = "
            INSERT INTO educacion
            (
                FK_postulante,
                institucion_edu,
                FK_nivel,
                an_graduacion
            )
            VALUES
            (
                :postulante,
                :institucion,
                :nivel,
                :graduacion
            )
        ";
    }

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':postulante'  => $id_postulante,
        ':institucion' => $institucion,
        ':nivel'       => $nivel,
        ':graduacion'  => $anioGraduacion
    ]);

    /*
    |--------------------------------------------------------------------------
    | CONFIRMAR TRANSACCIÓN
    |--------------------------------------------------------------------------
    */

    $pdo->commit();

    echo json_encode([
        'err'           => false,
        'icon'          => 'success',
        'id_postulante' => $id_postulante,
        'msg'           => "Postulación {$accion} correctamente"
    ]);

} catch (PDOException $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'err'   => true,
        'icon'  => 'error',
        'msg'   => 'Error en la base de datos',
        'error' => $e->getMessage()
    ]);

} catch (Exception $e) {

    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'err'   => true,
        'icon'  => 'error',
        'msg'   => $e->getMessage()
    ]);
}