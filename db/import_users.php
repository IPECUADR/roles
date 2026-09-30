<?php

require_once '../sys/sys.conf.php';

header('Content-Type: application/json; charset=utf-8');

// ======================================================
// VALIDAR ARCHIVO
// ======================================================

if (!isset($_FILES['archivo'])) {

    echo json_encode([
        'err' => 1,
        'mensaje' => 'Archivo no recibido'
    ]);

    exit;
}

if ($_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {

    echo json_encode([
        'err' => 1,
        'mensaje' => 'Error al subir el archivo'
    ]);

    exit;
}


// ======================================================
// ABRIR ARCHIVO
// ======================================================

$archivo = $_FILES['archivo']['tmp_name'];

$handle = fopen($archivo, 'r');

if (!$handle) {

    echo json_encode([
        'err' => 1,
        'mensaje' => 'No se pudo abrir el archivo'
    ]);

    exit;
}


// ======================================================
// LEER ENCABEZADO
// ======================================================

$encabezado = fgetcsv($handle, 0, ';');

if ($encabezado === false) {

    fclose($handle);

    echo json_encode([
        'err' => 1,
        'mensaje' => 'El archivo está vacío'
    ]);

    exit;
}


// ======================================================
// VALIDAR ENCABEZADO
// ======================================================

$encabezadoEsperado = [
    'PK_persona',
    'nom_p',
    'ap_p',
    'ci_p',
    'dir_p',
    'email',
    'telf_p',
    'user_p',
    'clave_p',
    'firm_p',
    'firma_pr',
    'FK_cg',
    'FK_t_user',
    'FK_pro',
    'status_p'
];


// Limpiar BOM UTF-8 del primer campo
if (isset($encabezado[0])) {
    $encabezado[0] = preg_replace('/^\xEF\xBB\xBF/', '', $encabezado[0]);
}


if ($encabezado !== $encabezadoEsperado) {

    fclose($handle);

    echo json_encode([
        'err' => 1,
        'mensaje' => 'El encabezado del archivo no coincide con el formato esperado',
        'esperado' => $encabezadoEsperado,
        'recibido' => $encabezado
    ]);

    exit;
}


// ======================================================
// TRANSACCIÓN
// ======================================================

$pdo->beginTransaction();

try {

    // ==================================================
    // SQL
    // ==================================================

    $sql = "
        INSERT INTO persona (
            PK_persona,
            nom_p,
            ap_p,
            ci_p,
            dir_p,
            email,
            telf_p,
            user_p,
            clave_p,
            firm_p,
            firma_pr,
            FK_cg,
            FK_t_user,
            FK_pro,
            status_p
        )
        VALUES (
            ?,?,?,?,?,?,
            ?,?,?,?,?,?,
            ?,?,?
        )
    ";

    $stmt = $pdo->prepare($sql);


    // ==================================================
    // CONTADOR
    // ==================================================

    $fila = 1;
    $importados = 0;


    // ==================================================
    // RECORRER CSV
    // ==================================================

    while (($data = fgetcsv($handle, 0, ';')) !== false) {

        $fila++;


        // ==============================================
        // IGNORAR FILAS VACÍAS
        // ==============================================

        if (
            count($data) === 1 &&
            trim($data[0]) === ''
        ) {
            continue;
        }


        // ==============================================
        // VALIDAR COLUMNAS
        // ==============================================

        if (count($data) !== 15) {

            throw new Exception(
                "Error en fila $fila: se esperaban 15 columnas y llegaron " .
                count($data)
            );
        }


        // ==============================================
        // LIMPIAR DATOS
        // ==============================================

        foreach ($data as $k => $v) {

            if (is_string($v)) {
                $data[$k] = trim($v);
            }
        }


        // ==============================================
        // ASIGNAR VARIABLES
        // ==============================================

        [
            $PK_persona,
            $nom_p,
            $ap_p,
            $ci_p,
            $dir_p,
            $email,
            $telf_p,
            $user_p,
            $clave_p,
            $firm_p,
            $firma_pr,
            $FK_cg,
            $FK_t_user,
            $FK_pro,
            $status_p
        ] = $data;


        // ==============================================
        // VALIDAR CAMPOS OBLIGATORIOS
        // ==============================================

        if (
            $PK_persona === '' ||
            $nom_p === '' ||
            $ap_p === '' ||
            $ci_p === '' ||
            $email === '' ||
            $user_p === '' ||
            $clave_p === ''
        ) {

            throw new Exception(
                "Error en fila $fila: existen campos obligatorios vacíos"
            );
        }


        // ==============================================
        // VALIDAR DUPLICADO EN BASE DE DATOS
        // ==============================================

        $sqlExiste = "
            SELECT PK_persona
            FROM persona
            WHERE PK_persona = ?
               OR ci_p = ?
               OR user_p = ?
            LIMIT 1
        ";

        $stmtExiste = $pdo->prepare($sqlExiste);

        $stmtExiste->execute([
            $PK_persona,
            $ci_p,
            $user_p
        ]);

        $existe = $stmtExiste->fetch(PDO::FETCH_ASSOC);


        if ($existe) {

            throw new Exception(
                "Error en fila $fila: ya existe una persona con PK_persona, cédula o usuario registrado"
            );
        }


        // ==============================================
        // HASH DE CLAVE
        // ==============================================

        $clave_hash = password_hash(
            $clave_p,
            PASSWORD_DEFAULT
        );


        if ($clave_hash === false) {

            throw new Exception(
                "Error en fila $fila: no se pudo generar el hash de la contraseña"
            );
        }


        // ==============================================
        // INSERTAR
        // ==============================================

        $stmt->execute([

            $PK_persona,
            $nom_p,
            $ap_p,
            $ci_p,
            $dir_p,
            $email,
            $telf_p,
            $user_p,
            $clave_hash,
            $firm_p,
            $firma_pr,
            $FK_cg,
            $FK_t_user,
            $FK_pro,
            $status_p

        ]);


        $importados++;
    }


    // ==================================================
    // CONFIRMAR
    // ==================================================

    $pdo->commit();


    echo json_encode([
        'err' => 0,
        'mensaje' => 'Personas importadas correctamente',
        'importados' => $importados
    ]);


} catch (Exception $e) {


    // ==================================================
    // DESHACER
    // ==================================================

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }


    echo json_encode([
        'err' => 1,
        'mensaje' => $e->getMessage(),
        'fila' => $fila ?? null
    ]);
}


// ======================================================
// CERRAR ARCHIVO
// ======================================================

fclose($handle);