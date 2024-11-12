<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'compresores_bd');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los servicios
$sql = "SELECT icono, nombre AS titulo, descripcion FROM servicios";
$result = $conexion->query($sql);

// Inicializar el array de servicios
$servicios = array();

if ($result->num_rows > 0) {
    // Salida de cada fila
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row; // Agregar cada servicio al array
    }
} else {
    echo "No hay servicios disponibles.";
}

// Cerrar la conexión
$conexion->close();
?>
