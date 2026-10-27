<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$estadoActual = $reporte['id_estado'] ?? 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte #<?php echo htmlspecialchars($reporte['id_reporte'] ?? ''); ?> - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; animation: fadeIn 0.4s ease-out; }
        .animated-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 12px; border: none; }
        .animated-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important; }
        .timeline { position: relative; padding-left: 30px; margin: 15px 0; }
        .timeline::before { content: ''; position: absolute; left: 10px; top: 5px; bottom: 5px; width: 3px; background: #e9ecef; }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-badge { position: absolute; left: -27px; top: 0; width: 24px; height: 24px; border-radius: 50%; text-align: center; font-size: 11px; line-height: 24px; color: #fff; background: #ced4da; border: 3px solid #fff; box-shadow: 0 0 0 2px #e9ecef; }
        .timeline-item.completed .timeline-badge { background: #198754; }
        .timeline-item.current .timeline-badge { background: #0d6efd; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); } 100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); } }
        .evidence-img { transition: transform 0.4s ease; height: 200px; object-fit: cover; border-radius: 8px; }
        .evidence-img:hover { transform: scale(1.03); }
        .btn-custom { transition: all 0.2s ease-in-out; }
        .btn-custom:hover { transform: translateY(-2px); filter: brightness(1.05); }
        .toast { animation: slideInRight 0.3s ease-out forwards; border-radius: 8px; overflow: hidden; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>
</head>
<body>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        <?php if (isset($_SESSION['toast_success']) && !empty($_SESSION['toast_success'])): ?>
            <div class="toast align-items-center text-white bg-success border-0 shadow-lg show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-semibold"><i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['toast_success']; unset($_SESSION['toast_success']); ?></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['toast_error']) && !empty($_SESSION['toast_error'])): ?>
            <div class="toast align-items-center text-white bg-danger border-0 shadow-lg show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-semibold"><i class="fas fa-exclamation-triangle me-2"></i> <?php echo $_SESSION['toast_error']; unset($_SESSION['toast_error']); ?></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Detalle del Reporte #<?php echo htmlspecialchars($reporte['id_reporte'] ?? ''); ?></h2>
                <p class="text-muted mb-0">Seguimiento de estado y evidencias del caso reportado.</p>
            </div>
            <a href="/FresnoReporta/public/index.php?url=admin-reportes" class="btn btn-secondary btn-custom shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Volver al Panel
            </a>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card animated-card shadow-sm mb-4 bg-white">
                    <div class="card-body p-4">
                        <h4 class="text-primary fw-bold mb-3"><?php echo htmlspecialchars($reporte['titulo'] ?? 'Sin título'); ?></h4>
                        <p class="text-secondary mb-4" style="line-height: 1.6;"><?php echo nl2br(htmlspecialchars($reporte['descripcion'] ?? '')); ?></p>
                        <div class="bg-light p-3 rounded-3 border">
                            <span class="text-muted d-block small fw-bold text-uppercase mb-1">Fecha de registro:</span>
                            <span class="fw-semibold text-dark"><i class="far fa-calendar-alt me-2 text-primary"></i><?php echo htmlspecialchars($reporte['fecha_reporte'] ?? ''); ?></span>
                        </div>
                    </div>
                </div>
                <div class="card animated-card shadow-sm mb-4 bg-white">
                    <div class="card-body p-4">
                        <h5 class="text-primary fw-bold mb-4"><i class="fas fa-history me-2"></i> Línea de Tiempo del Estado</h5>
                        <div class="timeline">
                            <div class="timeline-item <?php echo ($estadoActual >= 1) ? ($estadoActual == 1 ? 'current' : 'completed') : ''; ?>">
                                <div class="timeline-badge"><i class="fas fa-check fa-xs"></i></div>
                                <h6 class="mb-1 fw-bold text-dark">1. Reporte Registrado / Pendiente</h6>
                                <p class="text-muted small mb-0">El reporte ha sido ingresado al sistema.</p>
                            </div>
                            <div class="timeline-item <?php echo ($estadoActual >= 4) ? ($estadoActual == 4 ? 'current' : 'completed') : ''; ?>">
                                <div class="timeline-badge"><i class="fas fa-check fa-xs"></i></div>
                                <h6 class="mb-1 fw-bold text-dark">2. En Proceso de Atención</h6>
                                <p class="text-muted small mb-0">El equipo trabaja en la solución del caso.</p>
                            </div>
                            <div class="timeline-item <?php echo ($estadoActual == 5) ? 'current' : ($estadoActual > 5 ? 'completed' : ''); ?>">
                                <div class="timeline-badge"><i class="fas fa-check fa-xs"></i></div>
                                <h6 class="mb-1 fw-bold text-dark">3. Solucionado</h6>
                                <p class="text-muted small mb-0">El incidente ha sido resuelto satisfactoriamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card animated-card shadow-sm mb-4 bg-white">
                    <div class="card-body p-4">
                        <h5 class="text-primary fw-bold mb-4"><i class="fas fa-images me-2"></i> Fotografías y Evidencias</h5>
                        <?php if (!empty($evidencias)): ?>
                            <div class="row g-3">
                                <?php foreach ($evidencias as $ev): ?>
                                    <?php 
                                        $archivo = $ev['nombre_archivo'] ?? $ev['ruta_archivo'] ?? $ev['url_archivo'] ?? '';
                                        if (strpos($archivo, 'uploads/') === 0) {
                                            $rutaImagen = '/FresnoReporta/public/' . $archivo;
                                        } else {
                                            $rutaImagen = '/FresnoReporta/public/uploads/' . ltrim($archivo, '/');
                                        }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                            <img src="<?php echo htmlspecialchars($rutaImagen); ?>" class="card-img-top evidence-img" alt="Evidencia" onerror="this.src='https://via.placeholder.com/400x200?text=Imagen+No+Disponible'">
                                            <div class="card-body p-2 text-center bg-light">
                                                <span class="badge bg-secondary text-uppercase px-2 py-1"><?php echo htmlspecialchars($ev['tipo_archivo'] ?? 'Evidencia'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted border border-dashed rounded bg-light">
                                <i class="fas fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                                <p class="mb-0">No hay evidencias registradas todavía.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card animated-card shadow-sm border-0 bg-white sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="card-title text-primary mb-3 fw-bold"><i class="fas fa-tools me-2"></i> Gestión Funcionario</h5>
                        <p class="text-muted small mb-4">Modifica el estado o sube evidencia de solución.</p>
                        <form action="/FresnoReporta/public/index.php?url=actualizar-estado" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="reporte_id" value="<?php echo $reporte['id_reporte']; ?>">
                            <div class="mb-3">
                                <label for="id_estado" class="form-label fw-semibold text-secondary">Actualizar Estado:</label>
                                <select name="id_estado" id="id_estado" class="form-select shadow-sm" required>
                                    <option value="1" <?php echo ($estadoActual == 1) ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="4" <?php echo ($estadoActual == 4) ? 'selected' : ''; ?>>En Proceso</option>
                                    <option value="5" <?php echo ($estadoActual == 5) ? 'selected' : ''; ?>>Solucionado</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="evidencia" class="form-label fw-semibold text-secondary">Evidencia de Solución:</label>
                                <input type="file" name="evidencia" id="evidencia" class="form-control shadow-sm" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-success btn-custom w-100 py-2 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) { return new bootstrap.Toast(toastEl, { autohide: true, delay: 4500 }).show(); });
        });
    </script>
</body>
</html>