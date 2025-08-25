<?php
require_once("../../Conexion.php");

class Empleados {
    private $db;

    public function __construct() {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    public function add($nombre, $apellido, $documento, $correo, $cargo, $fecha) {
        $sql = "INSERT INTO tb_empleados (NOMBRE, APELLIDO, DOCUMENTO, CORREO, CARGO, FECHA_REGISTRO) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $apellido, $documento, $correo, $cargo, $fecha]);
    }

    public function get() {
        $sql = "SELECT * FROM tb_empleados";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM tb_empleados WHERE ID_EMPLEADO = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $apellido, $documento, $correo, $cargo, $fecha) {
        $sql = "UPDATE tb_empleados 
                SET NOMBRE=?, APELLIDO=?, DOCUMENTO=?, CORREO=?, CARGO=?, FECHA_REGISTRO=? 
                WHERE ID_EMPLEADO=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $apellido, $documento, $correo, $cargo, $fecha, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM tb_empleados WHERE ID_EMPLEADO = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
