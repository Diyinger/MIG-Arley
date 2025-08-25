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
        try {
            // Validar datos básicos
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? '';

            if (empty($nombre) || !is_numeric($precio)) {
                throw new Exception("Nombre y precio son requeridos y deben ser válidos.");
            }

            // Validar ingredientes
            $productos = $_POST['productos'] ?? [];
            $cantidades = $_POST['cantidades'] ?? [];
            $unidades = $_POST['unidades'] ?? [];

            if (empty($productos)) {
                throw new Exception("Debe especificar al menos un ingrediente.");
            }

            // Preparar array de ingredientes
            $ingredientes = [];
            foreach ($productos as $key => $productoId) {
                if (empty($cantidades[$key]) || !is_numeric($cantidades[$key]) || $cantidades[$key] <= 0) {
                    throw new Exception("Cantidad inválida para uno de los ingredientes.");
                }

                $ingredientes[] = [
                    'ProductoID' => $productoId,
                    'cantidad' => $cantidades[$key],
                    'unidad_medida' => $unidades[$key] ?? 'unidad'
                ];
            }

            // Obtener la cantidad inicial de platos
            $cantidadInicial = isset($_POST['cantidad_platos']) ? (int)$_POST['cantidad_platos'] : 0;
            if ($cantidadInicial < 0) {
                throw new Exception("La cantidad de platos no puede ser negativa.");
            }

            // Verificar stock disponible multiplicado por la cantidad de platos
            foreach ($ingredientes as &$ingrediente) {
                $ingrediente['cantidad_total'] = $ingrediente['cantidad'] * $cantidadInicial;
            }
            
            $errores = $this->modelo->verificarStockIngredientes($ingredientes);
            if (!empty($errores)) {
                throw new Exception("Error de stock: " . implode(", ", $errores));
            }

            // Guardar plato con sus ingredientes y cantidad inicial
            $this->modelo->add($nombre, $descripcion, (float)$precio, $ingredientes, $cantidadInicial);
            $_SESSION['exito'] = "Plato registrado correctamente.";
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=index');

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ../../controladores/controlador_plato/PlatoController.php?accion=crear');
        }
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
