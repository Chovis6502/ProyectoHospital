<?php
include('config.php');

$user_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

header("Location: admin_manage_users.php");
$stmt->close();
$conn->close();
?>
