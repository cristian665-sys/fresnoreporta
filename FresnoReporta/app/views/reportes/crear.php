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
    <title>Crear Reporte - Fresno Reporta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS para el mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/app.css?v=4">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #334155; min-height: 100vh; display: flex; flex-direction: column; margin: 0; }
        .navbar-custom { background: rgba(30, 42, 68, 0.92); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .brand-badge { width: 38px; height: 38px; background: linear-gradient(135deg, #4F6BD8, #3B54B4); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .main-container { flex: 1; max-width: 860px; margin: 32px auto 48px; padding: 0 20px; width: 100%; }

        .report-hero {
            margin-bottom: -40px;
            z-index: 1;
        }
        .report-hero h3 { font-weight: 800; letter-spacing: -0.5px; margin: 0 0 6px; }
        .report-hero p { color: rgba(255,255,255,0.75); margin: 0; font-size: 0.92rem; }
        .report-hero .hero-icon {
            width: 54px; height: 54px; border-radius: 16px;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 14px;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.18);
        }

        .form-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 25px 60px -15px rgba(30, 42, 68, 0.15);
            padding: 45px 35px 35px;
            position: relative;
            z-index: 0;
        }

        .section-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.06em; color: #94a3b8; margin: 26px 0 12px;
        }
        .section-label:first-child { margin-top: 0; }
        .section-label i { color: #4F6BD8; }

        .form-label { font-size: 0.85rem; font-weight: 600; color: #475569; }
        .form-control, .form-select {
            border-radius: 12px; border: 1.5px solid #cbd5e1; padding: 12px 16px;
            background-color: #f8fafc; font-size: 0.95rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4F6BD8; background-color: #fff;
            box-shadow: 0 0 0 4px rgba(79, 107, 216, 0.12);
        }

        #map {
            height: 340px;
            border-radius: 16px;
            border: 1.5px solid #cbd5e1;
            margin-top: 10px;
            box-shadow: inset 0 2px 8px rgba(30, 42, 68, 0.06);
        }
        #geoStatus { min-height: 18px; }

        .btn-custom {
            background: linear-gradient(135deg, #4F6BD8, #3B54B4);
            border: none; border-radius: 14px; padding: 15px;
            font-weight: 700; color: white; width: 100%;
            box-shadow: 0 10px 24px rgba(79, 107, 216, 0.3);
        }
        .btn-custom:hover { box-shadow: 0 16px 32px rgba(79, 107, 216, 0.4); color: #fff; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-4 py-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center text-decoration-none" href="/FresnoReporta/public/index.php?url=mis-reportes">
                <div class="brand-badge me-2"><i class="fas fa-shield-alt"></i></div>
                <span class="text-white">Fresno <span class="text-primary">Reporta</span></span>
            </a>
            <div>
                <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="btn btn-outline-light btn-sm rounded-pill px-3 btn-3d">Volver</a>
            </div>
        </div>
    </nav>

    <div class="main-container">

        <div class="report-hero page-hero-photo photo-atardecer reveal">
            <div class="hero-icon"><i class="fas fa-map-pin"></i></div>
            <h3>Reportar Nuevo Daño</h3>
            <p>Cuéntanos qué pasó y marca la ubicación exacta en el mapa o usa tu GPS. Tu reporte queda radicado al instante.</p>
        </div>

        <div class="form-card reveal reveal-delay-1">

            <?php if (isset($_SESSION['toast_error'])): ?>
                <div class="alert alert-danger rounded-4 py-2 px-3 small mb-4">
                    <i class="fas fa-exclamation-triangle me-1"></i> <?php echo $_SESSION['toast_error']; unset($_SESSION['toast_error']); ?>
                </div>
            <?php endif; ?>

            <form action="/FresnoReporta/public/index.php?url=guardar-reporte" method="POST" enctype="multipart/form-data" autocomplete="off">

                <div class="section-label"><i class="fas fa-pen"></i> Datos del reporte</div>

                <div class="mb-3">
                    <label class="form-label">Título del Reporte</label>
                    <input type="text" name="titulo" class="form-control" required placeholder="Ej: Hueco grande en la vía principal">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría</label>
                        <div class="d-flex align-items-center gap-2">
                            <span class="cat-icon" id="catIconPreview"><i class="fas fa-triangle-exclamation"></i></span>
                            <select name="id_categoria" id="id_categoria" class="form-select" required>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['id_categoria']; ?>" data-icon="<?php echo categoriaIcon($cat['nombre']); ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Evidencia Fotográfica</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="mb-1">
                    <label class="form-label">Descripción Detallada</label>
                    <textarea name="descripcion" class="form-control" rows="3" required placeholder="Describe brevemente el daño o problema..."></textarea>
                </div>

                <div class="section-label"><i class="fas fa-map-location-dot"></i> Zona y ubicación</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de Zona</label>
                        <select name="tipo_zona" id="tipo_zona" class="form-select" required>
                            <option value="Urbana" selected>Urbana</option>
                            <option value="Rural">Rural</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3" id="grupoBarrio">
                        <label class="form-label">Barrio</label>
                        <select name="id_barrio" class="form-select">
                            <option value="">Selecciona un barrio (opcional)</option>
                            <?php foreach ($barrios as $b): ?>
                                <option value="<?php echo $b['id_barrio']; ?>"><?php echo htmlspecialchars($b['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3 d-none" id="grupoVereda">
                        <label class="form-label">Vereda</label>
                        <select name="id_vereda" class="form-select">
                            <option value="">Selecciona una vereda (opcional)</option>
                            <?php foreach ($veredas as $v): ?>
                                <option value="<?php echo $v['id_vereda']; ?>"><?php echo htmlspecialchars($v['nombre']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección o Referencia (opcional)</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Ej: Frente al parque principal, Calle 9">
                </div>

                <!-- Selector de Ubicación con Mapa -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <label class="form-label m-0">Ubicación del daño</label>
                        <button type="button" id="btnGeo" class="btn-geo btn-3d">
                            <i class="fas fa-location-crosshairs"></i> Usar mi ubicación actual
                        </button>
                    </div>
                    <div id="map" class="map-no-tilt"></div>
                    <small id="geoStatus" class="d-block mt-2"></small>
                    <!-- Campos ocultos que se llenan automáticamente al hacer clic en el mapa o por GPS -->
                    <input type="hidden" name="latitud" id="latitud">
                    <input type="hidden" name="longitud" id="longitud">
                </div>

                <button type="submit" class="btn btn-custom btn-3d">
                    <i class="fas fa-paper-plane me-2"></i> Enviar Reporte Ciudadano
                </button>
            </form>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Vista previa del ícono según la categoría seleccionada
        const catSelect = document.getElementById('id_categoria');
        const catIconPreview = document.getElementById('catIconPreview');
        function actualizarIconoCategoria() {
            const opt = catSelect.options[catSelect.selectedIndex];
            const icono = (opt && opt.dataset.icon) ? opt.dataset.icon : 'fa-triangle-exclamation';
            catIconPreview.innerHTML = '<i class="fas ' + icono + '"></i>';
        }
        catSelect.addEventListener('change', actualizarIconoCategoria);
        actualizarIconoCategoria();

        // Alternar entre Barrio (Urbana) y Vereda (Rural) según la zona seleccionada
        const tipoZonaSelect = document.getElementById('tipo_zona');
        const grupoBarrio = document.getElementById('grupoBarrio');
        const grupoVereda = document.getElementById('grupoVereda');

        function actualizarZona() {
            if (tipoZonaSelect.value === 'Rural') {
                grupoBarrio.classList.add('d-none');
                grupoVereda.classList.remove('d-none');
            } else {
                grupoVereda.classList.add('d-none');
                grupoBarrio.classList.remove('d-none');
            }
            // El cambio de campos altera la altura del formulario: recalculamos
            // el tamaño del mapa para que los clics sigan siendo exactos.
            setTimeout(function () { map.invalidateSize(); }, 50);
        }
        tipoZonaSelect.addEventListener('change', actualizarZona);
        actualizarZona();

        // Coordenadas aproximadas de Fresno, Tolima
        const fresnoLat = 5.158;
        const fresnoLng = -75.035;

        // Inicializar el mapa
        const map = L.map('map').setView([fresnoLat, fresnoLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // El tamaño real del contenedor puede cambiar una vez cargan las
        // fuentes/el layout (afecta la precisión del clic), así que
        // recalculamos el tamaño del mapa en varios momentos clave.
        setTimeout(function () { map.invalidateSize(); }, 300);
        window.addEventListener('load', function () { map.invalidateSize(); });
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function () { map.invalidateSize(); });
        }

        let marker = null;

        function ubicarMarcador(lat, lng) {
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        }

        // Evento al hacer clic en el mapa para ubicar el marcador y capturar coordenadas
        map.on('click', function (e) {
            ubicarMarcador(e.latlng.lat, e.latlng.lng);
        });

        // Botón "Usar mi ubicación actual" (GPS del navegador)
        const btnGeo = document.getElementById('btnGeo');
        const geoStatus = document.getElementById('geoStatus');

        function resetBtnGeo() {
            btnGeo.disabled = false;
            btnGeo.innerHTML = '<i class="fas fa-location-crosshairs"></i> Usar mi ubicación actual';
        }

        function mensajeErrorGeo(err) {
            switch (err.code) {
                case err.PERMISSION_DENIED:
                    return 'Bloqueaste el permiso de ubicación. Habilítalo en el candado de la barra de direcciones y vuelve a intentar.';
                case err.POSITION_UNAVAILABLE:
                    return 'No se pudo determinar tu posición. Verifica que el GPS/ubicación del dispositivo esté activado.';
                case err.TIMEOUT:
                    return 'Se agotó el tiempo esperando tu ubicación. Intenta de nuevo en un lugar con mejor señal.';
                default:
                    return 'No se pudo obtener tu ubicación (' + err.message + ').';
            }
        }

        btnGeo.addEventListener('click', function () {
            geoStatus.classList.remove('text-danger');
            geoStatus.textContent = '';

            if (!navigator.geolocation) {
                geoStatus.textContent = 'Tu navegador no soporta geolocalización.';
                geoStatus.classList.add('text-danger');
                return;
            }

            // La API de ubicación solo funciona en "contextos seguros":
            // https, o http sobre localhost/127.0.0.1. Si se accede por una
            // IP de red (ej. http://192.168.x.x/...), el navegador la bloquea
            // sin pedir permiso, y por eso "no agarra" la ubicación.
            if (window.isSecureContext === false) {
                geoStatus.innerHTML = 'Tu navegador bloquea el GPS en esta dirección por no ser segura (HTTPS). ' +
                    'Abre la página como <strong>http://localhost/FresnoReporta/...</strong> o usa el clic en el mapa.';
                geoStatus.classList.add('text-danger');
                return;
            }

            btnGeo.disabled = true;
            btnGeo.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Obteniendo ubicación...';

            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                ubicarMarcador(lat, lng);
                map.setView([lat, lng], 17);
                setTimeout(function () { map.invalidateSize(); }, 50);
                geoStatus.textContent = 'Ubicación capturada con una precisión de ' + Math.round(pos.coords.accuracy) + ' m (' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ').';
                resetBtnGeo();
            }, function (err) {
                geoStatus.textContent = mensajeErrorGeo(err);
                geoStatus.classList.add('text-danger');
                resetBtnGeo();
            }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
        });
    </script>
    <script src="/FresnoReporta/public/assets/js/tilt3d.js"></script>
</body>
</html>
