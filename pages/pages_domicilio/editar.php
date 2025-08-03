<?php
require_once '../../modelos/modelo_domicilio/Domicilio.php';
include '../pages_layout/head.php';

if (!isset($_GET['id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>❌ ID no especificado.</div></div>";
    exit;
}

$domicilio = new Domicilio();
$pedido = $domicilio->obtenerPorId($_GET['id']);

if (!$pedido) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Pedido no encontrado.</div></div>";
    exit;
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Pedido #<?= $pedido['PedidoID'] ?></h2>

    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id" value="<?= $pedido['PedidoID'] ?>">

        <div class="mb-3">
            <label for="cliente_id" class="form-label">ID del Cliente</label>
            <input type="number" class="form-control" name="cliente_id" id="cliente_id" value="<?= $pedido['ClienteID'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección de Entrega</label>
            <textarea class="form-control" name="direccion" id="direccion" rows="3" required><?= $pedido['DireccionEntrega'] ?></textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" name="precio" id="precio" value="<?= $pedido['Precio'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" name="estado" id="estado" required>
                <option value="Pendiente" <?= $pedido['Estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="Enviado" <?= $pedido['Estado'] == 'Enviado' ? 'selected' : '' ?>>Enviado</option>
                <option value="Entregado" <?= $pedido['Estado'] == 'Entregado' ? 'selected' : '' ?>>Entregado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="productos" class="form-label">Productos</label>
            <textarea class="form-control" name="productos" id="productos" rows="3" required><?= $pedido['Productos'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include '../pages_layout/footer.php'; ?>
