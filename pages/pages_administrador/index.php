<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificación de sesión
if (!isset($_SESSION['ID']) || $_SESSION['ID'] !== true) {
    header("Location: ../../pages/pages_login/login.php");
    exit();
}

// Capturamos el nombre del admin desde la sesión
$nombreAdmin = isset($_SESSION['NOMBRE']) ? $_SESSION['NOMBRE'] : 'Invitado';

require_once("../../modelos/modelo_administrador/Administradores.php");
require_once("../../modelos/modelo_dashboard/Dashboard.php"); 

include '../../pages/pages_layout/menu_admin.php';
include '../pages_layout/head.php';

// Instancias de las clases
$Modelo = new Administradores();
$dashboard = new Dashboard();

// Obtenemos datos
$totalUsuarios = $dashboard->getUsuariosRegistrados();
$totalReservas = $dashboard->getReservasRegistradas();
$totalPlatos = $dashboard->getPlatosVendidos();

// Datos para gráficas
$mesasEstado = $dashboard->getMesasEstado();
$platosVendidosHoy = $dashboard->getPlatosVendidosHoy();

$labelsPlatos = array_column($platosVendidosHoy, 'Nombre');
$valoresPlatos = array_column($platosVendidosHoy, 'total_vendidos');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body> 

<div class="container mt-4">
    <div class="text-center p-3" style="background-color: #4b2c0a; color: white; border-radius: 8px;">
        Bienvenido administrador <strong><?php echo htmlspecialchars($nombreAdmin); ?></strong>
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Panel de Administración</h2>

    <div class="row">
        <!-- Usuarios -->
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background-color:rgb(80, 48, 27);">
                <div class="card-body text-center">
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <p class="card-text display-5"><?= $totalUsuarios ?></p>
                </div>
            </div>
        </div>

        <!-- Reservas -->
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background-color:rgb(171, 96, 46);">
                <div class="card-body text-center">
                    <h5 class="card-title">Reservas Registradas</h5>
                    <p class="card-text display-5"><?= $totalReservas ?></p>
                </div>
            </div>
        </div>

        <!-- Platos -->
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background-color: #6e4b34;">
                <div class="card-body text-center">
                    <h5 class="card-title">Platos vendidos</h5>
                    <p class="card-text display-5"><?= $totalPlatos ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row mt-4">
        <!-- Estado de mesas -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3" style="background-color: #fffaf5; border: 1px solid #d1a684;">
                <h5 class="mb-3">Estado de las Mesas</h5>
                <canvas id="chartMesas"></canvas>
            </div>
        </div>

        <!-- Platos vendidos hoy -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3" style="background-color: #fffaf5; border: 1px solid #d1a684;">
                <h5 class="mb-3">Platos vendidos hoy</h5>
                <canvas id="chartPlatos"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="btn-registrarAdministrador">
        <a href="add.php" class="btn-registro">Lista y Registro de Usuarios</a>
        <a href="pages_reportes.php" class="btn-registro"> Reporte de Ventas</a>
    </div>
</div>



<?php include '../pages_layout/footer.php'; ?>

<script>
  // Pie Chart - Mesas
  const ctxMesas = document.getElementById('chartMesas').getContext('2d');
  new Chart(ctxMesas, {
    type: 'pie',
    data: {
      labels: ['Disponibles', 'Reservadas', 'Ocupadas'],
      datasets: [{
        data: [
          <?= $mesasEstado['Disponible'] ?>,
          <?= $mesasEstado['Reservada'] ?>,
          <?= $mesasEstado['Ocupada'] ?>
        ],
        backgroundColor: ['#198754', '#ffc107', '#dc3545']
      }]
    }
  });

  // Bar Chart - Platos vendidos hoy
  const ctxPlatos = document.getElementById('chartPlatos').getContext('2d');
  new Chart(ctxPlatos, {
    type: 'bar',
    data: {
      labels: <?= json_encode($labelsPlatos) ?>,
      datasets: [{
        label: 'Platos vendidos',
        data: <?= json_encode($valoresPlatos) ?>,
        backgroundColor: '#ab602e'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

</body>
</html>
