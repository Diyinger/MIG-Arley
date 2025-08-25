<?php
require_once("../../Conexion.php");

class Dashboard
{
    private $db;

    public function __construct()
    {
        $this->db = Conexion::getInstancia()->getConexion();
    }

    // Total de usuarios administradores
    public function getUsuariosRegistrados()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM tb_administradores");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Total de reservas registradas
    public function getReservasRegistradas()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM reservas");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Total de platos vendidos
    public function getPlatosVendidos()
    {
        $stmt = $this->db->query("SELECT IFNULL(SUM(Cantidad),0) as total FROM platos_pedido");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Estado de las mesas
    public function getMesasEstado()
    {
        $stmt = $this->db->query("
            SELECT Estado, COUNT(*) as total
            FROM mesas
            GROUP BY Estado
        ");

        $resultados = ['Disponible' => 0, 'Reservada' => 0, 'Ocupada' => 0];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[$row['Estado']] = $row['total'];
        }

        return $resultados;
    }

    // Platos vendidos hoy
    public function getPlatosVendidosHoy()
    {
        $stmt = $this->db->query("
            SELECT pl.Nombre AS Nombre, SUM(pp.Cantidad) AS total_vendidos
            FROM platos_pedido pp
            INNER JOIN platos pl ON pp.PlatoID = pl.PlatoID
            INNER JOIN pedidos p ON pp.PedidoID = p.PedidoID
            WHERE DATE(p.FechaHora) = CURDATE()
            GROUP BY pl.Nombre
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
