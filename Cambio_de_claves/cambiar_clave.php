<?php
// Configuración de conexión a la base de datos
$servidor = "localhost"; // Cambia según tu configuración
$usuario = "root"; // Cambia según tu configuración
$clave = ""; // Cambia según tu configuración
$base_de_datos = "compresores_bd"; // Cambia según tu configuración

// Crear conexión
$conn = new mysqli($servidor, $usuario, $clave, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $nueva_clave = $_POST['nueva_clave'];

    // Validar la nueva clave
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d])(?!.*\s).{8,}$/', $nueva_clave)) {
        // Verificar si el correo existe
        $sql = "SELECT * FROM usuarios WHERE correo='$email'";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            // Actualizar la contraseña en la base de datos (sin encriptar)
            $sql = "UPDATE usuarios SET clave_encriptada='$nueva_clave' WHERE correo='$email'";
            
            if ($conn->query($sql) === TRUE) {
                // Si la clave se cambió exitosamente, mostrar alerta y redirigir
                echo "<script>
                        alert('La clave fue cambiada con éxito.');
                        window.location.href = '../index.html'; // Redirigir a index.html
                      </script>";
                exit; // Asegurarse de que el script se detenga después de la redirección
            } else {
                echo "<script>
                        alert('Error al cambiar la contraseña: " . $conn->error . "');
                        window.history.back(); // Regresar a la página anterior
                      </script>";
            }
        } else {
            // Correo no encontrado
            echo "<script>
                    alert('El correo electrónico no está registrado.'); 
                    window.location.href = 'cambiar_clave_form.php'; // Redirigir a cambiar_clave_form.php
                  </script>";
        }
    } else {
        echo "<script>
                alert('La nueva clave debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas y caracteres especiales.');
                window.location.href = 'cambiar_clave_form.php'; // Redirigir a cambiar_clave_form.php
              </script>";
    }
}

// Cerrar conexión
$conn->close();
?>
