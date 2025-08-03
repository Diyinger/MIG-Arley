<?php

require_once __DIR__ . '/../../Conexion.php';
session_start();

$accion = $_GET['accion'] ?? '';

if ($accion === 'login') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$usuario || !$password) {
        header("Location: ../../pages/pages_login/login.php?error=Completa todos los campos");
        exit;
    }

    $conn = Conexion::getInstancia()->getConexion();
    $stmt = $conn->prepare("SELECT * FROM tb_administradores WHERE USUARIO = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['PASSWORD'])) {
        $_SESSION['usuario'] = $user['USUARIO'];
        header("Location: ../../pages/pages_administrador/index.php");
        exit;
    } else {
        header("Location: ../../pages/pages_login/login.php?error=Usuario o contraseña incorrectos");
        exit;
    }
}