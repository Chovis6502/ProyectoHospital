<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        die("Las contraseñas no coinciden.");
    }

    // Hash de la nueva contraseña
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Verificar el token y obtener el user_id
    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires >= ?");
    $stmt->bind_param("ss", $token, date("U"));
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    if ($user_id) {
        // Actualizar la contraseña en la tabla de usuarios
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();

        // Eliminar el token de la tabla password_resets
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        echo "Tu contraseña ha sido restablecida exitosamente.";
    } else {
        echo "El enlace de recuperación es inválido o ha expirado.";
    }

    $stmt->close();
    $conn->close();
}
?>
