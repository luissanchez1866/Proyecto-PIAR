<?php
require 'fpdf.php'; // Incluye la biblioteca FPDF
require 'conexion.php';  // Incluye el archivo de conexión

// Verificar si se ha pasado un ID de estudiante a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para seleccionar el estudiante por su ID
    $sql = "SELECT * FROM estudiantes WHERE id = :id";

    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        
        // Vincular el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($estudiante) {
            // Crear una instancia de FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
            
            // Establecer la fuente
            $pdf->SetFont('Arial', 'B', 16);
            
            // Agregar el título
            $pdf->Cell(0, 10, 'Detalles del Estudiante', 0, 1, 'C');
            
            // Saltar línea
            $pdf->Ln(10);
            
            // Establecer la fuente para los detalles
            $pdf->SetFont('Arial', '', 12);
            
            // Agregar los detalles del estudiante
            $pdf->Cell(0, 10, 'ID: ' . $estudiante['id'], 0, 1);
            $pdf->Cell(0, 10, 'Nombre: ' . $estudiante['primer_nombre'], 0, 1);
            $pdf->Cell(0, 10, 'Apellido: ' . $estudiante['primer_apellido'], 0, 1);
            $pdf->Cell(0, 10, 'Email: ' . $estudiante['email'], 0, 1);
            
            // Generar el PDF
            $pdf->Output('I', 'Detalles_Estudiante_' . $estudiante['id'] . '.pdf');
        } else {
            echo "No se encontró información para el estudiante con ID: " . htmlspecialchars($id);
        }
    } catch(PDOException $e) {
        echo "Error al recuperar la información del estudiante: " . $e->getMessage();
    }
} else {
    echo "No se ha proporcionado un ID de estudiante.";
    exit();
}
?>
