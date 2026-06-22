<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;

$client = new Client();
$client->setClientId('159762568886-9scg56aoohc2mng7640clo688ap6cv3f.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://kluane.itdospuntocero.net/ROLES/mail/oauth2callback.php');

// ✅ Scope
$client->setScopes([Gmail::GMAIL_SEND]);

// ✅ CLAVES para obtener refresh_token
$client->setAccessType('offline');
$client->setPrompt('consent');

// ✅ Redirigir a Google
header('Location: ' . $client->createAuthUrl());
exit;
