<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($email);
        $stmt->fetch();

        // Actualizar la contraseña en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Eliminar el token usado
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "La contraseña ha sido restablecida.";
    } else {
        echo "Token inválido.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        /* Incluye el CSS para que el diseño sea consistente */
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Restablecer Contraseña</h2>
        <form method="post" action="">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <input type="password" name="password" placeholder="Nueva Contraseña" required>
            <input type="submit" value="Restablecer Contraseña">
        </form>
    </div>
</body>
</html>
