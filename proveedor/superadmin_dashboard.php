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
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['desactivar_usuario'])) {
        // Lógica para desactivar usuario
        $correo_usuario = $_POST['correo_usuario_desactivar'];
        $sql = "UPDATE usuarios SET estado = 0 WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo_usuario);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['reactivar_usuario'])) {
        // Lógica para reactivar usuario
        $correo_usuario = $_POST['correo_usuario_reactivar'];
        $sql = "UPDATE usuarios SET estado = 1 WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo_usuario);
        $stmt->execute();
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
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        .nav {
            background-color: #4CAF50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px 15px;
        }
        .nav a {
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            margin-left: 10px;
            flex: 1; /* Asegura que los enlaces ocupen espacio igualmente */
            text-align: center; /* Centra el texto de los enlaces */
        }
        .nav a:hover {
            background-color: #0056b3;
        }
        .nav .btn {
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none;
            margin-left: 10px; /* Añade margen a los botones */
        }
        .nav .btn:hover {
            background-color: #0056b3;
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
            .nav {
                flex-direction: column;
                align-items: stretch; /* Cambia la dirección de los elementos */
            }
            .nav a {
                flex: none; /* Evita que los enlaces se expandan */
                text-align: left; /* Alinea el texto a la izquierda en pantallas pequeñas */
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
</head>
<body>
        <style>
body {
    font-family: Arial, sans-serif; /* Tipografía general */
    background-color: #f4f4f4; /* Color de fondo suave */
    margin: 0;
    padding: 20px;
}

h1, h2 {
    color: #333; /* Color del texto de los encabezados */
}

form {
    background-color: white; /* Fondo blanco para los formularios */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra suave */
    padding: 20px; /* Espaciado interno */
    margin-bottom: 20px; /* Espaciado entre formularios */
}

label {
    display: block; /* Hacer que las etiquetas ocupen todo el ancho */
    margin-bottom: 5px; /* Espaciado entre la etiqueta y el input */
    color: #555; /* Color de las etiquetas */
}

input[type="email"],
input[type="password"] {
    width: 100%; /* Hacer que los inputs ocupen todo el ancho del formulario */
    padding: 10px; /* Espaciado interno */
    margin-bottom: 15px; /* Espaciado entre inputs */
    border: 1px solid #ccc; /* Borde del input */
    border-radius: 4px; /* Bordes redondeados */
    font-size: 16px; /* Tamaño de la fuente */
}

input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #4CAF50; /* Color de borde al enfocar */
    outline: none; /* Quitar el contorno predeterminado */
}

button.btn {
    background-color: #4CAF50; /* Color de fondo del botón */
    color: white; /* Color del texto */
    border: none; /* Sin borde */
    padding: 10px 15px; /* Espaciado interno */
    border-radius: 4px; /* Bordes redondeados */
    cursor: pointer; /* Cambiar el cursor al pasar el mouse */
    font-size: 16px; /* Tamaño de la fuente */
}

button.btn:hover {
    background-color: #45a049; /* Color de fondo al pasar el mouse */
}

        nav {
    background-color: #4CAF50; /* Color verdoso */
    padding: 10px;
}

nav ul {
    list-style-type: none; /* Eliminar los puntos de la lista */
    padding: 0;
    margin: 0;
    display: flex; /* Usar flexbox para el diseño horizontal */
    justify-content: space-around; /* Espaciado uniforme entre los elementos */
}

nav ul li {
    flex: 1; /* Permitir que los elementos de la lista se expandan igualmente */
}

nav ul li a {
    text-decoration: none; /* Eliminar el subrayado */
    color: white; /* Color del texto */
    padding: 10px;
    display: block; /* Hacer que el enlace ocupe todo el espacio del <li> */
    text-align: center; /* Centrar el texto */
}

nav ul li a:hover {
    background-color: #45a049; /* Color de fondo al pasar el mouse */
}

/* Estilos responsivos */
@media (max-width: 600px) {
    nav ul {
        flex-direction: column; /* Cambiar a columna en pantallas pequeñas */
    }

    nav ul li {
        text-align: center; /* Centrar el texto en pantallas pequeñas */
    }
}

    </style>
</head>
<body>
<nav>
    <ul>
        <li><a href="superadmin_dashboard.php">Inicio</a></li>
        <li><a href="contactos.php">Contactos</a></li>
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
                        <td data-label="Acciones">
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="correo_usuario_reactivar" value="<?php echo htmlspecialchars($row['correo']); ?>">
                                <button type="submit" name="reactivar_usuario" class="btn">Reactivar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
