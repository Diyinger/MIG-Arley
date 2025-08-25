<?php 
include __DIR__ . '/../pages_layout/head.php';
require_once '../../modelos/modelo_existencias/InventarioModel.php';

// Obtener los productos disponibles
$modeloInventario = new InventarioModel();
$productos = $modeloInventario->obtenerInventario();

// Debug temporal
if (empty($productos)) {
    echo '<div class="alert alert-warning">No hay productos disponibles en el inventario.</div>';
} else {
    echo '<div style="display:none;">Debug: ' . print_r($productos, true) . '</div>';
}
?>

<link rel="stylesheet" href="../../css/estilosIndexAdmin.css">
<style>
    .ingrediente-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    .stock-info {
        font-size: 0.9em;
        margin-top: 5px;
    }
    .stock-warning {
        color: #dc3545;
    }
    .stock-ok {
        color: #198754;
    }
</style>

<div class="container mt-5">
    <h2>Agregar Plato</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form id="formCrearPlato" method="POST" action="../../controladores/controlador_plato/PlatoController.php?accion=guardar" onsubmit="return validarFormulario()">
        <div class="mb-3">
            <label>Nombre del Plato</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" class="form-control" required min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label>Cantidad inicial de platos</label>
            <input type="number" name="cantidad_platos" class="form-control" required min="0" value="0">
            <small class="text-muted">Cantidad inicial de platos que desea preparar. Esta cantidad afectará el stock de ingredientes.</small>
        </div>

        <div class="mb-4">
            <h4>Ingredientes</h4>
            <p class="text-muted">Seleccione los productos y cantidades necesarias para un plato individual</p>
            
            <div id="ingredientes">
                <div class="ingrediente-item">
                    <div class="row">
                        <div class="col-md-5">
                            <label>Producto</label>
                            <select name="productos[]" class="form-control producto-select" required>
                                <option value="">Seleccione un producto</option>
                                <?php foreach($productos as $producto): ?>
                                    <option value="<?php echo $producto['id']; ?>" 
                                            data-stock="<?php echo $producto['stock']; ?>">
                                        <?php echo $producto['nombre']; ?> 
                                        (Stock: <?php echo $producto['stock']; ?> unidades)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="stock-info"></div>
                        </div>
                        <div class="col-md-3">
                            <label>Cantidad necesaria</label>
                            <input type="number" name="cantidades[]" class="form-control cantidad-input" 
                                   required min="0.01" step="0.01" placeholder="Cantidad">
                        </div>
                        <div class="col-md-3">
                            <label>Unidad de medida</label>
                            <select name="unidades[]" class="form-control unidad-select">
                                <option value="kg">Kilogramos</option>
                                <option value="g">Gramos</option>
                                <option value="l">Litros</option>
                                <option value="ml">Mililitros</option>
                                <option value="unidad">Unidades</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm form-control eliminar-ingrediente">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-info mt-2" onclick="agregarIngrediente()">
                <i class="fas fa-plus"></i> Agregar otro ingrediente
            </button>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Plato
            </button>
            <a href="../../controladores/controlador_plato/PlatoController.php?accion=index" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function agregarIngrediente() {
    const div = document.createElement('div');
    div.className = 'ingrediente-item';
    div.innerHTML = document.querySelector('.ingrediente-item').innerHTML;
    document.getElementById('ingredientes').appendChild(div);

    // Limpiar valores
    div.querySelector('select[name="productos[]"]').value = '';
    div.querySelector('input[name="cantidades[]"]').value = '';
    div.querySelector('.stock-info').textContent = '';

    // Agregar eventos
    agregarEventosIngrediente(div);
}

function agregarEventosIngrediente(elemento) {
    const productoSelect = elemento.querySelector('.producto-select');
    const cantidadInput = elemento.querySelector('.cantidad-input');
    const stockInfo = elemento.querySelector('.stock-info');
    const unidadSelect = elemento.querySelector('.unidad-select');
    
    // Eliminar ingrediente
    elemento.querySelector('.eliminar-ingrediente').addEventListener('click', function() {
        if (document.querySelectorAll('.ingrediente-item').length > 1) {
            elemento.remove();
        } else {
            alert('Debe mantener al menos un ingrediente');
        }
    });

    // Actualizar información de stock al cambiar producto
    productoSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (this.value) {
            const stock = option.dataset.stock;
            
            stockInfo.innerHTML = `Stock disponible: <span class="${parseFloat(stock) > 0 ? 'stock-ok' : 'stock-warning'}">${stock} unidades</span>`;
            cantidadInput.max = stock;
            unidadSelect.value = 'unidad'; // Por defecto usamos unidades
            
            if (parseFloat(stock) <= 0) {
                stockInfo.innerHTML += '<br><span class="stock-warning">¡No hay suficiente stock!</span>';
            }
        } else {
            stockInfo.textContent = '';
            cantidadInput.removeAttribute('max');
        }
    });

    // Validar cantidad contra stock disponible
    cantidadInput.addEventListener('input', function() {
        const stock = parseFloat(productoSelect.options[productoSelect.selectedIndex].dataset.stock);
        const cantidad = parseFloat(this.value);
        
        if (cantidad > stock) {
            this.value = stock;
            alert('La cantidad no puede superar el stock disponible');
        }
    });
}

function validarFormulario() {
    const ingredientes = document.querySelectorAll('.ingrediente-item');
    const cantidadPlatos = parseFloat(document.querySelector('input[name="cantidad_platos"]').value);
    let valido = true;
    let mensaje = '';

    // Verificar que la cantidad de platos sea válida
    if (!cantidadPlatos || cantidadPlatos <= 0) {
        mensaje = 'Debe especificar una cantidad válida de platos a preparar.';
        alert(mensaje);
        return false;
    }

    // Verificar que haya al menos un ingrediente
    if (ingredientes.length === 0) {
        mensaje = 'Debe agregar al menos un ingrediente al plato.';
        alert(mensaje);
        return false;
    }

    // Verificar cada ingrediente
    ingredientes.forEach((ingrediente, index) => {
        const productoSelect = ingrediente.querySelector('.producto-select');
        const cantidadInput = ingrediente.querySelector('.cantidad-input');
        const producto = productoSelect.value;
        const cantidad = parseFloat(cantidadInput.value);
        const stock = parseFloat(productoSelect.options[productoSelect.selectedIndex]?.dataset.stock || 0);
        const cantidadTotalNecesaria = cantidad * cantidadPlatos;

        if (!producto) {
            mensaje = `El ingrediente #${index + 1} debe tener un producto seleccionado.`;
            valido = false;
        }
        if (!cantidad || cantidad <= 0) {
            mensaje = `El ingrediente #${index + 1} debe tener una cantidad válida.`;
            valido = false;
        }
        if (cantidadTotalNecesaria > stock) {
            mensaje = `No hay suficiente stock para el ingrediente #${index + 1}.
` +
                     `Stock disponible: ${stock}
` +
                     `Cantidad necesaria total: ${cantidadTotalNecesaria} (${cantidad} por plato × ${cantidadPlatos} platos)`;
            valido = false;
        }
    });

    if (!valido) {
        alert(mensaje);
    }
    return valido;
}

function actualizarValidacionesStock() {
    const cantidadPlatos = parseFloat(document.querySelector('input[name="cantidad_platos"]').value) || 0;
    
    document.querySelectorAll('.ingrediente-item').forEach((ingrediente, index) => {
        const productoSelect = ingrediente.querySelector('.producto-select');
        const cantidadInput = ingrediente.querySelector('.cantidad-input');
        const stockInfo = ingrediente.querySelector('.stock-info');
        
        const stock = parseFloat(productoSelect.options[productoSelect.selectedIndex]?.dataset.stock || 0);
        const cantidadPorPlato = parseFloat(cantidadInput.value) || 0;
        const cantidadTotalNecesaria = cantidadPorPlato * cantidadPlatos;
        
        if (productoSelect.value) {
            let mensaje = `Stock disponible: ${stock} unidades<br>`;
            mensaje += `Necesario total: ${cantidadTotalNecesaria} unidades `;
            mensaje += `(${cantidadPorPlato} × ${cantidadPlatos} platos)`;
            
            if (cantidadTotalNecesaria > stock) {
                mensaje += '<br><span class="stock-warning">¡Stock insuficiente!</span>';
                stockInfo.classList.add('stock-warning');
            } else {
                stockInfo.classList.remove('stock-warning');
            }
            
            stockInfo.innerHTML = mensaje;
        }
    });
}

function agregarEventosIngrediente(elemento) {
    const productoSelect = elemento.querySelector('.producto-select');
    const cantidadInput = elemento.querySelector('.cantidad-input');
    const stockInfo = elemento.querySelector('.stock-info');
    const unidadSelect = elemento.querySelector('.unidad-select');
    
    // Eliminar ingrediente
    elemento.querySelector('.eliminar-ingrediente').addEventListener('click', function() {
        if (document.querySelectorAll('.ingrediente-item').length > 1) {
            elemento.remove();
        } else {
            alert('Debe mantener al menos un ingrediente');
        }
    });

    // Actualizar información de stock
    productoSelect.addEventListener('change', function() {
        actualizarValidacionesStock();
    });

    // Validar cantidad
    cantidadInput.addEventListener('input', function() {
        actualizarValidacionesStock();
    });
}

// Agregar eventos para actualización en tiempo real
document.querySelector('input[name="cantidad_platos"]').addEventListener('input', actualizarValidacionesStock);

// Agregar eventos a los ingredientes iniciales
document.querySelectorAll('.ingrediente-item').forEach(agregarEventosIngrediente);

// Inicializar eventos para los ingredientes existentes
document.querySelectorAll('.ingrediente-item').forEach(agregarEventosIngrediente);
</script>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>