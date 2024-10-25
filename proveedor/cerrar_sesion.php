<?php
session_start(); // Iniciar sesión
session_unset(); // Descartar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir a la página de inicio de sesión
header("Location: Masterlogin.php");
exit();
?>
