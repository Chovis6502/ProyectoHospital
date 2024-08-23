<?php
session_start();
include('configuracion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_error = "Correo electrónico no válido.";
    } else {
        // Preparar la consulta
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();
            
            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                header("Location: indexH.php"); // Redirigir al usuario a la página principal
                exit();
            } else {
                $mensaje_error = "Credenciales incorrectas.";
            }
        } else {
            $mensaje_error = "Credenciales incorrectas.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6e8efb, #006D77);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 150px;
            height: auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="email"], input[type="password"], input[type="submit"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="email"], input[type="password"] {
            font-size: 16px;
            color: #333;
        }
        input[type="submit"] {
            background: #6e8efb;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background: #5a7cf4;
        }
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
        }
        .google-btn img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        .google-btn span {
            font-size: 14px;
            color: #333;
        }
        .login-links {
            margin-top: 20px;
        }
        .login-links a {
            color: #006D77;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }
        .login-links a:hover {
            text-decoration: underline;
        }
        .mensaje-error {
            color: red;
            background: #fdd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="imss_bienestar.png" alt="IMSS Bienestar">
        </div>
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar Sesión">
        </form>
        
        <!-- Botón de Google -->
        <div class="google-btn" onclick="window.location.href='tu-url-de-google-auth'">
            <img src="images.png" alt="Google Logo">
            <span>Iniciar sesión con Google</span>
        </div>

        <!-- Enlaces para "Olvidar Contraseña" y "Registrarse" -->
        <div class="login-links">
            <a href="olvide_contraseña.php">Recuperar Contraseña</a>
            <a href="registro.php">Registrarse</a>
        </div>
    </div>
</body>
</html>
