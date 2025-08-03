<?php
require_once __DIR__ . '/../../config/db.php';

class Pedido {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT * FROM platos ORDER BY PlatoID DESC");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM platos WHERE PlatoID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function crear($nombre, $descripcion, $precio, $cantidad) {
        $stmt = $this->conn->prepare("INSERT INTO platos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $cantidad);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $cantidad) {
        $stmt = $this->conn->prepare("UPDATE platos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ? WHERE PlatoID = ?");
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $cantidad, $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM platos WHERE PlatoID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
