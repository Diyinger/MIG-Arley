<?php
require_once 'modelos/modelo_reservas/Reserva.php';

class ReservaController
{
    private $modelo;

    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php');
            exit;
        }

        $this->modelo = new Reserva();
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';

        require_once 'models/Reserva.php';
        $reservaModel = new Reserva();
        $reservaModel->actualizarEstadoMesasPorHorario();
        $reservaModel->liberarMesasPasadas();
        $reservas = $this->modelo->obtenerTodas($busqueda);
        include 'views/index.php';
    }

    public function crear()
    {
        $this->modelo->actualizarEstadoMesasPorHorario();
        $mesas = $this->modelo->obtenerMesasDisponibles(); // Obtener mesas desde el modelo
        include 'views/crear_reserva.php'; // Enviar a la vista
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
            header('Location: index.php?url=reserva/index');
            return;
        }

        $this->modelo->guardar($datos); // Solo guarda la reserva

        $_SESSION['exito'] = "Reserva registrada correctamente.";
        header('Location: index.php?url=reserva/index');
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminar($id);
        }
        header('Location: index.php?url=reserva/index');
    }

    public function editar()
    {
        $this->modelo->actualizarEstadoMesasPorHorario();
        if (!isset($_GET['id'])) {
            header('Location: index.php?url=reserva/index');
            return;
        }

        $id = $_GET['id'];
        $reserva = $this->modelo->obtenerPorId($id);

        if (!$reserva) {
            $_SESSION['error'] = "Reserva no encontrada.";
            header('Location: index.php?url=reserva/index');
            return;
        }

        include 'views/editar_reserva.php';
    }

    public function actualizar()
    {
        $datos = [
            'id'       => $_POST['id'],
            'nombre'   => trim($_POST['nombre']),
            'fecha'    => $_POST['fecha'],
            'hora'     => $_POST['hora'],
            'personas' => $_POST['personas']
        ];

        if (
            empty($datos['nombre']) || !preg_match('/^[A-Za-z\s]+$/', $datos['nombre']) ||
            empty($datos['fecha']) ||
            empty($datos['hora']) ||
            empty($datos['personas']) || !is_numeric($datos['personas']) || $datos['personas'] <= 0
        ) {
            $_SESSION['error'] = "Datos inválidos, por favor verifique.";
            header("Location: index.php?url=reserva/editar&id=" . $datos['id']);
            return;
        }

        $this->modelo->actualizar($datos);
        $_SESSION['exito'] = "Reserva actualizada correctamente.";
        header('Location: index.php?url=reserva/index');
    }

    public function dashboard()
    {
        $this->modelo->actualizarEstadoMesasPorHorario();
        $totalReservasHoy = $this->modelo->contarReservasDeHoy();
        $mesasDisponibles = $this->modelo->contarMesasDisponibles();
        $totalMesas = $this->modelo->contarTodasLasMesas();
        $proximasReservas = $this->modelo->obtenerProximasReservas();

        include 'views/dashboard.php';
    }

    public function reporteMensual()
    {
        $this->modelo->actualizarEstadoMesasPorHorario();
        $mes = $_GET['mes'] ?? date('m');
        $año = $_GET['anio'] ?? date('Y');

        $reservas = $this->modelo->obtenerReservasPorMes($mes, $año);
        include 'views/reporte_mensual.php';
    }
}
