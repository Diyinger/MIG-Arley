<?php include 'header.php'; 
include 'header.php';
require_once '../../config/Conexion.php';

$conn = Conexion::getInstancia()->getConexion();

$stmt = $conn->query("SELECT * FROM mesas");
$mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4 shadow" style="max-width: 600px; width: 100%;">
        <h3 class="mb-4 text-center">Agregar Reserva</h3>

        <form id="formReserva" action="../../controladores/controlador_reservas/ReservaController.php?accion=guardar" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Cliente</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>

            <div class="mb-3">
                <label for="personas" class="form-label">Número de Personas</label>
                <input type="number" class="form-control" id="personas" name="personas" min="1" required>
            </div>

            <div class="mb-3">
                <label for="mesa_id" class="form-label">Mesa disponible</label>
                <select class="form-select" id="mesa_id" name="mesa_id" required>
                    <option value="">Seleccione una mesa</option>
                    <?php foreach ($mesas as $mesa): ?>
                        <option value="<?= htmlspecialchars($mesa['MesaID']) ?>"
                                data-capacidad="<?= htmlspecialchars($mesa['Capacidad']) ?>">
                            Mesa <?= htmlspecialchars($mesa['Numero']) ?> - Capacidad: <?= htmlspecialchars($mesa['Capacidad']) ?> personas
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar reserva</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger mt-3"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('formReserva').addEventListener('submit', function(e) {
    var personas = parseInt(document.getElementById('personas').value);
    var mesaSelect = document.getElementById('mesa_id');
    var selectedOption = mesaSelect.options[mesaSelect.selectedIndex];
    var capacidad = parseInt(selectedOption.getAttribute('data-capacidad'));

    if (mesaSelect.value === "") {
        alert("Por favor seleccione una mesa.");
        e.preventDefault();
        return;
    }

    if (personas > capacidad) {
        alert("La cantidad de personas excede la capacidad de la mesa seleccionada.");
        e.preventDefault();
    }
});
</script>

<?php include 'footer.php'; ?>
