<?php
require_once("../Modelo/Empleados.php");

if ($_POST) {
    $ModeloEmpleados = new Empleados();
    $Id = $_POST["Id"];
    $ModeloEmpleados->delete($Id);
    header("Location: ../Pages/index.php");
} else {
    header("Location: ../../index.php");
}
?>
