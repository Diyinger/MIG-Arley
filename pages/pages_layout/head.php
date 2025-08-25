<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle . ' | GRUPO MIG' : 'GRUPO MIG - Sistema' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" href="/assets/logo-negro.png" type="image/png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">




    <!-- CSS global -->
    <link rel="stylesheet" href="/Public/css/global.css">

    <!-- CSS específico de la página (si se define) -->
    <?php if (isset($customCss)) : ?>
        <link rel="stylesheet" href="/Public/css/<?= $customCss ?>">
    <?php endif; ?>
</head>

<body class="d-flex flex-column min-vh-100">

<!-- ======== Navbar / Encabezado ========== -->
<header class="navbar navbar-expand-lg navbar-dark" style="background-color: #4b2c0a;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo y título -->
        <div class="d-flex align-items-center">
            <img src="../../assets/logo-negro.png" alt="Logo" width="50" height="50" class="me-2">
            <strong style="color: #ffffff;">Grupo MIG</strong>
        </div>

        <!-- Botón Cerrar sesión -->
        <div class="d-flex align-items-center ms-auto">
            <a href="../../controladores/controlador_usuario/Salir.php" class="btn-registro">Cerrar sesión</a>
        </div>
    </div>
</header>
