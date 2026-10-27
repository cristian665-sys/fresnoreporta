<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/helpers.php';

class ReporteController
{
    public function crear()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        try {
            $database = new Database();
            $conexion = $database->conectar();
            $categorias = $conexion->query("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
            $estados = $conexion->query("SELECT * FROM estados WHERE activo = 1 ORDER BY id_estado ASC")->fetchAll(PDO::FETCH_ASSOC);
            $barrios = $conexion->query("SELECT * FROM barrios WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
            $veredas = $conexion->query("SELECT * FROM veredas WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $categorias = [];
            $estados = [];
            $barrios = [];
            $veredas = [];
        }

        require_once __DIR__ . '/../views/reportes/crear.php';
    }

    public function guardar()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'];
            $titulo = !empty($_POST['titulo']) ? $_POST['titulo'] : 'Reporte Ciudadano';
            $descripcion = $_POST['descripcion'] ?? '';
            $id_categoria = $_POST['id_categoria'] ?? 1;
            $direccion = $_POST['direccion'] ?? null;
            $latitud = !empty($_POST['latitud']) ? $_POST['latitud'] : null;
            $longitud = !empty($_POST['longitud']) ? $_POST['longitud'] : null;

            $tipo_zona = ($_POST['tipo_zona'] ?? 'Urbana') === 'Rural' ? 'Rural' : 'Urbana';
            $id_barrio = ($tipo_zona === 'Urbana' && !empty($_POST['id_barrio'])) ? $_POST['id_barrio'] : null;
            $id_vereda = ($tipo_zona === 'Rural' && !empty($_POST['id_vereda'])) ? $_POST['id_vereda'] : null;

            try {
                $database = new Database();
                $conexion = $database->conectar();

                $stmt = $conexion->prepare("INSERT INTO reportes (id_usuario, titulo, descripcion, id_categoria, id_prioridad, id_municipio, id_barrio, id_vereda, tipo_zona, direccion, latitud, longitud, id_estado) VALUES (:id_usuario, :titulo, :descripcion, :id_categoria, 2, 1, :id_barrio, :id_vereda, :tipo_zona, :direccion, :latitud, :longitud, 1)");
                $stmt->execute([
                    ':id_usuario' => $id_usuario,
                    ':titulo' => $titulo,
                    ':descripcion' => $descripcion,
                    ':id_categoria' => $id_categoria,
                    ':id_barrio' => $id_barrio,
                    ':id_vereda' => $id_vereda,
                    ':tipo_zona' => $tipo_zona,
                    ':direccion' => $direccion,
                    ':latitud' => $latitud,
                    ':longitud' => $longitud
                ]);

                $id_reporte_nuevo = $conexion->lastInsertId();

                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['foto']['tmp_name'];
                    $fileName = $_FILES['foto']['name'];
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                    if (in_array($fileExtension, $allowedExtensions)) {
                        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                        $uploadFileDir = __DIR__ . '/../../public/uploads/';
                        if (!is_dir($uploadFileDir)) { mkdir($uploadFileDir, 0755, true); }

                        if (move_uploaded_file($fileTmpPath, $uploadFileDir . $newFileName)) {
                            try {
                                $stmtEv = $conexion->prepare("INSERT INTO evidencias (id_reporte, nombre_archivo, tipo_archivo, subido_por) VALUES (:id_reporte, :archivo, :tipo, 'ciudadano')");
                                $stmtEv->execute([
                                    ':id_reporte' => $id_reporte_nuevo,
                                    ':archivo' => $newFileName,
                                    ':tipo' => 'imagen'
                                ]);
                            } catch (PDOException $ex) {}
                        }
                    }
                }

                $_SESSION['toast_success'] = "¡Reporte creado con éxito!";
                header('Location: /FresnoReporta/public/index.php?url=mis-reportes');
                exit;
            } catch (PDOException $e) {
                $_SESSION['toast_error'] = "Error al guardar el reporte: " . $e->getMessage();
                header('Location: /FresnoReporta/public/index.php?url=crear');
                exit;
            }
        }
    }

    public function misReportes()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        $id_usuario = $_SESSION['id_usuario'];
        $reportes = []; $categorias = []; $estados = [];
        $busqueda = $_GET['busqueda'] ?? '';
        $filtro_categoria = $_GET['categoria'] ?? '';
        $filtro_estado = $_GET['estado'] ?? '';

        try {
            $database = new Database();
            $conexion = $database->conectar();
            $categorias = $conexion->query("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
            $estados = $conexion->query("SELECT * FROM estados WHERE activo = 1 ORDER BY id_estado ASC")->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT r.*,
                        (SELECT e.nombre_archivo FROM evidencias e WHERE e.id_reporte = r.id_reporte ORDER BY e.id_evidencia DESC LIMIT 1) AS foto
                    FROM reportes r WHERE r.id_usuario = :id_usuario";
            $params = [':id_usuario' => $id_usuario];

            if (!empty($busqueda)) {
                $sql .= " AND (r.titulo LIKE :busqueda OR r.descripcion LIKE :busqueda)";
                $params[':busqueda'] = '%' . $busqueda . '%';
            }
            if (!empty($filtro_categoria)) {
                $sql .= " AND r.id_categoria = :categoria";
                $params[':categoria'] = $filtro_categoria;
            }
            if (!empty($filtro_estado)) {
                $sql .= " AND r.id_estado = :estado";
                $params[':estado'] = $filtro_estado;
            }

            $sql .= " ORDER BY r.id_reporte DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($params);
            $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { $reportes = []; }

        require_once __DIR__ . '/../views/reportes/mis_reportes.php';
    }

    public function admin()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] != 1) {
            $_SESSION['toast_error'] = "Acceso denegado. No tienes permisos de administración.";
            header('Location: /FresnoReporta/public/index.php?url=mis-reportes');
            exit;
        }

        $reportes = []; $categorias = []; $estados = [];
        $busqueda = $_GET['busqueda'] ?? '';
        $filtro_categoria = $_GET['categoria'] ?? '';
        $filtro_estado = $_GET['estado'] ?? '';

        try {
            $database = new Database();
            $conexion = $database->conectar();
            $categorias = $conexion->query("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
            $estados = $conexion->query("SELECT * FROM estados WHERE activo = 1 ORDER BY id_estado ASC")->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT r.*, u.nombre as nombre_usuario,
                        (SELECT e.nombre_archivo FROM evidencias e WHERE e.id_reporte = r.id_reporte ORDER BY e.id_evidencia DESC LIMIT 1) AS foto
                    FROM reportes r LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario WHERE 1=1";
            $params = [];

            if (!empty($busqueda)) {
                $sql .= " AND (r.titulo LIKE :busqueda OR r.descripcion LIKE :busqueda)";
                $params[':busqueda'] = '%' . $busqueda . '%';
            }
            if (!empty($filtro_categoria)) {
                $sql .= " AND r.id_categoria = :categoria";
                $params[':categoria'] = $filtro_categoria;
            }
            if (!empty($filtro_estado)) {
                $sql .= " AND r.id_estado = :estado";
                $params[':estado'] = $filtro_estado;
            }

            $sql .= " ORDER BY r.id_reporte DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($params);
            $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) { $reportes = []; }

        require_once __DIR__ . '/../views/reportes/admin.php';
    }

    public function dashboardEstadisticas()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] != 1) {
            $_SESSION['toast_error'] = "Acceso denegado al Dashboard.";
            header('Location: /FresnoReporta/public/index.php?url=mis-reportes');
            exit;
        }

        $total_reportes = 0;
        $pendientes = 0;
        $en_proceso = 0;
        $solucionados = 0;
        $por_categoria = [];

        try {
            $database = new Database();
            $conexion = $database->conectar();

            $stmtTotal = $conexion->query("SELECT COUNT(*) as total FROM reportes");
            $total_reportes = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            $stmtEstados = $conexion->query("SELECT id_estado, COUNT(*) as total FROM reportes GROUP BY id_estado");
            $resultadosEstados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);

            // Estados reales: 1 Pendiente, 2 En revisión, 3 Asignado, 4 En proceso, 5 Solucionado, 6 Cerrado, 7 Rechazado
            foreach ($resultadosEstados as $row) {
                $idEstado = (int)$row['id_estado'];
                $cantidad = (int)$row['total'];

                if ($idEstado === 1) {
                    $pendientes += $cantidad;
                } elseif (in_array($idEstado, [2, 3, 4], true)) {
                    $en_proceso += $cantidad;
                } elseif (in_array($idEstado, [5, 6], true)) {
                    $solucionados += $cantidad;
                }
            }

            $stmtCat = $conexion->query("
                SELECT c.nombre as categoria, COUNT(r.id_reporte) as total
                FROM categorias c
                LEFT JOIN reportes r ON c.id_categoria = r.id_categoria
                GROUP BY c.id_categoria, c.nombre
                ORDER BY total DESC
            ");
            $por_categoria = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $total_reportes = 0;
        }

        require_once __DIR__ . '/../views/reportes/dashboard.php';
    }

    public function actualizarEstado()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_reporte = $_POST['id_reporte'] ?? null;
            $nuevo_estado = $_POST['id_estado'] ?? ($_POST['nuevo_estado'] ?? null);

            if (!empty($id_reporte) && !empty($nuevo_estado)) {
                try {
                    $database = new Database();
                    $conexion = $database->conectar();

                    $stmt = $conexion->prepare("UPDATE reportes SET id_estado = :id_estado WHERE id_reporte = :id_reporte");
                    $stmt->execute([
                        ':id_estado' => $nuevo_estado,
                        ':id_reporte' => $id_reporte
                    ]);

                    $_SESSION['toast_success'] = "¡Estado actualizado con éxito!";
                } catch (PDOException $e) {
                    $_SESSION['toast_error'] = "Error al actualizar el estado: " . $e->getMessage();
                }
            } else {
                $_SESSION['toast_error'] = "Faltan datos obligatorios para actualizar.";
            }
        }

        $redirectUrl = $_POST['redirect'] ?? '/FresnoReporta/public/index.php?url=admin';
        header('Location: ' . $redirectUrl);
        exit;
    }

    public function mapa()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        $reportes = [];
        $categorias = [];
        $estados = [];
        try {
            $database = new Database();
            $conexion = $database->conectar();
            $categorias = $conexion->query("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
            $estados = $conexion->query("SELECT * FROM estados WHERE activo = 1 ORDER BY id_estado ASC")->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conexion->query("
                SELECT r.*, c.nombre as categoria_nombre,
                    (SELECT e.nombre_archivo FROM evidencias e WHERE e.id_reporte = r.id_reporte ORDER BY e.id_evidencia DESC LIMIT 1) AS foto
                FROM reportes r
                LEFT JOIN categorias c ON r.id_categoria = c.id_categoria
                WHERE r.latitud IS NOT NULL AND r.longitud IS NOT NULL
            ");
            $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($reportes as &$r) {
                $r['foto'] = resolverRutaEvidencia($r['foto'] ?? '');
            }
            unset($r);
        } catch (PDOException $e) { $reportes = []; }

        require_once __DIR__ . '/../views/reportes/mapa.php';
    }

    public function detalle()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=login');
            exit;
        }

        $id_reporte = $_GET['id'] ?? null;
        $reporte = null;
        $evidencias = [];

        if ($id_reporte) {
            try {
                $database = new Database();
                $conexion = $database->conectar();

                $stmt = $conexion->prepare("SELECT r.*, c.nombre as categoria_nombre, e.nombre as estado_nombre, e.color as estado_color, u.nombre as usuario_nombre FROM reportes r LEFT JOIN categorias c ON r.id_categoria = c.id_categoria LEFT JOIN estados e ON r.id_estado = e.id_estado LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario WHERE r.id_reporte = :id LIMIT 1");
                $stmt->execute([':id' => $id_reporte]);
                $reporte = $stmt->fetch(PDO::FETCH_ASSOC);

                $stmtEv = $conexion->prepare("SELECT * FROM evidencias WHERE id_reporte = :id ORDER BY id_evidencia ASC");
                $stmtEv->execute([':id' => $id_reporte]);
                $evidencias = $stmtEv->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) { $reporte = null; }
        }

        require_once __DIR__ . '/../views/reportes/detalle.php';
    }
}
