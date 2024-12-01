<?php
require 'vendor/autoload.php'; // Incluye la autoload de Composer
require 'conexion.php'; // Incluye el archivo de conexión

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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
            // Crear una nueva instancia de PHPWord
            $phpWord = new PhpWord();
            
            // Agregar una nueva sección
            $section = $phpWord->addSection();
            
            // Agregar el título
            $section->addTitle('Detalles del Estudiante', 1);
            
            // Agregar los detalles del estudiante
            $section->addText('ID: ' . $estudiante['id']);
            $section->addText('Nombre: ' . $estudiante['primer_nombre']);
            $section->addText('Apellido: ' . $estudiante['primer_apellido']);
            $section->addText('Email: ' . $estudiante['email']);
            
            // Guardar el documento
            $fileName = 'Detalles_Estudiante_' . $estudiante['id'] . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $phpWord->save($tempFile, 'Word2007');

            // Forzar la descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            readfile($tempFile);
            unlink($tempFile);
            exit();
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
