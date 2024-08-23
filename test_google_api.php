<?php
require 'vendor/autoload.php'; // Carga las dependencias de Composer

use Google\Client as GoogleClient;

// Crear una instancia de Google Client
$client = new GoogleClient();

// Configurar el cliente (solo como ejemplo, puedes añadir configuraciones según tus necesidades)
$client->setApplicationName('Test Google API Client');
$client->setDeveloperKey('YOUR_DEVELOPER_KEY'); // Reemplaza con tu clave de desarrollador si es necesario

echo 'Google API Client está instalado y funcionando correctamente.';
?>
