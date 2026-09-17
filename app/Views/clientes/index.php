<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Clientes</h2>
        <p class="text-muted mb-0">Directorio de clientes registrados para facturación</p>
    </div>
    <div>
        <a href="<?= base_url('/clientes/crear') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Nuevo Cliente
        </a>
    </div>
</div>

<div class="card bg-white p-4">
    <?php if (empty($clientes)): ?>
        <div class="alert alert-light text-center py-5 border">
            <i class="bi bi-people fs-1 text-muted d-block mb-2"></i>
            <h5 class="text-muted">No hay clientes registrados</h5>
            <p class="text-muted small mb-3">Comienza registrando tu primer cliente para poder realizar ventas.</p>
            <a href="<?= base_url('/clientes/crear') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Registrar Cliente
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Documento / ID</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $index => $c): ?>
                        <tr>
                            <td class="text-muted small"><?= $index + 1 ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= esc($c['documento'] ?: 'S/D') ?>
                                </span>
                            </td>
                            <td class="fw-semibold text-dark"><?= esc($c['nombre']) ?></td>
                            <td><?= esc($c['telefono'] ?: '-') ?></td>
                            <td>
                                <?php if ($c['email']): ?>
                                    <a href="mailto:<?= esc($c['email']) ?>" class="text-decoration-none">
                                        <?= esc($c['email']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td><small class="text-muted"><?= esc($c['direccion'] ?: '-') ?></small></td>
                            <td class="text-end">
                                <a href="<?= base_url('/clientes/editar/' . $c['id']) ?>" class="btn btn-outline-primary btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('/clientes/eliminar/' . $c['id']) ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   title="Eliminar"
                                   onclick="return confirm('¿Está seguro de eliminar al cliente <?= esc($c['nombre']) ?>?');">
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
