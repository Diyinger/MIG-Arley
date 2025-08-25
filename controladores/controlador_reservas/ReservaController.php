<?php
session_start();
require_once '../../modelos/modelo_reservas/Reserva.php';

class ReservaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Reserva();
    }

    // Opcional: lista (si la usas como acción)
    public function index()
    {
        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    public function guardar()
    {
        $datos = [
            'nombre'   => trim($_POST['nombre'] ?? ''),
            'fecha'    => $_POST['fecha'] ?? '',
            'hora'     => $_POST['hora'] ?? '',
            'personas' => $_POST['personas'] ?? '',
            'mesa_id'  => $_POST['mesa_id'] ?? ''
        ];

        // Validaciones básicas
        if (
            empty($datos['nombre']) || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u', $datos['nombre']) ||
            empty($datos['fecha']) ||
            empty($datos['hora']) ||
            !is_numeric($datos['personas']) || (int)$datos['personas'] <= 0 ||
            !is_numeric($datos['mesa_id'])
        ) {
            $_SESSION['error'] = "Datos inválidos. Verifica los campos.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        $resultado = $this->modelo->guardar($datos);

        if ($resultado === true) {
            $_SESSION['exito'] = "Reserva registrada correctamente.";
        } elseif ($resultado === "conflicto") {
            $_SESSION['error'] = "Ya existe una reserva para esa mesa en ese horario.";
        } elseif ($resultado === "sin_capacidad") {
            $_SESSION['error'] = "La capacidad de la mesa no es apta para esa cantidad de personas, por favor seleccione otra.";
        } elseif ($resultado === "mesa_invalida") {
            $_SESSION['error'] = "La mesa seleccionada no existe.";
        } else {
            $_SESSION['error'] = "No se pudo guardar la reserva.";
        }

        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID inválido.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        if ($this->modelo->eliminar((int)$id)) {
            $_SESSION['exito'] = "Reserva eliminada correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo eliminar la reserva.";
        }

        header('Location: ../../pages/pages_reservas/reserva.php');
        exit;
    }

    // ✅ ÚNICO método editar()
    public function editar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID inválido.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        $reserva = $this->modelo->obtenerPorId((int)$id);
        if (!$reserva) {
            $_SESSION['error'] = "Reserva no encontrada.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        }

        $mesas = $this->modelo->obtenerMesas(); // para el <select>
        // Muestra la vista de edición
        include '../../pages/pages_reservas/editar_reserva.php';
    }

    public function actualizar()
    {
        $datos = [
            'id'       => $_POST['id'] ?? '',
            'nombre'   => trim($_POST['nombre'] ?? ''),
            'fecha'    => $_POST['fecha'] ?? '',
            'hora'     => $_POST['hora'] ?? '',
            'personas' => $_POST['personas'] ?? '',
            'mesa_id'  => $_POST['mesa_id'] ?? ''
        ];

        if (
            !is_numeric($datos['id']) ||
            empty($datos['nombre']) || !preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u', $datos['nombre']) ||
            empty($datos['fecha']) ||
            empty($datos['hora']) ||
            !is_numeric($datos['personas']) || (int)$datos['personas'] <= 0 ||
            !is_numeric($datos['mesa_id'])
        ) {
            $_SESSION['error'] = "Datos inválidos. Verifica los campos.";
            header('Location: ../../controladores/controlador_reservas/ReservaController.php?accion=editar&id=' . urlencode($datos['id']));
            exit;
        }

        $resultado = $this->modelo->actualizar($datos);

        if ($resultado === true) {
            $_SESSION['exito'] = "Reserva actualizada correctamente.";
            header('Location: ../../pages/pages_reservas/reserva.php');
            exit;
        } elseif ($resultado === "conflicto") {
            $_SESSION['error'] = "Ya existe una reserva para esa mesa en ese horario.";
        } elseif ($resultado === "sin_capacidad") {
            $_SESSION['error'] = "La capacidad de la mesa no es apta para esa cantidad de personas, por favor seleccione otra.";
        } elseif ($resultado === "mesa_invalida") {
            $_SESSION['error'] = "La mesa seleccionada no existe.";
        } else {
            $_SESSION['error'] = "No se pudo actualizar la reserva.";
        }

        header('Location: ../../controladores/controlador_reservas/ReservaController.php?accion=editar&id=' . urlencode($datos['id']));
        exit;
    }
}

// Dispatcher
$accion = $_GET['accion'] ?? $_POST['accion'] ?? 'index';
$controller = new ReservaController();

if (method_exists($controller, $accion)) {
    $controller->$accion();
} else {
    $controller->index();
}
