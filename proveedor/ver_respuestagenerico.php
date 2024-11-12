<?php
// Información de conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Simulación de la autenticación del usuario
session_start();
$_SESSION['rol'] = 1; // Establecer rol 1 en la sesión

// Verificar el rol del usuario
$rol_usuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
$roles_permitidos = [1, 2, 3]; // Roles permitidos para acceder a esta página

if ($rol_usuario && in_array($rol_usuario, $roles_permitidos)) {
    // Consultar los datos de la tabla respuestas y realizar un JOIN con contactos
    $sql = "
        SELECT r.id AS respuesta_id, c.id AS contacto_id, c.nombre, c.email, r.respuesta, r.fecha_envio 
        FROM respuestas r 
        JOIN contactos c ON r.id_contacto = c.id
    ";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Respuestas</title>
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
</head>
<body>
<nav class="nav">
        <ul>
        <li><a href="generico_dashboard.php">Volver</a></li>
        </ul>
    </nav>

<h2>Respuestas Registradas</h2>

<table>
    <tr>
        <th>ID Respuesta</th>
        <th>ID Contacto</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Respuesta</th>
        <th>Fecha de Envío</th>
    </tr>
    <?php
    // Verificar si hay resultados y mostrarlos
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['respuesta_id']}</td>
                    <td>{$row['contacto_id']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['respuesta']}</td>
                    <td>{$row['fecha_envio']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No hay respuestas registradas.</td></tr>";
    }
    ?>
</table>

<?php
// Cerrar conexión
$conn->close();
} else {
    // Mensaje de acceso denegado
    echo "<h2>Acceso denegado. No tienes permiso para ver esta página.</h2>";
}
?>

</body>
</html>
