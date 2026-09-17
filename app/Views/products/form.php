<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0 text-dark"><?= esc($titulo) ?></h3>
            <a href="<?= base_url('/productos') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver a Productos
            </a>
        </div>

        <div class="card bg-white p-4">
            <?php 
                $actionUrl = ($accion === 'editar') 
                    ? base_url('/productos/actualizar/' . $producto['id']) 
                    : base_url('/productos/guardar');
            ?>

            <form action="<?= $actionUrl ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="codigo" class="form-label fw-semibold text-secondary">Código del Producto <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control font-monospace" 
                               id="codigo" 
                               name="codigo" 
                               value="<?= old('codigo', $producto['codigo'] ?? '') ?>" 
                               placeholder="PROD-001" 
                               required>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="stock" class="form-label fw-semibold text-secondary">Stock Inicial / Cantidad <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               id="stock" 
                               name="stock" 
                               min="0" 
                               value="<?= old('stock', $producto['stock'] ?? 0) ?>" 
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold text-secondary">Nombre del Producto <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= old('nombre', $producto['nombre'] ?? '') ?>" 
                           placeholder="Ej. Monitor Samsung 24 FHD" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label fw-semibold text-secondary">Precio de Venta ($) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">$</span>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               class="form-control" 
                               id="precio" 
                               name="precio" 
                               value="<?= old('precio', $producto['precio'] ?? '0.00') ?>" 
                               placeholder="0.00" 
                               required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="form-label fw-semibold text-secondary">Descripción</label>
                    <textarea class="form-control" 
                              id="descripcion" 
                              name="descripcion" 
                              rows="3" 
                              placeholder="Detalles técnicos, especificaciones, marca..."><?= old('descripcion', $producto['descripcion'] ?? '') ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('/productos') ?>" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
