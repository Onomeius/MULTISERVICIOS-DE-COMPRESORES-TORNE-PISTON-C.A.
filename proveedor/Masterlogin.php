<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Responsivo</title>
    <style>
        /* Estilos básicos para reset y fuente */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-container input:focus {
            border-color: #007BFF;
            outline: none;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            background: none;
            border: none;
            color: #007BFF;
            font-size: 16px;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .login-container p {
            text-align: center;
            margin-top: 15px;
        }

        .login-container p a {
            color: #007BFF;
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        /* Estilos responsivos */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="Login.PHP" method="POST">
        <div class="input-container">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
        </div>
        <div class="input-container">
            <input type="password" id="password" name="clave" placeholder="Contraseña" required>
            <button type="button" class="toggle-password" id="togglePassword">👁️</button>
        </div>
        <button type="submit" class="login-btn">Iniciar Sesión</button>
    </form>
    <p>¿Olvidaste tu contraseña? <a href="../Cambio_de_claves/cambiar_clave_form.php">Recupérala aquí</a></p>
    <p>¿Quieres Volver al Inicio? <a href="../index.php">Pagina de Inicio</a></p>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Alternar el tipo de entrada
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        // Alternar el texto del botón
        this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    });
</script>

</body>
</html>
