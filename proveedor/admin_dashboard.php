<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol_id'] != 2) {
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
    } elseif (isset($_POST['cambiar_clave'])) {
        $correo_usuario = $_POST['correo_usuario'];

        // Verificar si el usuario seleccionado es el superadministrador
        if ($correo_usuario === 'superadmin@correo.com') { // Reemplaza con el correo real del superadmin
            echo "<script>alert('No se puede cambiar la clave del superadministrador.');</script>";
        } else {
            $nueva_clave = $_POST['nueva_clave'];

            // Encriptar la nueva clave en SHA-256
            $nueva_clave_encriptada = hash('sha256', $nueva_clave);

            $sql = "UPDATE usuarios SET clave_encriptada = ? WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nueva_clave_encriptada, $correo_usuario);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Clave cambiada exitosamente.');</script>";
        }
    } elseif (isset($_POST['editar_contacto'])) {
        // Lógica para editar contacto
        $id_contacto = $_POST['id_contacto'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $asunto = $_POST['asunto'];
        $mensaje = $_POST['mensaje'];
        $estatus = $_POST['estatus'];

        $sql = "UPDATE contactos SET nombre = ?, email = ?, asunto = ?, mensaje = ?, estatus = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $email, $asunto, $mensaje, $estatus, $id_contacto);
        $stmt->execute();
        $stmt->close();
    }
}

// Obtener contactos de la base de datos
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);

// Obtener usuarios para cambiar claves
$sql_usuarios = "SELECT correo FROM usuarios";
$result_usuarios = $conn->query($sql_usuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        nav {
            background-color: #4CAF50; /* Color verde */
            color: white;
            padding: 1rem;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-between; /* Espacio entre los elementos */
            flex-wrap: wrap; /* Asegura que los elementos se ajusten en pantallas pequeñas */
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Efecto hover */
        }

        .btn {
            background-color: #f44336; /* Color rojo para el botón */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #e53935; /* Efecto hover para el botón */
        }

        /* Estilo para encabezados */
        h1, h2 {
            color: #333;
        }

        /* Estilo para tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .responsive-form {
            display: flex;
            flex-direction: column; /* Apilar los elementos verticalmente */
            max-width: 400px; /* Ancho máximo del formulario */
            margin: 20px auto; /* Centramos el formulario en la página */
            padding: 20px; /* Espaciado interno */
            border: 1px solid #ddd; /* Bordes suaves */
            border-radius: 4px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo */
        }

        .responsive-form label {
            margin-bottom: 5px; /* Espaciado entre etiqueta y campo */
        }

        .responsive-form select,
        .responsive-form input[type="password"],
        .responsive-form button {
            margin-bottom: 15px; /* Espaciado entre campos */
            padding: 10px; /* Espaciado interno */
            border: 1px solid #ccc; /* Bordes suaves */
            border-radius: 4px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño de fuente */
            width: 100%; /* Ocupa todo el ancho disponible */
        }

        .responsive-form button {
            background-color: #4CAF50; /* Color de fondo del botón */
            color: white; /* Color del texto */
            cursor: pointer; /* Cambia el cursor al pasar por encima */
        }

        .responsive-form button:hover {
            background-color: #45a049; /* Efecto hover del botón */
        }

        /* Media query para pantallas más pequeñas */
        @media (max-width: 600px) {
            .responsive-form {
                max-width: 90%; /* Ocupa un 90% del ancho en pantallas pequeñas */
            }
        }
    </style>
</head>
<body>
<nav>
    <ul>
        <li><a href="admin_dashboard.php">Inicio</a></li>
        <li><a href="contactos_admin.php">Contactos</a></li>
        <li><a href="responder_contactoadmin.php">Responder</a></li>
        <li><a href="ver_respuestasadmin.php">Ver Respuestas</a></li>
        <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
    </ul>
</nav>

<h1>Gestión de Usuarios y Contactos</h1>

<h2>Cambiar Contraseña de Usuario</h2>
<form method="POST" class="responsive-form">
    <label for="correo_usuario">Correo del usuario:</label>
    <select name="correo_usuario" required>
        <option value="">Selecciona un usuario</option>
        <?php while ($usuario = $result_usuarios->fetch_assoc()) { ?>
            <option value="<?php echo htmlspecialchars($usuario['correo']); ?>"><?php echo htmlspecialchars($usuario['correo']); ?></option>
        <?php } ?>
    </select>
    <label for="nueva_clave">Nueva clave:</label>
    <input type="password" name="nueva_clave" required>
    <button type="submit" name="cambiar_clave">Cambiar Clave</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
