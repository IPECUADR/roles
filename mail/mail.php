<?php
header('Content-Type: application/json');

try {

    require_once '../sys/sys.conf.php';

    $nombres = $_POST['nombres'] ?? '';
    $correo  = $_POST['mail'] ?? '';
    $id      = $_POST['id'] ?? '';
    $us      = $_POST['us'] ?? '';

    if (empty($nombres) || empty($correo) || empty($id) || empty($us)) {
        throw new Exception('Datos incompletos');
    }

    // ✅ Generar token
    $token = random_int(100000, 999999);

    // ✅ Expiración 10 minutos
    $token_expira = date('Y-m-d H:i:s', time() + 600);

    // ✅ INICIO TRANSACCIÓN (importante)
    $pdo->beginTransaction();

    // ✅ DESACTIVAR tokens activos del usuario
    $sqlUpdate = "
        UPDATE token
        SET 
            estado_token = 0,
            up_aut_us_token = :us,
            fc_aut_up_token = NOW()
        WHERE FK_persona = :id
          AND estado_token = 1
    ";

    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([
        ':id' => $id,
        ':us' => $us
    ]);

    // ✅ INSERT nuevo token
    $sqlInsert = "
        INSERT INTO token (
            token,
            estado_token,
            FK_persona,
            token_expira,
            in_aut_us_token,
            up_aut_us_token,
            fc_aut_in_token
        ) VALUES (
            :tk,
            1,
            :id,
            :fc,
            :us,
            'n/a',
            NOW()
        )
    ";

    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':tk' => $token,
        ':id' => $id,
        ':fc' => $token_expira,
        ':us' => $us
    ]);

    // ✅ Confirmar transacción
    $pdo->commit();

    // ✅ Validar inserción REAL
    if ($stmtInsert->rowCount() === 0) {
        throw new Exception('No se pudo generar el token');
    }

    /* 🔽 DESDE AQUÍ TU CÓDIGO SIGUE EXACTO 🔽 */

    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/services/GmailService.php';

    date_default_timezone_set('America/Guayaquil');

    $gmailService = new GmailService();

    $solicitud = 'RECUPERAR CONTRASEÑA';
    $fecha = date('d/m/Y');

    $template = file_get_contents(__DIR__ . '/templates/soporte.html');
    if ($template === false) {
        throw new Exception('No se pudo cargar la plantilla');
    }

    $html = str_replace(
        ['{{solicitud}}', '{{nombre}}', '{{fecha}}', '{{token}}'],
        [
            htmlspecialchars($solicitud, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($nombres, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($token, ENT_QUOTES, 'UTF-8')
        ],
        $template
    );

    $asunto = mb_encode_mimeheader(
        'Recuperación de contraseña',
        'UTF-8',
        'B'
    );

    $gmailService->send($correo, $asunto, $html);

    echo json_encode([
        'err' => false,
        'msg' => 'Se ha enviado un correo de verificación'
    ]);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'err' => true,
        'msg' => $e->getMessage()
    ]);
}
