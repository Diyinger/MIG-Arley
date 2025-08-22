<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle . ' | GRUPO MIG' : 'GRUPO MIG - Sistema' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" href="/assets/img/logo-negro.png" type="image/png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

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
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../../assets/img/logo-negro.png" alt="Logo" width="50" height="50" class="me-2">
            <strong style="color: #ffffff;">Grupo MIG</strong>
        </a>
      
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        </div>
    </div>
</header>
