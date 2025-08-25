<?php

$titulo = "Lista de Pedidos";

include __DIR__ . '/../../pages/pages_layout/menu_admin.php';
include __DIR__ . '/../pages_layout/head.php';

require_once '../../Conexion.php';
$conn = Conexion::getInstancia()->getConexion();

$pedidos = $conn->query("SELECT * FROM pedidos ORDER BY PedidoID DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">

    <!-- DataTables CSS con botones -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">

    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">

    <link rel="stylesheet" href="../../css/listar_pedidos.css">
</head>

<body class="bg-light">
    <div class="container pedidos-contenedor mt-5">
        <h2>Lista de Pedidos</h2>
        <table id="tablaPedidos" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Mesa/Dirección</th>
                    <th>Teléfono</th>
                    <th>Fecha y hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $pedidos->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $pedido['PedidoID'] ?></td>
                        <td><?= htmlspecialchars($pedido['Cliente']) ?></td>
                        <td>
                            <span class="badge <?= $pedido['tipo_pedido'] === 'mesa' ? 'bg-primary' : 'bg-success' ?>">
                                <?= ucfirst($pedido['tipo_pedido']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($pedido['tipo_pedido'] === 'mesa'): ?>
                                Mesa <?= $pedido['Mesa'] ?>
                            <?php else: ?>
                                <?= htmlspecialchars($pedido['direccion']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $pedido['tipo_pedido'] === 'domicilio' ? htmlspecialchars($pedido['telefono']) : '-' ?></td>
                        <td><?= $pedido['FechaHora'] ?></td>
                        <td>
                            <a href="ticket.php?id=<?= $pedido['PedidoID'] ?>" class="btn btn-sm btn-primary">Ver ticket</a>
                            <a href="../../controladores/controlador_pedidos/pedidosControllers.php?accion=editar&id=<?= $pedido['PedidoID'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="../../controladores/controlador_pedidos/pedidosControllers.php?accion=eliminar&id=<?= $pedido['PedidoID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás segura de eliminar este pedido?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-success mt-3">Crear nuevo pedido</a>
    </div>
     <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- pdfmake para PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- DataTables + botones -->
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js"></script>

    <!-- Inicializar DataTables -->
    <script>
      $(document).ready(function() {
        $('#tablaPedidos').DataTable({
          
          language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
          }
        });
      });
    </script>
</body>
<?php include __DIR__ . '/../pages_layout/footer.php'; ?>
</html>