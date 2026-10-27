# FresnoReporta 🇨🇴 📊

### Sistema de Información Web para la Gestión de Incidencias Ciudadanas

**FresnoReporta** es una plataforma web centralizada diseñada para modernizar, optimizar y transparentar la comunicación entre los habitantes del municipio de Fresno, Tolima, y las entidades administradoras. Permite a los ciudadanos reportar problemas comunitarios en tiempo real y ofrece a las autoridades un panel de control avanzado para el seguimiento operativo.

---

## 🚀 Problema que Resuelve
Los canales tradicionales de radicación de peticiones (PQRS) suelen ser lentos, manuales y propensos a la pérdida de información. **FresnoReporta elimina este desabastecimiento operativo** al automatizar el flujo de trabajo y proporcionar trazabilidad en tiempo real. 

Al cambiar el papel por estados digitales dinámicos (**Pendiente, En Proceso, Resuelto**), se garantiza transparencia institucional y respuestas significativamente más rápidas para la comunidad.

---

## 🛠️ Tecnologías y Herramientas Utilizadas

El sistema fue desarrollado bajo estándares de código limpio y una arquitectura robusta:

*   **Backend:** PHP 8.2 utilizando el patrón de diseño arquitectónico **MVC (Modelo-Vista-Controlador)** para una separación limpia de responsabilidades.
*   **Seguridad y Conexión:** Acceso a datos mediante **PDO (PHP Data Objects)** con consultas preparadas para mitigar ataques de inyección SQL.
*   **Frontend:** HTML5, CSS3 y **Bootstrap** para un diseño moderno, intuitivo y 100% responsivo (adaptable a celulares y computadores).
*   **Base de Datos:** MySQL (gestionado a través de phpMyAdmin) con un modelo relacional para el control de usuarios, roles, barrios, veredas y reportes.
*   **Entorno Local:** XAMPP (Servidor Apache).

---

## 📂 Estructura Principal del Proyecto

El proyecto sigue una arquitectura limpia y escalable:

*   `config/database.php`: Componente de conexión centralizado optimizado para entornos locales.
*   `public/index.php`: Enrutador principal del sistema (Front Controller) que gestiona las URLs amigables.
*   `controllers/ReporteController.php`: Lógica de negocio encargada de procesar las peticiones y orquestar el flujo entre las vistas y la base de datos.

---

## 💻 Módulos y Vistas Clave

1.  **Módulo de Acceso (`/login`):** Sistema de autenticación seguro para ciudadanos y administradores.
2.  **Radicación de Incidencias (`/crear`):** Formulario dinámico con selectores georreferenciados para barrios urbanos y veredas rurales de Fresno.
3.  **Seguimiento Ciudadano (`/mis-reportes`):** Historial personal del usuario para verificar en tiempo real el avance de sus solicitudes.
4.  **Panel Administrativo (`/admin`):** Consola de control para que los administradores actualicen estados de forma masiva y gestionen las métricas del municipio.

---

## 🔧 Instalación y Despliegue Local

1. Clonar el repositorio en la carpeta `htdocs` de tu servidor local XAMPP.
2. Importar el archivo `.sql` provisto en este repositorio dentro de tu phpMyAdmin.
3. Configurar las credenciales en `config/database.php` apuntando al host `127.0.0.1`.
4. Abrir el navegador e ingresar a `http://localhost/fresnoreporta/public/`.

---
*Desarrollado con orgullo como Proyecto Técnico en Programación de Software - SENA / Articulación con la Educación Media.*
