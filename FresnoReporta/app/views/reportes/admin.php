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
    <title>Panel de Administración - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para las gráficas estadísticas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; min-height: 100vh; display: flex; flex-direction: column; margin: 0; }
        .navbar-custom { background: rgba(30, 42, 68, 0.92); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); z-index: 1030; }
        .brand-badge { width: 38px; height: 38px; background: linear-gradient(135deg, #4F6BD8, #3B54B4); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(79, 107, 216, 0.3); }
        .main-container { flex: 1; max-width: 1200px; margin: 30px auto; padding: 0 20px; width: 100%; animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .stat-card { background: #ffffff; border-radius: 20px; padding: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
        .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #fff; }

        /* Apartado de Gráficas */
        .chart-section-card { background: #ffffff; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); padding: 24px; margin-bottom: 25px; }

        .filter-container { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05) !important; border-radius: 20px; }
        .form-control:focus, .form-select:focus { background-color: #fff !important; box-shadow: 0 0 0 3px rgba(79, 107, 216, 0.15) !important; border-color: #4F6BD8 !important; }
        .select-custom, .input-group-custom input { transition: all 0.25s ease; font-size: 0.92rem; color: #334155; }
        .btn-filter { background: linear-gradient(135deg, #4F6BD8, #3B54B4); border: none; transition: all 0.25s ease; font-size: 0.92rem; }
        .btn-filter:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79, 107, 216, 0.35); background: linear-gradient(135deg, #3B54B4, #2F4494); }
        .table-card { background: #ffffff; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .custom-table th { background-color: #1E2A44; color: white; font-weight: 600; padding: 16px; font-size: 0.9rem; border: none; }
        .custom-table td { padding: 16px; vertical-align: middle; font-size: 0.92rem; border-bottom: 1px solid #f1f5f9; }
        .custom-table tbody tr:hover { background-color: #f8fafc; }
        .thumbnail-img { width: 45px; height: 45px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
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
                <a href="/FresnoReporta/public/index.php?url=dashboard-estadisticas" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-chart-pie me-1"></i> Dashboard
                </a>
                <a href="/FresnoReporta/public/index.php?url=mapa" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-map-marked-alt me-1"></i> Mapa General
                </a>
                <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-outline-light btn-sm rounded-pill px-3">Mis Reportes</a>
                <a href="/FresnoReporta/public/index.php?url=logout" class="btn btn-danger btn-sm rounded-pill px-3" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        
        <div class="page-hero-photo photo-atardecer reveal mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold text-white m-0"><i class="fas fa-clipboard-list me-2"></i>Panel de Administración</h2>
                <p class="mb-0 small" style="color: rgba(255,255,255,0.78);">Gestiona y actualiza el estado de las incidencias reportadas en Fresno, Tolima.</p>
            </div>
            <a href="/FresnoReporta/public/index.php?url=dashboard-estadisticas" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-filter btn-3d shadow-sm">
                <i class="fas fa-chart-pie me-2"></i> Ver Dashboard y Estadísticas
            </a>
        </div>

        <?php if (isset($_SESSION['toast_success'])): ?>
            <div class="alert alert-success rounded-4 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['toast_success']; unset($_SESSION['toast_success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['toast_error'])): ?>
            <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $_SESSION['toast_error']; unset($_SESSION['toast_error']); ?>
            </div>
        <?php endif; ?>

        <!-- Barra de Filtros -->
        <div class="card border-0 shadow-sm p-4 mb-4 filter-container tilt-card reveal">
            <form action="" method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="url" value="admin">
                
                <div class="col-lg-4 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">
                        <i class="fas fa-search text-primary me-1"></i> Búsqueda Rápida
                    </label>
                    <div class="input-group input-group-custom">
                        <span class="input-group-text bg-light border-0 ps-3 rounded-start-pill text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="busqueda" class="form-control bg-light border-0 rounded-end-pill py-2 shadow-none" placeholder="Título, descripción..." value="<?php echo htmlspecialchars($_GET['busqueda'] ?? ''); ?>">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">
                        <i class="fas fa-tags text-primary me-1"></i> Categoría
                    </label>
                    <select name="categoria" class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none select-custom">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">
                        <i class="fas fa-tasks text-primary me-1"></i> Estado
                    </label>
                    <select name="estado" class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none select-custom">
                        <option value="">Todos los estados</option>
                        <?php foreach ($estados as $est): ?>
                            <option value="<?php echo $est['id_estado']; ?>" <?php echo (isset($_GET['estado']) && $_GET['estado'] == $est['id_estado']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($est['nombre'] ?? $est['descripcion']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-3 py-2 flex-grow-1 fw-bold btn-filter shadow-sm">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                    <a href="/FresnoReporta/public/index.php?url=admin" class="btn btn-light rounded-circle border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;" title="Reiniciar Filtros">
                        <i class="fas fa-undo text-secondary"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Reportes -->
        <?php if (empty($reportes)): ?>
            <div class="table-card text-center py-5 px-3">
                <div class="empty-illustration"><i class="fas fa-clipboard-list"></i></div>
                <h5 class="fw-bold text-dark">No se encontraron reportes</h5>
                <p class="text-muted small">No hay registros que coincidan con los filtros seleccionados.</p>
            </div>
        <?php else: ?>
            <div class="table-card reveal reveal-delay-1">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th># Radicado</th>
                                <th>Ciudadano</th>
                                <th>Categoría</th>
                                <th>Evidencia</th>
                                <th>Título</th>
                                <th>Fecha</th>
                                <th>Cambiar Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $categoriasMap = array_column($categorias, 'nombre', 'id_categoria'); ?>
                            <?php foreach ($reportes as $reporte): ?>
                                <?php $nombreCategoria = $categoriasMap[$reporte['id_categoria'] ?? 0] ?? 'General'; ?>
                                <tr>
                                    <td class="fw-bold text-primary">#<?php echo htmlspecialchars($reporte['id_reporte']); ?></td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?php echo htmlspecialchars($reporte['nombre_usuario'] ?? 'Ciudadano'); ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="cat-icon cat-icon-sm"><i class="fas <?php echo categoriaIcon($nombreCategoria); ?>"></i></span>
                                            <span class="small text-secondary"><?php echo htmlspecialchars($nombreCategoria); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($reporte['foto'])): ?>
                                            <img src="<?php echo htmlspecialchars(resolverRutaEvidencia($reporte['foto'])); ?>" class="thumbnail-img" alt="Evidencia">
                                        <?php else: ?>
                                            <div class="thumbnail-img bg-light d-flex align-items-center justify-content-center text-muted small rounded-3">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($reporte['titulo']); ?></div>
                                        <small class="text-muted"><?php echo htmlspecialchars(substr($reporte['descripcion'] ?? '', 0, 40)) . '...'; ?></small>
                                    </td>
                                    <td><span class="text-secondary small"><?php echo htmlspecialchars($reporte['fecha_creacion'] ?? 'Reciente'); ?></span></td>
                                    <td>
                                        <form action="/FresnoReporta/public/index.php?url=actualizar-estado" method="POST" class="d-inline">
                                            <input type="hidden" name="id_reporte" value="<?php echo $reporte['id_reporte']; ?>">
                                            <input type="hidden" name="redirect" value="/FresnoReporta/public/index.php?url=admin">
                                            <select name="id_estado" class="form-select form-select-sm rounded-pill fw-semibold shadow-none border-0 bg-light py-2 px-3" onchange="this.form.submit()">
                                                <?php foreach ($estados as $est): ?>
                                                    <option value="<?php echo $est['id_estado']; ?>" <?php echo ($reporte['id_estado'] == $est['id_estado']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($est['nombre']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <a href="/FresnoReporta/public/index.php?url=detalle&id=<?php echo $reporte['id_reporte']; ?>" class="btn btn-primary btn-sm rounded-pill px-3 py-1 fw-semibold text-decoration-none">
                                            <i class="fas fa-eye me-1"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FresnoReporta/public/assets/js/tilt3d.js"></script>
</body>
</html>