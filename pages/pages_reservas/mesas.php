<?php include 'views/header.php'; ?>


<div class="container mt-4">
    <h2>Listado de Mesas</h2>

    <a href="index.php?url=mesa/agregar" class="btn btn-success mb-3">Agregar nueva mesa</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Número de Mesa</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mesas as $mesa): ?>
                <tr>
                    <td><?= $mesa['Numero'] ?></td>
                    <td><?= $mesa['Capacidad'] ?> personas</td>
                    <td><?= $mesa['Estado'] ?></td>
                    <td>
                        <a href="index.php?url=mesa/editar&id=<?= $mesa['MesaID'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?url=mesa/eliminar&id=<?= $mesa['MesaID'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta mesa?');">
                            Eliminar
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'views/footer.php'; ?>