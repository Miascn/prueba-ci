<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0 text-dark">Registrar Venta</h3>
            <a href="<?= base_url('/ventas') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver a Ventas
            </a>
        </div>

        <div class="card bg-white p-4 shadow-sm">
            <form action="<?= base_url('/ventas/guardar') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Cliente -->
                <div class="mb-3">
                    <label for="cliente_id" class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                    <select class="form-select" id="cliente_id" name="cliente_id" required>
                        <option value="">-- Selecciona un Cliente --</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= old('cliente_id') == $c['id'] ? 'selected' : '' ?>>
                                <?= esc($c['nombre']) ?> <?= $c['documento'] ? '('.esc($c['documento']).')' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Producto -->
                <div class="mb-3">
                    <label for="producto_id" class="form-label fw-semibold">Producto <span class="text-danger">*</span></label>
                    <select class="form-select" id="producto_id" name="producto_id" required>
                        <option value="">-- Selecciona un Producto --</option>
                        <?php foreach ($productos as $p): ?>
                            <option value="<?= $p['id'] ?>" 
                                    data-precio="<?= $p['precio'] ?>" 
                                    data-stock="<?= $p['stock'] ?>"
                                    <?= old('producto_id') == $p['id'] ? 'selected' : '' ?>>
                                <?= esc($p['nombre']) ?> - $<?= number_format($p['precio'], 2) ?> (Stock: <?= $p['stock'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="stock_aviso" class="form-text text-muted mt-1">Selecciona un producto para ver el precio.</div>
                </div>

                <!-- Cantidad y Total -->
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <label for="cantidad" class="form-label fw-semibold">Cantidad <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               id="cantidad" 
                               name="cantidad" 
                               min="1" 
                               value="<?= old('cantidad', 1) ?>" 
                               required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Total a Pagar</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control fw-bold text-success bg-light" id="total" readonly value="0.00">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('/ventas') ?>" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-cart-check me-1"></i> Guardar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const productoSelect = document.getElementById('producto_id');
    const cantidadInput  = document.getElementById('cantidad');
    const totalInput     = document.getElementById('total');
    const stockAviso     = document.getElementById('stock_aviso');

    function recalcular() {
        const option = productoSelect.options[productoSelect.selectedIndex];
        if (productoSelect.value) {
            const precio = parseFloat(option.dataset.precio || 0);
            const stock  = parseInt(option.dataset.stock || 0);
            const cant   = parseInt(cantidadInput.value || 0);

            cantidadInput.max = stock;
            stockAviso.textContent = `Stock disponible: ${stock} unidades | Precio: $${precio.toFixed(2)}`;

            if (cant > stock) {
                totalInput.value = 'Stock superado';
            } else {
                totalInput.value = (precio * cant).toFixed(2);
            }
        } else {
            stockAviso.textContent = 'Selecciona un producto para ver el precio.';
            totalInput.value = '0.00';
        }
    }

    productoSelect.addEventListener('change', recalcular);
    cantidadInput.addEventListener('input', recalcular);
    recalcular();
</script>
<?= $this->endSection() ?>
