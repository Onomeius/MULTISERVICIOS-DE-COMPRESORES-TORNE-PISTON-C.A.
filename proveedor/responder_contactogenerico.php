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
$_SESSION['rol'] = 3; // Establecer rol 3 en la sesión

// Verificar el rol del usuario
$rol_usuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
$roles_permitidos = [1, 2, 3]; // Roles permitidos para acceder a esta página

if ($rol_usuario && in_array($rol_usuario, $roles_permitidos)) {
    // Manejar el envío del formulario
    $mensaje = ''; // Variable para el mensaje de éxito o error

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir datos del formulario
        $id_contacto = $_POST['id_contacto'];
        $respuesta = $_POST['respuesta'];

        // Validar los datos
        if (!empty($id_contacto) && !empty($respuesta)) {
            // Preparar la consulta para insertar la respuesta
            $stmt = $conn->prepare("INSERT INTO respuestas (id_contacto, respuesta) VALUES (?, ?)");
            $stmt->bind_param("is", $id_contacto, $respuesta);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $mensaje = "Respuesta enviada correctamente.";
            } else {
                $mensaje = "Error al enviar la respuesta: " . $stmt->error;
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            $mensaje = "Por favor, complete todos los campos.";
        }
    }

    // Consulta para obtener los contactos
    $result = $conn->query("SELECT id, nombre FROM contactos");
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Respuestas</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
            h1 {
                color: #333;
                text-align: center;
            }
            .nav {
                background-color: #4CAF50;
                padding: 10px;
                text-align: center;
            }
            .nav ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
            .nav ul li {
                flex: 1;
            }
            .nav ul li a {
                text-decoration: none;
                color: white;
                padding: 10px 15px;
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
                margin: 20px auto;
                max-width: 500px;
            }
            label {
                display: block;
                margin-bottom: 5px;
                color: #555;
            }
            select, textarea, input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }
            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #45a049;
            }
            @media (max-width: 600px) {
                .nav ul {
                    flex-direction: column;
                }
            }
        </style>
        <script>
            window.onload = function() {
                <?php if ($mensaje): ?>
                    alert('<?php echo addslashes($mensaje); ?>');
                <?php endif; ?>
            };
        </script>
    </head>
    <body>
        <nav class="nav">
            <ul>
                <li><a href="generico_dashboard.php">Volver</a></li>
            </ul>
        </nav>
        <h1>Enviar Respuesta</h1>
        
        <form method="POST" action="">
            <label for="id_contacto">Seleccionar Contacto:</label>
            <select name="id_contacto" id="id_contacto" required>
                <option value="">Seleccione un contacto</option>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay contactos disponibles</option>";
                }
                ?>
            </select>

            <label for="respuesta">Respuesta:</label>
            <textarea name="respuesta" id="respuesta" rows="4" required></textarea>

            <input type="submit" value="Enviar Respuesta">
        </form>

        <?php
        // Cerrar conexión
        $conn->close();
        ?>
    </body>
    </html>

    <?php
} else {
    echo "<script>
            alert('No tienes permisos para acceder a esta página.');
            window.location.href = 'Masterlogin.php'; // Redirigir al menú principal
          </script>";
}
?>
