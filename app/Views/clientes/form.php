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
                        ? base_url('/clientes/actualizar/' . $cliente['id']) 
                        : base_url('/clientes/guardar');
                ?>

                <form action="<?= $url ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $cliente['nombre'] ?? '') ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento" value="<?= old('documento', $cliente['documento'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= old('telefono', $cliente['telefono'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $cliente['email'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"><?= old('direccion', $cliente['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/clientes') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
