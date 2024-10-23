<?php
// conexion.php

// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

$conn = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los contactos
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();

// Retornar el resultado
if ($result->num_rows > 0) {
    return $result;
} else {
    return null; // No hay resultados
}
?>
