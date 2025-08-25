<?php
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
    <link rel="stylesheet" href="../../css/formularioAdd.css">
</head>
<body>
    <?php include '../pages_layout/head.php'; ?>

    <h1>Editar Administrador</h1>

    <div class="formularios-contenedor">
        <div class="form-card">
            <h3>Formulario de Edición</h3>
            <form method="POST" action="../../controladores/controlador_administrador/edit.php">
                <input type="hidden" name="Id" value="<?php echo $Id; ?>">

                <?php foreach ($Admin as $Info) { ?>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="Nombre" value="<?php echo $Info['NOMBRE']; ?>" required>

                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="Apellido" value="<?php echo $Info['APELLIDO']; ?>" required>

                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="Usuario" value="<?php echo $Info['USUARIO']; ?>" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="Password" value="<?php echo $Info['PASSWORD']; ?>" required>

                    <label for="estado">Estado:</label>
                    <select id="estado" name="Estado" required>
                        <option value="Activo" <?php if($Info['ESTADO'] == 'Activo') echo 'selected'; ?>>Activo</option>
                        <option value="Inactivo" <?php if($Info['ESTADO'] == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
                    </select>
                <?php } ?>

                <input type="submit" value="Actualizar">
            </form>

            <!-- Botón para volver -->
            <a href="index.php" class="btn-volver">Volver a la lista de administradores</a>
        </div>
    </div>
    <?php include '../pages_layout/footer.php'; ?>

</body>
</html>
