<?php
require_once __DIR__ . '/../../Conexion.php';

class Domicilio
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getInstancia()->getConexion();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM pedidosdomicilio";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM pedidosdomicilio WHERE PedidoID = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($clienteID, $direccion, $precio, $productos, $estado = 'Pendiente')
    {
        $sql = "INSERT INTO pedidosdomicilio (ClienteID, DireccionEntrega, Precio, Estado, Productos)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$clienteID, $direccion, $precio, $estado, $productos]);
    }


    public function actualizar($id, $clienteID, $direccion, $precio, $estado, $productos)
    {
        $sql = "UPDATE pedidosdomicilio SET ClienteID=?, DireccionEntrega=?, Precio=?, Estado=?, Productos=? WHERE PedidoID=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$clienteID, $direccion, $precio, $estado, $productos, $id]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM pedidosdomicilio WHERE PedidoID=?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }
}
