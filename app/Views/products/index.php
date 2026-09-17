<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Listado de Productos</h3>
    <a href="<?= base_url('/productos/crear') ?>" class="btn btn-primary">Nuevo Producto</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if (empty($productos)): ?>
            <p class="text-muted p-3 mb-0">No hay productos registrados.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Descripción</th>
                        <th style="width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td><code><?= esc($p['codigo']) ?></code></td>
                            <td><?= esc($p['nombre']) ?></td>
                            <td>$<?= number_format((float)$p['precio'], 2) ?></td>
                            <td><?= esc($p['stock']) ?></td>
                            <td><?= esc($p['descripcion'] ?: '-') ?></td>
                            <td>
                                <a href="<?= base_url('/productos/editar/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="<?= base_url('/productos/eliminar/' . $p['id']) ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('¿Eliminar producto?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
