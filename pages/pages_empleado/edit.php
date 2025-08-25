<?php
require_once("../../Usuarios/Modelo/Usuarios.php");
$ModeloUsuario = new Usuarios();
$ModeloUsuario->validateSession();
?>

<?php
require_once("../../Empleados/Modelo/Empleados.php");
$Modelo = new Empleados();

$Id = $_GET['Id'];
$Empleado = $Modelo->getById($Id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="../../assets/estilos.css">

</head>
<body>
    <h1>Editar Empleado</h1>
    <form method="POST" action="../Controladores/edit.php">
        <input type="hidden" name="Id" value="<?php echo $Id; ?>">

        <?php foreach ($Empleado as $Info) { ?>
            Nombre: <br><input type="text" name="Nombre" value="<?php echo $Info['NOMBRE']; ?>"><br><br>
            Apellido: <br><input type="text" name="Apellido" value="<?php echo $Info['APELLIDO']; ?>"><br><br>
            Documento: <br><input type="text" name="Documento" value="<?php echo $Info['DOCUMENTO']; ?>"><br><br>
            Correo: <br><input type="email" name="Correo" value="<?php echo $Info['CORREO']; ?>"><br><br>
            Cargo: <br><input type="text" name="Cargo" value="<?php echo $Info['CARGO']; ?>"><br><br>
        <?php } ?>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>
