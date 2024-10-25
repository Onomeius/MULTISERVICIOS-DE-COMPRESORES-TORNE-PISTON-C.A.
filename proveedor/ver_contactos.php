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

// Consulta para obtener los contactos
$sql = "SELECT * FROM contactos";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Tabla de Contactos</title>
        <link rel='stylesheet' href='css/tablas1.css'> <!-- Verifica esta ruta -->
    </head>
    <body>
        <div class='container'>
            <h1>Lista de Contactos</h1>
            <table class='contact-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Estatus</th> <!-- Nueva columna de estatus -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";

    // Iterar sobre los resultados y crear filas en la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['nombre']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['asunto']) . "</td>
                <td>" . htmlspecialchars($row['mensaje']) . "</td>
                <td>" . $row['fecha'] . "</td>
                <td>" . htmlspecialchars($row['estatus']) . "</td> <!-- Mostrar el estatus -->
                <td>
                    <a class='btn' href='editar.php?id=" . $row['id'] . "'>Cambiar</a> | 
                    <a class='btn' href='eliminar.php?id=" . $row['id'] . "'>Eliminar</a>
                </td>
              </tr>";
    }

    echo "    </tbody>
            </table>
        </div>
    </body>
    </html>";

} else {
    echo "<div class='container'><p>No hay contactos disponibles.</p></div>";
}

$conn->close();
?>
