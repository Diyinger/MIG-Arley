<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php"); 
?>
<?php $Id = $_GET['Id']; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Administrador</title>
    <link rel="stylesheet" href="../../css/formularioAdd.css">
</head>
<body>
    <?php include '../pages_layout/head.php'; ?>

    <h1>Eliminar Administrador</h1>

    <div class="formularios-contenedor">
        <div class="form-card">
            <h3>Confirmación</h3>
            <form method="POST" action="../../controladores/controlador_administrador/delete.php">
                <input type="hidden" name="Id" value="<?php echo $Id; ?>">
                <p style="text-align:center; margin-bottom: 20px;">
                    ¿Estás seguro que deseas eliminar este administrador?
                </p>
                <input type="submit" value="Eliminar" class="btn-dt-eliminar">
            </form>

            <a href="index.php" class="btn-volver">Volver a la lista de administradores</a>
        </div>
    </div>

    <?php include '../pages_layout/footer.php'; ?>
</body>
</html>
