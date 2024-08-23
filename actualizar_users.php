<?php
include('config.php');

// Obtener los datos del formulario
$user_id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$age = $_POST['age'];
$folio = $_POST['folio'];

// Actualizar los datos del usuario en la base de datos
$stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, email = ?, age = ?, folio = ? WHERE id = ?");
$stmt->bind_param("ssssssi", $first_name, $last_name, $phone, $email, $age, $folio, $user_id);
$stmt->execute();

// Redirigir de vuelta a la página de administración de usuarios
header("Location: admin_manage_users.php");
$stmt->close();
$conn->close();
?>
