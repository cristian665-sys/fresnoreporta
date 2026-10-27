<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fresno Reporta - Sistema de Gestión de Reportes de Daños</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* BARRA SUPERIOR (HEADER) */
        .main-header {
            background-color: #1E2A44;
            color: #ffffff;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .brand-logo {
            font-size: 1.45rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .brand-logo span {
            color: #38bdf8;
        }
        .main-nav {
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
        }
        .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            color: #ffffff;
        }
        .nav-badge-admin {
            background: linear-gradient(135deg, #F7CB8F 0%, #E0A860 100%);
            color: #ffffff !important;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.88rem;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
            transition: transform 0.2s ease;
        }
        .nav-badge-admin:hover {
            transform: translateY(-1px);
        }
        .user-section {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .user-greeting {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        .user-name {
            color: #ffffff;
            font-weight: 700;
        }
        .btn-logout {
            background-color: #F4A3A3;
            color: #ffffff;
            padding: 7px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            transition: background-color 0.2s ease;
        }
        .btn-logout:hover {
            background-color: #E07A7A;
        }
        .btn-login {
            background-color: #4F6BD8;
            color: #ffffff;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .btn-login:hover {
            background-color: #3B54B4;
        }
        /* CONTENIDO PRINCIPAL */
        .content-wrapper {
            flex: 1;
        }
        /* PIE DE PÁGINA (FOOTER) */
        .main-footer {
            background-color: #1E2A44;
            color: #94a3b8;
            text-align: center;
            padding: 20px;
            font-size: 0.88rem;
            border-top: 1px solid #1e293b;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- Navegación Superior Profesional -->
    <header class="main-header">
        <a href="/FresnoReporta/public/index.php?url=home" class="brand-logo">
            <span>🏛️</span> Fresno Reporta
        </a>

        <nav class="main-nav">
            <a href="/FresnoReporta/public/index.php?url=home" class="nav-link">Inicio</a>
            <a href="/FresnoReporta/public/index.php?url=crear" class="nav-link">Reportar Daño</a>
            <a href="/FresnoReporta/public/index.php?url=mis-reportes" class="nav-link">Mis Reportes</a>
            
            <?php 
                // Capturamos cualquier posible variable de sesión donde se guarde el rol o ID de rol
                $rolTexto  = strtolower($_SESSION['rol'] ?? $_SESSION['tipo_usuario'] ?? $_SESSION['nombre_rol'] ?? '');
                $idRol     = $_SESSION['id_rol'] ?? $_SESSION['rol_id'] ?? 0;
                
                // Validación amplia y flexible para detectar administradores o funcionarios
                $esAdminOFuncionario = (
                    str_contains($rolTexto, 'admin') || 
                    str_contains($rolTexto, 'func') || 
                    $idRol == 1 || 
                    $idRol == 2
                );
            ?>

            <?php if ($esAdminOFuncionario): ?>
                <!-- Acceso exclusivo para el Panel Administrativo de Funcionarios -->
                <a href="/FresnoReporta/public/index.php?url=admin-reportes" class="nav-link nav-badge-admin">
                    🛠️ Panel Admin
                </a>
            <?php endif; ?>
        </nav>

        <div class="user-section">
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <span class="user-greeting">
                    Hola, <strong class="user-name"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?></strong>
                </span>
                <a href="/FresnoReporta/public/index.php?url=logout" class="btn-logout">Cerrar Sesión</a>
            <?php else: ?>
                <a href="/FresnoReporta/public/index.php?url=login" class="btn-login">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Renderizado dinámico del contenido de cada vista -->
    <main class="content-wrapper">
        <?php 
            if (isset($contenidoVista) && file_exists($contenidoVista)) {
                require_once $contenidoVista;
            }
        ?>
    </main>

    <!-- Pie de Página Unificado -->
    <footer class="main-footer">
        <p>© <?= date('Y') ?> <strong>Fresno Reporta</strong> — Sistema de Gestión y Control Ciudadano de Daños en Infraestructura.</p>
    </footer>

</body>
</html>