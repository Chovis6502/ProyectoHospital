<?php
$servername = "localhost";
$username = "root"; // o el nombre de usuario que estés utilizando
$password = "admin"; // la contraseña de MySQL, si la tienes
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>