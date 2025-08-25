<?php
require_once("../../modelos/modelo_administrador/Administradores.php");

if ($_POST) {
    $Modelo = new Administradores();

    $Id = $_POST["Id"];
    $Nombre = $_POST["Nombre"];
    $Apellido = $_POST["Apellido"];
    $Usuario = $_POST["Usuario"];
    $Password = $_POST["Password"];
    $Estado = $_POST["Estado"];

    $Modelo->update($Id, $Nombre, $Apellido, $Usuario, $Password, $Estado);

    header("Location: ../../pages/pages_administrador/index.php");
} else {
    header("Location: ../../pages/pages_administrador/index.php");
}
?>
