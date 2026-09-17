<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Registrar Nueva Venta</h2>
        <p class="text-muted mb-0">Seleccione el cliente y agregue los productos a la orden</p>
    </div>
    <a href="<?= base_url('/ventas') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver al Historial
    </a>
</div>

<form action="<?= base_url('/ventas/guardar') ?>" method="POST" id="formVenta">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Columna Izquierda: Selección de Cliente y Selector de Productos -->
        <div class="col-12 col-lg-5">
            <!-- Tarjeta Cliente -->
            <div class="card bg-white p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-check text-primary me-2"></i>1. Datos del Cliente</h5>
                
                <div class="mb-3">
                    <label for="cliente_id" class="form-label fw-semibold text-secondary">Seleccionar Cliente <span class="text-danger">*</span></label>
                    <select class="form-select" id="cliente_id" name="cliente_id" required>
                        <option value="">-- Seleccione un cliente --</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= old('cliente_id') == $c['id'] ? 'selected' : '' ?>>
                                <?= esc($c['nombre']) ?> <?= $c['documento'] ? '('.esc($c['documento']).')' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text-end">
                    <a href="<?= base_url('/clientes/crear') ?>" target="_blank" class="small text-decoration-none">
                        <i class="bi bi-plus-circle me-1"></i>Registrar nuevo cliente
                    </a>
                </div>
            </div>

            <!-- Tarjeta Selector de Producto -->
            <div class="card bg-white p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-box-seam text-success me-2"></i>2. Agregar Productos</h5>

                <?php if (empty($productos)): ?>
                    <div class="alert alert-warning small mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i> No hay productos con stock disponible en el inventario.
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label for="producto_selector" class="form-label fw-semibold text-secondary">Producto</label>
                        <select class="form-select" id="producto_selector">
                            <option value="">-- Seleccione un producto --</option>
                            <?php foreach ($productos as $p): ?>
                                <option value="<?= $p['id'] ?>" 
                                        data-codigo="<?= esc($p['codigo']) ?>" 
                                        data-nombre="<?= esc($p['nombre']) ?>" 
                                        data-precio="<?= floatval($p['precio']) ?>" 
                                        data-stock="<?= intval($p['stock']) ?>">
                                    <?= esc($p['nombre']) ?> - $<?= number_format(floatval($p['precio']), 2) ?> (Stock: <?= $p['stock'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-secondary">Precio Unitario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="text" class="form-control bg-light" id="precio_display" readonly value="0.00">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="cantidad_input" class="form-label fw-semibold text-secondary">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad_input" value="1" min="1">
                            <small class="text-muted" id="stock_info">Stock: -</small>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success w-100 shadow-sm" id="btnAgregarProducto">
                        <i class="bi bi-cart-plus me-1"></i> Agregar a la Lista
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Columna Derecha: Detalle de la Venta y Total -->
        <div class="col-12 col-lg-7">
            <div class="card bg-white p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-receipt text-warning me-2"></i>3. Detalle de la Venta</h5>

                <div class="table-responsive flex-grow-1 mb-4">
                    <table class="table table-hover align-middle mb-0" id="tablaDetalles">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center" style="width: 110px;">Cant.</th>
                                <th class="text-end" style="width: 100px;">Precio</th>
                                <th class="text-end" style="width: 110px;">Subtotal</th>
                                <th class="text-center" style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTabla">
                            <tr id="filaVacia">
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-cart-x fs-2 d-block mb-1"></i>
                                    No se han agregado productos aún a la orden.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Resumen y Total -->
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fs-5 fw-semibold text-secondary">Total a Pagar:</span>
                        <span class="fs-2 fw-bold text-success" id="totalDisplay">$0.00</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow" id="btnEmitirVenta" disabled>
                        <i class="bi bi-check2-circle me-1"></i> Emitir y Guardar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const productoSelector = document.getElementById('producto_selector');
    const precioDisplay    = document.getElementById('precio_display');
    const cantidadInput    = document.getElementById('cantidad_input');
    const stockInfo        = document.getElementById('stock_info');
    const btnAgregar       = document.getElementById('btnAgregarProducto');
    const cuerpoTabla      = document.getElementById('cuerpoTabla');
    const filaVacia        = document.getElementById('filaVacia');
    const totalDisplay     = document.getElementById('totalDisplay');
    const btnEmitir        = document.getElementById('btnEmitirVenta');

    let productosAgregados = {};

    if (productoSelector) {
        productoSelector.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                const precio = parseFloat(selectedOption.getAttribute('data-precio') || 0);
                const stock  = parseInt(selectedOption.getAttribute('data-stock') || 0);
                precioDisplay.value = precio.toFixed(2);
                stockInfo.textContent = `Stock disponible: ${stock}`;
                cantidadInput.max = stock;
                cantidadInput.value = 1;
            } else {
                precioDisplay.value = '0.00';
                stockInfo.textContent = 'Stock: -';
                cantidadInput.value = 1;
            }
        });
    }

    if (btnAgregar) {
        btnAgregar.addEventListener('click', function () {
            if (!productoSelector.value) {
                alert('Por favor selecciona un producto.');
                return;
            }

            const selectedOption = productoSelector.options[productoSelector.selectedIndex];
            const prodId   = selectedOption.value;
            const nombre   = selectedOption.getAttribute('data-nombre');
            const codigo   = selectedOption.getAttribute('data-codigo');
            const precio   = parseFloat(selectedOption.getAttribute('data-precio'));
            const maxStock = parseInt(selectedOption.getAttribute('data-stock'));
            const cantidad = parseInt(cantidadInput.value);

            if (isNaN(cantidad) || cantidad <= 0) {
                alert('La cantidad debe ser mayor a 0.');
                return;
            }

            // Validar si ya fue agregado
            const cantidadActual = productosAgregados[prodId] ? productosAgregados[prodId].cantidad : 0;
            const nuevaCantidad  = cantidadActual + cantidad;

            if (nuevaCantidad > maxStock) {
                alert(`Stock insuficiente. Solo hay ${maxStock} unidades disponibles en inventario.`);
                return;
            }

            if (productosAgregados[prodId]) {
                productosAgregados[prodId].cantidad = nuevaCantidad;
                productosAgregados[prodId].subtotal = nuevaCantidad * precio;
            } else {
                productosAgregados[prodId] = {
                    id: prodId,
                    codigo: codigo,
                    nombre: nombre,
                    precio: precio,
                    cantidad: cantidad,
                    subtotal: cantidad * precio,
                    maxStock: maxStock
                };
            }

            // Limpiar selector
            productoSelector.value = '';
            precioDisplay.value = '0.00';
            stockInfo.textContent = 'Stock: -';
            cantidadInput.value = 1;

            actualizarTabla();
        });
    }

    window.quitarProducto = function(prodId) {
        delete productosAgregados[prodId];
        actualizarTabla();
    };

    window.cambiarCantidad = function(prodId, nuevaCant) {
        nuevaCant = parseInt(nuevaCant);
        if (isNaN(nuevaCant) || nuevaCant <= 0) {
            alert('La cantidad mínima es 1.');
            actualizarTabla();
            return;
        }

        if (nuevaCant > productosAgregados[prodId].maxStock) {
            alert(`Stock máximo disponible: ${productosAgregados[prodId].maxStock}`);
            actualizarTabla();
            return;
        }

        productosAgregados[prodId].cantidad = nuevaCant;
        productosAgregados[prodId].subtotal = nuevaCant * productosAgregados[prodId].precio;
        actualizarTabla();
    };

    function actualizarTabla() {
        const keys = Object.keys(productosAgregados);

        if (keys.length === 0) {
            cuerpoTabla.innerHTML = '';
            cuerpoTabla.appendChild(filaVacia);
            totalDisplay.textContent = '$0.00';
            btnEmitir.disabled = true;
            return;
        }

        let html = '';
        let granTotal = 0;

        keys.forEach(id => {
            const item = productosAgregados[id];
            granTotal += item.subtotal;

            html += `
                <tr>
                    <td>
                        <div class="fw-semibold text-dark">${item.nombre}</div>
                        <small class="text-muted font-monospace">${item.codigo}</small>
                        <input type="hidden" name="producto_id[]" value="${item.id}">
                    </td>
                    <td class="text-center">
                        <input type="number" 
                               name="cantidad[]" 
                               value="${item.cantidad}" 
                               min="1" 
                               max="${item.maxStock}" 
                               class="form-control form-control-sm text-center"
                               onchange="cambiarCantidad('${item.id}', this.value)">
                    </td>
                    <td class="text-end">$${item.precio.toFixed(2)}</td>
                    <td class="text-end fw-bold text-dark">$${item.subtotal.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="quitarProducto('${item.id}')" title="Quitar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        cuerpoTabla.innerHTML = html;
        totalDisplay.textContent = `$${granTotal.toFixed(2)}`;
        btnEmitir.disabled = false;
    }
});
</script>
<?= $this->endSection() ?>
