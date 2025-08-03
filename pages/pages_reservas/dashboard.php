<?php include '../pages_layout/head.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Bienvenido al Panel de Administración</h2>

    <div class="row">
        <!-- Total de reservas de hoy -->
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background-color:rgb(80, 48, 27);">
                <div class="card-body">
                    <h5 class="card-title">Reservas para hoy</h5>
                    <p class="card-text display-5"><?= $totalReservasHoy ?? 0 ?></p>
                </div>
            </div>
        </div>

        <!-- Mesas disponibles -->
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background-color:rgb(171, 96, 46);">
                <div class="card-body">
                    <h5 class="card-title">Mesas disponibles</h5>
                    <p class="card-text display-5"><?= $mesasDisponibles ?? 0 ?></p>
                </div>
            </div>
        </div>

        
        <!-- Total de mesas -->
        <div class="col-md-4">
            <div  class="card text-white mb-3" style="background-color: #6e4b34;">
                <div  class="card-body">
                    <h5 class="card-title">Total de mesas</h5>
                    <p class="card-text display-5"><?= $totalMesas ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximas reservas -->
    <div class="card shadow-sm mt-4">
        <div class="card-header  text-white" style="background-color: #6e4b34;">
            Próximas reservas
        </div>
        <div class="card-body">
            <pre>
</pre>

            <?php if (!empty($proximasReservas)): ?>
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
                        <?php foreach ($proximasReservas as $reserva): ?>
                            <tr>
                                <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                                <td><?= $reserva['fecha'] ?></td>
                                <td><?= $reserva['hora'] ?></td>
                                <td><?= $reserva['personas'] ?></td>
                                <td><?= $reserva['mesa_id'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay reservas próximas.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<form action="reserva.php" method="POST">
    <button class="btn btn-secondary" type="submit">Volver a reservas</button>
</form>
<!-- <a href="index.php?url=reserva/reporteMensual" class="btn mt-3" style="background-color:rgb(224, 156, 53);">Ver reporte mensual</a> -->

<?php include '../pages_layout/footer.php'; ?>