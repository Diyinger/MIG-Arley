<?php
session_start();
date_default_timezone_set('America/Bogota'); 


// Control de mensajes
$mensaje_error = $_SESSION['error'] ?? null;
$mensaje_exito = $_SESSION['exito'] ?? null;
unset($_SESSION['error'], $_SESSION['exito']);

// Enrutamiento básico
$url = $_GET['url'] ?? 'login';

switch ($url) {
    case 'login':
        include 'views/login.php';
        break;

    case 'auth/login':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case 'auth/recuperar':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->recuperar();
        break;


    case 'auth/logout':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'registro':
        include 'views/registro.php';
        break;

    case 'auth/registro':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->registro();
        break;

    case 'reserva/index':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->index();
        break;

    case 'mesa/index':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->index();
        break;

    case 'mesa/agregar':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->agregar();
        break;

    case 'mesa/guardar':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->guardar();
        break;

    case 'mesa/editar':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->editar();
        break;

    case 'mesa/actualizar':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->actualizar();
        break;

    case 'mesa/eliminar':
        require_once 'controllers/MesaController.php';
        $mesa = new MesaController();
        $mesa->eliminar();
        break;


    case 'reserva/crear':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->crear();
        break;

    case 'reserva/guardar':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->guardar();
        break;

    case 'reserva/eliminar':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->eliminar();
        break;

    case 'reserva/editar':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->editar();
        break;

    case 'reserva/actualizar':
        require_once 'controllers/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->actualizar();
        break;

    case 'olvidar':
        include 'views/olvidar.php';
        break;

    default:
        echo "<h1>Error 404: Página no encontrada</h1>";
        break;

    case 'dashboard':
    require_once 'models/Reserva.php';
    require_once 'models/Mesa.php';

    $reserva = new Reserva();
    $mesa = new Mesa();

    $totalReservasHoy = $reserva->contarReservasDeHoy();
    $proximasReservas = $reserva->obtenerReservasDeHoy();
    $estadoMesas = $mesa->contarPorEstado();

    $mesasDisponibles = $estadoMesas['Disponible'] ?? 0;
    $totalMesas = array_sum($estadoMesas);

    include 'views/dashboard.php';
    break;

    case 'reserva/reporteMensual':
    require_once 'controllers/ReservaController.php';
    $reserva = new ReservaController();
    $reserva->reporteMensual();
    break;





}
?>
