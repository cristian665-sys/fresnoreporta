<?php
require_once __DIR__ . '/../config/database.php';

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (isset($_SESSION['id_usuario'])) {
            header('Location: /FresnoReporta/public/index.php?url=mis-reportes');
            exit;
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function procesarLogin()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? ($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            try {
                $database = new Database();
                $conexion = $database->conectar();

                $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
                $stmt->execute([':correo' => $correo]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && (password_verify($password, $usuario['password']) || $password === $usuario['password'])) {
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre'] = $usuario['nombre'] ?? 'Usuario';
                    $_SESSION['id_rol'] = $usuario['id_rol'] ?? 2; // 1 = Admin, 2 = Ciudadano

                    $_SESSION['toast_success'] = "¡Bienvenido de nuevo!";
                    
                    if ($_SESSION['id_rol'] == 1) {
                        header('Location: /FresnoReporta/public/index.php?url=admin');
                    } else {
                        header('Location: /FresnoReporta/public/index.php?url=mis-reportes');
                    }
                    exit;
                } else {
                    $_SESSION['error_login'] = "Correo o contraseña incorrectos.";
                    header('Location: /FresnoReporta/public/index.php?url=login');
                    exit;
                }
            } catch (PDOException $e) {
                error_log('[Fresno Reporta][Login] ' . $e->getMessage());
                $_SESSION['error_login'] = 'No se pudo conectar con la base de datos. Revisa MySQL en XAMPP e inténtalo de nuevo.';
                header('Location: /FresnoReporta/public/index.php?url=login');
                exit;
            }
        }
    }

    public function registro()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function procesarRegistro()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $cedula = $_POST['cedula'] ?? '';
            $correo = $_POST['correo'] ?? ($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $id_rol = 2; // Ciudadano

            try {
                $database = new Database();
                $conexion = $database->conectar();

                $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, cedula, correo, password, id_rol) VALUES (:nombre, :apellido, :cedula, :correo, :password, :id_rol)");
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':cedula' => $cedula,
                    ':correo' => $correo,
                    ':password' => $passwordHash,
                    ':id_rol' => $id_rol
                ]);

                $_SESSION['toast_success'] = "¡Registro exitoso! Por favor inicia sesión.";
                header('Location: /FresnoReporta/public/index.php?url=login');
                exit;
            } catch (PDOException $e) {
                error_log('[Fresno Reporta][Registro] ' . $e->getMessage());
                $_SESSION['error_registro'] = 'No se pudo conectar con la base de datos. Revisa MySQL en XAMPP e inténtalo de nuevo.';
                header('Location: /FresnoReporta/public/index.php?url=register');
                exit;
            }
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        session_destroy();
        header('Location: /FresnoReporta/public/index.php?url=login');
        exit;
    }
}