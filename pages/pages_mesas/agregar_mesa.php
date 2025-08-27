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
  <title>Agregar Mesa</title>
  <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Agregar Mesa</h2>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form method="POST" action="../../controladores/controlador_mesa/MesaController.php?accion=guardar">
    <div class="mb-3">
      <label for="numero" class="form-label">Número de Mesa</label>
      <input type="number" class="form-control" id="numero" name="numero" required>
    </div>
    <div class="mb-3">
      <label for="capacidad" class="form-label">Capacidad</label>
      <input type="number" class="form-control" id="capacidad" name="capacidad" required>
    </div>
    <div class="mb-3">
      <label for="estado" class="form-label">Estado</label>
      <select class="form-control" id="estado" name="estado" required>
        <option value="Disponible" selected>Disponible</option>
        <option value="Ocupada">Ocupada</option>
        <option value="Reservada">Reservada</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="mesas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
<?php include '../../pages/pages_layout/footer.php'; ?>
