<?php
require_once '../../config/conexion.php';

class Reserva
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    public function obtenerTodas($busqueda = '')
    {
        if (!empty($busqueda)) {
            $stmt = $this->db->prepare("
            SELECT r.*, m.Numero AS numero_mesa
            FROM reservas r
            JOIN mesas m ON r.mesa_id = m.MesaID
            WHERE r.nombre LIKE ?
            ORDER BY r.fecha, r.hora
        ");
            $stmt->execute(["%$busqueda%"]);
        } else {
            $stmt = $this->db->query("
            SELECT r.*, m.Numero AS numero_mesa
            FROM reservas r
            JOIN mesas m ON r.mesa_id = m.MesaID
            ORDER BY r.fecha, r.hora
        ");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function guardar($data)
    {
        $db = Conexion::getInstancia()->getConexion();

        $sql = "INSERT INTO reservas (nombre, fecha, hora, personas, mesa_id, Estado)
            VALUES (?, ?, ?, ?, ?, 'Pendiente')";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['fecha'],
            $data['hora'],
            $data['personas'],
            $data['mesa_id']
        ]);
    }



    public function eliminar($id)
    {
        // Primero obtener la reserva para saber qué mesa liberar
        $stmt = $this->db->prepare("SELECT mesa_id FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reserva && isset($reserva['mesa_id'])) {
            $this->liberarMesa($reserva['mesa_id']);
        }

        // Luego eliminar la reserva
        $stmt = $this->db->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
    }


    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($datos)
    {
        $stmt = $this->db->prepare("UPDATE reservas SET nombre = ?, fecha = ?, hora = ?, personas = ? WHERE id = ?");
        $stmt->execute([
            $datos['nombre'],
            $datos['fecha'],
            $datos['hora'],
            $datos['personas'],
            $datos['id']
        ]);
    }

    public function obtenerMesasDisponibles()
    {
        $stmt = $this->db->query("SELECT * FROM mesas WHERE Estado = 'Disponible'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoMesa($mesa_id, $estado)
    {
        $stmt = $this->db->prepare("UPDATE mesas SET Estado = ? WHERE MesaID = ?");
        $stmt->execute([$estado, $mesa_id]);
    }

    public function liberarMesa($mesa_id)
    {
        $stmt = $this->db->prepare("UPDATE mesas SET Estado = 'Disponible' WHERE MesaID = ?");
        $stmt->execute([$mesa_id]);
    }

    public function contarReservasDeHoy()
    {
        $hoy = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM reservas WHERE fecha = ?");
        $stmt->execute([$hoy]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtenerReservasDeHoy()
    {
        $hoy = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE fecha = ? ORDER BY hora ASC");
        $stmt->execute([$hoy]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function contarMesasDisponibles()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM mesas WHERE Estado = 'Disponible'");
        return $stmt->fetchColumn();
    }

    public function contarTodasLasMesas()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM mesas");
        return $stmt->fetchColumn();
    }

    public function obtenerProximasReservas()
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE fecha >= CURDATE() ORDER BY fecha ASC, hora ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerReservasPorMes($mes, $año)
    {
        $stmt = $this->db->prepare("SELECT * FROM reservas WHERE MONTH(fecha) = ? AND YEAR(fecha) = ? ORDER BY fecha, hora");
        $stmt->execute([$mes, $año]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoMesasPorHorario()
    {
        $db = Conexion::getInstancia()->getConexion();
        $sql = "SELECT * FROM reservas";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($reservas as $reserva) {
            if (!isset($reserva['fecha']) || !isset($reserva['hora'])) {
                continue;
            }

            $fechaHoraReserva = $reserva['fecha'] . ' ' . $reserva['hora'];
            $tiempoReserva = strtotime($fechaHoraReserva);
            $ahora = time();
            $diferencia = $tiempoReserva - $ahora;

            if ($reserva['Estado'] === 'Pendiente' && $diferencia <= 3600 && $diferencia > 0) {
                $sqlUpdate = "UPDATE mesas SET Estado = 'Reservada' WHERE MesaID = ?";
                $stmtUpdate = $db->prepare($sqlUpdate);
                $stmtUpdate->execute([$reserva['mesa_id']]);

                $sqlEstado = "UPDATE reservas SET Estado = 'Activa' WHERE id = ?";
                $stmtEstado = $db->prepare($sqlEstado);
                $stmtEstado->execute([$reserva['id']]);
            }

            if ($diferencia <= 0) {
                $sqlLiberar = "UPDATE mesas SET Estado = 'Disponible' WHERE MesaID = ?";
                $stmtLiberar = $db->prepare($sqlLiberar);
                $stmtLiberar->execute([$reserva['mesa_id']]);

                $sqlEliminar = "DELETE FROM reservas WHERE id = ?";
                $stmtEliminar = $db->prepare($sqlEliminar);
                $stmtEliminar->execute([$reserva['id']]);
            }
        }
    }


    public function liberarMesasPasadas()
    {
        $db = Conexion::getInstancia()->getConexion();

        $sql = "SELECT * FROM reservas WHERE Estado = 'Activa'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($reservas as $reserva) {
            if (!isset($reserva['fecha']) || !isset($reserva['hora'])) {
                continue;
            }

            $fechaHoraReserva = $reserva['fecha'] . ' ' . $reserva['hora'];
            $tiempoReserva = strtotime($fechaHoraReserva);
            $ahora = time();

            // Si ya pasó la hora de la reserva, liberar la mesa
            if ($ahora > $tiempoReserva) {
                // Liberar mesa
                $sqlMesa = "UPDATE mesas SET Estado = 'Disponible' WHERE MesaID = ?";
                $stmtMesa = $db->prepare($sqlMesa);
                $stmtMesa->execute([$reserva['mesa_id']]);

                // Marcar la reserva como Finalizada
                $sqlReserva = "UPDATE reservas SET Estado = 'Finalizada' WHERE id = ?";
                $stmtReserva = $db->prepare($sqlReserva);
                $stmtReserva->execute([$reserva['id']]);
            }
        }
    }
}
