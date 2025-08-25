<?php
require_once 'models/Mesa.php';

class MesaController
{
    private $modelo;

    public function __construct()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php');
            exit;
        }

        $this->modelo = new Mesa();
    }

    public function index()
    {
        $mesas = $this->modelo->obtenerTodas();
        include 'views/mesas.php';
    }

    public function agregar()
    {
        include 'views/agregar_mesa.php';
    }

    public function guardar()
    {
        $numero = $_POST['numero'];
        $capacidad = $_POST['capacidad'];

        if (empty($numero) || empty($capacidad) || !is_numeric($numero) || !is_numeric($capacidad)) {
            $_SESSION['error'] = "Datos inválidos para la mesa.";
            header('Location: index.php?url=mesa/agregar');
            return;
        }

        $this->modelo->agregarMesa($numero, $capacidad);
        $_SESSION['exito'] = "Mesa agregada correctamente.";
        header('Location: index.php?url=mesa/index');
    }

    public function editar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $mesa = $this->modelo->obtenerPorId($id);
            include 'views/editar_mesa.php';
        }
    }

    public function actualizar()
    {
        $mesa_id = $_POST['mesa_id'];
        $numero = $_POST['numero'];
        $capacidad = $_POST['capacidad'];

        if (empty($numero) || empty($capacidad) || !is_numeric($numero) || !is_numeric($capacidad)) {
            $_SESSION['error'] = "Datos inválidos para actualizar la mesa.";
            header("Location: index.php?url=mesa/editar&id=$mesa_id");
            return;
        }

        $this->modelo->actualizarMesa($mesa_id, $numero, $capacidad);
        $_SESSION['exito'] = "Mesa actualizada correctamente.";
        header("Location: index.php?url=mesa/index");
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelo->eliminarMesa($id);
            $_SESSION['exito'] = "Mesa eliminada correctamente.";
        }
        header("Location: index.php?url=mesa/index");
    }
}
?>