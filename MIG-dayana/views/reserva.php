<?php include 'views/header.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Reservas del Restaurante</h2>
            <a href="index.php?url=auth/dashboard" class="btn btn-secondary">Volver al Panel</a>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['exito'])): ?>
                <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
                <?php unset($_SESSION['exito']); ?>
            <?php endif; ?>

        </div>

        <form action="index.php?url=reserva/guardar" method="POST" class="card p-4 shadow-sm mb-4 needs-validation" novalidate>
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
            </div>
            <button type="submit" class="btn btn-success">Agregar Reserva</button>
        </form>


        <div class="card shadow-sm p-3">
            <h5 class="mb-3">Listado de Reservas</h5>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
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
                                <a href="index.php?url=reserva/editar&id=<?= $reserva['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?url=reserva/eliminar&id=<?= $reserva['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

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

<?php include 'views/footer.php'; ?>
</body>

</html>