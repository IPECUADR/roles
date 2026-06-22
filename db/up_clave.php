<?php
session_start();

header('Content-Type: application/json');

// Bloquear acceso directo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'err' => true,
        'msg' => 'Método no permitido',
        'icon' => 'error'
    ]);
    exit;
}

// Conexión
require_once '../sys/sys.conf.php';

// Usuario en sesión
$us = $_SESSION['user'] ?? null;

if (!$us) {
    echo json_encode([
        'err' => true,
        'msg' => 'Sesión no válida',
        'icon' => 'error'
    ]);
    exit;
}

// Datos recibidos
$pass_actual    = trim($_POST['pass_actual'] ?? '');
$pass_nueva     = trim($_POST['pass_nueva'] ?? '');
$pass_confirmar = trim($_POST['pass_confirmar'] ?? '');

// Validaciones básicas
if ($pass_actual === '' || $pass_nueva === '' || $pass_confirmar === '') {
    echo json_encode([
        'err' => true,
        'msg' => 'Complete todos los campos',
        'icon' => 'info'
    ]);
    exit;
}

if ($pass_nueva !== $pass_confirmar) {
    echo json_encode([
        'err' => true,
        'msg' => 'La nueva contraseña y la confirmación no coinciden',
        'icon' => 'error'
    ]);
    exit;
}

try {
    // Obtener contraseña actual del usuario
    $stmt = $pdo->prepare("

        SELECT
            clave_p

        FROM
            persona

        WHERE
            user_p = :us

        LIMIT 1
    ");

    $stmt->execute([
        ':us' => $us
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            'err' => true,
            'msg' => 'No se encontró el usuario',
            'icon' => 'error'
        ]);
        exit;
    }

    // Validar contraseña actual
    if (!password_verify($pass_actual, $data['clave_p'])) {
        echo json_encode([
            'err' => true,
            'msg' => 'La contraseña actual es incorrecta',
            'icon' => 'error'
        ]);
        exit;
    }

    // Generar nuevo hash
    $new_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);

    // Actualizar contraseña
    $stmt = $pdo->prepare("

        UPDATE persona
        SET
            clave_p = :clave

        WHERE
            user_p = :us

    ");

    $stmt->execute([
        ':clave' => $new_hash,
        ':us'    => $us
    ]);

    echo json_encode([
        'err' => false,
        'msg' => 'Contraseña actualizada correctamente',
        'icon' => 'success'
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al actualizar la contraseña',
        'icon' => 'error'
    ]);
}