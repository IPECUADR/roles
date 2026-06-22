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

try {
    $stmt = $pdo->prepare("

        SELECT
            persona.nom_p,
            persona.ap_p,
            persona.ci_p,
            persona.dir_p,
            persona.email,
            persona.telf_p,
            persona.user_p,
            cargo.cargo_cg,
            proyecto.proyecto,
            t_user.t_user

        FROM
            persona,
            cargo,
            proyecto,
            t_user

        WHERE
            cargo.PK_cg = persona.FK_cg
            and proyecto.PK_pro = persona.FK_pro
            and t_user.PK_t_user = persona.FK_t_user
            and persona.user_p = :us

        LIMIT 1
    ");

    $stmt->execute([
        ':us' => $us
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            'err' => true,
            'msg' => 'No se encontró información del usuario',
            'icon' => 'info'
        ]);
        exit;
    }

    echo json_encode([
        'err' => false,
        'data' => $data
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());

    echo json_encode([
        'err' => true,
        'msg' => 'Error al consultar la información del perfil',
        'icon' => 'error'
    ]);
}
