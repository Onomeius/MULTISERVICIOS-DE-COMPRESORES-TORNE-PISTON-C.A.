<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol_id'] != 1) {
    header("Location: Masterlogin.php");
    exit();
}

// Configuración de conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

$conn = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejo de acciones del formulario
$alertMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: Masterlogin.php");
        exit();
    } elseif (isset($_POST['editar_usuario'])) {
        // Lógica para editar usuario
        $correo_usuario = $_POST['correo_usuario'];
        $nueva_clave = $_POST['nueva_clave'];
        $nueva_clave_encriptada = hash('sha256', $nueva_clave);

        $sql = "UPDATE usuarios SET clave_encriptada = ? WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nueva_clave_encriptada, $correo_usuario);
        if ($stmt->execute()) {
            $alertMessage = "La clave del usuario ha sido actualizada con éxito.";
        } else {
            $alertMessage = "Error al actualizar la clave.";
        }
        $stmt->close();
    } elseif (isset($_POST['desactivar_usuario'])) {
        // Lógica para desactivar usuario
        $correo_usuario = $_POST['correo_usuario_desactivar'];
        $sql = "UPDATE usuarios SET estado = 0 WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo_usuario);
        if ($stmt->execute()) {
            $alertMessage = "El usuario ha sido desactivado.";
        } else {
            $alertMessage = "Error al desactivar el usuario.";
        }
        $stmt->close();
    } elseif (isset($_POST['reactivar_usuario'])) {
        // Lógica para reactivar usuario
        $correo_usuario = $_POST['correo_usuario_reactivar'];
        $sql = "UPDATE usuarios SET estado = 1 WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo_usuario);
        if ($stmt->execute()) {
            $alertMessage = "El usuario ha sido reactivado.";
        } else {
            $alertMessage = "Error al reactivar el usuario.";
        }
        $stmt->close();
    }
}

// Obtener contactos de la base de datos, solo usuarios activos
$sql = "SELECT * FROM usuarios WHERE estado = 1";
$result = $conn->query($sql);

// Obtener contactos inactivos
$sql_inactivos = "SELECT * FROM usuarios WHERE estado = 0";
$result_inactivos = $conn->query($sql_inactivos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            color: #333;
        }

        .nav {
            background-color: #4CAF50;
            padding: 10px;
        }

        .nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-around;
        }

        .nav ul li {
            flex: 1;
        }

        .nav ul li a {
            text-decoration: none;
            color: white;
            padding: 10px;
            display: block;
            text-align: center;
        }

        .nav ul li a:hover {
            background-color: #45a049;
        }

        form {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button.btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button.btn:hover {
            background-color: #45a049;
        }

        .contact-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-table th, .contact-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .contact-table th {
            background-color: #4CAF50;
            color: white;
        }

        .contact-table tr:hover {
            background-color: #f5f5f5;
        }

        @media (max-width: 600px) {
            .nav ul {
                flex-direction: column;
            }

            .contact-table, .contact-table thead, .contact-table tbody, .contact-table th, .contact-table td, .contact-table tr {
                display: block;
            }

            .contact-table th {
                display: none;
            }

            .contact-table tr {
                margin-bottom: 15px;
            }

            .contact-table td {
                text-align: right;
                position: relative;
                padding-left: 50%;
            }

            .contact-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 10px;
                text-align: left;
                font-weight: bold;
            }
        }
    </style>
    <script>
        window.onload = function() {
            <?php if ($alertMessage): ?>
                alert('<?php echo addslashes($alertMessage); ?>');
            <?php endif; ?>
        };
    </script>
</head>
<body>
    <nav class="nav">
        <ul>
            <li><a href="superadmin_dashboard.php">Inicio</a></li>
            <li><a href="contactos.php">Contactos</a></li>
            <li><a href="responder_contactosuper.php">Responder</a></li>
            <li><a href="ver_respuestassuper.php">Ver Respuestas</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <h1>Gestión de Usuarios</h1>

    <h2>Editar Usuario</h2>
    <form method="POST">
        <label for="correo_usuario">Correo del usuario:</label>
        <input type="email" name="correo_usuario" required>
        <label for="nueva_clave">Nueva clave:</label>
        <input type="password" name="nueva_clave" required>
        <button type="submit" name="editar_usuario" class="btn">Actualizar</button>
    </form>

    <h2>Desactivar Usuario</h2>
    <form method="POST">
        <label for="correo_usuario_desactivar">Correo del usuario a desactivar:</label>
        <input type="email" name="correo_usuario_desactivar" required>
        <button type="submit" name="desactivar_usuario" class="btn">Desactivar</button>
    </form>

    <h2>Reactivar Usuario</h2>
    <form method="POST">
        <label for="correo_usuario_reactivar">Correo del usuario a reactivar:</label>
        <input type="email" name="correo_usuario_reactivar" required>
        <button type="submit" name="reactivar_usuario" class="btn">Reactivar</button>
    </form>

    <h2>Tabla de Usuarios Activos</h2>
    <table class="contact-table">
        <thead>
            <tr>
                <th>Correo</th>
                <th>Rol ID</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td data-label="Correo"><?php echo htmlspecialchars($row['correo']); ?></td>
                    <td data-label="Rol ID"><?php echo htmlspecialchars($row['rol_id']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Tabla de Usuarios Inactivos</h2>
    <table class="contact-table">
        <thead>
            <tr>
                <th>Correo</th>
                <th>Rol ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_inactivos->fetch_assoc()) { ?>
                <tr>
                    <td data-label="Correo"><?php echo htmlspecialchars($row['correo']); ?></td>
                    <td data-label="Rol ID"><?php echo htmlspecialchars($row['rol_id']); ?></td>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Empresa</p>
    </footer>

    <?php $conn->close(); ?>
</body>
</html>
