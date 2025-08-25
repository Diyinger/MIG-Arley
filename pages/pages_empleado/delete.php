<?php
require_once("../../Usuarios/Modelo/Usuarios.php");
$ModeloUsuario = new Usuarios();
$ModeloUsuario->validateSession();
?>

<?php
$Id = $_GET['Id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="../../assets/estilos.css">

    <meta charset="UTF-8">
    <title>Eliminar Empleado</title>
</head>
<body>
    <h1>Eliminar Empleado</h1>
    <form method="POST" action="../Controladores/delete.php">
        <input type="hidden" name="Id" value="<?php echo $Id; ?>">
        <p>¿Estás seguro que deseas eliminar este empleado?</p>
        <input type="submit" value="Eliminar">
    </form>
</body>
</html>
