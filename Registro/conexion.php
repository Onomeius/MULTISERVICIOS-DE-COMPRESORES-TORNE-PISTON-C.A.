<?php
// Cambia estos datos según tu configuración
$host = 'localhost';
$user = 'root'; // Cambia si tu usuario es diferente
$password = ''; // Cambia si tu contraseña es diferente
$dbname = 'compresores_bd'; // Cambia si tu base de datos es diferente

// Crear conexión
$conexion = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
