<?php include('../../pages/pages_layout/head.php'); ?>
<link rel="stylesheet" href="../../css/estilosReservas.css">

<div class="container mt-5">
    <h2 class="mb-4">Editar Reserva</h2>

    <form action="../../controladores/controlador_reservas/ReservaController.php?accion=actualizar" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($reserva['nombre']) ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" required value="<?= $reserva['fecha'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Hora</label>
                <input type="time" name="hora" class="form-control" required value="<?= $reserva['hora'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Personas</label>
                <input type="number" name="personas" class="form-control" required value="<?= $reserva['personas'] ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Mesa disponible</label>
                <select name="mesa_id" class="form-select" required>
                    <option value="">Seleccione una mesa</option>
                    <?php foreach ($mesas as $mesa): ?>
                        <option value="<?= $mesa['MesaID'] ?>" <?= $mesa['MesaID'] == $reserva['mesa_id'] ? 'selected' : '' ?>>
                            Mesa <?= htmlspecialchars($mesa['Numero']) ?> - Capacidad: <?= htmlspecialchars($mesa['Capacidad']) ?> personas
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        <a href="../../pages/pages_reservas/reserva.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include('../../pages/pages_layout/footer.php'); ?>