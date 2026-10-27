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
    <title>Mis Reportes - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #4F6BD8;
            --primary-hover: #3B54B4;
            --dark-navy: #1E2A44;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .navbar-custom {
            background: rgba(30, 42, 68, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1030;
        }

        .brand-badge {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #4F6BD8, #3B54B4);
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(79, 107, 216, 0.3);
        }

        .main-container {
            flex: 1;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            width: 100%;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .filter-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05) !important;
            border-radius: 20px;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 3px rgba(79, 107, 216, 0.15) !important;
            border-color: #4F6BD8 !important;
        }

        .select-custom, .input-group-custom input {
            transition: all 0.25s ease;
            font-size: 0.92rem;
            color: #334155;
        }

        .btn-filter {
            background: linear-gradient(135deg, #4F6BD8, #3B54B4);
            border: none;
            transition: all 0.25s ease;
            font-size: 0.92rem;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 107, 216, 0.35);
            background: linear-gradient(135deg, #3B54B4, #2F4494);
        }

        .table-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .custom-table th {
            background-color: #1E2A44;
            color: white;
            font-weight: 600;
            padding: 16px;
            font-size: 0.9rem;
            border: none;
        }

        .custom-table td {
            padding: 16px;
            vertical-align: middle;
            font-size: 0.92rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .custom-table tbody tr {
            transition: all 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 50rem;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-pendiente { background-color: #fef2f2; color: #E07A7A; border: 1px solid #fecaca; }
        .badge-proceso { background-color: #fffbeb; color: #E0A860; border: 1px solid #fde68a; }
        .badge-solucionado { background-color: #ecfdf5; color: #6FCE9E; border: 1px solid #a7f3d0; }

        .btn-action {
            background: linear-gradient(135deg, #4F6BD8, #3B54B4);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(79, 107, 216, 0.2);
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(79, 107, 216, 0.35);
            color: white;
        }

        .thumbnail-img {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none" href="/FresnoReporta/public/index.php?url=mis-reportes">
                <div class="brand-badge me-2"><i class="fas fa-shield-alt"></i></div>
                <span class="text-white">Fresno <span class="text-primary">Reporta</span></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="/FresnoReporta/public/index.php?url=mapa" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-map-marked-alt me-1"></i> Mapa
                </a>
                <a href="/FresnoReporta/public/index.php?url=crear" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                    <i class="fas fa-plus me-1"></i> Nuevo Reporte
                </a>
                <a href="/FresnoReporta/public/index.php?url=logout" class="btn btn-danger btn-sm rounded-pill px-3" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="main-container">
        
        <div class="page-hero-photo photo-arcoiris reveal mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold text-white m-0"><i class="fas fa-clipboard-list me-2"></i>Mis Reportes</h2>
                <p class="mb-0 small" style="color: rgba(255,255,255,0.78);">Historial de incidencias registradas en el municipio de Fresno, Tolima.</p>
            </div>
            <a href="/FresnoReporta/public/index.php?url=crear" class="btn btn-primary rounded-pill px-4 py-2 fw-bold btn-filter btn-3d shadow-sm">
                <i class="fas fa-plus me-2"></i> Nuevo Reporte
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Barra de Filtros Moderna con Persistencia -->
        <div class="card border-0 shadow-sm p-4 mb-4 filter-container tilt-card reveal">
            <form action="" method="GET" class="row g-3 align-items-end">
                <input type="hidden" name="url" value="mis-reportes">
                
                <!-- Búsqueda Rápida -->
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

                <!-- Categoría / Tipo de Daño Dinámica -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">
                        <i class="fas fa-tags text-primary me-1"></i> Categoría de Daño
                    </label>
                    <select name="categoria" class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none select-custom">
                        <option value="">Todas las categorías</option>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id_categoria']; ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="1" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == '1') ? 'selected' : ''; ?>>Huecos en la vía</option>
                            <option value="2" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == '2') ? 'selected' : ''; ?>>Alumbrado público</option>
                            <option value="3" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == '3') ? 'selected' : ''; ?>>Basuras y Limpieza</option>
                            <option value="4" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == '4') ? 'selected' : ''; ?>>Acueducto y Alcantarillado</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Estado del Reporte Dinámico -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">
                        <i class="fas fa-tasks text-primary me-1"></i> Estado
                    </label>
                    <select name="estado" class="form-select bg-light border-0 rounded-pill py-2 px-3 shadow-none select-custom">
                        <option value="">Todos los estados</option>
                        <?php if (!empty($estados)): ?>
                            <?php foreach ($estados as $est): ?>
                                <option value="<?php echo $est['id_estado']; ?>" <?php echo (isset($_GET['estado']) && $_GET['estado'] == $est['id_estado']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($est['nombre'] ?? $est['descripcion']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="1" <?php echo (isset($_GET['estado']) && $_GET['estado'] == '1') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="4" <?php echo (isset($_GET['estado']) && $_GET['estado'] == '4') ? 'selected' : ''; ?>>En Proceso</option>
                            <option value="5" <?php echo (isset($_GET['estado']) && $_GET['estado'] == '5') ? 'selected' : ''; ?>>Solucionado</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Botones de Acción -->
                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-3 py-2 flex-grow-1 fw-bold btn-filter shadow-sm">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                    <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-light rounded-circle border-0 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;" title="Reiniciar Filtros">
                        <i class="fas fa-undo text-secondary"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Listado de Reportes -->
        <?php if (empty($reportes)): ?>
            <div class="table-card text-center py-5 px-3">
                <div class="empty-illustration"><i class="fas fa-clipboard-list"></i></div>
                <h5 class="fw-bold text-dark">No se encontraron reportes</h5>
                <p class="text-muted small mb-4">No tienes incidencias registradas con los filtros actuales o aún no has creado ninguna.</p>
                <a href="/FresnoReporta/public/index.php?url=crear" class="btn btn-primary rounded-pill px-4 fw-bold btn-filter">
                    <i class="fas fa-plus me-2"></i> Crear mi primer reporte
                </a>
            </div>
        <?php else: ?>
            <div class="table-card reveal reveal-delay-1">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th># Radicado</th>
                                <th>Categoría</th>
                                <th>Evidencia</th>
                                <th>Título y Descripción</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $categoriasMap = array_column($categorias, 'nombre', 'id_categoria'); ?>
                            <?php foreach ($reportes as $reporte): ?>
                                <?php
                                    $id_rep = $reporte['id_reporte'] ?? $reporte['id'] ?? '';
                                    $titulo = $reporte['titulo'] ?? $reporte['descripcion'] ?? 'Sin título';
                                    $desc = $reporte['descripcion'] ?? '';
                                    $fecha = $reporte['fecha_creacion'] ?? $reporte['created_at'] ?? 'Reciente';
                                    $foto = $reporte['foto'] ?? '';
                                    $id_estado = $reporte['id_estado'] ?? 1;
                                    $nombreCategoria = $categoriasMap[$reporte['id_categoria'] ?? 0] ?? 'General';

                                    $est = estadoInfo($id_estado, $estados);
                                    $status_text = $est['nombre'];
                                    $colorIconos = [
                                        'warning' => 'fa-exclamation-triangle', 'info' => 'fa-search',
                                        'primary' => 'fa-user-check', 'secondary' => 'fa-spinner fa-spin',
                                        'success' => 'fa-check-circle', 'dark' => 'fa-box-archive', 'danger' => 'fa-ban'
                                    ];
                                    $status_icon = $colorIconos[$est['color']] ?? 'fa-circle';
                                    $badge_style = 'background-color: var(--bs-' . $est['color'] . '-bg-subtle, #f1f5f9); color: var(--bs-' . $est['color'] . '-text-emphasis, #334155);';
                                ?>
                                <tr>
                                    <td class="fw-bold text-primary">#<?php echo htmlspecialchars($id_rep); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="cat-icon cat-icon-sm"><i class="fas <?php echo categoriaIcon($nombreCategoria); ?>"></i></span>
                                            <span class="small text-secondary"><?php echo htmlspecialchars($nombreCategoria); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($foto)): ?>
                                            <img src="<?php echo htmlspecialchars(resolverRutaEvidencia($foto)); ?>" class="thumbnail-img" alt="Evidencia">
                                        <?php else: ?>
                                            <div class="thumbnail-img bg-light d-flex align-items-center justify-content-center text-muted small rounded-3">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($titulo); ?></div>
                                        <small class="text-muted"><?php echo htmlspecialchars(substr($desc, 0, 50)) . (strlen($desc) > 50 ? '...' : ''); ?></small>
                                    </td>
                                    <td><span class="text-secondary small"><?php echo htmlspecialchars($fecha); ?></span></td>
                                    <td>
                                        <span class="badge-status" style="<?php echo $badge_style; ?>">
                                            <i class="fas <?php echo $status_icon; ?>"></i> <?php echo htmlspecialchars($status_text); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="/FresnoReporta/public/index.php?url=detalle&id=<?php echo $id_rep; ?>" class="btn-action">
                                            <i class="fas fa-eye me-1"></i> Ver Detalle
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