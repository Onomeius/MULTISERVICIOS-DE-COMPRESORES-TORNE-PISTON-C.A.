<?php
// index.php

// Incluir el archivo de conexión
$result = include('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Contactos</title>
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
            overflow: hidden;
        }
        .nav a {
            float: right;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .nav a:hover {
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
        .btn {
    display: inline-block; /* Permitir el uso de margin */
    background-color: #4CAF50; /* Color de fondo */
    color: white; /* Color del texto */
    padding: 10px 15px; /* Espaciado interno */
    border-radius: 4px; /* Bordes redondeados */
    text-decoration: none; /* Quitar subrayado */
    margin-bottom: 10px; /* Espaciado entre los enlaces */
    transition: background-color 0.3s; /* Suavizar la transición de color */
}

.btn:hover {
    background-color: #45a049; /* Color de fondo al pasar el mouse */
}

        @media (max-width: 600px) {
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
    <div class="nav">
        <!-- Botón de volver -->
        <a href="admin_dashboard.php">Volver</a>
    </div>
    <div class="container">
        <h1>Lista de Solicitudes</h1>
        <table class="contact-table">
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
            <tbody>
                <?php
                // Verificar si hay resultados
                if ($result && $result->num_rows > 0) {
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
                                    <a class='btn' href='editar.php?id=" . $row['id'] . "'>Cambiar</a> 
                                    <a class='btn' href='eliminar.php?id=" . $row['id'] . "'>Eliminar</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay contactos disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
