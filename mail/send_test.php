<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/services/GmailService.php';

$mail = new GmailService();

$mail->send(
    'sistemas.ti@kluane-ecuador.ec',
    '✅ Prueba Gmail API',
    '<h2>🔥 Funciona 🔥</h2><p>Correo enviado con Gmail API + PHP</p>'
);

echo '✅ Correo enviado correctamente';
