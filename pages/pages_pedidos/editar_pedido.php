<?php
$titulo = "Editar Pedido";
include __DIR__ . '/../../pages/pages_layout/menu_admin.php';
include __DIR__ . '/../pages_layout/head.php';

?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<div class="container mt-5">
    <h2>Editar Pedido</h2>
    <form method="POST" action="../../controladores/controlador_pedidos/pedidosControllers.php?accion=actualizar">
        <input type="hidden" name="pedido_id" value="<?= $pedido['PedidoID'] ?>">

        <div class="mb-3">
    <label>Tipo de Pedido</label>
    <select name="tipo_pedido" class="form-control" required>
        <option value="mesa" <?= $pedido['tipo_pedido'] == 'mesa' ? 'selected' : '' ?>>Mesa</option>
        <option value="domicilio" <?= $pedido['tipo_pedido'] == 'domicilio' ? 'selected' : '' ?>>Domicilio</option>
    </select>
</div>

<?php if ($pedido['tipo_pedido'] == 'mesa'): ?>
<div class="mb-3" id="mesaDiv">
    <label>Número de Mesa</label>
    <input type="number" name="mesa" class="form-control" value="<?= $pedido['Mesa'] ?>">
</div>
<?php endif; ?>

<div class="mb-3" id="direccionDiv" style="display: <?= $pedido['tipo_pedido'] == 'domicilio' ? 'block' : 'none' ?>;">
    <label>Dirección de Entrega</label>
    <textarea name="direccion" class="form-control" rows="2"><?= htmlspecialchars($pedido['direccion'] ?? '') ?></textarea>
</div>

<div class="mb-3" id="telefonoDiv" style="display: <?= $pedido['tipo_pedido'] == 'domicilio' ? 'block' : 'none' ?>;">
    <label>Teléfono</label>
    <input type="tel" name="telefono" class="form-control" value="<?= htmlspecialchars($pedido['telefono'] ?? '') ?>">
</div>

        <div class="mb-3">
            <label>Platos</label>
            <div id="platos-container">
                <?php while ($plato = $platos->fetch(PDO::FETCH_ASSOC)):
                    $checked = isset($platosPedido[$plato['PlatoID']]);
                    $cantidad = $checked ? $platosPedido[$plato['PlatoID']] : '';
                ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="platos[]" value="<?= $plato['PlatoID'] ?>" id="plato<?= $plato['PlatoID'] ?>" <?= $checked ? 'checked' : '' ?>>
                        <label class="form-check-label" for="plato<?= $plato['PlatoID'] ?>">
                            <?= $plato['nombre'] ?> ($<?= number_format($plato['precio'], 0) ?>)
                        </label>
                        <input type="number" name="cantidades[<?= $plato['PlatoID'] ?>]" class="form-control mt-1 cantidad-input" placeholder="Cantidad" min="1" value="<?= $cantidad ?>" <?= $checked ? '' : 'disabled' ?>>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>

        <form action="index.php" method="get">
            <button class="btn btn-secondary ms-2" type="submit">Cancelar</button>
        </form>

    </form>
</div>

<script>
    document.querySelectorAll('input[type="checkbox"][name="platos[]"]').forEach(cb => {
        const cantidadInput = cb.parentElement.querySelector('.cantidad-input');
        cb.addEventListener('change', () => {
            cantidadInput.disabled = !cb.checked;
            if (!cb.checked) cantidadInput.value = '';
        });
    });

    // Manejo del tipo de pedido
    document.querySelector('select[name="tipo_pedido"]').addEventListener('change', function() {
        const mesaDiv = document.getElementById('mesaDiv');
        const direccionDiv = document.getElementById('direccionDiv');
        const telefonoDiv = document.getElementById('telefonoDiv');

        if (this.value === 'mesa') {
            mesaDiv.style.display = 'block';
            direccionDiv.style.display = 'none';
            telefonoDiv.style.display = 'none';
        } else if (this.value === 'domicilio') {
            mesaDiv.style.display = 'none';
            direccionDiv.style.display = 'block';
            telefonoDiv.style.display = 'block';
        }
    });
</script>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>