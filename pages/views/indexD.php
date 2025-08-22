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
        include 'login.php';
        break;

    case 'auth/login':
        require_once '../../controladores/AuthController.php';
        $auth = new AuthController();
        $auth->login();
        break;

    case 'auth/recuperar':
        require_once '../../controladores/AuthController.php';
        $auth = new AuthController();
        $auth->recuperar();
        break;


    case 'auth/logout':
        require_once '../../controladores/AuthController.php';
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'registro':
        include 'registro.php';
        break;

    case 'auth/registro':
        require_once '../../controladores/AuthController.php';
        $auth = new AuthController();
        $auth->registro();
        break;

    case 'reserva/index':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->index();
        break;

    case 'mesa/index':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->index();
        break;

    case 'mesa/agregar':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->agregar();
        break;

    case 'mesa/guardar':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->guardar();
        break;

    case 'mesa/editar':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->editar();
        break;

    case 'mesa/actualizar':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->actualizar();
        break;

    case 'mesa/eliminar':
        require_once '../../controladores/MesaController.php';
        $mesa = new MesaController();
        $mesa->eliminar();
        break;


    case 'reserva/crear':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->crear();
        break;

    case 'reserva/guardar':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->guardar();
        break;

    case 'reserva/eliminar':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->eliminar();
        break;

    case 'reserva/editar':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->editar();
        break;

    case 'reserva/actualizar':
        require_once '../../controladores/ReservaController.php';
        $reserva = new ReservaController();
        $reserva->actualizar();
        break;

    case 'olvidar':
        include 'olvidar.php';
        break;

    default:
        echo "<h1>Error 404: Página no encontrada</h1>";
        break;

    case 'dashboard':
    require_once '../../modelos/modelo_reservas/Reserva.php';
    require_once '../../modelos/modelo_reservas/Mesa.php';

    $reserva = new Reserva();
    $mesa = new Mesa();

    $totalReservasHoy = $reserva->contarReservasDeHoy();
    $proximasReservas = $reserva->obtenerReservasDeHoy();
    $estadoMesas = $mesa->contarPorEstado();

    $mesasDisponibles = $estadoMesas['Disponible'] ?? 0;
    $totalMesas = array_sum($estadoMesas);

    include 'dashboard.php';
    break;

    case 'reserva/reporteMensual':
    require_once '../../controladores/ReservaController.php';
    $reserva = new ReservaController();
    $reserva->reporteMensual();
    break;





}
?>
