<?php
require_once("../../modelos/modelo_usuario/Usuarios.php");
$ModeloUsuario = new Usuarios();
$ModeloUsuario->validateSession();

?>

<?php
require_once("../../modelos/modelo_empleado/Empleados.php");
$Modelo = new Empleados();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Empleados</title>
    <link rel="stylesheet" href="../../assets/estilos.css">

</head>
<body>
    <h1>Empleados</h1>
    <a href="add.php">Registrar Empleado</a><br><br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Documento</th>
            <th>Correo</th>
            <th>Cargo</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>

        <?php
        $Empleados = $Modelo->get();
        if ($Empleados !== null) {
            foreach ($Empleados as $Empleado) {
        ?>
        <tr>
            <td><?php echo $Empleado['ID_EMPLEADO']; ?></td>
            <td><?php echo $Empleado['NOMBRE']; ?></td>
            <td><?php echo $Empleado['APELLIDO']; ?></td>
            <td><?php echo $Empleado['DOCUMENTO']; ?></td>
            <td><?php echo $Empleado['CORREO']; ?></td>
            <td><?php echo $Empleado['CARGO']; ?></td>
            <td><?php echo $Empleado['FECHA_REGISTRO']; ?></td>
            <td>
                <a href="edit.php?Id=<?php echo $Empleado['ID_EMPLEADO']; ?>">Editar</a> |
                <a href="delete.php?Id=<?php echo $Empleado['ID_EMPLEADO']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php
            }
        }
        ?>
    </table>
</body>
</html>
