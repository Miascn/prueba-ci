<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detalle de Venta</h3>
            <a href="<?= base_url('/ventas') ?>" class="btn btn-secondary btn-sm">Volver a Ventas</a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-6">
                        <strong>Factura:</strong> <?= esc($venta['numero_factura']) ?><br>
                        <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?>
                    </div>
                    <div class="col-6 text-end">
                        <strong>Cliente:</strong> <?= esc($venta['cliente_nombre'] ?? 'Cliente General') ?><br>
                        <span class="text-muted small">Doc: <?= esc($venta['cliente_documento'] ?: 'S/D') ?></span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $d): ?>
                            <tr>
                                <td><?= esc($d['producto_nombre']) ?></td>
                                <td class="text-center"><?= esc($d['cantidad']) ?></td>
                                <td class="text-end">$<?= number_format((float)$d['precio_unitario'], 2) ?></td>
                                <td class="text-end">$<?= number_format((float)$d['subtotal'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end text-primary fs-5">$<?= number_format((float)$venta['total'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
