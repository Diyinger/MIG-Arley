<h2>Registrar Movimiento</h2>

<form action="index.php" method="post">
    <label>Producto ID:</label>
        <input type="number" name="producto_id" required>

        <label>Tipo:</label>
        <select name="tipo">
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
        </select>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" required min="1">

        <label>Observaciones:</label>
        <textarea name="observaciones"></textarea>

        <button type="submit" name="registrar" class="btn-success">Registrar Movimiento</button>
</form>
