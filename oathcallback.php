<?php
require 'vendor/autoload.php';

use Google\Client as GoogleClient;
use Google\Service\Oauth2 as GoogleOauth2;

session_start();

$client = new GoogleClient();
$client->setClientId('YOUR_CLIENT_ID'); // Reemplaza con tu ID de cliente
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Reemplaza con tu secreto de cliente
$client->setRedirectUri('http://localhost/Programa%20Hospital/oauth2callback.php'); // Reemplaza con tu URI de redirección
$client->addScope('profile');
$client->addScope('email');

if (!isset($_GET['code'])) {
    // Redirigir al usuario a Google para la autenticación
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
} else {
    // Intercambiar el código de autorización por un token
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $oauth2 = new GoogleOauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // Procesar la información del usuario y guardar en sesión
    $_SESSION['user'] = $userInfo;

    header('Location: index.php'); // Redirige al usuario a tu página principal
    exit();
}
?>
