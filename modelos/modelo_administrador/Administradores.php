<?php
require_once("../../config/Conexion.php");

class Administradores {
    private $db;

    public function __construct() {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    public function login($usuario, $password) {
        try {
            $sql = "SELECT * FROM tb_administradores WHERE USUARIO = ? AND ESTADO = 'Activo'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario]);
            $usuario_db = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario_db && password_verify($password, $usuario_db['PASSWORD'])) {
                // Guardar datos importantes en la sesión
                $_SESSION["ID"] = $usuario_db["ID_USUARIO"];
                $_SESSION["NOMBRE"] = $usuario_db["NOMBRE"];
                $_SESSION["PERFIL"] = $usuario_db["PERFIL"];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // public function login($usuario, $password) {
    // $sql = "SELECT * FROM tb_administradores WHERE USUARIO = ? AND ESTADO = 'Activo'";
    // $stmt = $this->db->prepare($sql);
    // $stmt->execute([$usuario]);
    // $result = $stmt->fetch();

    // if ($result && password_verify($password, $result["PASSWORD"])) {
    //     $_SESSION["ID"] = $result["ID_USUARIO"];
    //     $_SESSION["NOMBRE"] = $result["NOMBRE"];
    //     $_SESSION["PERFIL"] = $result["PERFIL"];
    //     return true;
    // }
    // return false; ESTA ES LA VERSION ANTERIOR

    public function add($nombre, $apellido, $usuario, $password) {
        $sql = "INSERT INTO tb_administradores (NOMBRE, APELLIDO, USUARIO, PASSWORD) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $apellido, $usuario, $password]);
    }

    public function get() {
        $sql = "SELECT * FROM tb_administradores";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM tb_administradores WHERE ID_USUARIO = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $apellido, $usuario, $password, $estado) {
        $sql = "UPDATE tb_administradores SET NOMBRE=?, APELLIDO=?, USUARIO=?, PASSWORD=?, ESTADO=? WHERE ID_USUARIO=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $apellido, $usuario, $password, $estado, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM tb_administradores WHERE ID_USUARIO = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
