<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../../css/formularioAdd.css">
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
    <link rel="stylesheet" href="../../css/add_delet_edit_admin.css">
   <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <?php
    include '../../pages/pages_layout/menu_admin.php';
    
    include '../pages_layout/head.php'; ?>
    <h1>Registrar Usuario</h1>
<br><br><br>
    <div class="formularios-contenedor" style="display: flex; gap: 40px; justify-content: center; align-items: flex-start;">
        <div class="form-card" style="flex: 1; min-width: 320px; max-width: 400px;">
            <h3>Formulario de Registro</h3>
            <form method="POST" action="../../controladores/controlador_administrador/add.php">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="Nombre" required>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="Apellido" required>
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="Usuario" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="Password" required>
                <input type="submit" value="Registrar">
            </form>
            <!-- Botón para volver -->
            <a href="index.php" class="btn-volver">Volver a la lista</a>
        </div>

        <div class="tabla-card" style="flex: 2; min-width: 800px;">
            <h2>Lista de Usuarios</h2>
            <?php
            require_once("../../modelos/modelo_administrador/Administradores.php");
            $Modelo = new Administradores();
            $Lista = $Modelo->get();
            ?>
            <table id="tabla-usuarios" class="display" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
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
                            <a href="edit.php?Id=<?php echo $Admin['ID_USUARIO']; ?>" class="btn-registro" style="padding:6px 12px; font-size:13px;">Editar</a>
                            <a href="delete.php?Id=<?php echo $Admin['ID_USUARIO']; ?>" class="btn-registro" style="background-color:#a0522d; padding:6px 12px; font-size:13px;">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php }} ?>
                </tbody>
            </table>
        </div>
                        </div>
                    


<?php include '../pages_layout/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#tabla-usuarios').DataTable({
            responsive: true,
            scrollX: false,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [ [4, 10, 15, 20, -1], [4, 10, 15, 20, "Todos"] ]
        });
    });
</script>
</body>
</html>
