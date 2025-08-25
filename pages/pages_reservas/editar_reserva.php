<?php
include __DIR__ . '/../../pages/pages_layout/menu_admin.php'; 

include '../../pages/pages_layout/head.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilosReservas.css">
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
</head>
<body>
    <div class="container mt-5">
    <h2>Editar Reserva</h2>

    <form action="../../controladores/controlador_reservas/ReservaController.php?accion=actualizar" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($reserva['nombre']) ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" value="<?= $reserva['fecha'] ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Hora</label>
                <input type="time" name="hora" class="form-control" value="<?= $reserva['hora'] ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Personas</label>
                <input type="number" name="personas" class="form-control" value="<?= $reserva['personas'] ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Mesa</label>
                <select name="mesa_id" class="form-select" required>
                    <?php foreach ($mesas as $mesa): ?>
                        <option value="<?= $mesa['MesaID'] ?>" 
                            <?= ($mesa['MesaID'] == $reserva['mesa_id']) ? 'selected' : '' ?>>
                            Mesa <?= htmlspecialchars($mesa['Numero']) ?> (Cap: <?= $mesa['Capacidad'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button href="../../pages/pages_reservas/reserva.php" class="btn btn-primary">Cancelar</button>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
    
        
</div>
<?php include '../../pages/pages_layout/footer.php'; ?>

</body>
</html>
