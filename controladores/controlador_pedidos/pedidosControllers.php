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
        $tipo_pedido = $_POST['tipo_pedido'] ?? 'mesa';
        $mesa = ($tipo_pedido == 'mesa') ? $_POST['mesa'] : null;
        $direccion = ($tipo_pedido == 'domicilio') ? $_POST['direccion'] : null;
        $telefono = ($tipo_pedido == 'domicilio') ? $_POST['telefono'] : null;
        $platos = $_POST['platos'] ?? [];
        $cantidades = $_POST['cantidades'] ?? [];

        try {
            // Iniciar transacción
            $conn->beginTransaction();

            // Verificar stock disponible para cada plato
            $cantidadesTotales = array();
            
            // Primero, sumar todas las cantidades por plato
            foreach ($platos as $index => $platoId) {
                if (!isset($cantidadesTotales[$platoId])) {
                    $cantidadesTotales[$platoId] = 0;
                }
                $cantidadesTotales[$platoId] += (int)$cantidades[$index];
            }
            
            // Luego, verificar el stock para cada plato
            foreach ($cantidadesTotales as $platoId => $cantidadTotal) {
                // Obtener stock actual y nombre del plato
                $stmt = $conn->prepare("SELECT cantidad, Nombre FROM platos WHERE PlatoID = ?");
                $stmt->execute([$platoId]);
                $plato = $stmt->fetch(PDO::FETCH_ASSOC);
                $stockActual = $plato['cantidad'];
                $nombrePlato = $plato['Nombre'];

                if ($cantidadTotal > $stockActual) {
                    throw new Exception("No hay suficientes {$nombrePlato} en stock");
                }
            }

            // Insertar pedido
            $stmt = $conn->prepare("INSERT INTO pedidos (Cliente, Mesa, tipo_pedido, direccion, telefono, FechaHora) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$cliente, $mesa, $tipo_pedido, $direccion, $telefono]);
            $pedidoId = $conn->lastInsertId();

            // Insertar cada plato y actualizar stock
            foreach ($platos as $platoId) {
                $cantidad = (int)$cantidades[$platoId];
                
                // Insertar en platos_pedido
                $stmt = $conn->prepare("INSERT INTO platos_pedido (PedidoID, PlatoID, Cantidad) VALUES (?, ?, ?)");
                $stmt->execute([$pedidoId, $platoId, $cantidad]);

                // Actualizar stock del plato
                $stmt = $conn->prepare("UPDATE platos SET cantidad = cantidad - ? WHERE PlatoID = ?");
                $stmt->execute([$cantidad, $platoId]);
            }

            // Confirmar transacción
            $conn->commit();
            
            $_SESSION['mensaje'] = "Pedido guardado correctamente";
            header("Location: ../../pages/pages_pedidos/ticket.php?id=" . $pedidoId);
            exit;

        } catch (Exception $e) {
            // Revertir cambios si hay error
            $conn->rollBack();
            
            $_SESSION['error'] = "No hay suficientes platos en stock";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
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