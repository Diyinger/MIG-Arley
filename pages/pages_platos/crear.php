<?php 
include __DIR__ . '/../pages_layout/head.php';
require_once '../../modelos/modelo_existencias/InventarioModel.php';

// Obtener los productos disponibles
$modeloInventario = new InventarioModel();
$productos = $modeloInventario->obtenerInventario();
?>

<div class="container mt-4">
    <h3>Crear plato</h3>

    <form action="../../controladores/controlador_plato/PlatoController.php?accion=guardar" method="post" id="form-plato">
        <div class="form-group">
            <label>Nombre del plato</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="precio" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Cantidad inicial de platos (para validar stock)</label>
            <input type="number" name="cantidad_platos" class="form-control" value="1" min="1" step="1" required>
        </div>

        <hr>
        <h4>Ingredientes</h4>
        <p class="text-muted">Seleccione los productos y cantidades necesarias para un plato individual</p>

        <div id="ingredientes">
            <div class="ingrediente-item">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label>Producto</label>
                        <select name="productos[]" class="form-control producto-select" required>
                            <option value="">Seleccione un producto</option>
                            <?php foreach($productos as $producto): 
                                // intentar detectar unidad base si no existe unidad_base
                                $unidad_base = $producto['unidad_base'] ?? null;
                                if (!$unidad_base) {
                                    $desc = strtolower($producto['descripcion'] ?? '');
                                    if (strpos($desc, 'libra') !== false || strpos($desc, 'lb') !== false) $unidad_base = 'lb';
                                    elseif (strpos($desc, 'kilo') !== false || strpos($desc, 'kg') !== false) $unidad_base = 'kg';
                                    elseif (strpos($desc, 'litro') !== false || strpos($desc, 'l') !== false) $unidad_base = 'l';
                                    else $unidad_base = 'unidad';
                                }
                            ?>
                                <option value="<?php echo $producto['id']; ?>" 
                                        data-stock="<?php echo $producto['stock']; ?>"
                                        data-unidad="<?php echo $unidad_base; ?>">
                                    <?php echo htmlspecialchars($producto['nombre']); ?> 
                                    (Stock: <?php echo $producto['stock']; ?> <?php echo $unidad_base; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="stock-info small text-muted mt-1"></div>
                    </div>

                    <div class="col-md-3">
                        <label>Cantidad necesaria</label>
                        <input type="number" name="cantidades[]" class="form-control cantidad-input" required min="0.001" step="0.001" placeholder="Cantidad por plato">
                    </div>

                    <div class="col-md-3">
                        <label>Unidad de medida</label>
                        <select name="unidades[]" class="form-control unidad-select">
                            <option value="kg">Kilogramos (kg)</option>
                            <option value="g">Gramos (g)</option>
                            <option value="lb">Libras (lb)</option>
                            <option value="oz">Onzas (oz)</option>
                            <option value="l">Litros (l)</option>
                            <option value="ml">Mililitros (ml)</option>
                            <option value="unidad">Unidades</option>
                        </select>
                    </div>

                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm eliminar-ingrediente">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <hr>
            </div>
        </div>

        <button type="button" class="btn btn-info mt-2" id="btn-agregar">
            <i class="fas fa-plus"></i> Agregar otro ingrediente
        </button>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Guardar plato</button>
            <a href="../../controladores/controlador_plato/PlatoController.php?accion=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
(function(){
    // util: factores para conversión (a gramos / mililitros)
    const massFactors = { g: 1, kg: 1000, lb: 453.59237, oz: 28.349523125 };
    const volFactors  = { ml: 1, l: 1000 };

    function unitCategory(u) {
        if (!u) return null;
        u = u.toLowerCase();
        if (['g','kg','lb','oz'].includes(u)) return 'mass';
        if (['ml','l'].includes(u)) return 'volume';
        if (u === 'unidad') return 'unidad';
        return null;
    }

    function convert(value, fromUnit, toUnit) {
        if (fromUnit === toUnit) return parseFloat(value) || 0;
        const fromCat = unitCategory(fromUnit);
        const toCat   = unitCategory(toUnit);
        if (!fromCat || !toCat || fromCat !== toCat) return null; // incompatible
        if (fromCat === 'mass') {
            const grams = parseFloat(value) * (massFactors[fromUnit] || 1);
            return grams / (massFactors[toUnit] || 1);
        } else if (fromCat === 'volume') {
            const ml = parseFloat(value) * (volFactors[fromUnit] || 1);
            return ml / (volFactors[toUnit] || 1);
        } else {
            // unidad
            return parseFloat(value) || 0;
        }
    }

    // agrega un nuevo bloque de ingrediente clonando el primero
    function agregarIngrediente() {
        const template = document.querySelector('#ingredientes .ingrediente-item');
        const clone = template.cloneNode(true);
        // limpiar valores
        clone.querySelector('.producto-select').value = '';
        clone.querySelector('.cantidad-input').value = '';
        clone.querySelector('.unidad-select').value = 'kg';
        clone.querySelector('.stock-info').textContent = '';
        // agregar eventos
        agregarEventosIngrediente(clone);
        document.getElementById('ingredientes').appendChild(clone);
    }

    function eliminarIngrediente(btn) {
        const items = document.querySelectorAll('#ingredientes .ingrediente-item');
        if (items.length <= 1) {
            alert('Debe mantener al menos un ingrediente');
            return;
        }
        btn.closest('.ingrediente-item').remove();
        actualizarValidacionesStock();
    }

    function agregarEventosIngrediente(elemento) {
        const productoSelect = elemento.querySelector('.producto-select');
        const cantidadInput = elemento.querySelector('.cantidad-input');
        const unidadSelect = elemento.querySelector('.unidad-select');
        const stockInfo = elemento.querySelector('.stock-info');
        const btnEliminar = elemento.querySelector('.eliminar-ingrediente');

        productoSelect.addEventListener('change', function(){
            stockInfo.textContent = '';
            actualizarValidacionesStock();
        });

        cantidadInput.addEventListener('input', actualizarValidacionesStock);
        unidadSelect.addEventListener('change', actualizarValidacionesStock);
        btnEliminar.addEventListener('click', function(){ eliminarIngrediente(this); });
    }

    function actualizarValidacionesStock() {
        const cantidadPlatos = parseFloat(document.querySelector('input[name="cantidad_platos"]').value) || 0;
        document.querySelectorAll('#ingredientes .ingrediente-item').forEach((ingrediente) => {
            const productoSelect = ingrediente.querySelector('.producto-select');
            const cantidadInput = ingrediente.querySelector('.cantidad-input');
            const unidadSelect = ingrediente.querySelector('.unidad-select');
            const stockInfo = ingrediente.querySelector('.stock-info');

            if (!productoSelect.value) {
                stockInfo.innerHTML = '';
                return;
            }

            const option = productoSelect.options[productoSelect.selectedIndex];
            const stock = parseFloat(option.dataset.stock) || 0;
            const productoUnidad = option.dataset.unidad || 'unidad';

            const cantidadPorPlato = parseFloat(cantidadInput.value) || 0;
            const necesarioTotal = cantidadPorPlato * (cantidadPlatos || 1);

            // Convertir necesarioTotal desde unidadSeleccionada a unidad del producto
            const convertido = convert(necesarioTotal, unidadSelect.value, productoUnidad);

            let mensaje = `Stock disponible: ${stock} ${productoUnidad}<br>`;
            mensaje += `Necesario total: ${necesarioTotal} ${unidadSelect.value} (por ${cantidadPlatos} plato(s))`;

            if (convertido === null) {
                // unidades incompatibles
                mensaje += `<br><span class="text-warning">Unidades incompatibles. No se puede comparar ${unidadSelect.value} con ${productoUnidad}.</span>`;
                stockInfo.innerHTML = mensaje;
                stockInfo.classList.add('text-warning');
            } else {
                // redondeo razonable para mostrar
                const convertidoShow = Math.round(convertido * 1000) / 1000;
                mensaje += `<br>Necesario convertido: ${convertidoShow} ${productoUnidad}`;
                if (convertido > stock) {
                    mensaje += `<br><span class="text-danger">¡Stock insuficiente!</span>`;
                    stockInfo.classList.remove('text-success');
                    stockInfo.classList.add('text-danger');
                } else {
                    mensaje += `<br><span class="text-success">Stock suficiente</span>`;
                    stockInfo.classList.remove('text-danger');
                    stockInfo.classList.add('text-success');
                }
                stockInfo.innerHTML = mensaje;
            }
        });
    }

    // init
    document.getElementById('btn-agregar').addEventListener('click', agregarIngrediente);
    document.querySelector('input[name="cantidad_platos"]').addEventListener('input', actualizarValidacionesStock);
    // agregar eventos para el primer ingrediente y los que ya existan
    document.querySelectorAll('#ingredientes .ingrediente-item').forEach(agregarEventosIngrediente);

    // por si se hace submit: se puede hacer validación final aquí
    document.getElementById('form-plato').addEventListener('submit', function(e){
        // validación extra si quieres (por ejemplo evitar guardar si stock insuficiente)
        // la validación de stock crítica se hace en el servidor también.
    });

})();
</script>

<?php include __DIR__ . '/../pages_layout/footer.php'; ?>
