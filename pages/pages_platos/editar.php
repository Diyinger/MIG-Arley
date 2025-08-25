<?php include __DIR__ . '/../pages_layout/head.php'; ?>
<div class="container mt-5">
    <h2>Editar Plato</h2>
    <form method="POST" action="../../controladores/controlador_plato/PlatoController.php?accion=actualizar">
        <input type="hidden" name="id" value="<?= $plato['PlatoID'] ?>">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($plato['nombre']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"><?= htmlspecialchars($plato['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" class="form-control" value="<?= $plato['precio'] ?>" required min="0" step="0.01">
        </div>
        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" name="cantidad" class="form-control" value="<?= $plato['cantidad'] ?>" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="../../controladores/controlador_plato/PlatoController.php?accion=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>