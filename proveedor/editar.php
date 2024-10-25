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
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $asunto = trim($_POST['asunto']);
    $mensaje = trim($_POST['mensaje']);
    $estatus = $_POST['estatus'];

    // Validaciones del lado del servidor
    $errors = [];

    if (empty($nombre)) {
        $errors[] = "El nombre es obligatorio.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El formato del email es inválido.";
    }

    if (empty($asunto)) {
        $errors[] = "El asunto es obligatorio.";
    }

    if (empty($mensaje)) {
        $errors[] = "El mensaje es obligatorio.";
    }

    if (empty($errors)) {
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
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"],
        .btn-regresar {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            margin-right: 10px; /* Espacio entre botones */
        }

        input[type="submit"]:hover,
        .btn-regresar:hover {
            background: #218838;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            input[type="submit"],
            .btn-regresar {
                width: 100%;
                margin: 5px 0; /* Espacio en móviles */
            }
        }
    </style>
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
            <a href="contactos.php" class="btn-regresar">Regresar</a> <!-- Botón de regresar -->
        </form>
    </div>
</body>
</html>
