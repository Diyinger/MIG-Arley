<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2>Agregar nueva mesa</h2>

    <form action="indexD.php?url=mesa/guardar" method="POST">
        <div class="mb-3">
            <label for="numero" class="form-label">Número de mesa</label>
            <input type="number" class="form-control" name="numero" required>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad (número de personas)</label>
            <input type="number" class="form-control" name="capacidad" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar mesa</button>
        <a href="indexD.php?url=mesa/index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
