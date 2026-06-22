<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;

$client = new Client();
$client->setClientId('159762568886-9scg56aoohc2mng7640clo688ap6cv3f.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://kluane.itdospuntocero.net/ROLES/mail/oauth2callback.php');

$client->setScopes([Gmail::GMAIL_SEND]);
$client->setAccessType('offline');
$client->setPrompt('consent');

if (!isset($_GET['code'])) {
    die('No llegó el code');
}

// Intercambio FINAL
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

echo '<pre>';
print_r($token);