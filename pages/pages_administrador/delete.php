<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php"); ?>
<?php $Id = $_GET['Id']; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Administrador</title>
    <link rel="stylesheet" href="../../public/css/add_delet_edit_admin.css">

</head>
<body>
    <h1>Eliminar Administrador</h1>
    <form method="POST" action="../../controladores/controlador_administrador/delete.php">
        <input type="hidden" name="Id" value="<?php echo $Id; ?>">
        <p>¿Estás seguro que deseas eliminar este administrador?</p>
        <input type="submit" value="Eliminar">
    </form>
</body>
</html>