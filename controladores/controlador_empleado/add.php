<?php
require_once("../Modelo/Empleados.php");

if ($_POST) {
    $ModeloEmpleados = new Empleados();

    $Nombre = $_POST["Nombre"];
    $Apellido = $_POST["Apellido"];
    $Documento = $_POST["Documento"];
    $Correo = $_POST["Correo"];
    $Cargo = $_POST["Cargo"];
    $Fecha = date('Y-m-d');

    $ModeloEmpleados->add($Nombre, $Apellido, $Documento, $Correo, $Cargo, $Fecha);
    header("Location: ../Pages/index.php");
} else {
    header("Location: ../../index.php");
}
?>
