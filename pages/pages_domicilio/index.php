<?php
require_once '../../modelos/modelo_domicilio/Domicilio.php';
include '../pages_layout/head.php';

$domicilio = new Domicilio();
$pedidos = $domicilio->obtenerTodos();
?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de Pedidos a Domicilio</h2>

    <?php if (isset($_GET['mensaje'])): ?>
        <?php if ($_GET['mensaje'] === 'guardado'): ?>
            <div class="alert alert-success"> Pedido guardado correctamente.</div>
        <?php elseif ($_GET['mensaje'] === 'actualizado'): ?>
            <div class="alert alert-primary"> Pedido actualizado correctamente.</div>
        <?php elseif ($_GET['mensaje'] === 'eliminado'): ?>
            <div class="alert alert-danger"> Pedido eliminado correctamente.</div>
        <?php endif; ?>
    <?php endif; ?>



    <a href="crear.php" class="btn btn-primary mb-3"> Nuevo Pedido</a>
    <a href="../pages_administrador/index.php" class="btn btn-primary mb-3">Volver atras</a>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info">No hay pedidos registrados.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Dirección</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= $pedido['PedidoID'] ?></td>
                            <td><?= $pedido['ClienteID'] ?></td>
                            <td><?= $pedido['DireccionEntrega'] ?></td>
                            <td>$<?= number_format($pedido['Precio'], 2) ?></td>
                            <td><?= $pedido['Estado'] ?></td>
                            <td><?= $pedido['FechaHora'] ?></td>
                            <td><?= $pedido['Productos'] ?></td>
                            <td>
                                <a href="editar.php?id=<?= $pedido['PedidoID'] ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                                <a href="eliminar.php?id=<?= $pedido['PedidoID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este pedido?')">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../pages_layout/footer.php'; ?>