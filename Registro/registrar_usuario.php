<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "compresores_bd";

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se han enviado datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $correo = $_POST['correo'];
    $clave_encriptada = $_POST['clave']; // Usa un método de encriptación más tarde
    $rol_id = $_POST['rol_id'];
    $clave_acceso = $_POST['clave_acceso']; // Clave de acceso

    // Validar clave de acceso según el rol
    $valid_keys = [
        2 => 'claveSuperadmin',  // Superadmin
        3 => 'claveAdmin',       // Admin
        4 => 'claveGenerico'     // Genérico
    ];

    if ($clave_acceso !== $valid_keys[$rol_id]) {
        echo "<script>
                alert('Clave de acceso incorrecta para el rol seleccionado. Por favor, consulte con su administrador del sistema.');
                window.location.href = '../index.html'; // Cambia 'index.html' a la URL de tu página de inicio
              </script>";
        exit; // Detener la ejecución
    }

    // Prepara la consulta
    $stmt = $conn->prepare("INSERT INTO usuarios (correo, clave_encriptada, fecha_creacion, rol_id) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("ssi", $correo, $clave_encriptada, $rol_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Usuario registrado exitosamente.');
                window.location.href = '../index.html'; // Cambia 'index.html' a la URL de tu página de inicio
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>

