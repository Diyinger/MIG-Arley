<?php
require_once '../../modelos/modelo_plato/modelo_plato.php';
session_start();

class PlatoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Plato();
    }

    public function index() {
        $platos = $this->modelo->getAll();
        include '../../pages/pages_platos/index.php';
    }

    public function crear() {
        include '../../pages/pages_platos/crear.php';
    }

    public function guardar() {
        // Validar y sanitizar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = $_POST['precio'] ?? '';
        $cantidad = $_POST['cantidad'] ?? '';

        if (empty($nombre) || empty($descripcion) || !is_numeric($precio) || !is_numeric($cantidad)) {
            $_SESSION['error'] = "Datos inválidos para registrar el plato.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=crear');
            exit;
        }

        $this->modelo->add($nombre, $descripcion, (float)$precio, (int)$cantidad);
        $_SESSION['exito'] = "Plato registrado correctamente.";
        header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
        exit;
    }

    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID de plato inválido.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
            exit;
        }

        $plato = $this->modelo->getById((int)$id);

        if (!$plato) {
            $_SESSION['error'] = "Plato no encontrado.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
            exit;
        }

        include '../../pages/pages_platos/editar.php';
    }

    public function actualizar() {
        $id = $_POST['id'] ?? '';
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = $_POST['precio'] ?? '';
        $cantidad = $_POST['cantidad'] ?? '';

        if (empty($id) || !is_numeric($id) ||
            empty($nombre) || empty($descripcion) ||
            !is_numeric($precio) || !is_numeric($cantidad)) {
            $_SESSION['error'] = "Datos inválidos para actualizar el plato.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=editar&id=' . urlencode($id));
            exit;
        }

        $this->modelo->update((int)$id, $nombre, $descripcion, (float)$precio, (int)$cantidad);
        $_SESSION['exito'] = "Plato actualizado correctamente.";
        header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
        exit;
    }

    public function eliminar() {
        $id = $_GET['id'] ?? '';

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID inválido para eliminar el plato.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
            exit;
        }

        $this->modelo->delete((int)$id);
        $_SESSION['exito'] = "Plato eliminado correctamente.";
        header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');
        exit;
    }
}

// Dispatcher
$accion = $_GET['accion'] ?? 'index';
$controller = new PlatoController();
if (method_exists($controller, $accion)) {
    $controller->$accion();
} else {
    $controller->index();
}
