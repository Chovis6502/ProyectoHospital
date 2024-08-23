<?php
include('configuracion.php');

$mensaje_error = "";
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $age = $_POST['age'];

    // Manejo de la foto de perfil
    $profile_photo = "";
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = basename($_FILES["profile_photo"]["name"]);
        }
    }

    // Verificar si el correo electrónico ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $mensaje_error = "El correo electrónico ya está registrado. Por favor, utiliza otro correo.";
    } else {
        // Si no existe, insertar el nuevo registro
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, password, profile_photo, age) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $first_name, $last_name, $phone, $email, $password, $profile_photo, $age);
        
        if ($stmt->execute()) {
            $mensaje_exito = "Registro exitoso. Puedes iniciar sesión ahora.";
        } else {
            $mensaje_error = "Error en el registro: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .registro-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            position: relative;
            box-sizing: border-box;
            overflow-y: auto; /* Permite el desplazamiento vertical */
            max-height: 80vh; /* Ajusta la altura máxima del contenedor */
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 150px;
            height: auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="file"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
        }
        button:hover {
            background: #0056b3;
        }
        .mensaje-error, .mensaje-exito {
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            box-sizing: border-box;
            z-index: 1; /* Asegura que el mensaje esté encima del formulario */
        }
        .mensaje-error {
            color: red;
            background: #fdd;
        }
        .mensaje-exito {
            color: green;
            background: #dff0d8;
        }
        form {
            position: relative;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <div class="logo-container">
            <img src="imss_bienestar.png" alt="IMSS Bienestar">
        </div>
        <h2>Registro de Personal del Hospital General de Pachuca</h2>
        
        <?php if (!empty($mensaje_error)): ?>
            <div class="mensaje-error"><?php echo $mensaje_error; ?></div>
        <?php elseif (!empty($mensaje_exito)): ?>
            <div class="mensaje-exito"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>
        
        <form action="registro_proceso.php" method="post" enctype="multipart/form-data">
            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
            
            <label for="last_name">Apellidos:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
            
            <label for="phone">Número de Teléfono:</label>
            <input type="text" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="profile_photo">Foto de Perfil:</label>
            <input type="file" id="profile_photo" name="profile_photo">
            
            <label for="age">Edad:</label>
            <input type="number" id="age" name="age" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>">
            
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
