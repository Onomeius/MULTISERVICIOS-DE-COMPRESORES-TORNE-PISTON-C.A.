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

// Verificar si se ha enviado el ID del contacto
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener el contacto
    $sql = "SELECT * FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el contacto
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $email = $row['email'];
        $asunto = $row['asunto'];
        $mensaje = $row['mensaje'];
        $estatus = $row['estatus'];
    } else {
        echo "Contacto no encontrado.";
        exit;
    }
} else {
    echo "ID no especificado.";
    exit;
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    $estatus = $_POST['estatus'];

    // Consulta para actualizar el contacto
    $sql = "UPDATE contactos SET nombre = ?, email = ?, asunto = ?, mensaje = ?, estatus = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $email, $asunto, $mensaje, $estatus, $id);

    if ($stmt->execute()) {
        echo "Contacto actualizado con éxito.";
        header("Location: contactos.php"); // Redirigir a la lista de contactos
        exit;
    } else {
        echo "Error al actualizar el contacto: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Contacto</h1>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="asunto">Asunto:</label>
            <input type="text" id="asunto" name="asunto" value="<?php echo htmlspecialchars($asunto); ?>" required>

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" required><?php echo htmlspecialchars($mensaje); ?></textarea>

            <label for="estatus">Estatus:</label>
            <select id="estatus" name="estatus">
                <option value="Respondido" <?php if ($estatus == 'Respondido') echo 'selected'; ?>>Respondido</option>
                <option value="En Proceso" <?php if ($estatus == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                <option value="Pendiente" <?php if ($estatus == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            </select>

            <input type="submit" value="Actualizar Contacto">
        </form>
    </div>
</body>
</html>

