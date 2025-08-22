<?php include 'views/header.php'; ?>

<div class="container mt-5">
    <h2>Recuperar Contraseña</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['exito'])): ?>
        <div class="alert alert-success"><?= $_SESSION['exito'] ?></div>
        <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>

    <form action="index.php?url=auth/recuperar" method="POST">
    <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" name="usuario" id="usuario" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="nueva_clave" class="form-label">Nueva contraseña</label>
        <input type="password" name="nueva_clave" id="nueva_clave" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
</form>


</div>

<?php include 'views/footer.php'; ?>
?>