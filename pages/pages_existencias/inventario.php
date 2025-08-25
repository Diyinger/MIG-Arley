<?php
$modelo = new InventarioModel();
$productos = $modelo->obtenerInventario();
$movimientos = $modelo->obtenerMovimientos();
?>

<h2>Inventario actual</h2>
<table>
    <tr><th>Producto</th><th>Stock</th></tr>
    <?php foreach ($productos as $p): ?>
        <tr><td><?= $p['nombre'] ?></td><td><?= $p['stock'] ?></td></tr>
    <?php endforeach; ?>
</table>

<h2>Movimientos recientes</h2>
<table>
    <tr><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Fecha</th><th>Obs</th></tr>
    <?php foreach ($movimientos as $m): ?>
        <tr>
            <td><?= $m['nombre'] ?></td>
            <td><?= ucfirst($m['tipo']) ?></td>
            <td><?= $m['cantidad'] ?></td>
            <td><?= $m['fecha'] ?></td>
            <td><?= $m['observaciones'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>