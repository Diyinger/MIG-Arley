<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function validarSesion() {
    // Verificar si existe la sesión y si tiene un ID válido
    if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
        header("Location: ../../pages/pages_login/login.php");
        exit();
    }

    // Verificar tiempo de inactividad (30 minutos)
    if (isset($_SESSION['tiempo'])) {
        $inactivo = 1800; // 30 minutos
        $vida_session = time() - $_SESSION['tiempo'];

        if ($vida_session > $inactivo) {
            // Limpiar variables de sesión
            $_SESSION = array();
            
            // Destruir cookie de sesión si existe
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-42000, '/');
            }
            
            session_destroy();
            header("Location: ../../pages/pages_login/login.php");
            exit();
        }
    }

    $_SESSION['tiempo'] = time();
}

// Prevenir caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");

validarSesion();