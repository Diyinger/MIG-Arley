<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Listado de Reservas</h2>

    <a href="crear_reserva.php" class="btn btn-success mb-3">Nueva Reserva</a>

    <form action="index.php?url=reserva/guardar" method="POST" class="mb-3">
        <input type="hidden" name="url" value="reserva/index">
        <div class="input-group">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>


    <?php if (!empty($reservas)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Mesa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= $reserva['id'] ?></td>
                            <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                            <td><?= $reserva['fecha'] ?></td>
                            <td><?= $reserva['hora'] ?></td>
                            <td><?= $reserva['personas'] ?></td>
                            <td>Mesa<?= htmlspecialchars($reserva['numero_mesa']) ?></td>
                            <td>
                                <a href="index.php?url=reserva/editar&id=<?= $reserva['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?url=reserva/eliminar&id=<?= $reserva['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">
                                    Eliminar
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay reservas registradas.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>