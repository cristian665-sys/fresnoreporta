<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Fresno Reporta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/auth.css?v=4">
</head>
<body class="auth-page" data-photo="arcoiris">
    <div class="auth-photo"></div>
    <div class="auth-background"></div>
    <div class="auth-orb auth-orb-one"></div>
    <div class="auth-orb auth-orb-two"></div>

    <div class="auth-layout">
        <div class="auth-intro">
            <div class="auth-brand">
                <div class="auth-brand-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <p class="auth-brand-name">Fresno <span>Reporta</span></p>
                    <p class="auth-brand-caption">Plataforma ciudadana de Fresno, Tolima</p>
                </div>
            </div>
            <h1>Reporta daños, <span>da seguimiento</span> en tiempo real</h1>
            <p>Huecos, alumbrado, acueducto y más: registra la incidencia, ubícala en el mapa y entérate cuándo se soluciona.</p>

            <div class="auth-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div><strong>Ubicación exacta</strong><small>Marca el punto en el mapa o usa tu GPS</small></div>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <div><strong>Estadísticas abiertas</strong><small>Sigue el estado de cada reporte en el municipio</small></div>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-bolt"></i></div>
                    <div><strong>Respuesta ágil</strong><small>Los funcionarios atienden y actualizan el estado</small></div>
                </div>
            </div>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Iniciar sesión</h2>
                <p>Ingresa tus credenciales para gestionar tus reportes.</p>
            </div>

            <?php if (isset($_SESSION['error_login'])): ?>
                <div class="auth-alert">
                    <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($_SESSION['error_login'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error_login']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['toast_success'])): ?>
                <div class="auth-alert auth-alert-success">
                    <i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($_SESSION['toast_success'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['toast_success']); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/FresnoReporta/public/index.php?url=procesar-login" method="POST" autocomplete="off">
                <div class="auth-field">
                    <label for="correo">Correo electrónico</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="password">Contraseña</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="auth-submit">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>

                <div class="auth-switch">
                    ¿No tienes cuenta? <a class="auth-link" href="/FresnoReporta/public/index.php?url=register">Regístrate aquí</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
