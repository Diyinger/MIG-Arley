<?php
class Mesa
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=reservas_admin", "root", "");
    }

    public function obtenerTodas()
    {
        $stmt = $this->db->query("SELECT * FROM mesas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado($mesaId, $estado)
    {
        $stmt = $this->db->prepare("UPDATE mesas SET Estado = ? WHERE MesaID = ?");
        $stmt->execute([$estado, $mesaId]);
    }

    public function agregarMesa($numero, $capacidad)
    {
        $stmt = $this->db->prepare("INSERT INTO mesas (Numero, Capacidad) VALUES (?, ?)");
        $stmt->execute([$numero, $capacidad]);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mesas WHERE MesaID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarMesa($id, $numero, $capacidad)
    {
        $stmt = $this->db->prepare("UPDATE mesas SET Numero = ?, Capacidad = ? WHERE MesaID = ?");
        $stmt->execute([$numero, $capacidad, $id]);
    }

    public function eliminarMesa($id)
    {
        $stmt = $this->db->prepare("DELETE FROM mesas WHERE MesaID = ?");
        $stmt->execute([$id]);
    }

    public function contarPorEstado()
    {
    $stmt = $this->db->query("SELECT estado, COUNT(*) AS cantidad FROM mesas GROUP BY estado");
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conteo = [
        'Disponible' => 0,
        'Reservada' => 0,
        'Ocupada' => 0
    ];

    foreach ($resultados as $fila) {
        $conteo[$fila['estado']] = $fila['cantidad'];
    }

    return $conteo;
    }



}
?>
