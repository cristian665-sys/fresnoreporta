-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2026 a las 21:26:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fresno_reporta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id_asignacion` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_asignado_por` int(11) NOT NULL,
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrios`
--

CREATE TABLE `barrios` (
  `id_barrio` int(11) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `barrios`
--

INSERT INTO `barrios` (`id_barrio`, `id_municipio`, `nombre`, `activo`) VALUES
(1, 1, 'Alto de la Cruz', 1),
(2, 1, 'Caldas', 1),
(3, 1, 'Centenario', 1),
(4, 1, 'El Carmen', 1),
(5, 1, 'El Obrero', 1),
(6, 1, 'Estadio', 1),
(7, 1, 'Jorge Eliécer Gaitán', 1),
(8, 1, 'Juan B. Cortés', 1),
(9, 1, 'La Abundancia', 1),
(10, 1, 'La Esperanza', 1),
(11, 1, 'La Libertad', 1),
(12, 1, 'La Playita', 1),
(13, 1, 'Las Chapoleras', 1),
(14, 1, 'Las Palmeras', 1),
(15, 1, 'Matadero', 1),
(16, 1, 'Nuevo Horizonte', 1),
(17, 1, 'San Luis', 1),
(18, 1, 'San Pedro', 1),
(19, 1, 'Santa Ana', 1),
(20, 1, 'Santo Domingo', 1),
(21, 1, 'Simón Bolívar', 1),
(22, 1, 'Villa del Prado', 1),
(23, 1, 'Villa María', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Huecos en la vía', 'Huecos o deterioro de la malla vial', 1),
(2, 'Alumbrado público', 'Luminarias apagadas o dañadas', 1),
(3, 'Basuras', 'Acumulación de residuos sólidos', 1),
(4, 'Árboles caídos', 'Árboles caídos o con riesgo de caída', 1),
(5, 'Parques', 'Daños en parques o zonas recreativas', 1),
(6, 'Puentes', 'Daños en puentes peatonales o vehiculares', 1),
(7, 'Inundaciones', 'Inundaciones causadas por lluvias', 1),
(8, 'Deslizamientos', 'Desprendimientos de tierra', 1),
(9, 'Acueducto', 'Daños en tuberías o redes de agua', 1),
(10, 'Alcantarillado', 'Daños en el sistema de alcantarillado', 1),
(11, 'Señalización vial', 'Daños o ausencia de señales de tránsito', 1),
(12, 'Semáforos', 'Semáforos fuera de servicio', 1),
(13, 'Espacio público', 'Daños en andenes, plazas o espacios públicos', 1),
(14, 'Otro', 'Daños que no pertenecen a las categorías anteriores', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencias`
--

CREATE TABLE `dependencias` (
  `id_dependencia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `dependencias`
--

INSERT INTO `dependencias` (`id_dependencia`, `nombre`, `descripcion`, `telefono`, `correo`, `activo`) VALUES
(1, 'Secretaría de Planeación e Infraestructura', 'Atiende vías, puentes, parques y obras públicas', NULL, NULL, 1),
(2, 'Empresa de Servicios Públicos', 'Atiende acueducto, alcantarillado y aseo', NULL, NULL, 1),
(3, 'Alumbrado Público', 'Atiende daños en luminarias y postes', NULL, NULL, 1),
(4, 'Secretaría de Ambiente', 'Atiende árboles, zonas verdes y protección ambiental', NULL, NULL, 1),
(5, 'Gestión del Riesgo', 'Atiende emergencias, inundaciones y deslizamientos', NULL, NULL, 1),
(6, 'Inspección de Policía', 'Atiende reportes relacionados con espacio público y convivencia', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `nombre`, `descripcion`, `color`, `activo`) VALUES
(1, 'Pendiente', 'Reporte recién creado', 'warning', 1),
(2, 'En revisión', 'El reporte está siendo revisado', 'info', 1),
(3, 'Asignado', 'El reporte fue asignado a un funcionario', 'primary', 1),
(4, 'En proceso', 'Se está realizando la intervención', 'secondary', 1),
(5, 'Solucionado', 'El daño fue solucionado', 'success', 1),
(6, 'Cerrado', 'El reporte fue cerrado definitivamente', 'dark', 1),
(7, 'Rechazado', 'El reporte fue rechazado', 'danger', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id_evidencia` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `subido_por` varchar(20) DEFAULT 'ciudadano'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evidencias`
--

INSERT INTO `evidencias` (`id_evidencia`, `id_reporte`, `nombre_archivo`, `tipo_archivo`, `descripcion`, `fecha_subida`, `subido_por`) VALUES
(1, 5, '/FresnoReporta/public/uploads/4165028d35c88deca647cae2dcdbea37.jpg', 'imagen', NULL, '2026-09-11 19:45:29', 'ciudadano'),
(2, 6, '/FresnoReporta/public/uploads/d25d12f5ac4c3792ca10d11f7db3d19f.jpg', 'imagen', NULL, '2026-09-11 19:46:19', 'ciudadano'),
(3, 7, '/FresnoReporta/public/uploads/ca2111d339335b717ac709f5dc233b7c.png', 'imagen', NULL, '2026-09-11 20:24:58', 'ciudadano'),
(4, 8, '/FresnoReporta/public/uploads/136ee7a1d06221bfe16cf970b6986eb6.jpg', 'imagen', NULL, '2026-09-11 21:19:35', 'ciudadano'),
(5, 12, '/FresnoReporta/public/uploads/evidencia_1789567084_6aaaa06c29e4f.jpg', '', NULL, '2026-09-16 13:58:04', 'ciudadano'),
(6, 13, '/FresnoReporta/public/uploads/evidencia_1789567230_6aaaa0fead7e3.jpg', '', NULL, '2026-09-16 14:00:30', 'ciudadano'),
(7, 14, '/FresnoReporta/public/uploads/evidencia_1789567361_6aaaa18195f47.jpg', '', NULL, '2026-09-16 14:02:41', 'ciudadano'),
(8, 45, 'fbdb68f4c04a7c5f462157fd9860cf8b.jpg', '', NULL, '2026-09-23 13:48:08', 'ciudadano'),
(9, 45, 'func_e2d6af218fa45ff0e6d14033ed77beea.jpg', '', NULL, '2026-09-23 14:20:27', 'ciudadano'),
(10, 45, 'func_6145ed963f3350163be68e69250131df.jpg', '', NULL, '2026-09-25 16:21:25', 'ciudadano'),
(11, 46, 'uploads/solucion_5d4fd2e129e0b96bdf80f745d259ec0a.png', 'solucion', NULL, '2026-09-25 20:30:41', 'ciudadano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_reportes`
--

CREATE TABLE `historial_reportes` (
  `id_historial` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `observacion` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `nombre`, `departamento`) VALUES
(1, 'Fresno', 'Tolima');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario`, `id_reporte`, `mensaje`, `leido`, `fecha_creacion`) VALUES
(1, 2, 14, 'Tu reporte #14 (\'arbol\') ha sido creado exitosamente y se encuentra en estado Registrado.', 0, '2026-09-16 09:02:41'),
(2, 1, 1, 'El estado de tu reporte #1 (\'agua\') ha sido actualizado.', 0, '2026-09-16 09:21:51'),
(3, 1, 2, 'El estado de tu reporte #2 (\'luz\') ha sido actualizado.', 0, '2026-09-16 09:21:53'),
(4, 2, 14, 'El estado de tu reporte #14 (\'arbol\') ha sido actualizado.', 0, '2026-09-16 15:48:52'),
(5, 1, 3, 'El estado de tu reporte #3 cambió a: Pendiente', 0, '2026-09-18 15:04:40'),
(6, 1, 3, 'El estado de tu reporte #3 cambió a: En proceso', 0, '2026-09-18 15:04:50'),
(7, 1, 3, 'El estado de tu reporte #3 cambió a: Pendiente', 0, '2026-09-18 15:04:55'),
(8, 1, 36, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 15:05:18'),
(9, 1, 1, 'El estado de tu reporte #1 cambió a: Pendiente', 0, '2026-09-18 15:05:54'),
(10, 1, 1, 'El estado de tu reporte #1 cambió a: En proceso', 0, '2026-09-18 15:12:36'),
(11, 2, 37, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 15:25:38'),
(12, 2, 38, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 15:26:05'),
(13, 2, 7, 'El estado de tu reporte #7 cambió a: En proceso', 0, '2026-09-18 15:26:23'),
(14, 1, 2, 'El estado de tu reporte #2 cambió a: Solucionado', 0, '2026-09-18 15:27:20'),
(15, 2, 39, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 15:30:40'),
(16, 1, 1, 'El estado de tu reporte #1 cambió a: En proceso', 0, '2026-09-18 15:31:42'),
(17, 4, 41, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 16:19:24'),
(18, 1, 1, 'El estado de tu reporte #1 cambió a: En revisión', 0, '2026-09-18 16:20:58'),
(19, 2, 42, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-18 16:24:20'),
(20, 2, 7, 'El estado de tu reporte #7 cambió a: En proceso', 0, '2026-09-18 16:26:18'),
(21, 1, 1, 'El estado de tu reporte #1 cambió a: Solucionado', 0, '2026-09-18 16:34:03'),
(22, 1, 3, 'El estado de tu reporte #3 cambió a: Solucionado', 0, '2026-09-18 16:34:09'),
(23, 1, 4, 'El estado de tu reporte #4 cambió a: Solucionado', 0, '2026-09-18 16:34:15'),
(24, 1, 5, 'El estado de tu reporte #5 cambió a: Solucionado', 0, '2026-09-18 16:34:20'),
(25, 2, 13, 'El estado de tu reporte #13 cambió a: En proceso', 0, '2026-09-18 16:34:26'),
(26, 1, 1, 'El estado de tu reporte #1 cambió a: Pendiente', 0, '2026-09-23 07:58:43'),
(27, 1, 1, 'El estado de tu reporte #1 cambió a: Pendiente', 0, '2026-09-23 07:58:48'),
(28, 2, 43, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-23 08:39:37'),
(29, 2, 44, 'Tu reporte ha sido registrado con éxito.', 0, '2026-09-23 08:44:19'),
(30, 2, 45, 'Tu reporte #45 ha sido registrado con éxito.', 0, '2026-09-23 08:48:08'),
(31, 2, 45, 'El estado de tu reporte #45 cambió a: En revisión', 0, '2026-09-23 09:20:19'),
(32, 2, 45, 'El estado de tu reporte #45 cambió a: Pendiente', 0, '2026-09-23 09:20:27'),
(33, 2, 45, 'El estado de tu reporte #45 cambió a: Pendiente', 0, '2026-09-25 10:23:32'),
(34, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 10:23:39'),
(35, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:00:35'),
(36, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:20:15'),
(37, 2, 45, 'El estado de tu reporte #45 cambió a: En revisión', 0, '2026-09-25 11:20:19'),
(38, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:20:23'),
(39, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:20:28'),
(40, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:20:32'),
(41, 2, 45, 'El estado de tu reporte #45 cambió a: En revisión', 0, '2026-09-25 11:20:34'),
(42, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:20:41'),
(43, 2, 45, 'El estado de tu reporte #45 cambió a: Asignado', 0, '2026-09-25 11:21:25'),
(44, 1, 24, 'El estado de tu reporte #24 cambió a: Asignado', 0, '2026-09-25 14:19:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridades`
--

CREATE TABLE `prioridades` (
  `id_prioridad` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prioridades`
--

INSERT INTO `prioridades` (`id_prioridad`, `nombre`, `descripcion`, `color`, `activo`) VALUES
(1, 'Baja', 'No requiere atención inmediata', 'success', 1),
(2, 'Media', 'Debe atenderse en un tiempo razonable', 'warning', 1),
(3, 'Alta', 'Requiere atención prioritaria', 'danger', 1),
(4, 'Crítica', 'Atención inmediata por riesgo para la comunidad', 'dark', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_prioridad` int(11) NOT NULL,
  `id_dependencia` int(11) DEFAULT NULL,
  `id_municipio` int(11) NOT NULL,
  `id_barrio` int(11) DEFAULT NULL,
  `id_vereda` int(11) DEFAULT NULL,
  `tipo_zona` enum('Urbana','Rural') NOT NULL,
  `titulo` varchar(150) NOT NULL DEFAULT 'Reporte Ciudadano',
  `descripcion` text NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `fecha_reporte` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `calificacion` int(11) DEFAULT NULL,
  `comentario_calificacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_usuario`, `id_categoria`, `id_estado`, `id_prioridad`, `id_dependencia`, `id_municipio`, `id_barrio`, `id_vereda`, `tipo_zona`, `titulo`, `descripcion`, `direccion`, `latitud`, `longitud`, `fecha_reporte`, `fecha_actualizacion`, `calificacion`, `comentario_calificacion`) VALUES
(1, 1, 10, 1, 1, 4, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'clla9', NULL, NULL, '2026-09-11 19:33:19', '2026-09-23 12:58:43', NULL, NULL),
(2, 1, 2, 5, 1, 1, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', NULL, NULL, '2026-09-11 19:33:56', '2026-09-18 20:27:20', NULL, NULL),
(3, 1, 7, 5, 1, 4, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'clla9', NULL, NULL, '2026-09-11 19:38:12', '2026-09-18 21:34:09', NULL, NULL),
(4, 1, 10, 5, 1, NULL, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'clla9', NULL, NULL, '2026-09-11 19:42:12', '2026-09-18 21:34:15', NULL, NULL),
(5, 1, 10, 5, 1, NULL, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'clla9', NULL, NULL, '2026-09-11 19:45:29', '2026-09-18 21:34:20', NULL, NULL),
(6, 1, 4, 1, 1, NULL, 1, NULL, NULL, 'Rural', 'Reporte Ciudadano', '', 'primavera', NULL, NULL, '2026-09-11 19:46:19', '2026-09-11 19:46:19', NULL, NULL),
(7, 2, 9, 4, 1, NULL, 1, NULL, NULL, 'Rural', 'Reporte Ciudadano', '', 'vereda cerro azul', NULL, NULL, '2026-09-11 20:24:58', '2026-09-18 20:26:23', NULL, NULL),
(8, 2, 9, 5, 1, NULL, 1, NULL, NULL, 'Urbana', 'Reporte Ciudadano', '', 'clla9', NULL, NULL, '2026-09-11 21:19:35', '2026-09-11 21:23:33', NULL, NULL),
(12, 2, 4, 1, 1, NULL, 1, NULL, 13, 'Rural', 'Reporte Ciudadano', '', 'vereda cerro azul', 5.15745400, -75.04293000, '2026-09-16 13:58:04', '2026-09-16 13:58:04', NULL, NULL),
(13, 2, 4, 4, 1, NULL, 1, NULL, 10, 'Rural', 'Reporte Ciudadano', '', 'clla9', 5.14916200, -75.06095400, '2026-09-16 14:00:30', '2026-09-18 21:34:26', NULL, NULL),
(14, 2, 4, 3, 1, NULL, 1, NULL, 15, 'Rural', 'Reporte Ciudadano', '', 'primavera', 5.15078600, -75.04962400, '2026-09-16 14:02:41', '2026-09-16 20:48:52', NULL, NULL),
(18, 1, 4, 1, 1, NULL, 1, NULL, 16, 'Rural', 'Reporte Ciudadano', '', 'primavera', 5.15170000, -75.03530000, '2026-09-18 15:56:11', '2026-09-18 15:56:11', NULL, NULL),
(19, 1, 4, 1, 1, NULL, 1, NULL, 16, 'Rural', 'Reporte Ciudadano', '', 'primavera', 5.15170000, -75.03530000, '2026-09-18 15:57:01', '2026-09-18 15:57:01', NULL, NULL),
(20, 1, 10, 1, 1, NULL, 1, NULL, 11, 'Rural', 'Reporte Ciudadano', '', 'primavera', 5.15170000, -75.03530000, '2026-09-18 15:58:14', '2026-09-18 15:58:14', NULL, NULL),
(21, 1, 10, 1, 1, NULL, 1, NULL, 11, 'Rural', 'Reporte Ciudadano', '', 'primavera', 5.15170000, -75.03530000, '2026-09-18 16:02:50', '2026-09-18 16:02:50', NULL, NULL),
(22, 1, 12, 1, 1, NULL, 1, 11, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:03:16', '2026-09-18 16:03:16', NULL, NULL),
(23, 1, 12, 1, 1, NULL, 1, 11, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:04:29', '2026-09-18 16:04:29', NULL, NULL),
(24, 1, 12, 3, 1, NULL, 1, 11, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:05:42', '2026-09-25 19:19:07', NULL, NULL),
(25, 1, 8, 1, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:07:35', '2026-09-18 16:07:35', NULL, NULL),
(26, 1, 8, 1, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:09:32', '2026-09-18 16:09:32', NULL, NULL),
(27, 1, 8, 1, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:11:48', '2026-09-18 16:11:48', NULL, NULL),
(28, 1, 8, 1, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:11:54', '2026-09-18 16:11:54', NULL, NULL),
(29, 1, 8, 5, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:28:19', '2026-10-16 19:20:42', NULL, NULL),
(30, 1, 8, 1, 1, NULL, 1, 12, NULL, 'Urbana', 'Reporte Ciudadano', '', 'crr8', 5.15170000, -75.03530000, '2026-09-18 16:32:43', '2026-09-18 16:32:43', NULL, NULL),
(31, 2, 9, 1, 1, NULL, 1, NULL, 14, 'Rural', 'Reporte Ciudadano', '', 'clla9', 5.15170000, -75.03530000, '2026-09-18 19:06:32', '2026-09-18 19:06:32', NULL, NULL),
(32, 2, 9, 1, 1, NULL, 1, NULL, 14, 'Rural', 'Reporte Ciudadano', 'Título: agua\n\ndaño', 'clla9', 5.15170000, -75.03530000, '2026-09-18 19:23:05', '2026-09-18 19:23:05', NULL, NULL),
(33, 2, 9, 1, 1, NULL, 1, NULL, 14, 'Rural', 'Reporte Ciudadano', 'Título: agua\n\ndaño', 'clla9', 5.15170000, -75.03530000, '2026-09-18 19:23:11', '2026-09-18 19:23:11', NULL, NULL),
(34, 2, 9, 1, 1, NULL, 1, 5, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'crr8', 5.15170000, -75.03530000, '2026-09-18 19:31:22', '2026-09-18 19:31:22', NULL, NULL),
(35, 2, 13, 1, 1, NULL, 1, 15, NULL, 'Urbana', 'Reporte Ciudadano', 'd', 'clla9', 5.15170000, -75.03530000, '2026-09-18 19:33:33', '2026-09-18 19:33:33', NULL, NULL),
(36, 1, 11, 1, 1, NULL, 1, 18, NULL, 'Urbana', 'Reporte Ciudadano', 'g', 'clla9', 5.15170000, -75.03530000, '2026-09-18 20:05:18', '2026-09-18 20:05:18', NULL, NULL),
(37, 2, 13, 1, 1, NULL, 1, 17, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'clla9', 5.15170000, -75.03530000, '2026-09-18 20:25:38', '2026-09-18 20:25:38', NULL, NULL),
(38, 2, 11, 1, 1, NULL, 1, 19, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'vereda cerro azul', 5.15340112, -75.03700733, '2026-09-18 20:26:05', '2026-09-18 20:26:05', NULL, NULL),
(39, 2, 1, 1, 1, NULL, 1, NULL, 26, 'Rural', 'Reporte Ciudadano', 'un hueco en la via', 'san silverio', 5.16952261, -75.03962517, '2026-09-18 20:30:40', '2026-09-18 20:30:40', NULL, NULL),
(40, 4, 2, 1, 1, NULL, 1, 10, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'san silverio', 5.15170000, -75.03530000, '2026-09-18 21:17:34', '2026-09-18 21:17:34', NULL, NULL),
(41, 4, 2, 1, 1, NULL, 1, 10, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'san silverio', 5.15170000, -75.03530000, '2026-09-18 21:19:24', '2026-09-18 21:19:24', NULL, NULL),
(42, 2, 10, 1, 1, NULL, 1, NULL, 13, 'Rural', 'Reporte Ciudadano', 'falla del servicio del agua', 'casa roja', 5.15052071, -75.03083825, '2026-09-18 21:24:20', '2026-09-18 21:24:20', NULL, NULL),
(43, 2, 9, 1, 1, NULL, 1, 10, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'crr8', 5.15170000, -75.03530000, '2026-09-23 13:39:37', '2026-09-23 13:39:37', NULL, NULL),
(44, 2, 11, 1, 1, NULL, 1, 13, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'casa roja', 5.15170000, -75.03530000, '2026-09-23 13:44:19', '2026-09-23 13:44:19', NULL, NULL),
(45, 2, 12, 3, 1, 3, 1, 17, NULL, 'Urbana', 'Reporte Ciudadano', 'daño', 'san silverio', 5.15500000, -75.02100000, '2026-09-23 13:48:08', '2026-09-25 16:20:41', NULL, NULL),
(46, 2, 12, 5, 2, NULL, 1, NULL, NULL, 'Urbana', '', 'jjjj', NULL, 5.15128182, -75.03713185, '2026-09-25 20:07:15', '2026-09-25 20:28:36', NULL, NULL),
(47, 2, 10, 1, 2, NULL, 1, NULL, NULL, 'Urbana', '', 'fuga de agua', NULL, 5.15134237, -75.03709032, '2026-09-25 20:32:07', '2026-09-25 20:32:07', NULL, NULL),
(48, 7, 1, 5, 2, NULL, 1, NULL, NULL, 'Urbana', '', 'un gran hueco', NULL, 5.15128864, -75.03712111, '2026-09-25 21:19:35', '2026-09-25 21:36:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', 'Control total del sistema'),
(2, 'Ciudadano', 'Puede registrar reportes'),
(3, 'Funcionario', 'Gestiona reportes asignados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_dependencia` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `id_dependencia`, `nombre`, `apellido`, `cedula`, `correo`, `telefono`, `password`, `foto_perfil`, `activo`, `fecha_registro`) VALUES
(1, 1, NULL, 'Cristian', 'Cogua', '123456789', 'admin@fresnoreporta.com', '3100000000', '123456', NULL, 1, '2026-07-25 21:40:52'),
(2, 3, NULL, 'Diego García', '', '', 'diego@gmail.com', NULL, '123456', NULL, 1, '2026-09-11 20:23:30'),
(4, 2, NULL, 'Mariana Bejarano', '', '1098765432', 'mariana@fresno.gov.co', NULL, '123456', NULL, 1, '2026-09-11 21:30:37'),
(7, 3, NULL, 'Cristian', '', '1013117786', 'coguacristian665@gmail.com', NULL, '$2y$10$pzVedOWweiZLRq8EtMDUTe8dH4SHifR18iRGYS0/l/nDO1uIG.2oe', NULL, 1, '2026-09-25 20:42:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veredas`
--

CREATE TABLE `veredas` (
  `id_vereda` int(11) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('Vereda','Centro Poblado') DEFAULT 'Vereda',
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `veredas`
--

INSERT INTO `veredas` (`id_vereda`, `id_municipio`, `nombre`, `tipo`, `activo`) VALUES
(1, 1, 'Aguas Claras', 'Vereda', 1),
(2, 1, 'Aguasal Brillante', 'Vereda', 1),
(3, 1, 'Aguasal La Playa', 'Vereda', 1),
(4, 1, 'Alegrías', 'Vereda', 1),
(5, 1, 'Alto del Águila', 'Vereda', 1),
(6, 1, 'Alto Grande', 'Vereda', 1),
(7, 1, 'Arrayán', 'Vereda', 1),
(8, 1, 'Bajo Gualí', 'Vereda', 1),
(9, 1, 'Barretico', 'Vereda', 1),
(10, 1, 'Barreto', 'Vereda', 1),
(11, 1, 'Betania', 'Vereda', 1),
(12, 1, 'Brisas del Gualí', 'Vereda', 1),
(13, 1, 'Brisas del Guarinó', 'Vereda', 1),
(14, 1, 'Buenos Aires', 'Vereda', 1),
(15, 1, 'Cachipay', 'Vereda', 1),
(16, 1, 'Caja Rica', 'Vereda', 1),
(17, 1, 'California', 'Vereda', 1),
(18, 1, 'Campeón Bajo', 'Vereda', 1),
(19, 1, 'Cascabel', 'Vereda', 1),
(20, 1, 'Caucasia', 'Vereda', 1),
(21, 1, 'Cerro Azul', 'Vereda', 1),
(22, 1, 'Colombia', 'Vereda', 1),
(23, 1, 'Dos Quebradas', 'Vereda', 1),
(24, 1, 'El Bosque', 'Vereda', 1),
(25, 1, 'El Espejo', 'Vereda', 1),
(26, 1, 'El Guayabo', 'Vereda', 1),
(27, 1, 'El Indio', 'Vereda', 1),
(28, 1, 'El Mulato', 'Vereda', 1),
(29, 1, 'El Nogal', 'Vereda', 1),
(30, 1, 'El Placer', 'Vereda', 1),
(31, 1, 'El Tablazo', 'Centro Poblado', 1),
(32, 1, 'El Turco', 'Vereda', 1),
(33, 1, 'España', 'Vereda', 1),
(34, 1, 'Fátima', 'Vereda', 1),
(35, 1, 'Guayacanal', 'Vereda', 1),
(36, 1, 'Guineal', 'Vereda', 1),
(37, 1, 'La Aguadita', 'Vereda', 1),
(38, 1, 'La Ceiba', 'Vereda', 1),
(39, 1, 'La Colina', 'Vereda', 1),
(40, 1, 'La Cristalina', 'Vereda', 1),
(41, 1, 'La Divisa', 'Vereda', 1),
(42, 1, 'La Floresta', 'Vereda', 1),
(43, 1, 'La Florida', 'Vereda', 1),
(44, 1, 'La Hondura', 'Vereda', 1),
(45, 1, 'La Linda', 'Vereda', 1),
(46, 1, 'La Picota', 'Vereda', 1),
(47, 1, 'La Porfía', 'Vereda', 1),
(48, 1, 'La Sierra', 'Vereda', 1),
(49, 1, 'Las Marías', 'Vereda', 1),
(50, 1, 'Los Andes', 'Vereda', 1),
(51, 1, 'Los Guaduales', 'Vereda', 1),
(52, 1, 'Mateguadua', 'Vereda', 1),
(53, 1, 'Medina', 'Vereda', 1),
(54, 1, 'Miraflores', 'Vereda', 1),
(55, 1, 'Mireya', 'Vereda', 1),
(56, 1, 'Monte Redondo', 'Vereda', 1),
(57, 1, 'Palenque', 'Vereda', 1),
(58, 1, 'Paramillo', 'Vereda', 1),
(59, 1, 'Partidas', 'Vereda', 1),
(60, 1, 'Pavas', 'Vereda', 1),
(61, 1, 'Peña Lisa', 'Vereda', 1),
(62, 1, 'Petaqueros', 'Vereda', 1),
(63, 1, 'Piedra Grande', 'Centro Poblado', 1),
(64, 1, 'Pitalito', 'Vereda', 1),
(65, 1, 'Playas del Gualí', 'Vereda', 1),
(66, 1, 'Portugal', 'Vereda', 1),
(67, 1, 'Primavera', 'Vereda', 1),
(68, 1, 'Providencia', 'Vereda', 1),
(69, 1, 'Puente Tierra', 'Vereda', 1),
(70, 1, 'Raizal I', 'Vereda', 1),
(71, 1, 'Raizal II', 'Vereda', 1),
(72, 1, 'Remolino', 'Vereda', 1),
(73, 1, 'San Antonio', 'Vereda', 1),
(74, 1, 'San Bernardo', 'Vereda', 1),
(75, 1, 'San Ignacio', 'Vereda', 1),
(76, 1, 'San Isidro', 'Vereda', 1),
(77, 1, 'Santa Clara', 'Vereda', 1),
(78, 1, 'Trincheras', 'Vereda', 1),
(79, 1, 'Travesías', 'Vereda', 1),
(80, 1, 'Yarima', 'Vereda', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `fk_asignacion_reporte` (`id_reporte`),
  ADD KEY `fk_asignacion_funcionario` (`id_funcionario`),
  ADD KEY `fk_asignacion_administrador` (`id_asignado_por`);

--
-- Indices de la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `fk_barrio_municipio` (`id_municipio`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_comentario_reporte` (`id_reporte`),
  ADD KEY `fk_comentario_usuario` (`id_usuario`);

--
-- Indices de la tabla `dependencias`
--
ALTER TABLE `dependencias`
  ADD PRIMARY KEY (`id_dependencia`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD PRIMARY KEY (`id_evidencia`),
  ADD KEY `fk_evidencia_reporte` (`id_reporte`);

--
-- Indices de la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historial_reporte` (`id_reporte`),
  ADD KEY `fk_historial_usuario` (`id_usuario`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_reporte` (`id_reporte`);

--
-- Indices de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  ADD PRIMARY KEY (`id_prioridad`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_prioridad` (`id_prioridad`),
  ADD KEY `id_dependencia` (`id_dependencia`),
  ADD KEY `id_municipio` (`id_municipio`),
  ADD KEY `id_barrio` (`id_barrio`),
  ADD KEY `id_vereda` (`id_vereda`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_usuario_rol` (`id_rol`),
  ADD KEY `fk_usuario_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `veredas`
--
ALTER TABLE `veredas`
  ADD PRIMARY KEY (`id_vereda`),
  ADD KEY `id_municipio` (`id_municipio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `barrios`
--
ALTER TABLE `barrios`
  MODIFY `id_barrio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dependencias`
--
ALTER TABLE `dependencias`
  MODIFY `id_dependencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id_evidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `prioridades`
--
ALTER TABLE `prioridades`
  MODIFY `id_prioridad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `veredas`
--
ALTER TABLE `veredas`
  MODIFY `id_vereda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `fk_asignacion_administrador` FOREIGN KEY (`id_asignado_por`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_asignacion_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_asignacion_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id_reporte`) ON DELETE CASCADE;

--
-- Filtros para la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD CONSTRAINT `fk_barrio_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentario_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id_reporte`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `fk_evidencia_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id_reporte`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_reportes`
--
ALTER TABLE `historial_reportes`
  ADD CONSTRAINT `fk_historial_reporte` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id_reporte`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_reporte`) REFERENCES `reportes` (`id_reporte`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reportes_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `reportes_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `reportes_ibfk_4` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridades` (`id_prioridad`),
  ADD CONSTRAINT `reportes_ibfk_5` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencias` (`id_dependencia`),
  ADD CONSTRAINT `reportes_ibfk_6` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`),
  ADD CONSTRAINT `reportes_ibfk_7` FOREIGN KEY (`id_barrio`) REFERENCES `barrios` (`id_barrio`),
  ADD CONSTRAINT `reportes_ibfk_8` FOREIGN KEY (`id_vereda`) REFERENCES `veredas` (`id_vereda`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_dependencia` FOREIGN KEY (`id_dependencia`) REFERENCES `dependencias` (`id_dependencia`),
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `veredas`
--
ALTER TABLE `veredas`
  ADD CONSTRAINT `veredas_ibfk_1` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
