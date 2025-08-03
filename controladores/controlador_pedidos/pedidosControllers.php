<?php

ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../Conexion.php';
$conn = Conexion::getInstancia()->getConexion();

$accion = $_GET['accion'] ?? 'listar';

switch ($accion) {
    case 'editar':
        if (!isset($_GET['id'])) {
            echo "ID de pedido no proporcionado.";
            exit;
        }

        $pedidoId = $_GET['id'];

        // Obtener datos del pedido
        $stmt = $conn->prepare("SELECT * FROM pedidos WHERE PedidoID = ?");
        $stmt->execute([$pedidoId]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener los platos del pedido
        $stmt = $conn->prepare("SELECT * FROM platos_pedido WHERE PedidoID = ?");
        $stmt->execute([$pedidoId]);
        $platosPedido = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $platosPedido[$row['PlatoID']] = $row['Cantidad'];
        }

        // Obtener todos los platos disponibles
        $platos = $conn->query("SELECT * FROM platos");

        include __DIR__ . '/../../pages/pages_pedidos/editar_pedido.php';
        break;

    case 'actualizar':
        $pedidoId = $_POST['pedido_id'];
        $cliente = $_POST['cliente'];
        $mesa = $_POST['mesa'];
        $platos = $_POST['platos'] ?? [];
        $cantidades = $_POST['cantidades'] ?? [];

        // Actualizar datos del pedido
        $stmt = $conn->prepare("UPDATE pedidos SET Cliente = ?, Mesa = ? WHERE PedidoID = ?");
        $stmt->execute([$cliente, $mesa, $pedidoId]);

        // Eliminar platos actuales
        $stmt = $conn->prepare("DELETE FROM platos_pedido WHERE PedidoID = ?");
        $stmt->execute([$pedidoId]);

        // Insertar nuevos platos
        foreach ($platos as $platoId) {
            $cantidad = (int)$cantidades[$platoId];
            $stmt = $conn->prepare("INSERT INTO platos_pedido (PedidoID, PlatoID, Cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$pedidoId, $platoId, $cantidad]);
        }

    
        header("Location: ../../pages/pages_pedidos/ticket.php?id=" . $pedidoId);
        exit;

    case 'guardar':
        $cliente = $_POST['cliente'];
        $mesa = $_POST['mesa'];
        $platos = $_POST['platos'] ?? [];
        $cantidades = $_POST['cantidades'] ?? [];

        // Insertar pedido
        $stmt = $conn->prepare("INSERT INTO pedidos (Cliente, Mesa, FechaHora) VALUES (?, ?, NOW())");
        $stmt->execute([$cliente, $mesa]);
        $pedidoId = $conn->lastInsertId();

        // Insertar cada plato
        foreach ($platos as $platoId) {
            $cantidad = (int)$cantidades[$platoId];
            $stmt = $conn->prepare("INSERT INTO platos_pedido (PedidoID, PlatoID, Cantidad) VALUES (?, ?, ?)");
            $stmt->execute([$pedidoId, $platoId, $cantidad]);
        }

        header("Location: ../../pages/pages_pedidos/ticket.php?id=" . $pedidoId);
        exit;

    case 'eliminar':
        $pedidoId = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM platos_pedido WHERE PedidoID = ?");
        $stmt->execute([$pedidoId]);
        $stmt = $conn->prepare("DELETE FROM pedidos WHERE PedidoID = ?");
        $stmt->execute([$pedidoId]);


        header("Location: ../../pages/pages_pedidos/listar_pedidos.php");
        exit;

    default:
        
        include __DIR__ . '/../../pages/pages_pedidos/listar_pedidos.php';
        break;
}

ob_end_flush();