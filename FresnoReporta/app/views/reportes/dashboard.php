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
    <title>Dashboard y Estadísticas - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; min-height: 100vh; display: flex; flex-direction: column; margin: 0; }
        .navbar-custom { background: rgba(30, 42, 68, 0.92); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); z-index: 1030; }
        .brand-badge { width: 38px; height: 38px; background: linear-gradient(135deg, #4F6BD8, #3B54B4); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(79, 107, 216, 0.3); }
        .main-container { flex: 1; max-width: 1200px; margin: 30px auto; padding: 0 20px; width: 100%; }
        .stat-card { background: #ffffff; border-radius: 20px; padding: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #fff; }
        .chart-section-card { background: #ffffff; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); padding: 24px; margin-bottom: 25px; }
        .table-card { background: #ffffff; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .custom-table th { background-color: #1E2A44; color: white; font-weight: 600; padding: 14px; font-size: 0.9rem; border: none; }
        .custom-table td { padding: 14px; vertical-align: middle; font-size: 0.92rem; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none" href="/FresnoReporta/public/index.php?url=admin">
                <div class="brand-badge me-2"><i class="fas fa-shield-alt"></i></div>
                <span class="text-white">Fresno <span class="text-primary">Admin</span></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="/FresnoReporta/public/index.php?url=admin" class="btn btn-outline-light btn-sm rounded-pill px-3">Panel Admin</a>
                <a href="/FresnoReporta/public/index.php?url=mapa" class="btn btn-outline-light btn-sm rounded-pill px-3">Mapa General</a>
                <a href="/FresnoReporta/public/index.php?url=logout" class="btn btn-danger btn-sm rounded-pill px-3" title="Cerrar Sesión"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>

    <div class="main-container">

        <div class="page-hero-photo photo-arcoiris reveal mb-4">
            <h2 class="fw-bold text-white m-0"><i class="fas fa-chart-pie me-2"></i>Dashboard y Estadísticas</h2>
            <p class="mb-0 small" style="color: rgba(255,255,255,0.78);">Análisis visual y control general de incidencias en Fresno, Tolima.</p>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card tilt-card reveal">
                    <div class="stat-icon bg-primary"><i class="fas fa-folder-open"></i></div>
                    <div>
                        <span class="text-muted small fw-semibold">Total Reportes</span>
                        <h4 class="fw-bold text-dark m-0"><?php echo (int)($total_reportes ?? 0); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card tilt-card reveal reveal-delay-1">
                    <div class="stat-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                    <div>
                        <span class="text-muted small fw-semibold">Pendientes</span>
                        <h4 class="fw-bold text-dark m-0"><?php echo (int)($pendientes ?? 0); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card tilt-card reveal reveal-delay-2">
                    <div class="stat-icon bg-warning text-dark"><i class="fas fa-spinner"></i></div>
                    <div>
                        <span class="text-muted small fw-semibold">En Proceso</span>
                        <h4 class="fw-bold text-dark m-0"><?php echo (int)($en_proceso ?? 0); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card tilt-card reveal reveal-delay-3">
                    <div class="stat-icon bg-success"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <span class="text-muted small fw-semibold">Solucionados</span>
                        <h4 class="fw-bold text-dark m-0"><?php echo (int)($solucionados ?? 0); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-section-card reveal reveal-delay-1">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-chart-bar text-primary me-2"></i>Apartado Estadístico</h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-4 border">
                        <h6 class="fw-bold text-secondary text-center mb-3">Distribución por Estados</h6>
                        <div style="position: relative; height: 240px; width: 100%;">
                            <canvas id="estadosChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-4 border">
                        <h6 class="fw-bold text-secondary text-center mb-3">Reportes por Categoría</h6>
                        <div style="position: relative; height: 240px; width: 100%;">
                            <canvas id="categoriaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($por_categoria)): ?>
        <div class="table-card reveal reveal-delay-2">
            <div class="table-responsive">
                <table class="table custom-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th class="text-end">Total de Reportes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($por_categoria as $cat): ?>
                            <tr>
                                <td class="fw-semibold text-dark"><?php echo htmlspecialchars($cat['categoria'] ?? 'Sin categoría'); ?></td>
                                <td class="text-end"><?php echo (int)($cat['total'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <script>
        const pendientes = <?php echo (int)($pendientes ?? 0); ?>;
        const enProceso = <?php echo (int)($en_proceso ?? 0); ?>;
        const solucionados = <?php echo (int)($solucionados ?? 0); ?>;

        new Chart(document.getElementById('estadosChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'En Proceso', 'Solucionados'],
                datasets: [{
                    data: [pendientes, enProceso, solucionados],
                    backgroundColor: ['#F4A3A3', '#F7CB8F', '#9EE6C0'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        const categoriaLabels = <?php echo json_encode(array_column($por_categoria ?? [], 'categoria')); ?>;
        const categoriaData = <?php echo json_encode(array_map('intval', array_column($por_categoria ?? [], 'total'))); ?>;

        new Chart(document.getElementById('categoriaChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: categoriaLabels,
                datasets: [{
                    label: 'Cantidad de Reportes',
                    data: categoriaData,
                    backgroundColor: 'rgba(79, 107, 216, 0.8)',
                    borderColor: '#4F6BD8',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FresnoReporta/public/assets/js/tilt3d.js"></script>
</body>
</html>
