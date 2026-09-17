<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <!-- Barra de Acciones Superior (Oculta al imprimir) -->
        <div class="d-flex justify-content-between align-items-center mb-3 no-print flex-wrap gap-2">
            <a href="<?= base_url('/ventas') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver a Ventas
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-primary btn-sm shadow-sm">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir Comprobante
                </button>
                <a href="<?= base_url('/ventas/crear') ?>" class="btn btn-primary btn-sm shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Nueva Venta
                </a>
            </div>
        </div>

        <!-- Comprobante / Recibo -->
        <div class="card bg-white p-4 p-md-5 border" id="comprobantePrint">
            <!-- Encabezado del Comprobante -->
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4 flex-wrap gap-3">
                <div>
                    <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-cart-check-fill text-primary"></i> Mi Negocio S.A. de C.V.
                    </h3>
                    <p class="text-muted small mb-0">Venta de Tecnología y Accesorios</p>
                    <p class="text-muted small mb-0">Tel: (503) 2222-0000 | info@minegocio.com</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-6 px-3 py-2 mb-2 font-monospace">
                        <?= esc($venta['numero_factura']) ?>
                    </span>
                    <div class="small text-muted"><strong>Fecha:</strong> <?= date('d/m/Y H:i A', strtotime($venta['fecha'])) ?></div>
                    <div class="small text-muted"><strong>Vendedor:</strong> <?= esc($venta['usuario_nombre'] ?? 'Administrador') ?></div>
                </div>
            </div>

            <!-- Datos del Cliente -->
            <div class="bg-light p-3 rounded-3 mb-4">
                <h6 class="fw-bold text-secondary text-uppercase small mb-2">Datos del Cliente</h6>
                <div class="row g-2">
                    <div class="col-12 col-sm-6">
                        <div class="small"><strong>Nombre:</strong> <?= esc($venta['cliente_nombre'] ?? 'Cliente General') ?></div>
                        <div class="small"><strong>Documento / ID:</strong> <?= esc($venta['cliente_documento'] ?: 'Consumidor Final') ?></div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="small"><strong>Teléfono:</strong> <?= esc($venta['cliente_telefono'] ?: 'No registrado') ?></div>
                        <div class="small"><strong>Dirección:</strong> <?= esc($venta['cliente_direccion'] ?: 'No registrada') ?></div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Ítems Vendidos -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Descripción del Producto</th>
                            <th class="text-center" style="width: 90px;">Cant.</th>
                            <th class="text-end" style="width: 120px;">P. Unitario</th>
                            <th class="text-end" style="width: 120px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $idx => $d): ?>
                            <tr>
                                <td class="text-center text-muted small"><?= $idx + 1 ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($d['producto_nombre'] ?? 'Producto') ?></div>
                                    <small class="text-muted font-monospace"><?= esc($d['producto_codigo'] ?? '') ?></small>
                                </td>
                                <td class="text-center fw-bold"><?= esc($d['cantidad']) ?></td>
                                <td class="text-end">$<?= number_format(floatval($d['precio_unitario']), 2) ?></td>
                                <td class="text-end fw-bold text-dark">$<?= number_format(floatval($d['subtotal']), 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Resumen de Totales -->
            <div class="row justify-content-end">
                <div class="col-12 col-sm-6 col-md-5">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-semibold">$<?= number_format(floatval($venta['total']), 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">IVA (Incluido):</span>
                        <span class="fw-semibold">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between py-3">
                        <span class="fs-5 fw-bold text-dark">TOTAL PAGADO:</span>
                        <span class="fs-4 fw-bold text-success">$<?= number_format(floatval($venta['total']), 2) ?></span>
                    </div>
                </div>
            </div>

            <!-- Mensaje de Agradecimiento -->
            <div class="text-center border-top pt-4 mt-3 text-muted small">
                <p class="mb-0">¡Gracias por su compra! Por favor conserve este comprobante para cualquier reclamo o garantía.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
