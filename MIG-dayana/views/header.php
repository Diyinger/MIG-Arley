<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Reservas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/estilos.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <!-- Barra de navegación -->
    <?php if (isset($_SESSION['admin'])): ?>
        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="assets/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center">
                        <li class="nav-item me-2">
                            <a class="btn btn"style="background-color: #e2a140;" href="index.php?url=mesa/index">Mesas</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn" style="background-color: #e2a140;" href="index.php?url=reserva/index">Reservas</a>
                        </li>
                    </ul>


                    <?php if (isset($_SESSION['admin'])): ?>
                        <a href="index.php?url=dashboard" class="btn btn me-2" style="background-color: #e2a140;">Inicio</a>
                        <a href="index.php?url=auth/logout" class="btn btn-" style="background-color:rgb(152, 38, 18);">Cerrar sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

    <?php endif; ?>

    <!-- Contenedor principal -->
    <div class="container mt-4">

        <!-- Mensaje de éxito -->
        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['exito'];
                unset($_SESSION['exito']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <!-- Mensaje de error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>