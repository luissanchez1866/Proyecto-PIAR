<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Host de la base de datos
$dbname = 'proyecto_piar'; // Nombre de la base de datos
$username = 'root'; // Nombre de usuario de MySQL
$password = ''; // Contraseña de MySQL

// Intentar establecer la conexión
try {
    // Crear una nueva conexión PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar el modo de error de PDO para mostrar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "¡Conexión exitosa a la base de datos!";
} catch(PDOException $e) {
    // Si hay algún error, mostrar el mensaje de error
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
