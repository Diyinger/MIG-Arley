<?php

$titulo = "Nuevo Producto"; 
include __DIR__ . '/../pages_layout/head.php'; 
require_once __DIR__ . '/../../controllers/dashboard.php';

$conn = Conexion::getInstancia()->getConexion();

// Obtener platos disponibles con su stock
$stmt = $conn->query("SELECT PlatoID, Nombre, Precio, cantidad as stock FROM platos WHERE cantidad > 0");
$platos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Pedido</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <style>
        .error-message {
            color: red;
            margin: 10px 0;
        }
        .stock-info {
            font-size: 0.9em;
            color: #666;
        }
        .stock-warning {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="pedido_container">
        <h2>Crear Pedido</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif;
        if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
                ?>
            </div>
        <?php endif; ?>

        <form id="pedidoForm" method="POST" action="../../controladores/controlador_pedidos/pedidosControllers.php?accion=guardar" onsubmit="validarPedido(event);">
            <label>Cliente:</label>
            <input type="text" name="cliente" required><br>
            
            <label>Mesa:</label>
            <input type="number" name="mesa" required><br>
            
            <div id="platos-container">
                <h3>Platos</h3>
                <div class="plato-item">
                    <select name="platos[]" class="plato-select" required>
                        <option value="">Seleccione un plato</option>
                        <?php foreach ($platos as $plato): ?>
                            <option value="<?php echo $plato['PlatoID']; ?>" 
                                    data-stock="<?php echo $plato['stock']; ?>"
                                    data-nombre="<?php echo $plato['Nombre']; ?>">
                                <?php echo $plato['Nombre']; ?> (Stock: <?php echo $plato['stock']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="cantidades[]" class="cantidad-input" min="1" required>
                    <div class="stock-info"></div>
                </div>
            </div>
            
            <button type="button" onclick="agregarPlato()">Agregar otro plato</button>
            <button type="submit">Crear Pedido</button>
        </form>
        <a href="index.php">Volver</a>
    </div>

    <script>
    function validarPedido(event) {
        event.preventDefault(); // Prevenir el envío del formulario por defecto
        
        const platos = document.querySelectorAll('.plato-select');
        const platosContados = new Map(); // Para contar la cantidad total por plato
        
        // Primero, sumar todas las cantidades por plato
        for (const platoSelect of platos) {
            if (platoSelect.value) {
                const platoId = platoSelect.value;
                const cantidad = parseInt(platoSelect.parentElement.querySelector('.cantidad-input').value) || 0;
                const nombrePlato = platoSelect.options[platoSelect.selectedIndex].dataset.nombre;
                
                // Sumar la cantidad si ya existe ese plato
                const cantidadActual = platosContados.get(platoId) || 0;
                platosContados.set(platoId, cantidadActual + cantidad);
            }
        }
        
        // Luego, verificar el stock para cada plato
        for (const [platoId, cantidadTotal] of platosContados) {
            const platoSelect = document.querySelector(`.plato-select[value="${platoId}"]`);
            const stock = parseInt(platoSelect.options[platoSelect.selectedIndex].dataset.stock);
            const nombrePlato = platoSelect.options[platoSelect.selectedIndex].dataset.nombre;
            
            if (cantidadTotal > stock) {
                alert(`No hay suficientes "${nombrePlato}" en stock.\nStock disponible: ${stock}\nCantidad solicitada: ${cantidadTotal}`);
                return false;
            }
        }
        
        // Si todo está bien, enviar el formulario manualmente
        document.getElementById('pedidoForm').submit();
    }

    function actualizarInfoStock(platoItem) {
        const select = platoItem.querySelector('.plato-select');
        const cantidadInput = platoItem.querySelector('.cantidad-input');
        const stockInfo = platoItem.querySelector('.stock-info');

        if (select.value) {
            const stock = parseInt(select.options[select.selectedIndex].dataset.stock);
            const cantidad = parseInt(cantidadInput.value) || 0;

            stockInfo.innerHTML = `Stock disponible: ${stock}`;
            if (cantidad > stock) {
                stockInfo.classList.add('stock-warning');
                stockInfo.innerHTML += '<br>¡Cantidad excede el stock disponible!';
            } else {
                stockInfo.classList.remove('stock-warning');
            }
        }
    }

    function agregarPlato() {
        const container = document.getElementById('platos-container');
        const platoItem = container.querySelector('.plato-item').cloneNode(true);
        
        platoItem.querySelector('.plato-select').value = '';
        platoItem.querySelector('.cantidad-input').value = '';
        platoItem.querySelector('.stock-info').innerHTML = '';
        
        // Agregar eventos
        platoItem.querySelector('.plato-select').addEventListener('change', () => actualizarInfoStock(platoItem));
        platoItem.querySelector('.cantidad-input').addEventListener('input', () => actualizarInfoStock(platoItem));
        
        container.appendChild(platoItem);
    }

    // Agregar eventos a los elementos iniciales
    document.querySelectorAll('.plato-item').forEach(platoItem => {
        platoItem.querySelector('.plato-select').addEventListener('change', () => actualizarInfoStock(platoItem));
        platoItem.querySelector('.cantidad-input').addEventListener('input', () => actualizarInfoStock(platoItem));
    });

    function validarYEnviarPedido() {
        if (!validarPedido()) {
            return false;
        }
        return true;
    }
    </script>
</body>
</html>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>