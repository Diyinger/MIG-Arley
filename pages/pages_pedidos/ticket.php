<?php
$titulo = "Ticket del Pedido";
include __DIR__ . '/../pages_layout/head.php';
require_once '../../Conexion.php';

$conn = Conexion::getInstancia()->getConexion();

if (!isset($_GET['id'])) {
    echo "No se proporcionó un ID de pedido.";
    exit;
}

//pedido especifico
$pedidoId = $_GET['id'];

// Obtener información del pedido
$stmt = $conn->prepare("SELECT * FROM pedidos WHERE PedidoID = ?");
$stmt->execute([$pedidoId]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}

// Obtener los platos del pedido
$stmt = $conn->prepare("
    SELECT p.nombre, p.precio, pp.Cantidad
    FROM platos_pedido pp
    INNER JOIN platos p ON pp.PlatoID = p.PlatoID
    WHERE pp.PedidoID = ?
");
$stmt->execute([$pedidoId]);
$platos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<div class="container mt-5 ticket-container">
    <h2 class="mb-4">Ticket del Pedido</h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['Cliente']) ?></p>
    <p><strong>Mesa:</strong> <?= htmlspecialchars($pedido['Mesa']) ?></p>
    <p><strong>Fecha y hora:</strong> <?= $pedido['FechaHora'] ?></p>

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Plato</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($platos as $plato):
                $subtotal = $plato['precio'] * $plato['Cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($plato['nombre']) ?></td>
                    <td><?= $plato['Cantidad'] ?></td>
                    <td>$<?= number_format($plato['precio'], 0, ',', '.') ?> COP</td>
                    <td>$<?= number_format($subtotal, 0, ',', '.') ?> COP</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total del pedido</th>
                <th class="text-success fw-bold">$<?= number_format($total, 0, ',', '.') ?> COP</th>
            </tr>
        </tfoot>
    </table>
    
    <div class="d-flex gap-3 mt-4">
    <a href="index.php" class="btn btn-primary">Crear otro pedido</a>
    <a href="listar_pedidos.php" class="btn btn-secondary">Ver Pedidos</a>
    <a href="../../controladores/controlador_pedidos/pedidosControllers.php?accion=editar&id=<?= $pedidoId ?>" class="btn btn-warning">Editar Pedido</a>
    </div>

</div>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>