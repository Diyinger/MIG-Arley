<?php
require_once '../../modelos/modelo_domicilio/Domicilio.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $domicilio = new Domicilio();
    $exito = $domicilio->eliminar($id);

    if ($exito) {
        header('Location: index.php?mensaje=eliminado');
        exit;
    } else {
        echo "❌ Error al eliminar el pedido.";
    }
} else {
    echo "ID no proporcionado.";
}
