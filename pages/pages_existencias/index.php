<?php
require_once("../../controladores/controlador_usuario/validar_sesion.php");
require_once '../../controladores/controlador_existencias/InventarioController.php';
require_once '../../modelos/modelo_existencias/InventarioModel.php';
include '../../pages/pages_layout/menu_admin.php';

$modelo = new InventarioModel();
$productos = $modelo->obtenerInventario();
$movimientos = $modelo->obtenerMovimientos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Existencias</title>
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
<?php include '../pages_layout/head.php'; ?>

<!-- CONTENEDOR GENERAL AJUSTADO -->
<div class="contenido-ajustado">
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="layout-contenedor">
        
        <!-- LADO IZQUIERDO: Formularios -->
        <div class="formularios-lateral">
            <div class="form-card">
                <?php include 'formulario_registro.php'; ?>
            </div>
            <div class="form-card">
                <?php include 'formulario.php'; ?>
            </div>
        </div>

        <!-- LADO DERECHO: Tablas -->
        <div class="tablas-contenedor">
            <div class="tabla-card">
                <h2>Existencias actuales</h2>
                <table id="tabla-existencias" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= $p['nombre'] ?></td>
                                <td><?= $p['stock'] ?></td>
                                <td class="text-center">
                                    <form method="POST" action="../../controladores/controlador_existencias/InventarioController.php" onsubmit="return confirm('¿Seguro que desea eliminar este producto?');" style="display:inline;">
                                        <input type="hidden" name="eliminar_producto" value="1">
                                        <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn-dt-eliminar">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tabla-card">
                <h2>Movimientos recientes</h2>
                <div class="table-responsive">
                    <table id="tabla-movimientos" class="display">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                                <th>Obs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movimientos as $m): ?>
                                <tr>
                                    <td><?= $m['nombre'] ?></td>
                                    <td><?= ucfirst($m['tipo']) ?></td>
                                    <td><?= $m['cantidad'] ?></td>
                                    <td><?= $m['fecha'] ?></td>
                                    <td><?= $m['observaciones'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- CIERRE de layout-contenedor -->
</div> <!-- CIERRE de contenido-ajustado -->





<script>
    $(document).ready(function() {
        $('#tabla-existencias').DataTable({
            responsive: true,
            scrollX: false,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [ [4, 10, 15, 20, -1], [4, 10, 15, 20, "Todos"] ]
        });

        $('#tabla-movimientos').DataTable({
            responsive: true,
            scrollX: false,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [ [5, 10, 15, 20, -1], [5, 10, 15, 20, "Todos"] ]
        });
    });
</script>

<?php include '../pages_layout/footer.php'; ?>
</body>
</html>
