<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Panel Principal</h3>
    <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary">Nueva Venta</a>
</div>

<!-- Resumen en tarjetas simples -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="card-title text-muted">Clientes</h6>
                <h2><?= esc($totalClientes) ?></h2>
                <a href="<?= base_url('/clientes') ?>" class="btn btn-sm btn-outline-primary">Ver clientes</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="card-title text-muted">Productos</h6>
                <h2><?= esc($totalProductos) ?></h2>
                <a href="<?= base_url('/productos') ?>" class="btn btn-sm btn-outline-primary">Ver productos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="card-title text-muted">Ventas</h6>
                <h2><?= esc($totalVentas) ?></h2>
                <a href="<?= base_url('/ventas') ?>" class="btn btn-sm btn-outline-primary">Ver ventas</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Ingresos</h6>
                <h2>$<?= number_format((float)$ingresosTotales, 2) ?></h2>
                <span class="text-muted small">Monto acumulado</span>
            </div>
        </div>
    </div>
</div>

<!-- Últimas Ventas -->
<div class="card">
    <div class="card-header bg-white">
        <strong>Últimas Ventas</strong>
    </div>
    <div class="card-body p-0">
        <?php if (empty($ultimasVentas)): ?>
            <p class="text-muted p-3 mb-0">No hay ventas registradas aún.</p>
        <?php else: ?>
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nº Factura</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimasVentas as $v): ?>
                        <tr>
                            <td><?= esc($v['numero_factura']) ?></td>
                            <td><?= esc($v['cliente_nombre']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($v['fecha'])) ?></td>
                            <td><strong>$<?= number_format((float)$v['total'], 2) ?></strong></td>
                            <td class="text-end">
                                <a href="<?= base_url('/ventas/detalle/' . $v['id']) ?>" class="btn btn-sm btn-light">Ver Detalle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
