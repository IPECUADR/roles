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


// 
$id = $_POST['rcu'] ?? null;
$passPlain = $_POST['pass'] ?? null;



if (!$id || !$passPlain) {
    echo json_encode([
        'err' => true,
        'msg' => 'Datos incompletos'
    ]);
    exit;
}

// 🔐 Hash password
$pass = password_hash($passPlain, PASSWORD_DEFAULT);





try {

 

    // Actualizar contraseña
    $stmt = $pdo->prepare("

        UPDATE persona
        SET
            clave_p = :clave

        WHERE
            user_p = :us

    ");

    $stmt->execute([
        ':clave' => $pass,
        ':us'    => $id
    ]);



    $data = $stmt->fetchAll();


        if (empty($data)) {
            echo json_encode([
                'error' => true,
                'msg' => 'Su solicitud no se pudo procesar.', 
                'icon' => 'error'
            ]);
            exit;
        }

        
    echo json_encode($data);




} catch (Throwable $e) {

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