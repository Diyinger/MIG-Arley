<?php include __DIR__ . '/../pages_layout/head.php'; ?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<div class="container mt-5">
    <h2>Agregar Plato</h2>
    <form method="POST" action="../../controladores/controlador_plato/PlatoController.php?accion=guardar">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" class="form-control" required min="0" step="0.01">
        </div>
        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../../controladores/controlador_plato/PlatoController.php?accion=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>