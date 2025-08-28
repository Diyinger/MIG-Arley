<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function validarAccesoAdmin() {
    // Si no hay sesión o el rol no es administrador, redirigir
    if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Administrador') {
        header("Location: ../../pages/pages_pedidos/index.php");
        exit();
    }
}

function validarAccesoMesero() {
    // Verificar si el usuario es mesero o administrador
    if (!isset($_SESSION['ROL']) || ($_SESSION['ROL'] !== 'Mesero' && $_SESSION['ROL'] !== 'Administrador')) {
        header("Location: ../../pages/pages_login/login.php");
        exit();
    }
}

// Lista de páginas que solo los administradores pueden acceder
$paginasAdmin = [
    'existencias',
    'platos',
    'add.php',
    'pages_reportes.php'
];

// Obtener el nombre del archivo actual
$paginaActual = basename($_SERVER['PHP_SELF']);
$directorioActual = basename(dirname($_SERVER['PHP_SELF']));

// Verificar si la página actual requiere acceso de administrador
foreach ($paginasAdmin as $pagina) {
    if (strpos($paginaActual, $pagina) !== false || strpos($directorioActual, $pagina) !== false) {
        validarAccesoAdmin();
        break;
    }
}
?>
