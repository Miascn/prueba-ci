<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Productos</h2>
        <p class="text-muted mb-0">Inventario y catálogo de productos disponibles</p>
    </div>
    <div>
        <a href="<?= base_url('/productos/crear') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-box-seam-fill me-1"></i> Nuevo Producto
        </a>
    </div>
</div>

<div class="card bg-white p-4">
    <?php if (empty($productos)): ?>
        <div class="alert alert-light text-center py-5 border">
            <i class="bi bi-box-seam fs-1 text-muted d-block mb-2"></i>
            <h5 class="text-muted">No hay productos en inventario</h5>
            <p class="text-muted small mb-3">Agrega productos para poder armar órdenes de venta y controlar el stock.</p>
            <a href="<?= base_url('/productos/crear') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Registrar Producto
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary font-monospace"><?= esc($p['codigo']) ?></span>
                            </td>
                            <td class="fw-semibold text-dark"><?= esc($p['nombre']) ?></td>
                            <td><small class="text-muted"><?= esc($p['descripcion'] ?: 'Sin descripción') ?></small></td>
                            <td class="fw-bold text-primary">$<?= number_format(floatval($p['precio']), 2) ?></td>
                            <td class="text-center">
                                <?php if ($p['stock'] == 0): ?>
                                    <span class="badge bg-danger">Agotado (0)</span>
                                <?php elseif ($p['stock'] <= 5): ?>
                                    <span class="badge bg-warning text-dark" title="Stock bajo"><?= esc($p['stock']) ?> unid.</span>
                                <?php else: ?>
                                    <span class="badge bg-success"><?= esc($p['stock']) ?> unid.</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('/productos/editar/' . $p['id']) ?>" class="btn btn-outline-primary btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('/productos/eliminar/' . $p['id']) ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   title="Eliminar"
                                   onclick="return confirm('¿Está seguro de eliminar el producto <?= esc($p['nombre']) ?>?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
