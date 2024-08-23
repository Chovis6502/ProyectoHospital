<?php
session_start();
include('config.php');

// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener la información del usuario a editar
$user_id = $_GET['id'];
$stmt = $conn->prepare("SELECT first_name, last_name, phone, email, age, folio FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $phone, $email, $age, $folio);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="update_user.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label for="first_name">Nombre:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
        
        <label for="last_name">Apellidos:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
        
        <label for="phone">Teléfono:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        <label for="age">Edad:</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>">
        
        <label for="folio">Folio:</label>
        <input type="text" id="folio" name="folio" value="<?php echo htmlspecialchars($folio); ?>">
        
        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
