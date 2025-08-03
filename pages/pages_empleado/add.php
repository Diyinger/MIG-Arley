<?php
require_once("../../Usuarios/Modelo/Usuarios.php");
$ModeloUsuario = new Usuarios();
$ModeloUsuario->validateSession();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Empleado</title>
    <link rel="stylesheet" href="../../assets/estilos.css">

</head>
<body>
    <h1>Registrar Empleado</h1>
    <form method="POST" action="../Controladores/add.php">
        Nombre: <br><input type="text" name="Nombre" required><br><br>
        Apellido: <br><input type="text" name="Apellido" required><br><br>
        Documento: <br><input type="text" name="Documento" required><br><br>
        Correo: <br><input type="email" name="Correo" required><br><br>
        Cargo: <br><input type="text" name="Cargo" required><br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
