<?php
// Incluir el archivo de conexión
require 'conexion.php';

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
    } catch(PDOException $e) {
        echo "Error al recuperar la información del estudiante: " . $e->getMessage();
    }
} else {
    echo "No se ha proporcionado un ID de estudiante.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Estudiante</title>
</head>
<body>
    <h2>Detalles del Estudiante</h2>
    <?php if ($estudiante): ?>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($estudiante['id']); ?></p>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($estudiante['nombre']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($estudiante['email']); ?></p>
        <p><strong>Edad:</strong> <?php echo htmlspecialchars($estudiante['edad']); ?></p>
        <a href="lista_estudiantes.php">Volver a la lista</a>
        <a href="generar_pdf.php?id=<?php echo $estudiante['id']; ?>">Generar PDF</a>
        <a href="generar_pdf.php?id=<?php echo $estudiante['id']; ?>">Generar PDF</a>
        <a href="generar_word.php?id=<?php echo $estudiante['id']; ?>">Generar Word</a>
    <?php else: ?>
        <p>No se encontró información para el estudiante con ID: <?php echo htmlspecialchars($id); ?></p>
    <?php endif; ?>
</body>
</html>
