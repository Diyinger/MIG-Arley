<?php include 'views/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Restablecer Contraseña</h3>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['exito'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=auth/restablecer" method="POST">
                        <input type="hidden" name="usuario" value="<?= htmlspecialchars($_GET['usuario']) ?>">
                        <div class="mb-3">
                            <label>Nueva Contraseña</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Actualizar Contraseña</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php">Volver al Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/footer.php'; ?>
