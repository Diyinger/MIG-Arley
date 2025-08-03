<?php include __DIR__ . '/../pages_layout/head.php'; ?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<div class="container mt-5">
    <h2>Platos</h2>
    <a href="../../controladores/controlador_plato/PlatoController.php?accion=crear" class="btn btn-success mb-3">Agregar Plato</a><br>
    <!-- <form action="/MIG-Arley/pages/pages_administrador/index.php" method="POST">
        <button class="custom-btn" type="submit">Volver al inicio</button>
    </form> -->
    <a href="../../pages/pages_administrador/index.php" class="btn btn-secondary">Volver al inicio</a>
    <br>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($platos as $plato): ?>
            <tr>
                <td><?= $plato['PlatoID'] ?></td>
                <td><?= htmlspecialchars($plato['nombre']) ?></td>
                <td><?= htmlspecialchars($plato['descripcion']) ?></td>
                <td>$<?= number_format($plato['precio'], 0, ',', '.') ?></td>
                <td><?= $plato['cantidad'] ?></td>
                <td>
                    <a href="../../controladores/controlador_plato/PlatoController.php?accion=editar&id=<?= $plato['PlatoID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="../../controladores/controlador_plato/PlatoController.php?accion=eliminar&id=<?= $plato['PlatoID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este plato?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>