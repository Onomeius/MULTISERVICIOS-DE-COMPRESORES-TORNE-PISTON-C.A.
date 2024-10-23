<?php
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

// Verificar si se ha enviado un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el contacto
    $sql = "DELETE FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Contacto eliminado correctamente. <a href='ver_contactos.php'>Volver a la lista</a>";
    } else {
        echo "Error al eliminar el contacto.";
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "ID no especificado.";
}

// Cerrar la conexión
$conn->close();
?>
