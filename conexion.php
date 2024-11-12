<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$password = ""; // Asegúrate de que sea correcto
$base_de_datos = "compresores_bd";

// Crea la conexión
$conn = new mysqli($host, $usuario, $password, $base_de_datos);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// La conexión se mantendrá abierta para que se pueda usar en otros scripts.
?>
