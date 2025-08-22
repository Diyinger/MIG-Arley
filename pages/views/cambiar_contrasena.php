<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-center">Cambiar contraseña</h4>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="index.php?url=auth/actualizar_contrasena" method="POST">
                        <input type="hidden" name="usuario" value="<?= htmlspecialchars($_GET['usuario']) ?>">

                        <div class="mb-3">
                            <label>Nueva contraseña</label>
                            <input type="password" class="form-control" name="nueva_clave" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar nueva contraseña</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php">Volver al login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
