<?php
session_start();
require_once '../../Conexion.php';
include __DIR__ . '/../../pages/pages_layout/menu_admin.php'; 
include '../pages_layout/head.php'; 


$conn = Conexion::getInstancia()->getConexion();
$stmtMesas = $conn->query("SELECT * FROM mesas WHERE Estado = 'Disponible'");
$mesas = $stmtMesas->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT * FROM reservas ORDER BY fecha DESC, hora DESC");
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilosReservas.css">
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">

</head>

<body class="bg-light">

<div class="d-flex">
    <!-- Menú lateral -->
    <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
    </div>

    <!-- Contenido principal -->
    <div class="container mt-5 flex-grow-1">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Reservas del Restaurante</h2>

        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
            <?php unset($_SESSION['exito']); ?>
        <?php endif; ?>

        <!-- Formulario de reservas -->
        <form action="../../controladores/controlador_reservas/ReservaController.php?accion=guardar" method="POST" class="card p-4 shadow-sm mb-4 needs-validation" novalidate>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required pattern="[A-Za-z\s]+" title="Solo letras">
                    <div class="invalid-feedback">Ingrese un nombre válido.</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" required>
                    <div class="invalid-feedback">Seleccione una fecha.</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                    <div class="invalid-feedback">Seleccione una hora.</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Personas</label>
                    <input type="number" name="personas" class="form-control" required min="1" max="50">
                    <div class="invalid-feedback">Ingrese entre 1 y 50 personas.</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Mesa disponible</label>
                    <select name="mesa_id" class="form-select" required>
                        <option value="">Seleccione una mesa</option>
                        <?php foreach ($mesas as $mesa): ?>
                            <option value="<?= $mesa['MesaID'] ?>">
                                Mesa <?= htmlspecialchars($mesa['Numero']) ?> - Capacidad: <?= htmlspecialchars($mesa['Capacidad']) ?> personas
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Seleccione una mesa.</div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Agregar Reserva</button>
        </form>

        <!-- Tabla de reservas -->
        <div class="card shadow-sm p-3">
            <h5 class="mb-3">Listado de Reservas</h5>
            <table class="table table-bordered table-hover">
                <thead class="encabezado-reservas">
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                            <td><?= $reserva['fecha'] ?></td>
                            <td><?= $reserva['hora'] ?></td>
                            <td><?= $reserva['personas'] ?></td>
                            <td>
                                <a href="../../controladores/controlador_reservas/ReservaController.php?accion=editar&id=<?= $reserva['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="../../controladores/controlador_reservas/ReservaController.php?accion=eliminar&id=<?= $reserva['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div> <!-- Fin contenido principal -->
</div> <!-- Fin d-flex -->

<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

<?php include '../pages_layout/footer.php'; ?>
</body>
</html>
