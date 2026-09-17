<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Historial de Ventas</h3>
    <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary">Nueva Venta</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if (empty($ventas)): ?>
            <p class="text-muted p-3 mb-0">No hay ventas registradas.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nº Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th style="width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td><?= esc($v['numero_factura']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($v['fecha'])) ?></td>
                            <td><?= esc($v['cliente_nombre'] ?? 'Cliente General') ?></td>
                            <td><strong>$<?= number_format((float)$v['total'], 2) ?></strong></td>
                            <td>
                                <a href="<?= base_url('/ventas/detalle/' . $v['id']) ?>" class="btn btn-sm btn-outline-primary">Detalle</a>
                                <a href="<?= base_url('/ventas/eliminar/' . $v['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('¿Eliminar venta? Se restaurará el stock.');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
