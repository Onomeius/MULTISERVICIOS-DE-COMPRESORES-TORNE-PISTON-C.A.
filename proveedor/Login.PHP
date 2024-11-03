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

// Consulta SQL para buscar el usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    // Verificar la clave encriptada
    if (hash('sha256', $clave) === $usuario['clave_encriptada']) {
        // Iniciar sesión
        session_start();
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['rol_id'] = $usuario['rol_id']; // Guardamos el rol en la sesión

        // Redirigir según el rol
        switch ($usuario['rol_id']) {
            case 1: // Superadmin
                header("Location: superadmin_dashboard.php");
                break;
            case 2: // Admin
                header("Location: admin_dashboard.php");
                break;
            case 3: // Genérico
                header("Location: generico_dashboard.php");
                break;
            default:
                header("Location: index.html"); // Redirigir a una página por defecto
                break;
        }
        exit(); // Asegúrate de llamar a exit después de header para detener la ejecución del script
    } else {
        // Clave incorrecta
        echo "<script>alert('Correo o clave incorrectos.'); window.location.href = 'Masterlogin.php';</script>";
    }
} else {
    // Correo no encontrado
    echo "<script>alert('Correo o clave incorrectos.'); window.location.href = 'Masterlogin.php';</script>";
}

$stmt->close();
$conn->close();
?>
