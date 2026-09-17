<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Ventas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.c    ss') ?>" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/icons/bootstrap-icons.min.css') ?>">

</head>
<body>

    <div class="login-card">
        <div class="text-center">
            <div class="brand-icon">
                <i class="bi bi-cart-check-fill"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark">Bienvenido de nuevo</h4>
            <p class="text-muted small mb-4">Ingresa tus credenciales para acceder al sistema</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show small py-2 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div><?= session()->getFlashdata('error') ?></div>
                <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show small py-2 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div><?= session()->getFlashdata('success') ?></div>
                <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="usuario" class="form-label small fw-semibold text-secondary">Usuario</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= old('usuario') ?>" placeholder="admin" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-semibold text-secondary">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100 mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
            </button>
        </form>

        <div class="demo-credentials text-secondary text-center mt-3">
            <div class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle me-1"></i> Credenciales de Acceso:</div>
            <div>Usuario: <strong class="text-primary">admin</strong></div>
            <div>Contraseña: <strong class="text-primary">admin123</strong></div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
