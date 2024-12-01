<?php
require 'vendor/autoload.php'; // Incluye la autoload de Composer
require 'conexion.php'; // Incluye el archivo de conexión

use PhpOffice\PhpWord\TemplateProcessor;

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
            // Crear una instancia de TemplateProcessor y cargar la plantilla
            $templateProcessor = new TemplateProcessor('anexo_1.docx');
            

            
            // Reemplazar los marcadores de posición con los detalles del estudiante
            $templateProcessor->setValue('Id', htmlspecialchars($estudiante['id']));
            $templateProcessor->setValue('Pnombre', htmlspecialchars($estudiante['primer_nombre']));
            $templateProcessor->setValue('Snombre', htmlspecialchars($estudiante['segundo_apellido']));
            $templateProcessor->setValue('Papellido', htmlspecialchars($estudiante['primer_apellido']));
            $templateProcessor->setValue('Sapellido', htmlspecialchars($estudiante['segundo_apellido']));
            
            // Guardar el documento temporalmente
            $fileName = 'Detalles_Estudiante_' . $estudiante['id'] . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $templateProcessor->saveAs($tempFile);

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
