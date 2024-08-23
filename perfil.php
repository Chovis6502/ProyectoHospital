<?php
session_start();
include('configuracion.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, phone, email, profile_picture, age, folio FROM users WHERE id = ?");
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $phone, $email, $profile_picture, $age, $folio);
$stmt->fetch();

if (empty($profile_picture)) {
    $profile_picture = 'default.png'; // Ruta a una imagen predeterminada
}

session_write_close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["new_profile_picture"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["new_profile_picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["new_profile_picture"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["new_profile_picture"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->bind_param("si", $target_file, $user_id);
            $stmt->execute();
            $stmt->close();
            header("Location: perfil.php");
            exit();
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "El archivo no es una imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F3F4F6;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 50px;
        }
        .logo-container img {
            max-width: 350px;
            height: auto;
        }
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 100px;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }
        .profile-photo-container {
            text-align: center;
        }
        .profile-photo-container form {
            margin-top: 15px;
        }
        .profile-photo-container form input[type="file"] {
            display: none;
        }
        .profile-photo-container label {
            background-color: #006D77; /* Color verde */
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
        }
        .profile-details {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #F3F4F6;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-details h1 {
            color: #006D77;
            margin-bottom: 20px;
            text-align: center;
        }
        .profile-details p {
            margin: 10px 0;
            color: #333;
            font-size: 16px;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .actions a, .actions input[type="submit"] {
            background-color: #006D77; /* Color verde */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
        .actions a:hover, .actions input[type="submit"]:hover {
            background-color: #004D40; /* Un verde más oscuro para el hover */
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="imss_bienestar.png" alt="IMSS Bienestar">
    </div>
    <div class="profile-container">
        <div class="profile-photo-container">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Foto de Perfil">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="new_profile_picture" id="new_profile_picture">
                <label for="new_profile_picture">Cambiar Foto de Perfil</label>
            </form>
        </div>
        <div class="profile-details">
            <h1>Perfil de Usuario</h1>
            <p>Nombre: <?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></p>
            <p>Teléfono: <?php echo htmlspecialchars($phone); ?></p>
            <p>Correo Electrónico: <?php echo htmlspecialchars($email); ?></p>
            <p>Edad: <?php echo htmlspecialchars($age); ?></p>
            <p>Folio: <?php echo htmlspecialchars($folio); ?></p>
            <div class="actions">
                <a href="editar_perfil.php">Editar Perfil</a> <!-- Botón Editar Perfil -->
                <a href="logout.php">Cerrar Sesión</a> <!-- Botón Cerrar Sesión -->
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
