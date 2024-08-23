<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo-container img {
            height: 50px;
            margin: 10px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: inline-block;
            text-align: left;
            width: 100%;
            max-width: 600px;
        }
        .form-container h2 {
            margin-top: 0;
            color: #6e8efb;
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .form-container input[type="text"], 
        .form-container input[type="email"], 
        .form-container input[type="password"], 
        .form-container input[type="file"], 
        .form-container input[type="number"] {
            width: calc(100% - 22px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #6e8efb;
            color: #fff;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        .form-container button:hover {
            background-color: #5a7cf4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="imss_bienestar.png" alt="Logotipo IMSS Bienestar">
        </div>
        <div class="form-container">
            <h2>Registro de Personal del Hospital General de Pachuca</h2>
            <form action="registro_proceso.php" method="post" enctype="multipart/form-data">
                <label for="first_name">Nombre:</label>
                <input type="text" id="first_name" name="first_name" required>
                <label for="last_name">Apellidos:</label>
                <input type="text" id="last_name" name="last_name" required>
                <label for="phone">Número de Teléfono:</label>
                <input type="text" id="phone" name="phone">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <label for="profile_photo">Foto de Perfil:</label>
                <input type="file" id="profile_photo" name="profile_photo">
                <label for="age">Edad:</label>
                <input type="number" id="age" name="age">
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
</body>
</html>
