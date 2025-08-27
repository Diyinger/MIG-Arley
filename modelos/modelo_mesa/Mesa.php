<?php
require_once '../../Conexion.php';

class Mesa {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::getInstancia()->getConexion(); // PDO
    }

    public function obtenerTodas() {
        $stmt = $this->conn->query("SELECT MesaID, Numero, Capacidad, Estado FROM mesas ORDER BY MesaID DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT MesaID, Numero, Capacidad, Estado FROM mesas WHERE MesaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarMesa($numero, $capacidad, $estado = 'Disponible') {
        $stmt = $this->conn->prepare("INSERT INTO mesas (Numero, Capacidad, Estado) VALUES (?, ?, ?)");
        return $stmt->execute([$numero, $capacidad, $estado]);
    }

    public function actualizarMesa($id, $numero, $capacidad, $estado) {
        $stmt = $this->conn->prepare("UPDATE mesas SET Numero = ?, Capacidad = ?, Estado = ? WHERE MesaID = ?");
        return $stmt->execute([$numero, $capacidad, $estado, $id]);
    }

    public function eliminarMesa($id) {
        $stmt = $this->conn->prepare("DELETE FROM mesas WHERE MesaID = ?");
        return $stmt->execute([$id]);
    }
}
