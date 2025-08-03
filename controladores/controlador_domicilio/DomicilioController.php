<?php
require_once 'C:\xampp\htdocs\MIG\modelos\modelo_domicilio\Domicilio.php';

class DomicilioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Domicilio();
    }

    public function index() {
        $datos = $this->modelo->obtenerTodos();
        include 'C:\xampp\htdocs\MIG\pages\pages_domicilio\index.php';
    }

    public function crear() {
        include 'C:\xampp\htdocs\MIG\pages\pages_domicilio\crear.php';
    }

    public function guardar() {
        $this->modelo->insertar($_POST['clienteID'], $_POST['direccion'], $_POST['precio'], $_POST['productos']);
        header('Location: index.php?url=domicilio/index');
    }

    public function editar($id) {
        $pedido = $this->modelo->obtenerPorId($id);
        include 'C:\xampp\htdocs\MIG\pages\pages_domicilio\editar.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST['id'], $_POST['clienteID'], $_POST['direccion'], $_POST['precio'], $_POST['estado'], $_POST['productos']);
        header('Location: index.php?url=domicilio/index');
    }

    public function eliminar($id) {
        $this->modelo->eliminar($id);
        header('Location: index.php?url=domicilio/index');
    }
}
