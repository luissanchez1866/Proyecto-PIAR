<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

try {
    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $estudiante_id = $_POST['estudiante_id'];
        $fecha = $_POST['fecha'];
        $tipo_intervencion = $_POST['tipo_intervencion'];
        $descripcion = $_POST['descripcion'];

        // Preparar la consulta SQL
        $sql = "INSERT INTO intervenciones (estudiante_id, fecha, tipo_intervencion, descripcion) 
                VALUES (:estudiante_id, :fecha, :tipo_intervencion, :descripcion)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':estudiante_id', $estudiante_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_intervencion', $tipo_intervencion, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        header("Location: registro_intervencion.php?status=success");
        exit();
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}
?>
