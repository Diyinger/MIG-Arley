<?php
require_once '../../Conexion.php';

class InventarioModel {
    private $db;

    public function __construct() {
        $this->db = Conexion::getInstancia()->getConexion();
    }
    
    // Verificar que el producto exista antes de registrar movimiento
    private function productoExiste($producto_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function registrarMovimiento($producto_id, $tipo, $cantidad, $observaciones) {
        // Validar existencia del producto
        if (!$this->productoExiste($producto_id)) {
            throw new Exception("❌ El producto con ID $producto_id no existe en la base de datos.");
        }

        // Validar tipo de movimiento
        if ($tipo !== 'entrada' && $tipo !== 'salida') {
            throw new Exception("❌ Tipo de movimiento inválido.");
        }

        // Validar cantidad
        if ($cantidad <= 0) {
            throw new Exception("❌ La cantidad debe ser mayor a 0.");
        }

        // Si es salida, validar stock suficiente
        if ($tipo === 'salida') {
            $stock_actual = $this->obtenerStockProducto($producto_id);
            if ($cantidad > $stock_actual) {
                throw new Exception("❌ No hay suficiente stock para realizar la salida.");
            }
        }

        // Registrar movimiento
        $stmt = $this->db->prepare("INSERT INTO inventario_movimientos 
            (producto_id, tipo, cantidad, observaciones) VALUES (?, ?, ?, ?)");
        $stmt->execute([$producto_id, $tipo, $cantidad, $observaciones]);
        // El trigger se encarga de actualizar el stock
    }

    public function obtenerUnidadesMedida() {
        return $this->db->query("SELECT * FROM unidades_medida ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerInventario() {
        $stmt = $this->db->query("
            SELECT p.id, p.nombre, p.descripcion, p.stock, p.codigo, 
                   um.nombre as unidad_medida, um.abreviatura
            FROM productos p
            LEFT JOIN unidades_medida um ON p.unidad_medida_id = um.id
            ORDER BY p.nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMovimientos() {
        $stmt = $this->db->query("SELECT m.*, p.nombre FROM inventario_movimientos m 
                                JOIN productos p ON m.producto_id = p.id 
                                ORDER BY m.fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function obtenerStockProducto($producto_id) {
        $stmt = $this->db->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
        return (int) $stmt->fetchColumn();
    }

    public function registrarProducto($codigo, $nombre, $descripcion, $stock, $unidad_medida_id) {
        // Validaciones básicas
        if (empty($codigo)) {
            throw new Exception("❌ El código del producto es requerido.");
        }
        
        if (empty($nombre)) {
            throw new Exception("❌ El nombre del producto es requerido.");
        }
        
        if ($stock < 0) {
            throw new Exception("❌ El stock inicial no puede ser negativo.");
        }

        if (empty($unidad_medida_id)) {
            throw new Exception("❌ La unidad de medida es requerida.");
        }

        // Verificar si el código ya existe
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE codigo = ?");
        $stmt->execute([$codigo]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("❌ Ya existe un producto con este código.");
        }

        // Registrar el producto
        $stmt = $this->db->prepare("INSERT INTO productos 
            (codigo, nombre, descripcion, stock, unidad_medida_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$codigo, $nombre, $descripcion, $stock, $unidad_medida_id]);

        // Ya no registrar automáticamente una entrada inicial de inventario
        // El stock inicial se establece directamente en la tabla productos
    }

    public function eliminarProducto($producto_id) {
        // Verificar que el producto exista
        if (!$this->productoExiste($producto_id)) {
            throw new Exception("❌ El producto no existe.");
        }
        // Eliminar movimientos relacionados
        $stmt = $this->db->prepare("DELETE FROM inventario_movimientos WHERE producto_id = ?");
        $stmt->execute([$producto_id]);
        // Eliminar el producto
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$producto_id]);
    }
        // Conversión entre unidades (simplificada: kilos <-> libras)
    private function convertirUnidad($cantidad, $unidad_origen, $unidad_destino) {
        // 1 kilo = 2.20462 libras
        $factor = 2.20462;

        if ($unidad_origen === $unidad_destino) {
            return $cantidad; // no hay conversión
        }

        if ($unidad_origen === 'kg' && $unidad_destino === 'lb') {
            return $cantidad * $factor;
        }

        if ($unidad_origen === 'lb' && $unidad_destino === 'kg') {
            return $cantidad / $factor;
        }

        // Si necesitas más conversiones, las agregamos aquí
        throw new Exception("❌ Conversión no soportada: $unidad_origen a $unidad_destino");
    }

    // Verificar si hay suficiente stock en la unidad seleccionada
    public function verificarStockIngrediente($producto_id, $cantidad_necesaria, $unidad_medida_usuario) {
        $stmt = $this->db->prepare("
            SELECT p.stock, um.abreviatura 
            FROM productos p
            JOIN unidades_medida um ON p.unidad_medida_id = um.id
            WHERE p.id = ?
        ");
        $stmt->execute([$producto_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("❌ Producto no encontrado en inventario.");
        }

        $stock_actual = (float)$data['stock'];
        $unidad_inventario = $data['abreviatura'];

        // Convertir la cantidad necesaria a la unidad del inventario
        $cantidad_convertida = $this->convertirUnidad($cantidad_necesaria, $unidad_medida_usuario, $unidad_inventario);

        return $stock_actual >= $cantidad_convertida;
    }

}