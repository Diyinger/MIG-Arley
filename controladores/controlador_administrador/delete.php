<?php
require_once("../../modelos/modelo_administrador/Administradores.php");

if ($_POST) {
    $Modelo = new Administradores();
    $Id = $_POST["Id"];
    $Modelo->delete($Id);

    header("Location: ../../pages/pages_administrador/index.php");
} else {
    header("Location: ../../pages/pages_administrador/index.php");
}
?>
