<?php include 'views/header.php'; ?>

<div class="container mt-4">
    <h2>Reporte de reservas mensuales</h2>

    <form method="GET" action="index.php">
        <input type="hidden" name="url" value="reserva/reporteMensual">
        <div class="row mb-3">
            <div class="col">
                <label for="mes">Mes</label>
                <input type="number" min="1" max="12" name="mes" id="mes" class="form-control" value="<?= $_GET['mes'] ?? date('m') ?>">
            </div>
            <div class="col">
                <label for="anio">Año</label>
                <input type="number" min="2000" max="2100" name="anio" id="anio" class="form-control" value="<?= $_GET['anio'] ?? date('Y') ?>">
            </div>
            <div class="col d-flex align-items-end">
                <button class="btn btn-primary" type="submit">Consultar</button>
            </div>
        </div>
    </form>

    <?php if (!empty($reservas)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Personas</th>
                    <th>Mesa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $r): ?>
                    <tr>
                        <td><?= $r['nombre'] ?></td>
                        <td><?= $r['fecha'] ?></td>
                        <td><?= $r['hora'] ?></td>
                        <td><?= $r['personas'] ?></td>
                        <td><?= $r['mesa_id'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay reservas registradas en ese mes.</p>
    <?php endif; ?>
</div>

<?php include 'views/footer.php'; ?>
