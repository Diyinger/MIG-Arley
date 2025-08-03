<?php
$titulo = "Editar Pedido";
include __DIR__ . '/../pages_layout/head.php';
?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<div class="container mt-5">
    <h2>Editar Pedido</h2>
    <form method="POST" action="../../controladores/controlador_pedidos/pedidosControllers.php?accion=actualizar">
    <input type="hidden" name="pedido_id" value="<?= $pedido['PedidoID'] ?>">

        <div class="mb-3">
            <label>Nombre del Cliente</label>
            <input type="text" name="cliente" class="form-control" value="<?= htmlspecialchars($pedido['Cliente']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Número de Mesa</label>
            <input type="number" name="mesa" class="form-control" value="<?= $pedido['Mesa'] ?>" required>
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
</script>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>