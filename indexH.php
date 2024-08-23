<?php
session_start();
include('configuracion.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registros de Personal del Hospital General de Pachuca</title>
    <style>
        /* General */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Gris claro */
        }

        .container {
            width: 80%;
            margin: 0 auto;
            overflow: hidden;
        }

        /* Header */
        header {
            background: #006D77; /* Verde IMSS */
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        nav ul {
            padding: 0;
            list-style: none;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Main Content */
        main {
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        /* Form Styles */
        form {
            margin: 20px 0;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background: #006D77; /* Verde IMSS */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background: #004D40; /* Un verde más oscuro para el hover */
        }

        /* Footer */
        footer {
            background: #006D77; /* Verde IMSS */
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
            font-size: 0.9em;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            nav ul li {
                display: block;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Sistema de Registros de Personal del Hospital General de Pachuca</h1>
    </header>
    <nav id="sidebar">
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="history.php">Ver Historial</a></li>
            <li><a href="login.php">Cerrar Sesión</a></li>
            <li><a href="imss_bienestar.php">IMSS Bienestar</a></li>
        </ul>
    </nav>
    <main>
        <h2>Bienvenido</h2>
        <!-- Aquí puedes agregar contenido principal -->
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Registros de Personal del Hospital General de Pachuca</p>
    </footer>
</body>
</html>
