<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2>Editar Mesa</h2>

    <form action="indexD.php?url=mesa/actualizar" method="POST">
        <input type="hidden" name="mesa_id" value="<?= $mesa['MesaID'] ?>">

        <div class="mb-3">
            <label for="numero" class="form-label">Número de mesa</label>
            <input type="number" class="form-control" name="numero" value="<?= $mesa['Numero'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" class="form-control" name="capacidad" value="<?= $mesa['Capacidad'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="indexD.php?url=mesa/index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
