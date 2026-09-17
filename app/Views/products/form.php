<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><?= esc($titulo) ?></h5>
            </div>
            <div class="card-body">
                <?php 
                    $url = ($accion === 'editar') 
                        ? base_url('/productos/actualizar/' . $producto['id']) 
                        : base_url('/productos/guardar');
                ?>

                <form action="<?= $url ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="codigo" class="form-label">Código *</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="<?= old('codigo', $producto['codigo'] ?? '') ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?= old('stock', $producto['stock'] ?? 0) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $producto['nombre'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio ($) *</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="precio" name="precio" value="<?= old('precio', $producto['precio'] ?? '0.00') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?= old('descripcion', $producto['descripcion'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/productos') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
