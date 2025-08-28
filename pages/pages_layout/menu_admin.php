<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="sidebar-menu">
    <h2>Menú</h2>
    
    <?php if ($_SESSION['ROL'] === 'Administrador'): ?>
        <!-- Menú completo para administradores -->
        <a href="../../pages/pages_administrador/index.php">
            <i class="fas fa-home"></i><span> Inicio</span>
        </a>
        <a href="../../pages/pages_existencias/index.php">
            <i class="fas fa-boxes"></i><span> Existencias</span>
        </a>
        <a href="../../pages/pages_pedidos/index.php">
            <i class="fas fa-receipt"></i><span> Pedidos</span>
        </a>
        <a href="../../pages/pages_reservas/reserva.php">
            <i class="fas fa-calendar-alt"></i><span> Reservas</span>
        </a>
        <a href="../../controladores/controlador_plato/PlatoController.php?accion=index">
            <i class="fas fa-utensils"></i><span> Platos</span>
        </a>
        <a href="../../pages/pages_mesas/mesas.php">
            <i class="fas fa-chair"></i><span> Mesas</span>
        </a>
        <a href="../../pages/pages_administrador/add.php">
            <i class="fas fa-users"></i><span> Lista y Registro de Usuarios</span>
        </a>
        <a href="../../pages/pages_administrador/pages_reportes.php">
            <i class="fas fa-chart-line"></i><span> Reporte de Ventas</span>
        </a>
    <?php else: ?>
        <!-- Menú limitado para meseros -->
        <a href="../../pages/pages_pedidos/index.php">
            <i class="fas fa-receipt"></i><span> Pedidos</span>
        </a>
        <a href="../../pages/pages_reservas/reserva.php">
            <i class="fas fa-calendar-alt"></i><span> Reservas</span>
        </a>
        <a href="../../pages/pages_mesas/mesas.php">
            <i class="fas fa-chair"></i><span> Mesas</span>
        </a>
    <?php endif; ?>
</div>
