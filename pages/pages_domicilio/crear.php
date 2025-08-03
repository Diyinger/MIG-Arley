<?php include '../pages_layout/head.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Nuevo Pedido a Domicilio</h2>

    <form action="guardar.php" method="POST">
        <div class="mb-3">
            <label for="cliente_id" class="form-label">ID del Cliente</label>
            <input type="number" class="form-control" name="cliente_id" id="cliente_id" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección de Entrega</label>
            <textarea class="form-control" name="direccion" id="direccion" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" name="precio" id="precio" required>
        </div>

        <div class="mb-3">
            <label for="productos" class="form-label">Productos</label>
            <textarea class="form-control" name="productos" id="productos" rows="3" required></textarea>
        </div>
        
        <div class="mb-3">
            <label for="estado" class="form-label">Estado del Pedido</label>
            <select class="form-control" name="estado" id="estado" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Enviado">Enviado</option>
                <option value="Entregado">Entregado</option>
            </select>
        </div>


        <button type="submit" class="btn btn-success">Guardar Pedido</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include '../pages_layout/footer.php'; ?>