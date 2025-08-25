<?php
require_once("../../Conexion.php");

class Usuarios {
    private $db;

    public function __construct() {
        session_start(); // importante
        $this->db = Conexion::getInstancia()->getConexion();
    }

    public function login($usuario, $password) {
    $sql = "SELECT * FROM tb_administradores WHERE USUARIO = ? AND ESTADO = 'Activo'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$usuario]);
    $result = $stmt->fetch();

    if ($result && password_verify($password, $result["PASSWORD"])) {
        $_SESSION["ID"] = $result["ID_USUARIO"];
        $_SESSION["NOMBRE"] = $result["NOMBRE"];
        $_SESSION["PERFIL"] = $result["PERFIL"];
        return true;
    }

    return false;
}

    public function validateSession() {
        if (!isset($_SESSION["ID"])) {
            header("Location: ../../login.php");
            exit();
        }
    }

    public function getNombre() {
        return $_SESSION["NOMBRE"];
    }

    public function getPerfil() {
        return $_SESSION["PERFIL"];
    }

    public function salir() {
    // Destruir todas las variables de sesión
    $_SESSION = array();
    
    // Destruir la cookie de sesión si existe
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    
    // Destruir la sesión
    session_destroy();
    
    // Asegurar que el navegador no almacene en caché las páginas protegidas
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    // Redireccionar al login
    header("Location: ../../login.php");
    exit();
    }
}
?>
