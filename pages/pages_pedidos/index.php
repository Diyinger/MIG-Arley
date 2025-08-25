<?php
$titulo = "Nuevo Pedido";

require_once __DIR__ . '/../../Conexion.php';
include __DIR__ . '/../../pages/pages_layout/menu_admin.php';
include __DIR__ . '/../pages_layout/head.php';

$conn = Conexion::getInstancia()->getConexion();
?>
<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">

<!-- CONTENEDOR PARA MOVER A LA DERECHA -->
<div class="contenido-ajustado">

<h2 class="mb-4">Nuevo Pedido</h2>

<form action="../../controladores/controlador_pedidos/pedidosControllers.php?accion=guardar" method="POST" id="pedidoForm" onsubmit="return validarFormulario();">

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Nombre del Cliente</label>
            <input type="text" name="cliente" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tipo de Pedido</label>
            <select name="tipo_pedido" class="form-control" id="tipoPedido" required>
                <option value="">Seleccione el tipo de pedido</option>
                <option value="mesa">Para Mesa</option>
                <option value="domicilio">Para Llevar</option>
            </select>
        </div>
        <div class="col-md-4" id="mesaDiv">
            <label class="form-label">Número de Mesa</label>
            <input type="number" name="mesa" class="form-control" id="mesaInput">
        </div>
        <div class="col-md-4" id="direccionDiv" style="display: none;">
            <label class="form-label">Dirección de Entrega</label>
            <textarea name="direccion" class="form-control" id="direccionInput" rows="2"></textarea>
        </div>
    </div>
    <div class="row mb-3" id="telefonoDiv" style="display: none;">
        <div class="col-md-4">
            <label class="form-label">Teléfono</label>
            <input type="tel" name="telefono" class="form-control" id="telefonoInput">
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label">Platos</label>
        <div class="border rounded p-3 bg-white shadow-sm">
            <?php
            $platos = $conn->query("SELECT * FROM platos");
            while ($plato = $platos->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="row align-items-center mb-2">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="platos[]" value="<?= $plato['PlatoID'] ?>" id="plato<?= $plato['PlatoID'] ?>">
                            <label class="form-check-label" for="plato<?= $plato['PlatoID'] ?>">
                                <?= $plato['nombre'] ?> <span class="text-muted">($<?= number_format($plato['precio'], 0, ',', '.') ?>) - Stock: <?= $plato['cantidad'] ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="cantidades[<?= $plato['PlatoID'] ?>]" class="form-control cantidad-input" 
                               placeholder="Cantidad" min="1" max="<?= $plato['cantidad'] ?>" 
                               data-stock="<?= $plato['cantidad'] ?>" disabled>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="botonera">
        <button type="submit" class="custom-btn">Guardar Pedido</button>
        <a href="../pages_pedidos/listar_pedidos.php" class="custom-btn">Ver Pedidos</a>
    </div>

</form>

</div> <!-- Cierre del contenido-ajustado -->

<script>
    document.querySelectorAll('input[type="checkbox"][name="platos[]"]').forEach(cb => {
        const cantidadInput = cb.closest('.row').querySelector('.cantidad-input');
        cb.addEventListener('change', () => {
            cantidadInput.disabled = !cb.checked;
            if (!cb.checked) cantidadInput.value = '';
        });

        // Validación de cantidad máxima
        cantidadInput.addEventListener('input', function() {
            const stock = parseInt(this.dataset.stock);
            const cantidad = parseInt(this.value);
            
            if (cantidad > stock) {
                alert(`No hay suficiente stock disponible. Stock máximo: ${stock}`);
                this.value = stock;
            }
            
            if (cantidad < 1) {
                this.value = 1;
            }
        });
    });

    // Manejo del tipo de pedido
    document.getElementById('tipoPedido').addEventListener('change', function() {
        const mesaDiv = document.getElementById('mesaDiv');
        const direccionDiv = document.getElementById('direccionDiv');
        const telefonoDiv = document.getElementById('telefonoDiv');
        const mesaInput = document.getElementById('mesaInput');
        const direccionInput = document.getElementById('direccionInput');
        const telefonoInput = document.getElementById('telefonoInput');

        if (this.value === 'mesa') {
            mesaDiv.style.display = 'block';
            direccionDiv.style.display = 'none';
            telefonoDiv.style.display = 'none';
            mesaInput.required = true;
            direccionInput.required = false;
            telefonoInput.required = false;
        } else if (this.value === 'domicilio') {
            mesaDiv.style.display = 'none';
            direccionDiv.style.display = 'block';
            telefonoDiv.style.display = 'block';
            mesaInput.required = false;
            direccionInput.required = true;
            telefonoInput.required = true;
        }
    });

    function validarFormulario() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="platos[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Por favor seleccione al menos un plato');
            return false;
        }

        const tipoPedido = document.getElementById('tipoPedido').value;
        if (!tipoPedido) {
            alert('Por favor seleccione el tipo de pedido');
            return false;
        }

        if (tipoPedido === 'mesa') {
            const mesa = document.getElementById('mesaInput').value;
            if (!mesa) {
                alert('Por favor ingrese el número de mesa');
                return false;
            }
        } else if (tipoPedido === 'domicilio') {
            const direccion = document.getElementById('direccionInput').value;
            const telefono = document.getElementById('telefonoInput').value;
            if (!direccion) {
                alert('Por favor ingrese la dirección de entrega');
                return false;
            }
            if (!telefono) {
                alert('Por favor ingrese el teléfono de contacto');
                return false;
            }
        }

        let valid = true;
        checkboxes.forEach(cb => {
            const cantidadInput = cb.closest('.row').querySelector('.cantidad-input');
            const stock = parseInt(cantidadInput.dataset.stock);
            const cantidad = parseInt(cantidadInput.value);

            if (cantidad > stock) {
                const platoNombre = cb.closest('.row').querySelector('.form-check-label').textContent.trim();
                alert(`No hay suficiente stock para ${platoNombre}. Stock máximo: ${stock}`);
                valid = false;
            }
        });

        return valid;
    }
</script>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>
