<?php
require_once '../../modelos/modelo_domicilio/Domicilio.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $clienteID = $_POST['cliente_id'];
    $direccion = $_POST['direccion'];
    $precio = $_POST['precio'];
    $estado = $_POST['estado'];
    $productos = $_POST['productos'];

    $domicilio = new Domicilio();
    $exito = $domicilio->actualizar($id, $clienteID, $direccion, $precio, $estado, $productos);

    if ($exito) {
        header('Location: index.php?mensaje=actualizado');
        exit;
    } else {
        echo "❌ Error al actualizar el pedido.";
    }
} else {
    echo "Acceso no permitido.";
}
