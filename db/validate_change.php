<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['err' => true]);
    exit;
}

date_default_timezone_set('America/Guayaquil');
require_once '../sys/sys.conf.php';

$email = $_POST['email'] ?? '';
$token = $_POST['token'] ?? '';
$id = $_POST['rcu'] ?? '';

if (empty($email) || empty($token)) {
    echo json_encode([
        'error' => true,
        'msg' => 'Datos incompletos'
    ]);
    exit;
}

try {

    $sql = "
        SELECT 
            token.token,
            token.FK_persona,
            token.token_expira
        FROM token
        INNER JOIN persona p ON p.PK_persona = token.FK_persona
        WHERE 
            p.email = :email
            AND token.token = :token
            AND token.estado_token = 1
            AND token.token_expira >= NOW()
            AND FK_persona = :id 
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':token' => $token, 
        ':id' => $id
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            'error' => true,
            'msg' => 'El código es inválido o ha expirado.',
            'icon' => 'error'
        ]);
        exit;
    }

    // ✅ Token válido
    echo json_encode([
        'error' => false,
        'msg' => 'Código verificado correctamente'
    ]);

} catch (Throwable $e) {
    error_log($e->getMessage());
    echo json_encode([
        'err' => true,
        'msg' => 'Error del servidor'
    ]);
}