<?php
$titulo = "Nuevo Pedido";


// Incluye la clase de conexión y obtén el objeto PDO
require_once __DIR__ . '/../../config/Conexion.php';
include __DIR__ . '/../pages_layout/head.php';

$conn = Conexion::getInstancia()->getConexion();
?>
<link rel="stylesheet" href="../../public/css/estilosIndexAdmin.css">
<h2 class="mb-4">Nuevo Pedido</h2>
<h4>
<a href="../pages_administrador/index.php"  class="custom-btn" >Volver al inicio</a>
</h4>

<form action="../../controladores/controlador_pedidos/pedidosControllers.php?accion=guardar" method="POST">

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nombre del Cliente</label>
            <input type="text" name="cliente" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Número de Mesa</label>
            <input type="number" name="mesa" class="form-control" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label">Platos</label>
        <div class="border rounded p-3 bg-white shadow-sm">
            <?php
            $platos = $conn->query("SELECT * FROM platos");
            while ($plato = $platos->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="row align-items-center mb-2">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="platos[]" value="<?= $plato['PlatoID'] ?>" id="plato<?= $plato['PlatoID'] ?>">
                            <label class="form-check-label" for="plato<?= $plato['PlatoID'] ?>">
                                <?= $plato['nombre'] ?> <span class="text-muted">($<?= number_format($plato['precio'], 0, ',', '.') ?>)</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="cantidades[<?= $plato['PlatoID'] ?>]" class="form-control cantidad-input" placeholder="Cantidad" min="1" disabled>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="botonera">
        <button type="submit" class="btn btn-success">Guardar Pedido</button>
        <a href="../pages_pedidos/listar_pedidos.php" class="btn btn-ver">Ver Pedidos</a>
        <a href="../pages_administrador/index.php" class="btn btn-secondary">Cancelar</a>
    </div>

</form>

<script>
    document.querySelectorAll('input[type="checkbox"][name="platos[]"]').forEach(cb => {
        const cantidadInput = cb.closest('.row').querySelector('.cantidad-input');
        cb.addEventListener('change', () => {
            cantidadInput.disabled = !cb.checked;
            if (!cb.checked) cantidadInput.value = '';
        });
    });
</script>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>