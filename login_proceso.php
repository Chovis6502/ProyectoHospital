<?php
session_start();
include('config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $hashed_password);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    header("Location: profile.php");
} else {
    echo "Correo electrónico o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
