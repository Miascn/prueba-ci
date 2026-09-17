<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Historial de Ventas</h2>
        <p class="text-muted mb-0">Listado de transacciones, facturas y comprobantes emitidos</p>
    </div>
    <div>
        <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-cart-plus-fill me-1"></i> Nueva Venta
        </a>
    </div>
</div>

<div class="card bg-white p-4">
    <?php if (empty($ventas)): ?>
        <div class="alert alert-light text-center py-5 border">
            <i class="bi bi-receipt fs-1 text-muted d-block mb-2"></i>
            <h5 class="text-muted">No hay ventas registradas</h5>
            <p class="text-muted small mb-3">Registra una nueva venta para generar comprobantes y actualizar el inventario.</p>
            <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Realizar Nueva Venta
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nº Factura</th>
                        <th>Fecha y Hora</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Total</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace fs-6">
                                    <?= esc($v['numero_factura']) ?>
                                </span>
                            </td>
                            <td>
                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                <?= date('d/m/Y H:i', strtotime($v['fecha'])) ?>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><?= esc($v['cliente_nombre'] ?? 'Cliente General') ?></span>
                                <?php if (!empty($v['cliente_documento'])): ?>
                                    <br><small class="text-muted">Doc: <?= esc($v['cliente_documento']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted"><i class="bi bi-person me-1"></i><?= esc($v['usuario_nombre'] ?? 'Admin') ?></small>
                            </td>
                            <td class="fw-bold text-success fs-6">
                                $<?= number_format(floatval($v['total']), 2) ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('/ventas/detalle/' . $v['id']) ?>" class="btn btn-outline-primary btn-sm me-1" title="Ver Comprobante">
                                    <i class="bi bi-printer me-1"></i> Comprobante
                                </a>
                                <a href="<?= base_url('/ventas/eliminar/' . $v['id']) ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   title="Anular Venta"
                                   onclick="return confirm('¿Está seguro de anular esta venta (<?= esc($v['numero_factura']) ?>)? El stock de los productos será devuelto al inventario.');">
                                    <i class="bi bi-x-circle"></i>
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
