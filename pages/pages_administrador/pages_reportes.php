<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
    header("Location: ../../pages/pages_login/login.php");
    exit();
}

require_once '../../Conexion.php';
include '../../pages/pages_layout/menu_admin.php';
include '../pages_layout/head.php';

$conn = Conexion::getInstancia()->getConexion();
$ventas = $conn->query("SELECT * FROM vista_ventas_detalladas ORDER BY PedidoID DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS con botones -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet"/>
</head>

<body class="bg-light">

<div class="contenido-ajustado"> <!-- 🔹 Ajusta el contenido al menú lateral -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center">📊 Reporte Detallado de Ventas</h2>

        <table id="tablaVentas" class="admin-table">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Ubicación</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($venta = $ventas->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $venta['PedidoID'] ?></td>
                        <td><?= htmlspecialchars($venta['Cliente']) ?></td>
                        <td><?= htmlspecialchars($venta['TipoPedido']) ?></td>
                        <td><?= htmlspecialchars($venta['Ubicacion']) ?></td>
                        <td><?= htmlspecialchars($venta['Telefono'] ?: '-') ?></td>
                        <td><?= $venta['FechaHora'] ?></td>
                        <td><?= htmlspecialchars($venta['Plato']) ?></td>
                        <td>$<?= number_format($venta['precio'], 0, ',', '.') ?></td>
                        <td><?= $venta['Cantidad'] ?></td>
                        <td>$<?= number_format($venta['Subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <a href="../pages_administrador/index.php" class="btn-registro"> Volver al Panel</a>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- pdfmake -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- DataTables con botones -->
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js"></script>

<script>
$(document).ready(function() {
    $('#tablaVentas').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copy', text: ' Copiar' },
            { extend: 'csv', text: ' CSV' },
            { extend: 'excel', text: ' Excel' },
            { 
                extend: 'pdf', 
                text: ' PDF',
                title: 'Reporte Detallado de Ventas',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function (doc) {
                  // Configurar estilo general
                    doc.styles.tableHeader = {
                        fillColor: '#4b2c0a',   // marrón estilo MIG
                        color: 'white',
                        alignment: 'center',
                        bold: true,
                        fontSize: 11
                    };
                    doc.styles.tableBodyOdd = {
                        fillColor: '#f9f5f0'   // filas alternas
                    };
                    doc.styles.tableBodyEven = {
                        fillColor: '#ffffff'
                    };
                    
                    // Centrar título
                    doc.content[0].alignment = 'center';
                    doc.content[0].fontSize = 16;
                    doc.content[0].bold = true;

                    // Ajustar márgenes
                    doc.pageMargins = [30, 40, 30, 30];

                    // Fuente un poco más pequeña
                    doc.defaultStyle.fontSize = 9;
                }
            },
            { extend: 'print', text: ' Imprimir' }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        }
    });
});

</script>


<?php include '../pages_layout/footer.php'; ?>
</body>
</html>
