<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Administrador</title>
    <link rel="stylesheet" href="../../public/css/add_delet_edit_admin.css">

</head>
<body>
    
    <h1>Registrar Administrador</h1>
    
    <form method="POST" action="../../controladores/controlador_administrador/add.php">
        Nombre: <br><input type="text" name="Nombre" required><br><br>
        Apellido: <br><input type="text" name="Apellido" required><br><br>
        Usuario: <br><input type="text" name="Usuario" required><br><br>
        Password: <br><input type="password" name="Password" required><br><br>
        <input type="submit" value="Registrar">
    </form>
    <button>
        <a href="index.php">Volver a la lista de administradores</a>
    </button>
</body>
</html>