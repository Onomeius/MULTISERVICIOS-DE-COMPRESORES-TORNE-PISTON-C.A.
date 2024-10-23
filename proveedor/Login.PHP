<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

$conn = new mysqli($host, $usuario, $password, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Datos del formulario de inicio de sesión
$correo = $_POST['correo'];
$clave = $_POST['clave'];

// Encriptar la clave ingresada para compararla con la clave encriptada en la base de datos
$clave_encriptada = hash('sha256', $clave);

// Consulta SQL para buscar el correo y la clave
$sql = "SELECT * FROM usuarios WHERE correo = ? AND clave_encriptada = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $clave_encriptada);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El usuario ha sido autenticado correctamente
    $usuario = $result->fetch_assoc();
    // Iniciar sesión
    session_start();
    $_SESSION['correo'] = $usuario['correo'];

    // Redirigir a Vista_1.html
    header("Location: contactos.php");
    exit(); // Asegúrate de llamar a exit después de header para detener la ejecución del script
} else {
    // El correo o la clave son incorrectos
    echo "Correo o clave incorrectos.";
}

$stmt->close();
$conn->close();
?>
