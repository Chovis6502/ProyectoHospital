<?php
// Asegúrate de ajustar la ruta según tu estructura de directorios
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir archivo de configuración
include('configuracion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Dirección de correo electrónico no válida.";
        exit();
    }

    // Preparar la consulta para verificar el correo electrónico
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Generar token de recuperación
        $token = bin2hex(random_bytes(50));
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'gioginu@gmail.com';  // Tu correo de Gmail
            $mail->Password = 'Chovis0605';  // Tu contraseña de Gmail o token de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente
            $mail->setFrom('gioginu@gmail.com', 'Soporte Tecnico');
            $mail->addAddress($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body    = 'Haz clic en el siguiente enlace para recuperar tu contraseña: <a href="http://localhost/Programa%20Hospital/enviar_link_contrase%C3%B1a.php' . $token . '">Recuperar Contraseña</a>';

            // Enviar correo
            $mail->send();
            echo 'Se ha enviado un enlace de recuperación a tu correo.';
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "El correo electrónico no está registrado.";
    }
    $stmt->close();
}
?>
