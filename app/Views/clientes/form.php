<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-0 text-dark"><?= esc($titulo) ?></h3>
            <a href="<?= base_url('/clientes') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Volver a Clientes
            </a>
        </div>

        <div class="card bg-white p-4">
            <?php 
                $actionUrl = ($accion === 'editar') 
                    ? base_url('/clientes/actualizar/' . $cliente['id']) 
                    : base_url('/clientes/guardar');
            ?>

            <form action="<?= $actionUrl ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold text-secondary">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= old('nombre', $cliente['nombre'] ?? '') ?>" 
                           placeholder="Ej. Juan Pérez" 
                           required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="documento" class="form-label fw-semibold text-secondary">Documento / DUI / RFC</label>
                        <input type="text" 
                               class="form-control" 
                               id="documento" 
                               name="documento" 
                               value="<?= old('documento', $cliente['documento'] ?? '') ?>" 
                               placeholder="05123456-7">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="telefono" class="form-label fw-semibold text-secondary">Teléfono</label>
                        <input type="text" 
                               class="form-control" 
                               id="telefono" 
                               name="telefono" 
                               value="<?= old('telefono', $cliente['telefono'] ?? '') ?>" 
                               placeholder="7123-4567">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-secondary">Correo Electrónico</label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="<?= old('email', $cliente['email'] ?? '') ?>" 
                           placeholder="cliente@ejemplo.com">
                </div>

                <div class="mb-4">
                    <label for="direccion" class="form-label fw-semibold text-secondary">Dirección</label>
                    <textarea class="form-control" 
                              id="direccion" 
                              name="direccion" 
                              rows="3" 
                              placeholder="Dirección residencial o fiscal del cliente..."><?= old('direccion', $cliente['direccion'] ?? '') ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('/clientes') ?>" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
