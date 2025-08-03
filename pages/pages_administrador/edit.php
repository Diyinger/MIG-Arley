<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php");
require_once("../../modelos/modelo_administrador/Administradores.php");
$Modelo = new Administradores();

$Id = $_GET['Id'];
$Admin = $Modelo->getById($Id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../../css/add_delet_edit_admin.css">

</head>
<body>
    <h1>Editar Administrador</h1>
    <form method="POST" action="../../controladores/controlador_administrador/edit.php">
        <input type="hidden" name="Id" value="<?php echo $Id; ?>">

        <?php foreach ($Admin as $Info) { ?>
            Nombre: <br><input type="text" name="Nombre" value="<?php echo $Info['NOMBRE']; ?>"><br><br>
            Apellido: <br><input type="text" name="Apellido" value="<?php echo $Info['APELLIDO']; ?>"><br><br>
            Usuario: <br><input type="text" name="Usuario" value="<?php echo $Info['USUARIO']; ?>"><br><br>
            Password: <br><input type="password" name="Password" value="<?php echo $Info['PASSWORD']; ?>"><br><br>
            Estado: <br>
            <select name="Estado" required>
                <option value="Activo" <?php if($Info['ESTADO'] == 'Activo') echo 'selected'; ?>>Activo</option>
                <option value="Inactivo" <?php if($Info['ESTADO'] == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
            </select><br><br>
        <?php } ?>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>