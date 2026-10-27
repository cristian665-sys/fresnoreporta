<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Fresno Reporta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/FresnoReporta/public/assets/css/auth.css?v=4">
</head>
<body class="auth-page" data-photo="atardecer">
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
            <h1>Únete y ayuda a <span>mejorar tu municipio</span></h1>
            <p>Crea tu cuenta para reportar daños en vías, alumbrado, acueducto y más, y sigue el estado de cada caso.</p>

            <div class="auth-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-user-check"></i></div>
                    <div><strong>Registro rápido</strong><small>Solo necesitas tu nombre, correo y contraseña</small></div>
                </div>
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-eye"></i></div>
                    <div><strong>Transparencia total</strong><small>Consulta el historial de tus reportes cuando quieras</small></div>
                </div>
            </div>
        </div>

        <div class="auth-card">
            <div class="auth-card-header">
                <h2>Crear cuenta</h2>
                <p>Regístrate en Fresno Reporta en menos de un minuto.</p>
            </div>

            <?php if (isset($_SESSION['error_registro'])): ?>
                <div class="auth-alert">
                    <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($_SESSION['error_registro'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error_registro']); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/FresnoReporta/public/index.php?url=procesar-registro" method="POST" autocomplete="off">
                <div class="auth-field">
                    <label for="nombre">Nombre</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="apellido">Apellido</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" id="apellido" name="apellido" required placeholder="Tu apellido">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="cedula">Cédula</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-id-card"></i>
                        <input type="text" id="cedula" name="cedula" required placeholder="Número de documento">
                    </div>
                </div>
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
                    <i class="fas fa-user-check"></i> Registrarse
                </button>

                <div class="auth-switch">
                    ¿Ya tienes cuenta? <a class="auth-link" href="/FresnoReporta/public/index.php?url=login">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
