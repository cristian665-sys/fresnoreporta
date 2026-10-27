<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /FresnoReporta/public/index.php?url=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Reporte #<?php echo htmlspecialchars($reporte['id_reporte'] ?? ''); ?> - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; min-height: 100vh; display: flex; flex-direction: column; margin: 0; }
        .navbar-custom { background: rgba(30, 42, 68, 0.92); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); z-index: 1030; }
        .brand-badge { width: 38px; height: 38px; background: linear-gradient(135deg, #4F6BD8, #3B54B4); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(79, 107, 216, 0.3); }
        .main-container { max-width: 1000px; margin: 35px auto; padding: 0 20px; width: 100%; animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .detail-card { background: #ffffff; border-radius: 24px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06); border: 1px solid rgba(226, 232, 240, 0.8); overflow: hidden; }
        .detail-img { width: 100%; height: 280px; object-fit: cover; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        #mapDetail { width: 100%; height: 280px; border-radius: 16px; z-index: 1; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .timeline { position: relative; padding-left: 30px; margin: 20px 0; }
        .timeline::before { content: ''; position: absolute; left: 10px; top: 5px; bottom: 5px; width: 3px; background: #e2e8f0; border-radius: 3px; }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-marker { position: absolute; left: -30px; top: 0; width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .timeline-item.completed .timeline-marker { background: #9EE6C0; }
        .timeline-content { background: #f8fafc; padding: 14px 18px; border-radius: 14px; border: 1px solid #e2e8f0; }
        .badge-status-pill { padding: 8px 16px; border-radius: 50rem; font-size: 0.82rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .bg-pendiente-light { background-color: #fef2f2; color: #E07A7A; border: 1px solid #fecaca; }
        .bg-proceso-light { background-color: #fffbeb; color: #E0A860; border: 1px solid #fde68a; }
        .bg-solucionado-light { background-color: #ecfdf5; color: #6FCE9E; border: 1px solid #a7f3d0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none" href="/FresnoReporta/public/index.php?url=mis-reportes">
                <div class="brand-badge me-2"><i class="fas fa-shield-alt"></i></div>
                <span class="text-white">Fresno <span class="text-primary">Reporta</span></span>
            </a>
            <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Volver</a>
        </div>
    </nav>

    <div class="main-container">
        <?php if (!empty($error) || !$reporte): ?>
            <div class="alert alert-danger rounded-4 shadow-sm p-4 text-center">
                <h4 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Error</h4>
                <p class="text-muted mb-3"><?php echo htmlspecialchars($error ?? 'Reporte no encontrado.'); ?></p>
                <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-primary rounded-pill px-4">Volver</a>
            </div>
        <?php else: ?>
            <?php 
                $id_estado = $reporte['id_estado'] ?? 1;
                $estado_nombre = $reporte['estado_nombre'] ?? 'Pendiente';
                $badge_class = 'bg-pendiente-light';
                $status_icon = 'fa-exclamation-triangle';
                if ($id_estado == 4) { $badge_class = 'bg-proceso-light'; $status_icon = 'fa-spinner fa-spin'; }
                elseif ($id_estado == 5) { $badge_class = 'bg-solucionado-light'; $status_icon = 'fa-check-circle'; }
            ?>
            <div class="detail-card p-4 p-md-5 reveal">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold mb-2 shadow-sm"><i class="fas fa-hashtag me-1"></i> Radicado #<?php echo $reporte['id_reporte']; ?></span>
                        <h2 class="fw-bold text-dark m-0"><?php echo htmlspecialchars($reporte['titulo']); ?></h2>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge-status-pill <?php echo $badge_class; ?>"><i class="fas <?php echo $status_icon; ?>"></i> <?php echo htmlspecialchars($estado_nombre); ?></span>
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-semibold"><i class="fas <?php echo categoriaIcon($reporte['categoria_nombre'] ?? 'General'); ?> text-primary me-1"></i> <?php echo htmlspecialchars($reporte['categoria_nombre'] ?? 'General'); ?></span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-align-left text-primary me-1"></i> Descripción del Daño</h6>
                            <div class="p-3 bg-light rounded-4 text-dark border border-light"><?php echo nl2br(htmlspecialchars($reporte['descripcion'] ?? 'Sin descripción proporcionada.')); ?></div>
                        </div>

                        <div>
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-history text-primary me-1"></i> Línea de Tiempo del Reporte</h6>
                            <div class="timeline">
                                <div class="timeline-item completed">
                                    <div class="timeline-marker"><i class="fas fa-check"></i></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1 text-dark">Reporte Creado</h6>
                                        <p class="text-muted small mb-0">Radicado ingresado con éxito al sistema municipal.</p>
                                    </div>
                                </div>
                                <div class="timeline-item <?php echo ($id_estado >= 4) ? 'completed' : ''; ?>">
                                    <div class="timeline-marker"><i class="fas fa-tools"></i></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1 text-dark">En Proceso de Revisión</h6>
                                        <p class="text-muted small mb-0">El equipo operativo ha asignado la cuadrilla para atender la incidencia.</p>
                                    </div>
                                </div>
                                <div class="timeline-item <?php echo ($id_estado == 5) ? 'completed' : ''; ?>">
                                    <div class="timeline-marker"><i class="fas fa-flag-checkered"></i></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold mb-1 text-dark">Solucionado</h6>
                                        <p class="text-muted small mb-0">La incidencia ha sido atendida y cerrada satisfactoriamente.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <?php if (!empty($evidencias)): ?>
                            <div class="mb-4">
                                <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-image text-primary me-1"></i> Evidencia Fotográfica</h6>
                                <div class="row g-2">
                                    <?php foreach ($evidencias as $ev): ?>
                                        <div class="col-6">
                                            <img src="<?php echo htmlspecialchars(resolverRutaEvidencia($ev['nombre_archivo'])); ?>" class="detail-img" alt="Evidencia" style="height: 135px;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($reporte['latitud']) && !empty($reporte['longitud'])): ?>
                            <div>
                                <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-map-marker-alt text-primary me-1"></i> Ubicación Geográfica</h6>
                                <div id="mapDetail"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/FresnoReporta/public/assets/js/tilt3d.js"></script>
    <?php if (!empty($reporte['latitud']) && !empty($reporte['longitud'])): ?>
    <script>
        const lat = <?php echo $reporte['latitud']; ?>;
        const lng = <?php echo $reporte['longitud']; ?>;
        const map = L.map('mapDetail').setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© Fresno Reporta' }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup("<b>Ubicación del Reporte</b>").openPopup();
    </script>
    <?php endif; ?>
</body>
</html>