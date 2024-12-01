<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Verificar si se han enviado los datos del formulario
if (isset($_POST['id']) && isset($_POST['direccion']) && isset($_POST['email']) && isset($_POST['telefono'])) {
    $id = $_POST['id'];
    $nombre = $_POST['direccion'];
    $email = $_POST['email'];
    $edad = $_POST['telefono'];

    // Consulta SQL para actualizar el estudiante
    $sql = "UPDATE estudiantes SET direccion = :direccion, email = :email, telefono = :telefono WHERE id = :id";

    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);
        
        // Vincular los parámetros
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':direccion', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $edad, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Estudiante actualizado exitosamente.";
            header("Location: buscar_estudiante.php?id=$id&status=success");
        } else {
            echo "Error al actualizar el estudiante.";
        }
    } catch(PDOException $e) {
        echo "Error al actualizar el estudiante: " . $e->getMessage();
    }
} else {
    echo "Datos del formulario incompletos.";
    exit();
}
?>
