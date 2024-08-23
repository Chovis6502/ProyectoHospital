<?php
require('fpdf.php'); // Asegúrate de que la ruta a 'fpdf.php' sea correcta
include('config.php'); // Asegúrate de que 'config.php' contiene la conexión a la base de datos

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Datos del Usuario', 0, 1, 'C');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Verifica que 'id' esté presente en la solicitud y es un número entero
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Asegúrate de que $conn esté definido en 'config.php'
    if ($conn) {
        $stmt = $conn->prepare("SELECT first_name, last_name, phone, email, age, folio FROM users WHERE id = ?");
        
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($first_name, $last_name, $phone, $email, $age, $folio);
            $stmt->fetch();
            $stmt->close();
        } else {
            die('Error en la consulta SQL: ' . $conn->error);
        }
        
        $conn->close();
        
        // Crear y configurar el PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nombre: ' . htmlspecialchars($first_name . ' ' . $last_name));
        $pdf->Cell(0, 10, 'Teléfono: ' . htmlspecialchars($phone));
        $pdf->Cell(0, 10, 'Correo: ' . htmlspecialchars($email));
        $pdf->Cell(0, 10, 'Edad: ' . htmlspecialchars($age));
        $pdf->Cell(0, 10, 'Folio: ' . htmlspecialchars($folio));
        $pdf->Output();
    } else {
        die('Error en la conexión a la base de datos.');
    }
} else {
    die('ID de usuario no válido.');
}
?>
