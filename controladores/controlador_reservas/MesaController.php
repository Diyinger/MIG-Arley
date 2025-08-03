<?php
require_once 'models/Mesa.php';

class MesaController
{
    private $modelo;

    public function __construct()
    {
        // Seguridad: verificar sesión
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php');
            exit;
        }

        // Cargar modelo Mesa
        $this->modelo = new Mesa();
    }

    public function index()
    {
        // Obtener todas las mesas (el modelo ya usa consultas preparadas)
        $mesas = $this->modelo->obtenerTodas();

        // Proteger salida en la vista (usaremos htmlspecialchars en la vista)
        include 'views/mesas.php';
    }

    public function agregar()
    {
        include 'views/agregar_mesa.php';
    }

    public function guardar()
    {
        // **1. Sanitizar entradas**
        $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
        $capacidad = filter_var($_POST['capacidad'], FILTER_VALIDATE_INT);

        // **2. Validar datos**
        if ($numero === false || $capacidad === false || $numero <= 0 || $capacidad <= 0) {
            $_SESSION['error'] = "Datos inválidos para la mesa.";
            header('Location: index.php?url=mesa/agregar');
            return;
        }

        // **3. Llamar al modelo (el modelo usará consultas preparadas)**
        $this->modelo->agregarMesa($numero, $capacidad);

        $_SESSION['exito'] = "Mesa agregada correctamente.";
        header('Location: index.php?url=mesa/index');
    }

    public function editar()
    {
        // **1. Validar ID recibido**
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false) {
            $_SESSION['error'] = "ID inválido para la mesa.";
            header('Location: index.php?url=mesa/index');
            return;
        }

        // **2. Consultar datos**
        $mesa = $this->modelo->obtenerPorId($id);

        if (!$mesa) {
            $_SESSION['error'] = "Mesa no encontrada.";
            header('Location: index.php?url=mesa/index');
            return;
        }

        include 'views/editar_mesa.php';
    }

    public function actualizar()
    {
        // **1. Sanitizar datos**
        $mesa_id = filter_var($_POST['mesa_id'], FILTER_VALIDATE_INT);
        $numero = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
        $capacidad = filter_var($_POST['capacidad'], FILTER_VALIDATE_INT);

        // **2. Validar**
        if ($mesa_id === false || $numero === false || $capacidad === false || $numero <= 0 || $capacidad <= 0) {
            $_SESSION['error'] = "Datos inválidos para actualizar la mesa.";
            header("Location: index.php?url=mesa/editar&id=" . urlencode($_POST['mesa_id']));
            return;
        }

        // **3. Actualizar usando consultas preparadas**
        $this->modelo->actualizarMesa($mesa_id, $numero, $capacidad);

        $_SESSION['exito'] = "Mesa actualizada correctamente.";
        header("Location: index.php?url=mesa/index");
    }

    public function eliminar()
    {
        // **1. Validar ID**
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id !== false) {
            $this->modelo->eliminarMesa($id);
            $_SESSION['exito'] = "Mesa eliminada correctamente.";
        } else {
            $_SESSION['error'] = "ID inválido para eliminar la mesa.";
        }

        header("Location: index.php?url=mesa/index");
    }
}
