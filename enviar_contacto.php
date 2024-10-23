<?php
// Conectar a la base de datos
$servername = "localhost"; // Cambia este valor si es necesario
$username = "root";
$password = "";
$dbname = "compresores_bd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

// Sanitizar los datos para evitar inyecciones SQL
$nombre = $conn->real_escape_string($nombre);
$email = $conn->real_escape_string($email);
$asunto = $conn->real_escape_string($asunto);
$mensaje = $conn->real_escape_string($mensaje);

// Insertar los datos en la tabla
$sql = "INSERT INTO contactos (nombre, email, asunto, mensaje) VALUES ('$nombre', '$email', '$asunto', '$mensaje')";

if ($conn->query($sql) === TRUE) {
  // Si la inserción es exitosa, enviar correo
  $destinatario = "brayaneherrera2000@gmail.com"; // Cambia a tu correo
  $titulo = "Nuevo contacto de proveedor - $asunto";
  $contenido = "
    Nombre: $nombre\n
    Email: $email\n
    Asunto: $asunto\n
    Mensaje: $mensaje\n
  ";

  // Cabeceras del correo
  $cabeceras = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "X-Mailer: PHP/" . phpversion();

  // Enviar el correo
  if (mail($destinatario, $titulo, $contenido, $cabeceras)) {
    echo "El correo ha sido enviado.";
  } else {
    echo "Error al enviar el correo.";
  }

  // Redirigir a index.html
  header("Location: index.html");
  exit(); // Asegurarse de detener el script después de la redirección
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
