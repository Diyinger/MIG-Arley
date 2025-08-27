<?php
// ¡Sesión ANTES de imprimir HTML!
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../pages/pages_layout/menu_admin.php';
include '../../pages/pages_layout/head.php';

require_once '../../Conexion.php';

$conn = Conexion::getInstancia()->getConexion();
$sql = "SELECT MesaID, Numero, Capacidad, Estado FROM mesas";
$stmt = $conn->query($sql);
$mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mesas</title>
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
    <h2>Lista de Mesas</h2>

    <?php if (!empty($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="../../controladores/controlador_mesa/MesaController.php?accion=agregar" class="btn btn-success mb-3">Agregar Mesa</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Capacidad</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($mesas as $mesa): ?>
        <tr>
            <td><?= $mesa['MesaID'] ?></td>
            <td><?= $mesa['Numero'] ?></td>
            <td><?= $mesa['Capacidad'] ?></td>
            <td><?= $mesa['Estado'] ?></td>
            <td>
            <a href="../../controladores/controlador_mesa/MesaController.php?accion=editar&id=<?= $mesa['MesaID'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="../../controladores/controlador_mesa/MesaController.php?accion=eliminar&id=<?= $mesa['MesaID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta mesa?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php include '../../pages/pages_layout/footer.php'; ?>
