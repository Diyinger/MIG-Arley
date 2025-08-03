<?php

$titulo = "Nuevo Producto"; 
include __DIR__ . '/../pages_layout/head.php'; 
require_once __DIR__ . '/../../controllers/dashboard.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <script src="../../assets/js/validaciones.js"></script>
</head>
<body>
    <div class="producto_container">

        <h2>Crear Producto</h2>
        <form method="POST" action="../../controladores/ProductoController.php?accion=guardar" onsubmit="return validarFormulario();">
            <label>Nombre:</label><input type="text" name="nombre" required><br>
            <label>Descripción:</label><textarea name="descripcion"></textarea><br>
            <label>Precio:</label><input type="number" step="0.01" name="precio" required><br>
            <label>Cantidad:</label><input type="number" name="cantidad" required><br>
            <button type="submit">Guardar</button>
        </form>
        <a href="index.php">Volver</a>
    </div>
</body>
</html>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>