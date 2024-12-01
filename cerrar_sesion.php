<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, también se debe eliminar la cookie de sesión.
// Nota: Esto destruirá la sesión, no solo los datos de la sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión.
session_destroy();

// Redirigir al usuario a la página de inicio de sesión o a la página principal
header("Location: login.html");
exit();
?>
