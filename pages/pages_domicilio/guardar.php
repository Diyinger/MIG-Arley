<?php
require_once '../../modelos/modelo_domicilio/Domicilio.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteID = $_POST['cliente_id'];
    $direccion = $_POST['direccion'];
    $precio = $_POST['precio'];
    $productos = $_POST['productos'];
    $estado = $_POST['estado']; // recibido desde el formulario

    $domicilio = new Domicilio();
    $exito = $domicilio->insertar($clienteID, $direccion, $precio, $productos, $estado);

    if ($exito) {
        header('Location: index.php?mensaje=guardado');
        exit;
    } else {
        echo "❌ Error al guardar el pedido.";
    }
} else {
    echo "Acceso no permitido.";
}
