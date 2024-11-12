<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol_id'] != 3) {
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
    }
}

// Obtener contactos de la base de datos
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Responsiva</title>
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

        /* Media query para pantallas más pequeñas */
        @media (max-width: 600px) {
            table {
                display: block; /* Cambia la tabla a bloque */
                overflow-x: auto; /* Agrega desplazamiento horizontal */
                white-space: nowrap; /* Evita que el texto se ajuste */
                margin-top: 0; /* Ajusta el margen en móviles */
            }

            thead {
                display: none; /* Oculta el encabezado en móviles */
            }

            tr {
                display: flex; /* Cambia las filas a flex */
                flex-direction: column; /* Apila los elementos verticalmente */
                margin-bottom: 15px; /* Espaciado entre filas */
                border: 1px solid #ddd; /* Bordes para las filas */
                border-radius: 8px; /* Bordes redondeados para filas */
                background-color: white; /* Color de fondo para filas */
            }

            td {
                display: flex; /* Cambia las celdas a flex */
                justify-content: space-between; /* Espacio entre elementos */
                padding: 10px; /* Espaciado interno */
                border-bottom: 1px solid #ddd; /* Bordes inferiores */
            }

            td:last-child {
                border-bottom: none; /* Elimina el borde inferior de la última celda */
            }

            td:before {
                content: attr(data-label); /* Usar el atributo data-label para mostrar la etiqueta */
                font-weight: bold; /* Negrita para etiquetas */
                margin-right: 10px; /* Espacio entre etiqueta y contenido */
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="generico_dashboard.php">Inicio</a></li>
            <li><a href="responder_contactogenerico.php">Responder</a></li>
            <li><a href="ver_respuestagenerico.php">Ver Respuestas</a></li>
            <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <h1>Lista de Mensajes</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td data-label="ID"><?php echo htmlspecialchars($row['id']); ?></td>
                    <td data-label="Nombre"><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td data-label="Asunto"><?php echo htmlspecialchars($row['asunto']); ?></td>
                    <td data-label="Mensaje"><?php echo htmlspecialchars($row['mensaje']); ?></td>
                    <td data-label="Fecha"><?php echo htmlspecialchars($row['fecha']); ?></td>
                    <td data-label="Estatus"><?php echo htmlspecialchars($row['estatus']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
