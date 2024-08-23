<?php
require_once 'vendor/autoload.php'; // Asegúrate de tener la biblioteca Google API Client instalada

$client = new Google_Client(['client_id' => 'YOUR_CLIENT_ID']); // Reemplaza con tu CLIENT_ID

$id_token = $_POST['id_token'];

try {
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
        $user_id = $payload['sub'];
        $email = $payload['email'];
        
        // Verifica si el usuario está registrado en tu base de datos
        // Si no está registrado, puedes crear una cuenta nueva
        
        // Inicia sesión para el usuario
        session_start();
        $_SESSION['user_id'] = $user_id;
        echo 'success';
    } else {
        echo 'Invalid ID token';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
