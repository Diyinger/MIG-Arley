<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../pages/pages_layout/menu_admin.php';
include '../../pages/pages_layout/head.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Mesa</title>
  <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Editar Mesa</h2>
  <form method="POST" action="../../controladores/controlador_mesa/MesaController.php?accion=actualizar">
    <input type="hidden" name="mesa_id" value="<?= $mesa['MesaID'] ?>">
    <div class="mb-3">
      <label for="numero" class="form-label">Número de Mesa</label>
      <input type="number" class="form-control" id="numero" name="numero" value="<?= $mesa['Numero'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="capacidad" class="form-label">Capacidad</label>
      <input type="number" class="form-control" id="capacidad" name="capacidad" value="<?= $mesa['Capacidad'] ?>" required>
    </div>
    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-control" id="estado" name="estado" required>
        <option value="Disponible" <?= $mesa['Estado'] === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
        <option value="Ocupada" <?= $mesa['Estado'] === 'Ocupada' ? 'selected' : '' ?>>Ocupada</option>
        <option value="Reservada" <?= $mesa['Estado'] === 'Reservada' ? 'selected' : '' ?>>Reservada</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="mesas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
<?php include '../../pages/pages_layout/footer.php'; ?>
