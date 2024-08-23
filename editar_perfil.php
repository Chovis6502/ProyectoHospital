<?php
session_start();
include('configuracion.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Inicializar variables
$first_name = '';
$last_name = '';
$phone = '';
$email = '';
$age = '';
$profile_picture = '';

// Obtener datos actuales del usuario
$stmt = $conn->prepare("SELECT first_name, last_name, phone, email, age, profile_picture FROM users WHERE id = ?");
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $phone, $email, $age, $profile_picture);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_phone = $_POST['phone'];
    $new_email = $_POST['email'];
    $new_age = $_POST['age'];

    // Actualizar la imagen de perfil si se selecciona una nueva
    if (isset($_FILES["new_profile_picture"]) && $_FILES["new_profile_picture"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["new_profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["new_profile_picture"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["new_profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = $target_file; // Actualiza la ruta de la imagen
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "El archivo no es una imagen.";
        }
    }

    // Actualizar la información del usuario en la base de datos
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ?, age = ?, profile_picture = ? WHERE id = ?");
    $stmt->bind_param("ssssisi", $new_first_name, $new_last_name, $new_phone, $new_email, $new_age, $profile_picture, $user_id);
    if ($stmt->execute()) {
        header("Location: perfil.php");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . htmlspecialchars($conn->error);
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .logo-container {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            height: 200px; /* Ajusta según el tamaño del logotipo */
            background-color: #fff; /* Fondo opcional */
        }
        .logo-container img {
            max-width: 70%; /* Ajusta la imagen para que no exceda el ancho del contenedor */
            height: auto; /* Mantiene las proporciones originales */
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 20px auto; /* Centra el contenedor del formulario */
        }
        .form-container h2 {
            text-align: center;
            color: #006D77;
            margin-top: 0;
        }
        .form-container label {
            display: block;
            margin: 15px 0 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #006D77;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #004D40;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="<?php echo htmlspecialchars($profile_picture ? $profile_picture : 'imss_bienestar.png'); ?>" alt="Logo IMSS Bienestar">
    </div>
    <div class="form-container">
        <h2>Editar Perfil</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="first_name">Nombre:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>

            <label for="last_name">Apellido:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>

            <label for="phone">Teléfono:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="age">Edad:</label>
            <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($age); ?>" required>

            <label for="new_profile_picture">Cambiar Foto de Perfil:</label>
            <input type="file" name="new_profile_picture" id="new_profile_picture">

            <input type="submit" value="Guardar Cambios">
        </form>
    </div>
</body>
</html>
