<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Iniciar sesión</h3>

                        <!-- Mensajes -->
                        <?php if (!empty($mensaje_error)): ?>
                            <div class="alert alert-danger"><?= $mensaje_error ?></div>
                        <?php endif; ?>
                        <?php if (!empty($mensaje_exito)): ?>
                            <div class="alert alert-success"><?= $mensaje_exito ?></div>
                        <?php endif; ?>

                        <form action="index.php?url=auth/login" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="clave" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="index.php?url=olvidar">¿Olvidaste tu contraseña?</a>
                            <a href="index.php?url=auth/registro">Registrar</a>
                            <a href="../../index.php">Volver al login</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>