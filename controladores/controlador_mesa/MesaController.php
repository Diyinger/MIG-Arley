<?php
require_once '../../modelos/modelo_mesa/Mesa.php';

class MesaController
{
    private $modelo;

    public function __construct()
    {
        // No forzamos redirect al index; solo iniciamos sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new Mesa();
    }

    private function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }

    public function index()
    {
        $mesas = $this->modelo->obtenerTodas();
        include '../../pages/pages_mesas/mesas.php';
    }

    public function agregar()
    {
        include '../../pages/pages_mesas/agregar_mesa.php';
    }

    public function guardar()
    {
        $numero    = isset($_POST['numero']) ? (int)$_POST['numero'] : null;
        $capacidad = isset($_POST['capacidad']) ? (int)$_POST['capacidad'] : null;
        $estado    = $_POST['estado'] ?? 'Disponible';

        if (!$numero || !$capacidad) {
            $_SESSION['error'] = "Datos inválidos para la mesa.";
            $this->redirect('../../pages/pages_mesas/agregar_mesa.php');
        }

        $this->modelo->agregarMesa($numero, $capacidad, $estado);
        $_SESSION['exito'] = "Mesa agregada correctamente.";
        $this->redirect('../../pages/pages_mesas/mesas.php');
    }

    public function editar()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            $_SESSION['error'] = "ID de mesa no válido.";
            $this->redirect('../../pages/pages_mesas/mesas.php');
        }

        $mesa = $this->modelo->obtenerPorId($id);
        if (!$mesa) {
            $_SESSION['error'] = "La mesa no existe.";
            $this->redirect('../../pages/pages_mesas/mesas.php');
        }

        include '../../pages/pages_mesas/editar_mesa.php';
    }

    public function actualizar()
    {
        $mesa_id   = isset($_POST['mesa_id']) ? (int)$_POST['mesa_id'] : null;
        $numero    = isset($_POST['numero']) ? (int)$_POST['numero'] : null;
        $capacidad = isset($_POST['capacidad']) ? (int)$_POST['capacidad'] : null;
        $estado    = $_POST['estado'] ?? 'Disponible';

        if (!$mesa_id || !$numero || !$capacidad) {
            $_SESSION['error'] = "Datos inválidos para actualizar la mesa.";
            $this->redirect('../../pages/pages_mesas/mesas.php');
        }

        $this->modelo->actualizarMesa($mesa_id, $numero, $capacidad, $estado);
        $_SESSION['exito'] = "Mesa actualizada correctamente.";
        $this->redirect('../../pages/pages_mesas/mesas.php');
    }

    public function eliminar()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            $_SESSION['error'] = "ID inválido para eliminar la mesa.";
            $this->redirect('../../pages/pages_mesas/mesas.php');
        }

        $this->modelo->eliminarMesa($id);
        $_SESSION['exito'] = "Mesa eliminada correctamente.";
        $this->redirect('../../pages/pages_mesas/mesas.php');
    }
}

// Dispatcher
$accion = $_GET['accion'] ?? 'index';
$controller = new MesaController();
if (method_exists($controller, $accion)) {
    $controller->$accion();
} else {
    $controller->index();
}
