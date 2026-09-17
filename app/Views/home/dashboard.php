<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Panel de Control</h2>
        <p class="text-muted mb-0">Resumen general del negocio y operaciones recientes</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-cart-plus me-1"></i> Nueva Venta
        </a>
        <a href="<?= base_url('/productos/crear') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-box me-1"></i> Nuevo Producto
        </a>
    </div>
</div>

<!-- Tarjetas de Métricas -->
<div class="row g-3 mb-4">
    <!-- Total Clientes -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Clientes</span>
                    <h3 class="fw-bold mt-1 mb-0 text-dark"><?= esc($totalClientes) ?></h3>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?= base_url('/clientes') ?>" class="text-decoration-none small text-primary fw-semibold">
                    Ver todos los clientes <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Productos -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Productos</span>
                    <h3 class="fw-bold mt-1 mb-0 text-dark"><?= esc($totalProductos) ?></h3>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-circle">
                    <i class="bi bi-box-seam-fill fs-3"></i>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <a href="<?= base_url('/productos') ?>" class="text-decoration-none small text-success fw-semibold">
                    Gestionar catálogo <i class="bi bi-arrow-right"></i>
                </a>
                <?php if ($productosBajoStock > 0): ?>
                    <span class="badge bg-danger" title="Productos con 5 o menos unidades en inventario">
                        <?= $productosBajoStock ?> bajo stock
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Total Ventas -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Ventas Totales</span>
                    <h3 class="fw-bold mt-1 mb-0 text-dark"><?= esc($totalVentas) ?></h3>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                    <i class="bi bi-receipt fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <a href="<?= base_url('/ventas') ?>" class="text-decoration-none small text-warning fw-semibold">
                    Historial de ventas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Ingresos Totales -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Ingresos Totales</span>
                    <h3 class="fw-bold mt-1 mb-0 text-dark">$<?= number_format(floatval($ingresosTotales), 2) ?></h3>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-circle">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-muted small">Monto total acumulado</span>
            </div>
        </div>
    </div>
</div>

<!-- Ventas Recientes -->
<div class="card bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Últimas Ventas Registradas</h5>
        <a href="<?= base_url('/ventas') ?>" class="btn btn-outline-primary btn-sm">Ver Todo el Historial</a>
    </div>

    <?php if (empty($ultimasVentas)): ?>
        <div class="alert alert-light text-center py-4 border">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
            <p class="text-muted mb-3">Aún no se han registrado ventas en el sistema.</p>
            <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Registrar la primera venta
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nº Factura</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimasVentas as $v): ?>
                        <tr>
                            <td>
                                <span class="fw-semibold text-primary"><?= esc($v['numero_factura']) ?></span>
                            </td>
                            <td><?= esc($v['cliente_nombre'] ?? 'Cliente General') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($v['fecha'])) ?></td>
                            <td class="fw-bold text-success">$<?= number_format(floatval($v['total']), 2) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('/ventas/detalle/' . $v['id']) ?>" class="btn btn-light btn-sm text-primary" title="Ver Comprobante">
                                    <i class="bi bi-eye"></i> Detalle
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
