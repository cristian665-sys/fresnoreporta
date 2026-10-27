<?php

require_once __DIR__ . '/../config/database.php';

class HomeController
{
    /**
     * Muestra la página principal (Landing Page) de Fresno Reporta.
     */
    public function index()
    {
        // La sesión ya está iniciada globalmente en index.php, 
        // pero se puede asegurar de forma segura si es necesario:
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Definir la vista interna que se incrustará en el layout principal
        $contenidoVista = __DIR__ . '/../views/home/index.php';

        // Cargar el diseño general (Layout)
        if (file_exists(__DIR__ . '/../views/layouts/main.php')) {
            require_once __DIR__ . '/../views/layouts/main.php';
        } else {
            // Fallback en caso de que no exista el layout principal
            if (file_exists($contenidoVista)) {
                require_once $contenidoVista;
            } else {
                echo "<h1>Bienvenido a Fresno Reporta</h1>";
            }
        }
    }
}