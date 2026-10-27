<?php
session_start();

// Evita que el navegador sirva páginas privadas (admin, mis-reportes, etc.)
// desde su caché al usar "Atrás"/"Adelante" después de cambiar de sesión o rol.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/helpers.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/ReporteController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$url = $_GET['url'] ?? 'home';
$homeController = new HomeController();
$reporteController = new ReporteController();
$authController = new AuthController();

switch ($url) {
    case '':
    case 'inicio':
    case 'home':
        $homeController->index();
        break;
    case 'login':
        $authController->login();
        break;
    case 'procesar-login':
        $authController->procesarLogin();
        break;
    case 'register':
        $authController->registro();
        break;
    case 'procesar-registro':
        $authController->procesarRegistro();
        break;
    case 'logout':
        $authController->logout();
        break;

    case 'crear':
        $reporteController->crear();
        break;
    case 'guardar-reporte':
        $reporteController->guardar();
        break;
    case 'mis-reportes':
        $reporteController->misReportes();
        break;
    case 'detalle':
        $reporteController->detalle();
        break;
    case 'mapa':
        $reporteController->mapa();
        break;

    case 'admin':
    case 'admin-reportes':
        $reporteController->admin();
        break;
    case 'dashboard-estadisticas':
        $reporteController->dashboardEstadisticas();
        break;
    case 'actualizar-estado':
        $reporteController->actualizarEstado();
        break;

    default:
        echo '<div style="font-family: sans-serif; text-align: center; margin-top: 80px; color: #334155;">';
        echo '<h1 style="font-size: 72px; margin-bottom: 10px; color: #3B54B4;">404</h1>';
        echo '<h2 style="margin-bottom: 20px;">Página no encontrada</h2>';
        echo '<p style="color: #64748b; margin-bottom: 30px;">La ruta <strong>?url=' . htmlspecialchars($url) . '</strong> no existe en Fresno Reporta.</p>';
        echo '<a href="/FresnoReporta/public/index.php?url=mis-reportes" style="background: #3B54B4; color: white; padding: 10px 24px; border-radius: 50rem; text-decoration: none; font-weight: 600;">Volver al inicio</a>';
        echo '</div>';
        break;
}