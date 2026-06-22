<?php

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    private Gmail $gmail;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/google.php';

        $client = new Client();
        $client->setClientId($config['client_id']);
        $client->setClientSecret($config['client_secret']);
        $client->setAccessType('offline');
        $client->setScopes([Gmail::GMAIL_SEND]);

        if (empty($config['refresh_token'])) {
            throw new Exception('Refresh token no encontrado');
        }

        // ✅ Intercambiar refresh_token por access_token
        $token = $client->fetchAccessTokenWithRefreshToken(
            trim($config['refresh_token'])
        );

        // ✅ Validar respuesta de Google
        if (isset($token['error'])) {
            throw new Exception(
                'Error al refrescar token: ' . $token['error_description']
            );
        }

        // ✅ ASIGNAR token al cliente (ESTO FALTABA)
        $client->setAccessToken($token);

        $this->gmail = new Gmail($client);
    }

    public function send(string $to, string $subject, string $html): void
    {
        $raw =
            "To: {$to}\r\n" .
            "Subject: {$subject}\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=utf-8\r\n\r\n" .
            $html;

        $message = new Message();
        $message->setRaw(
            rtrim(strtr(base64_encode($raw), '+/', '-_'), '=')
        );

        $this->gmail->users_messages->send('me', $message);
    }
}
