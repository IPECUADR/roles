<?php
header('Content-Type: application/json');
session_start();

// 🔒 Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido'
    ]);
    exit;
}

// 🔌 Conexión
require_once '../sys/sys.conf.php';

// 👤 Sesión
$us = $_SESSION['user'] ?? null;
$id = $_SESSION['pk_p'] ?? null;

// 📥 POST
$email = $_POST['email'] ?? null;
$passPlain = $_POST['pass'] ?? null;

// 🔐 Validaciones básicas
if (!$us || !$id) {
    echo json_encode([
        'err' => true,
        'msg' => 'Sesión no válida'
    ]);
    exit;
}

if (!$email || !$passPlain) {
    echo json_encode([
        'err' => true,
        'msg' => 'Datos incompletos'
    ]);
    exit;
}

// 🔐 Hash password
$pass = password_hash($passPlain, PASSWORD_DEFAULT);

// 🌐 IP
$ip = $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? '0.0.0.0';

// 📍 Ubicación (placeholder)
$ubicacion = 'No definida';

try {

    /* ===================================================
       ✅ VALIDAR EMAIL ÚNICO (excepto el propio usuario)
       =================================================== */
    $sqlValidaEmail = "
        SELECT 1
        FROM persona
        WHERE email = :email
          AND PK_persona <> :id
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sqlValidaEmail);
    $stmt->execute([
        ':email' => $email,
        ':id'    => $id
    ]);

    if ($stmt->fetch()) {
        echo json_encode([
            'err'  => true,
            'msg'  => 'El correo electrónico ya se encuentra registrado',
            'icon' => 'warning'
        ]);
        exit;
    }

    /* ===================================================
       🔄 TRANSACCIÓN
       =================================================== */
    $pdo->beginTransaction();

    // 1️⃣ UPDATE PERSONA
    $sqlPersona = "
        UPDATE persona
        SET email   = :email,
            clave_p = :pass
        WHERE PK_persona = :id
    ";
    $stmt = $pdo->prepare($sqlPersona);
    $stmt->execute([
        ':email' => $email,
        ':pass'  => $pass,
        ':id'    => $id
    ]);

    // 2️⃣ INSERT ACEPTACIÓN
    $sqlAceptacion = "
        INSERT INTO acpetacion_user (
            aceptacion_fromal,
            coments_acf,
            in_au_fc_acp,
            up_au_fc_acp,
            user_up_aut,
            ip_au_user,
            ub_au_user,
            FK_persona,
            FK_us_ser
        ) VALUES (
            'Acepto',
            'Se me compartió la información necesaria en el portal.',
            NOW(),
            NOW(),
            :usuario,
            :ip,
            :ubicacion,
            :persona,
            3
        )
    ";
    $stmt = $pdo->prepare($sqlAceptacion);
    $stmt->execute([
        ':usuario'   => $us,
        ':ip'        => $ip,
        ':ubicacion' => $ubicacion,
        ':persona'   => $id
    ]);

    // ✅ Confirmar todo
    $pdo->commit();

    echo json_encode([
        'err'  => false,
        'msg'  => 'Contraseña actualizada y aceptación registrada correctamente',
        'icon' => 'success'
    ]);

} catch (Throwable $e) {

    // ❌ Revertir cambios
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());

    echo json_encode([
        'err'  => true,
        'msg'  => 'Error al procesar la solicitud',
        'icon' => 'error'
    ]);
}