<?php
require_once '../../modelos/modelo_reservas/Reserva.php';

session_start();

class ReservaController
{
    private $modelo;

    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }
        $this->modelo = new Reserva();
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        $reservas = $this->modelo->obtenerTodas($busqueda);
        include '../../pages/pages_reservas/reserva.php';
    }

    public function crear()
    {
        $mesas = $this->modelo->obtenerMesasDisponibles();
        include '../../pages/pages_reservas/crear_reserva.php';
    }

    public function guardar()
    {
        $datos = [
            'nombre'   => trim($_POST['nombre']),
            'fecha'    => $_POST['fecha'],
            'hora'     => $_POST['hora'],
            'personas' => $_POST['personas'],
            'mesa_id'  => $_POST['mesa_id']
        ];

        if (
            empty($datos['nombre']) || !preg_match('/^[A-Za-z\s]+$/', $datos['nombre']) ||
            empty($datos['fecha']) ||
            empty($datos['hora']) ||
            empty($datos['personas']) || !is_numeric($datos['personas']) || $datos['personas'] <= 0 ||
            empty($datos['mesa_id']) || !is_numeric($datos['mesa_id'])
        ) {
            $_SESSION['error'] = "Datos inválidos, por favor verifique.";
            header('Location: ../../pages/pages_reservas/crear_reserva.php');
            exit;
        }

        $this->modelo->guardar($datos);

        $_SESSION['exito'] = "Reserva registrada correctamente.";
        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id && is_numeric($id)) {
            $this->modelo->eliminar($id);
            $_SESSION['exito'] = "Reserva eliminada correctamente.";
        } else {
            $_SESSION['error'] = "ID de reserva inválido.";
        }
        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    public function editar()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        $id = $_GET['id'];
        $reserva = $this->modelo->obtenerPorId($id);

        if (!$reserva) {
            $_SESSION['error'] = "Reserva no encontrada.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        $mesas = $this->modelo->obtenerMesasDisponibles();
        include '../../pages/pages_reservas/editar_reserva.php';
    }

    public function actualizar()
    {
        $datos = [
            'id'       => $_POST['id'],
            'nombre'   => trim($_POST['nombre']),
            'fecha'    => $_POST['fecha'],
            'hora'     => $_POST['hora'],
            'personas' => $_POST['personas'],
            'mesa_id'  => $_POST['mesa_id']
        ];

        if (
            empty($datos['nombre']) || !preg_match('/^[A-Za-z\s]+$/', $datos['nombre']) ||
            empty($datos['fecha']) ||
            empty($datos['hora']) ||
            empty($datos['personas']) || !is_numeric($datos['personas']) || $datos['personas'] <= 0 ||
            empty($datos['mesa_id']) || !is_numeric($datos['mesa_id']) ||
            empty($datos['id']) || !is_numeric($datos['id'])
        ) {
            $_SESSION['error'] = "Datos inválidos, por favor verifique.";
            header("Location: ../../controladores/controlador_reservas/ReservaController.php?accion=editar&id=" . $datos['id']);
            exit;
        }

        $this->modelo->actualizar($datos);
        $_SESSION['exito'] = "Reserva actualizada correctamente.";
        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    // ...otros métodos como dashboard, reporteMensual, etc.
}

// Dispatcher para ejecutar el método según el parámetro 'accion'
$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'index';
$controller = new ReservaController();

if (method_exists($controller, $accion)) {
    $controller->$accion();
} else {
    $controller->index();
}