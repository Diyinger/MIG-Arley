<?php
require_once("../Modelo/Empleados.php");

if ($_POST) {
    $ModeloEmpleados = new Empleados();

    $Id = $_POST["Id"];
    $Nombre = $_POST["Nombre"];
    $Apellido = $_POST["Apellido"];
    $Documento = $_POST["Documento"];
    $Correo = $_POST["Correo"];
    $Cargo = $_POST["Cargo"];
    $Fecha = date('Y-m-d');

    $ModeloEmpleados->update($Id, $Nombre, $Apellido, $Documento, $Correo, $Cargo, $Fecha);
    header("Location: ../Pages/index.php");
} else {
    header("Location: ../../index.php");
}
?>
