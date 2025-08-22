<?php
require_once '../../config/Conexion.php';

class Plato {
    private $db;

    public function __construct() {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM platos ORDER BY PlatoID DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM platos WHERE PlatoID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nombre, $descripcion, $precio, $cantidad) {
        $stmt = $this->db->prepare("INSERT INTO platos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $descripcion, $precio, $cantidad]);
    }

    public function update($id, $nombre, $descripcion, $precio, $cantidad) {
        $stmt = $this->db->prepare("UPDATE platos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ? WHERE PlatoID = ?");
        return $stmt->execute([$nombre, $descripcion, $precio, $cantidad, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM platos WHERE PlatoID = ?");
        return $stmt->execute([$id]);
    }
}