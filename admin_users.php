<?php
session_start();
include('config.php');

// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener la lista de usuarios
$result = $conn->query("SELECT id, first_name, last_name, email, phone, age, folio FROM users");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Administrar Usuarios</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Edad</th>
                <th>Folio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['age']); ?></td>
                <td><?php echo htmlspecialchars($row['folio']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>">Editar</a> |
                    <a href="delete_user.php?id=<?php echo $row['id']; ?>">Eliminar</a> |
                    <a href="generate_pdf.php?id=<?php echo $row['id']; ?>">Generar PDF</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>

