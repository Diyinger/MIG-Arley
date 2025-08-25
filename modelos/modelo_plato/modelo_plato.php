<?php
require_once '../../Conexion.php';

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

    public function add($nombre, $descripcion, $precio, $ingredientes, $cantidad = 0) {
        try {
            $this->db->beginTransaction();

            // Insertar el plato
            $stmt = $this->db->prepare("INSERT INTO platos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $descripcion, $precio, $cantidad]);
            $platoId = $this->db->lastInsertId();

            // Insertar los ingredientes y actualizar stock
            $stmtIngredientes = $this->db->prepare("INSERT INTO platos_productos (PlatoID, ProductoID, cantidad, unidad_medida) VALUES (?, ?, ?, ?)");
            $stmtActualizarStock = $this->db->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            
            foreach ($ingredientes as $ingrediente) {
                // Registrar ingrediente del plato
                $stmtIngredientes->execute([
                    $platoId,
                    $ingrediente['ProductoID'],
                    $ingrediente['cantidad'],
                    $ingrediente['unidad_medida']
                ]);

                // Descontar stock del producto
                $cantidadDescontar = $ingrediente['cantidad'] * $cantidad;
                if ($cantidadDescontar > 0) {
                    $stmtActualizarStock->execute([$cantidadDescontar, $ingrediente['ProductoID']]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function update($id, $nombre, $descripcion, $precio, $ingredientes) {
        try {
            $this->db->beginTransaction();

            // Actualizar información del plato
            $stmt = $this->db->prepare("UPDATE platos SET nombre = ?, descripcion = ?, precio = ? WHERE PlatoID = ?");
            $stmt->execute([$nombre, $descripcion, $precio, $id]);

            // Eliminar ingredientes anteriores
            $stmt = $this->db->prepare("DELETE FROM platos_productos WHERE PlatoID = ?");
            $stmt->execute([$id]);

            // Insertar nuevos ingredientes
            $stmt = $this->db->prepare("INSERT INTO platos_productos (PlatoID, ProductoID, cantidad, unidad_medida) VALUES (?, ?, ?, ?)");
            foreach ($ingredientes as $ingrediente) {
                $stmt->execute([
                    $id,
                    $ingrediente['ProductoID'],
                    $ingrediente['cantidad'],
                    $ingrediente['unidad_medida']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function delete($id) {
        try {
            $this->db->beginTransaction();

            // Eliminar ingredientes
            $stmt = $this->db->prepare("DELETE FROM platos_productos WHERE PlatoID = ?");
            $stmt->execute([$id]);

            // Eliminar plato
            $stmt = $this->db->prepare("DELETE FROM platos WHERE PlatoID = ?");
            $stmt->execute([$id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getIngredientes($platoId) {
        $stmt = $this->db->prepare("
            SELECT pp.*, p.nombre as producto_nombre, p.stock, p.unidad_medida
            FROM platos_productos pp
            JOIN productos p ON pp.ProductoID = p.id
            WHERE pp.PlatoID = ?
        ");
        $stmt->execute([$platoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarStockIngredientes($ingredientes) {
        $errores = [];
        foreach ($ingredientes as $ingrediente) {
            $stmt = $this->db->prepare("SELECT stock FROM productos WHERE id = ?");
            $stmt->execute([$ingrediente['ProductoID']]);
            $stock = $stmt->fetchColumn();

            if ($stock < $ingrediente['cantidad']) {
                $errores[] = "No hay suficiente stock para el ingrediente ID: {$ingrediente['ProductoID']}";
            }
        }
        return $errores;
    }
}