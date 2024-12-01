<?php
// Incluir el archivo de conexión
require 'conexion.php';

// Verificar si se ha enviado el formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    // Consulta SQL para seleccionar el usuario por su email
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario";

    
    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        
        // Vincular los parámetros
        $stmt->bindParam(':usuario', $usuario);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $usuario = $stmt->fetch();
        
        // Verificar si se encontró un usuario con ese email
        if ($usuario) {
            // Verificar si la contraseña ingresada coincide con la contraseña almacenada en la base de datos
            if (password_verify($password, $usuario['contraseña'])) {
                echo "¡Inicio de sesión exitoso!";
                // Redirigir a la página de inicio
                header("Location: index.php");
            } else {
                header("Location: login-Error.html");            }
        } else {
            echo "No se encontró ningún usuario con ese email.";
        }
    } catch(PDOException $e) {
        echo "Error al iniciar sesión: " . $e->getMessage();
    }
}
?>
