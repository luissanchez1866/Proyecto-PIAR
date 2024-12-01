<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

try {
    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $primer_nombre = $_POST['primer_nombre'];
        $segundo_nombre = $_POST['segundo_nombre'];
        $primer_apellido = $_POST['primer_apellido'];
        $segundo_apellido = $_POST['segundo_apellido'];
        $direccion = $_POST['direccion'];

        // Preparar la consulta SQL
        $sql = "INSERT INTO estudiantes ( primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion) 
                VALUES (:primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :direccion)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':primer_nombre', $primer_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':segundo_nombre', $segundo_nombre, PDO::PARAM_STR);
        $stmt->bindParam(':primer_apellido', $primer_apellido, PDO::PARAM_STR);
        $stmt->bindParam(':segundo_apellido', $segundo_apellido, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        header("Location: registro_estudiantes.php?status=success");
        exit();
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}
?>
