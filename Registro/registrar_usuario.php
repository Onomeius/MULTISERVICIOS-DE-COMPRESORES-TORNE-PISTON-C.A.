<?php
session_start();
include 'conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $correo = $_POST['correo'];
    $clave = $_POST['clave']; // Esta es la contraseña sin encriptar
    $rol_id = $_POST['rol_id'];
    $clave_acceso = $_POST['clave_acceso'] ?? ''; // Clave de acceso puede ser opcional

    // Validar el rol
    $roles_validos = [1, 2, 3]; // IDs válidos de los roles en tu base de datos

    if (!in_array($rol_id, $roles_validos)) {
        echo "<script>alert('Rol no válido seleccionado. Por favor, consulte con su administrador del sistema.'); window.location.href='Registro.html';</script>";
        exit();
    }

    // Validar la clave de acceso especial
    if (empty($clave_acceso)) {
        echo "<script>alert('La clave de acceso especial es requerida.'); window.location.href='Registro.html';</script>";
        exit();
    }

    // Aquí puedes agregar la lógica para verificar la clave de acceso
    $clave_acceso_valida = "clave_superadmin"; // Cambia esto a la clave esperada para el Superadmin
    if ($rol_id == 1 && $clave_acceso !== $clave_acceso_valida) {
        echo "<script>alert('Clave de acceso especial incorrecta para Superadmin.'); window.location.href='Registro.html';</script>";
        exit();
    }

    $clave_acceso_valida_admin = "clave_admin"; // Cambia esto a la clave esperada para el Admin
    if ($rol_id == 2 && $clave_acceso !== $clave_acceso_valida_admin) {
        echo "<script>alert('Clave de acceso especial incorrecta para Admin.'); window.location.href='Registro.html';</script>";
        exit();
    }

    // Para el rol Genérico (3), se requiere clave de acceso
    if ($rol_id == 3) {
        $clave_acceso_valida_generico = "clave_generico"; // Cambia esto a la clave esperada para el Genérico
        if ($clave_acceso !== $clave_acceso_valida_generico) {
            echo "<script>alert('Clave de acceso especial incorrecta para Genérico.'); window.location.href='Registro.html';</script>";
            exit();
        }
    }

    // Encriptar la contraseña usando SHA-256
    $clave_encriptada = hash('sha256', $clave);

    // Preparar y ejecutar la consulta de inserción
    $stmt = $conexion->prepare("INSERT INTO usuarios (correo, clave_encriptada, rol_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $correo, $clave_encriptada, $rol_id); // "ssi" significa: string, string, integer

    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado exitosamente.'); window.location.href='../index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar el usuario: " . $conexion->error . "'); window.location.href='Registro.html';</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>
