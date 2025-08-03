<?php
require_once __DIR__ . '/../../includes/admin_header.php';
require_once("../../modelos/modelo_administrador/Administradores.php"); 

if ($_POST) {
    $Modelo = new Administradores();

    $Nombre = $_POST["Nombre"];
    $Apellido = $_POST["Apellido"];
    $Usuario = $_POST["Usuario"];
    $Password = $_POST["Password"];

    // Encriptar la contraseña 
    $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);

    $Modelo->add($Nombre, $Apellido, $Usuario, $PasswordHash);

    header("Location: ../../pages/pages_administrador/index.php");
} else {
    header("Location: ../../pages/pages_administrador/index.php");
}
