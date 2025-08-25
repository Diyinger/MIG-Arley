<?php
require_once '../../Conexion.php';

class Reserva
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    // Obtener todas las reservas
    public function obtenerTodas()
    {
        $sql = "SELECT r.id, r.nombre, r.fecha, r.hora, r.personas, 
                       m.Numero AS numero_mesa, m.Capacidad
                FROM reservas r
                JOIN mesas m ON r.mesa_id = m.MesaID
                ORDER BY r.fecha DESC, r.hora DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar nueva reserva
    public function guardar($datos)
    {
        // Validar si ya existe reserva en misma mesa/hora/fecha
        $sqlCheck = "SELECT COUNT(*) FROM reservas 
                     WHERE mesa_id = ? AND fecha = ? AND hora = ?";
        $stmt = $this->db->prepare($sqlCheck);
        $stmt->execute([$datos['mesa_id'], $datos['fecha'], $datos['hora']]);
        if ($stmt->fetchColumn() > 0) {
            return "conflicto";
        }

        // Validar capacidad de la mesa
        $sqlMesa = "SELECT Capacidad FROM mesas WHERE MesaID = ?";
        $stmt = $this->db->prepare($sqlMesa);
        $stmt->execute([$datos['mesa_id']]);
        $capacidad = $stmt->fetchColumn();

        if (!$capacidad) {
            return "mesa_invalida";
        }
        if ($datos['personas'] > $capacidad) {
            return "sin_capacidad";
        }

        // Insertar
        $sql = "INSERT INTO reservas (nombre, fecha, hora, personas, mesa_id) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['fecha'],
            $datos['hora'],
            $datos['personas'],
            $datos['mesa_id']
        ]);
    }

    // Obtener reserva por ID
    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar reserva
    public function actualizar($datos)
    {
        // Validar conflicto excepto la misma reserva
        $sqlCheck = "SELECT COUNT(*) FROM reservas 
                     WHERE mesa_id = ? AND fecha = ? AND hora = ? AND id != ?";
        $stmt = $this->db->prepare($sqlCheck);
        $stmt->execute([$datos['mesa_id'], $datos['fecha'], $datos['hora'], $datos['id']]);
        if ($stmt->fetchColumn() > 0) {
            return "conflicto";
        }

        // Validar capacidad
        $sqlMesa = "SELECT Capacidad FROM mesas WHERE MesaID = ?";
        $stmt = $this->db->prepare($sqlMesa);
        $stmt->execute([$datos['mesa_id']]);
        $capacidad = $stmt->fetchColumn();

        if (!$capacidad) {
            return "mesa_invalida";
        }
        if ($datos['personas'] > $capacidad) {
            return "sin_capacidad";
        }

        // Actualizar
        $sql = "UPDATE reservas 
                SET nombre = ?, fecha = ?, hora = ?, personas = ?, mesa_id = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['nombre'],
            $datos['fecha'],
            $datos['hora'],
            $datos['personas'],
            $datos['mesa_id'],
            $datos['id']
        ]);
    }

    // Eliminar reserva
    public function eliminar($id)
{
    $stmt = $this->db->prepare("DELETE FROM reservas WHERE id = ?");
    return $stmt->execute([$id]);
}

    // Obtener todas las mesas
    public function obtenerMesas()
    {
        $stmt = $this->db->query("SELECT * FROM mesas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
