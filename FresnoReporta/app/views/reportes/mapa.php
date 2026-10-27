<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /FresnoReporta/public/index.php?url=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Interactivo - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        html, body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; height: 100%; margin: 0; overflow: hidden; }
        .page-wrapper { display: flex; flex-direction: column; height: 100vh; }
        .navbar-custom { background: rgba(30, 42, 68, 0.92); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); z-index: 1030; flex-shrink: 0; }
        .brand-badge { width: 38px; height: 38px; background: linear-gradient(135deg, #4F6BD8, #3B54B4); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .map-container { position: relative; flex-grow: 1; width: 100%; height: calc(100vh - 65px); }
        #map { width: 100%; height: 100%; z-index: 1; }
        .filter-card { position: absolute; top: 20px; right: 20px; z-index: 1000; width: 330px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(16px); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.6); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.18); padding: 20px; }
        .marker-pin-custom { width: 34px; height: 34px; border-radius: 50% 50% 50% 0; position: absolute; transform: rotate(-45deg); left: 50%; top: 50%; margin: -17px 0 0 -17px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 16px rgba(0,0,0,0.35); }
        .marker-pin-custom i { transform: rotate(45deg); color: white; font-size: 14px; }
        .bg-warning-pin { background: linear-gradient(135deg, #F7CB8F, #E0A860); }
        .bg-info-pin { background: linear-gradient(135deg, #8FE1D7, #8FE1D7); }
        .bg-primary-pin { background: linear-gradient(135deg, #4F6BD8, #3B54B4); }
        .bg-secondary-pin { background: linear-gradient(135deg, #64748b, #475569); }
        .bg-success-pin { background: linear-gradient(135deg, #9EE6C0, #6FCE9E); }
        .bg-dark-pin { background: linear-gradient(135deg, #1e293b, #1E2A44); }
        .bg-danger-pin { background: linear-gradient(135deg, #F4A3A3, #E07A7A); }
        .popup-img { width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 8px; }
        .btn-custom-sm { background: linear-gradient(135deg, #4F6BD8, #3B54B4); border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.85rem; color: white; font-weight: 600; text-decoration: none; display: block; text-align: center; }
        @media (max-width: 768px) { .filter-card { top: 10px; left: 10px; right: 10px; width: auto; } }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none" href="/FresnoReporta/public/index.php?url=admin">
                    <div class="brand-badge me-2"><i class="fas fa-shield-alt"></i></div>
                    <span class="text-white">Fresno <span class="text-primary">Reporta</span></span>
                </a>
                <div class="d-flex align-items-center gap-2">
                    <?php if (($_SESSION['id_rol'] ?? null) == 1): ?>
                        <a href="/FresnoReporta/public/index.php?url=dashboard-estadisticas" class="btn btn-outline-light btn-sm rounded-pill px-3">Dashboard</a>
                        <a href="/FresnoReporta/public/index.php?url=admin" class="btn btn-outline-light btn-sm rounded-pill px-3">Panel Admin</a>
                    <?php endif; ?>
                    <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-outline-light btn-sm rounded-pill px-3">Mis Reportes</a>
                    <a href="/FresnoReporta/public/index.php?url=logout" class="btn btn-danger btn-sm rounded-pill px-3"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </nav>

        <div class="map-container">
            <div class="filter-card reveal">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0 text-dark"><i class="fas fa-filter text-primary me-2"></i>Filtrar Daños</h6>
                    <span class="badge bg-primary rounded-pill px-3 py-2" id="totalCount">0 Reportes</span>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-semibold">Tipo de Daño / Categoría</label>
                    <select id="filterCategoria" class="form-select form-select-sm" onchange="aplicarFiltros()">
                        <option value="todos">Todas las categorías</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo $cat['id_categoria']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-semibold">Estado del Reporte</label>
                    <select id="filterEstado" class="form-select form-select-sm" onchange="aplicarFiltros()">
                        <option value="todos">Todos los estados</option>
                        <?php foreach ($estados as $est): ?>
                            <option value="<?php echo $est['id_estado']; ?>"><?php echo htmlspecialchars($est['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-light btn-sm w-100 text-secondary border fw-semibold rounded-pill py-2" onclick="limpiarFiltros()">Reiniciar Filtros</button>
            </div>
            <div id="map"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/FresnoReporta/public/assets/js/tilt3d.js"></script>
    <script>
        const reportesData = <?php echo json_encode($reportes ?? []); ?>;
        const estadosInfo = <?php echo json_encode(array_map(function ($e) {
            return ['id' => (int)$e['id_estado'], 'nombre' => $e['nombre'], 'color' => $e['color'] ?? 'secondary'];
        }, $estados)); ?>;
        const categoriaIconos = {
            <?php foreach ($categorias as $cat): ?>
            <?php echo (int)$cat['id_categoria']; ?>: '<?php echo categoriaIcon($cat['nombre']); ?>',
            <?php endforeach; ?>
        };
        const iconosPorColor = {
            warning: 'fa-exclamation-triangle', info: 'fa-search', primary: 'fa-user-check',
            secondary: 'fa-spinner', success: 'fa-check', dark: 'fa-box-archive', danger: 'fa-ban'
        };

        function estadoDe(idEstado) {
            return estadosInfo.find(e => e.id === parseInt(idEstado)) || { nombre: 'Desconocido', color: 'secondary' };
        }

        const map = L.map('map', { zoomControl: false }).setView([5.1517, -75.0361], 14);
        L.control.zoom({ position: 'bottomright' }).addTo(map);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© Fresno Reporta' }).addTo(map);

        let markersGroup = L.layerGroup().addTo(map);

        function renderizarMarcadores(lista) {
            markersGroup.clearLayers();
            document.getElementById('totalCount').innerText = lista.length + ' Reportes';
            lista.forEach(r => {
                if (!r.latitud || !r.longitud) return;
                const estado = estadoDe(r.id_estado);
                const colorClass = 'bg-' + estado.color + '-pin';
                const iconClass = categoriaIconos[r.id_categoria] || (iconosPorColor[estado.color] || 'fa-circle');

                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div class="marker-pin-custom ${colorClass}"><i class="fas ${iconClass}"></i></div>`,
                    iconSize: [34, 42],
                    iconAnchor: [17, 42]
                });

                const popupContent = `
                    <div style="width: 220px;">
                        ${r.foto ? `<img src="${r.foto}" class="popup-img" alt="Evidencia">` : ''}
                        <span class="badge bg-${estado.color} mb-1">${estado.nombre}</span>
                        <h6 class="fw-bold mb-1">${r.titulo}</h6>
                        <p class="text-muted small mb-2">${r.descripcion ? r.descripcion.substring(0, 60) + '...' : 'Sin descripción'}</p>
                        <a href="/FresnoReporta/public/index.php?url=detalle&id=${r.id_reporte}" class="btn-custom-sm">Ver Detalle</a>
                    </div>
                `;
                L.marker([parseFloat(r.latitud), parseFloat(r.longitud)], { icon: customIcon }).bindPopup(popupContent).addTo(markersGroup);
            });
        }

        function aplicarFiltros() {
            const catVal = document.getElementById('filterCategoria').value;
            const estadoVal = document.getElementById('filterEstado').value;
            let filtrados = reportesData.filter(r => {
                let cumpleCategoria = (catVal === 'todos' || r.id_categoria == catVal || r.categoria == catVal);
                let cumpleEstado = (estadoVal === 'todos' || r.id_estado == estadoVal);
                return cumpleCategoria && cumpleEstado;
            });
            renderizarMarcadores(filtrados);
        }

        function limpiarFiltros() {
            document.getElementById('filterCategoria').value = 'todos';
            document.getElementById('filterEstado').value = 'todos';
            renderizarMarcadores(reportesData);
        }

        renderizarMarcadores(reportesData);
        setTimeout(() => { map.invalidateSize(); }, 300);
    </script>
</body>
</html>