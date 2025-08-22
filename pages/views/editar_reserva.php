<?php
require '../../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $personas = $_POST['personas'];

    // Validación en el servidor
    if (empty($nombre) || empty($fecha) || empty($hora) || empty($personas)) {
        $_SESSION['error'] = 'Todos los campos son obligatorios.';
        header('Location: editar_reserva.php?id=' . $id);
        exit;
    }

    try {
        $sql = "UPDATE reservas SET nombre = ?, fecha = ?, hora = ?, personas = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $fecha, $hora, $personas, $id]);

        $_SESSION['exito'] = '¡Reserva actualizada correctamente!';
        header('Location: dashboard.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al actualizar la reserva.';
        header('Location: editar_reserva.php?id=' . $id);
        exit;
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Editar Reserva</h2>

    <form action="index.php?url=reserva/actualizar" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required value="<?= $reserva['nombre'] ?>">
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
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        <a href="indexD.php?url=reserva/index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
