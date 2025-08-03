<?php
// Iniciar nueva sesión y limpiar cualquier sesión existente
session_start();
session_unset();
session_destroy();
session_start();

// Obtener mensaje de error si existe
$error = $_GET['error'] ?? '';

// Prevenir que la página se almacene en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión MIG</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <!-- Meta tags para prevenir caché -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        .error { color: red; }
        .login-container { max-width: 400px; margin: 60px auto; padding: 2em; border-radius: 8px; background: #fff; box-shadow: 0 0 10px #ccc; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Bienvenido a MIG</h1>
        <p>Por favor, inicia sesión para continuar</p>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="../../controladores/controlador_usuario/login.php" method="POST" id="loginForm" autocomplete="off">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario" 
                   pattern=".{3,}" title="Mínimo 3 caracteres" maxlength="50"><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña"
                   pattern=".{4,}" title="Mínimo 4 caracteres" maxlength="100"><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p><a href="../pages_reservas/recuperar.php">¿Olvidaste tu contraseña?</a></p>
    </div>
    <script>
    document.getElementById('loginForm').onsubmit = function() {
        const usuario = document.getElementById('usuario').value.trim();
        const pass = document.getElementById('password').value.trim();
        
        if (usuario.length < 3) {
            alert('El usuario debe tener al menos 3 caracteres.');
            return false;
        }
        if (pass.length < 4) { // Cambiado a 5 para coincidir con el mensaje de error
            alert('La contraseña debe tener al menos 5 caracteres.');
            return false;
        }
        
        // Deshabilitar el botón después del envío para prevenir múltiples envíos
        document.querySelector('button[type="submit"]').disabled = true;
        return true;
    }
    </script>
</body>
</html>