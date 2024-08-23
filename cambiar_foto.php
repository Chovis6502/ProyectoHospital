<?php
session_start();
include('configuracion.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    
    // Verifica si el archivo se subió sin errores
    if ($file['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($file['name']);
        $file_path = $upload_dir . $file_name;
        
        // Verifica el tipo de archivo permitido
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            echo "Tipo de archivo no permitido.";
            exit();
        }

        // Mueve el archivo a la carpeta de uploads
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Actualiza la base de datos con el nuevo nombre de archivo
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $file_name, $user_id);
            $stmt->execute();
            $stmt->close();
            
            // Redirige a la página de perfil
            header("Location: perfil.php");
            exit();
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
        echo "Error en la subida del archivo.";
    }
}

$conn->close();
?>
