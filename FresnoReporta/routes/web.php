<?php
// app/config/web.php

require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/ReporteController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$url = $_GET['url'] ?? '';

switch ($url) {

    case 'reportar':
    case 'crear':
    case 'crear-reporte':
        $controller = new ReporteController();
        $controller->crear();
        break;

    case 'mis-reportes':
    case 'mis_reportes':
        $controller = new ReporteController();
        $controller->misReportes();
        break;

    case 'detalle-reporte':
    case 'detalle':
        $controller = new ReporteController();
        $controller->detalle();
        break;

    case 'admin':
    case 'admin-reportes':
    case 'panel-funcionario':
        $controller = new ReporteController();
        $controller->panelFuncionario();
        break;

    case 'mapa':
    case 'ver-mapa':
        $controller = new ReporteController();
        $controller->verMapa();
        break;

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '':
    case 'inicio':
        $controller = new HomeController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        echo '<div style="font-family: Arial, sans-serif; text-align: center; margin-top: 50px;">';
        echo '<h1 style="color: #d9534f;">404 - Página no encontrada</h1>';
        echo '<p>La ruta solicitada (<strong>' . htmlspecialchars($url) . '</strong>) no existe en Fresno Reporta.</p>';
        echo '<a href="/FresnoReporta/public/index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #2e7d32; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Volver al inicio</a>';
        echo '</div>';
        break;
}