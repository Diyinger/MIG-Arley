<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificación de sesión
if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
    header("Location: ../../pages/pages_login/login.php");
    exit();
}

require_once("../../modelos/modelo_administrador/Administradores.php");
include '../pages_layout/head.php';
$Modelo = new Administradores();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administradores</title>
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body><br><br>
    <h1>Administradores</h1>
<!-- Contenedor flex para los botones -->
<div class="custom-btn-container">
    <a href="add.php" class="custom-btn">Registrar Administrador</a>
    <a href="../pages_existencias/index.php" class="custom-btn">Existencias</a>
    <a href="../pages_pedidos/index.php" class="custom-btn">Tickets/Pedidos</a>
    <a href="../pages_reservas/reserva.php" class="custom-btn">Reservas</a>
    <a href="../../controladores/controlador_plato/PlatoController.php?accion=index" class="custom-btn">Platos</a>
    <a href="../pages_domicilio/index.php" class="custom-btn">Domicilios</a>
</div>


<br> <br>

    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Perfil</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php
        $Lista = $Modelo->get();
        if ($Lista !== null) {
            foreach ($Lista as $Admin) {
        ?>
        <tr>
            <td><?php echo $Admin['ID_USUARIO']; ?></td>
            <td><?php echo $Admin['NOMBRE']; ?></td>
            <td><?php echo $Admin['APELLIDO']; ?></td>
            <td><?php echo $Admin['USUARIO']; ?></td>
            <td><?php echo $Admin['PERFIL']; ?></td>
            <td><?php echo $Admin['ESTADO']; ?></td>
            <td>
                <div class="d-flex gap-3">
    <a href="edit.php?Id=<?php echo $Admin['ID_USUARIO']; ?>">Editar</a> |
                <a href="delete.php?Id=<?php echo $Admin['ID_USUARIO']; ?>">Eliminar</a>

</div>
            </td>
        </tr>
        <?php }} ?>
    </table>
    <a href="../../controladores/controlador_usuario/Salir.php" class="custom-btn">Cerrar sesion</a>
    <?php include '../pages_layout/footer.php'; ?>
    
</body>
</html>