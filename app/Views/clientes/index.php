<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Clientes</h3>
    <a href="<?= base_url('/clientes/crear') ?>" class="btn btn-primary">Nuevo Cliente</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if (empty($clientes)): ?>
            <p class="text-muted p-3 mb-0">No hay clientes registrados.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $idx => $c): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><?= esc($c['nombre']) ?></td>
                            <td><?= esc($c['documento']) ?></td>
                            <td><?= esc($c['telefono']) ?></td>
                            <td><?= esc($c['email']) ?></td>
                            <td><?= esc($c['direccion']) ?></td>
                            <td>
                                <a href="<?= base_url('/clientes/editar/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="<?= base_url('/clientes/eliminar/' . $c['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('¿Eliminar cliente?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
