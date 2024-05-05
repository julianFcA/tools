-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2024 a las 06:51:18
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
-- Base de datos: `herramientas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamo`
--

CREATE TABLE `detalle_prestamo` (
  `id_deta_presta` tinyint(4) NOT NULL,
  `cant_herra` tinyint(4) NOT NULL,
  `codigo_barra_herra` varchar(500) NOT NULL,
  `id_presta` tinyint(4) NOT NULL,
  `estado_presta` enum('prestado','incompleto','devuelto','reportado') NOT NULL,
  `cant_devolucion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_prestamo`
--

INSERT INTO `detalle_prestamo` (`id_deta_presta`, `cant_herra`, `codigo_barra_herra`, `id_presta`, `estado_presta`, `cant_devolucion`) VALUES
(3, 0, '6618baec23e7e8656', 2, 'devuelto', 1),
(4, 2, '6627628e204e01573', 2, 'reportado', 0),
(5, 1, '6627628e204e01573', 3, 'reportado', 0),
(6, 0, '6627628e204e01573', 4, 'devuelto', 1),
(7, 1, '6627628e204e01573', 5, 'reportado', 0),
(8, 0, '6627628e204e01573', 6, 'devuelto', 1),
(9, 0, '6627628e204e01573', 7, 'devuelto', 1),
(10, 0, '6627628e204e01573', 8, 'devuelto', 2),
(11, 0, '6627628e204e01573', 9, 'devuelto', 1),
(12, 0, '6627628e204e01573', 10, 'devuelto', 1),
(13, 0, '6627628e204e01573', 11, 'devuelto', 1),
(14, 1, '6618baec23e7e8656', 12, 'reportado', 0),
(15, 1, '6618ba9e1569b6707', 13, 'reportado', 0),
(16, 0, '6618ba9e1569b6707', 14, 'devuelto', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_ficha`
--

CREATE TABLE `deta_ficha` (
  `id_deta_ficha` tinyint(4) NOT NULL,
  `ficha` int(7) NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deta_ficha`
--

INSERT INTO `deta_ficha` (`id_deta_ficha`, `ficha`, `documento`) VALUES
(2, 2500591, 1023456789),
(3, 1234568, 1234567890),
(8, 1234567, 1110456214),
(9, 1230123, 1110456214),
(10, 2500591, 2147483647),
(11, 1234568, 1110546897),
(12, 2500591, 1110567985),
(13, 1234567, 1110567986);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_reporte`
--

CREATE TABLE `deta_reporte` (
  `id_deta_reporte` tinyint(4) NOT NULL,
  `id_reporte` tinyint(4) NOT NULL,
  `codigo_barra_herra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deta_reporte`
--

INSERT INTO `deta_reporte` (`id_deta_reporte`, `id_reporte`, `codigo_barra_herra`) VALUES
(2, 9, '6618ba9e1569b6707');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nit_empre` varchar(10) NOT NULL,
  `nom_empre` text NOT NULL,
  `direcc_empre` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_empre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit_empre`, `nom_empre`, `direcc_empre`, `telefono`, `correo_empre`) VALUES
('89999034-1', 'CENTRO DE FORMACION', 'Calle 57 No. 8-69, Bogotá ', '546150041', 'notificacionesjudiciales@sena.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_usu`
--

CREATE TABLE `entrada_usu` (
  `id_entrada` int(5) NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada_usu`
--

INSERT INTO `entrada_usu` (`id_entrada`, `fecha_entrada`, `documento`) VALUES
(102, '2024-03-30 15:10:02', 123456788),
(104, '2024-03-31 00:16:41', 123456788),
(106, '2024-03-31 00:46:04', 1234567890),
(107, '2024-03-31 14:40:39', 123456788),
(108, '2024-04-01 07:30:48', 123456788),
(109, '2024-04-01 08:56:45', 123456788),
(110, '2024-04-01 11:30:44', 123456788),
(111, '2024-04-01 11:32:26', 123456788),
(112, '2024-04-01 11:36:11', 123456788),
(113, '2024-04-01 11:37:10', 123456788),
(114, '2024-04-01 18:31:00', 123456788),
(115, '2024-04-01 23:57:13', 123456788),
(117, '2024-04-02 00:11:57', 123456788),
(118, '2024-04-02 00:18:49', 123456788),
(120, '2024-04-02 00:25:49', 123456788),
(122, '2024-04-02 01:08:58', 1234567890),
(123, '2024-04-02 01:28:30', 123456788),
(125, '2024-04-02 01:37:08', 1234567890),
(126, '2024-04-02 06:12:28', 123456788),
(127, '2024-04-02 06:27:35', 123456788),
(129, '2024-04-02 08:14:56', 123456788),
(130, '2024-04-02 08:26:28', 123456788),
(131, '2024-04-02 08:49:43', 123456788),
(133, '2024-04-02 10:06:36', 123456788),
(134, '2024-04-02 19:26:40', 123456788),
(135, '2024-04-02 19:28:35', 123456788),
(136, '2024-04-03 01:15:22', 123456788),
(137, '2024-04-03 02:35:42', 123456788),
(138, '2024-04-03 02:55:21', 123456788),
(139, '2024-04-03 06:09:38', 123456788),
(141, '2024-04-03 11:23:38', 1234567890),
(142, '2024-04-03 11:35:13', 1234567890),
(143, '2024-04-04 15:12:33', 123456788),
(146, '2024-04-04 15:49:36', 123456788),
(147, '2024-04-05 10:04:45', 1234567890),
(149, '2024-04-05 10:07:59', 123456788),
(150, '2024-04-05 10:19:08', 1234567890),
(152, '2024-04-05 10:20:08', 123456788),
(153, '2024-04-05 10:34:03', 123456788),
(154, '2024-04-05 10:34:33', 123456788),
(155, '2024-04-05 10:48:32', 123456788),
(156, '2024-04-05 10:53:12', 123456788),
(158, '2024-04-05 16:55:03', 123456788),
(162, '2024-04-06 00:26:11', 1234567890),
(163, '2024-04-06 00:39:50', 1234567890),
(164, '2024-04-06 00:46:22', 1234567890),
(165, '2024-04-06 00:51:14', 1234567890),
(166, '2024-04-06 00:51:55', 1234567890),
(167, '2024-04-06 09:38:14', 1234567890),
(171, '2024-04-09 18:31:25', 123456788),
(174, '2024-04-13 11:21:08', 123456788),
(176, '2024-04-13 11:35:37', 1234567890),
(177, '2024-04-14 15:47:18', 123456788),
(179, '2024-04-14 16:12:19', 1023456789),
(180, '2024-04-14 16:52:19', 123456788),
(182, '2024-04-14 18:06:56', 123456788),
(183, '2024-04-15 06:55:17', 123456788),
(184, '2024-04-15 07:17:53', 123456788),
(185, '2024-04-15 10:03:45', 123456788),
(186, '2024-04-16 06:50:58', 123456788),
(187, '2024-04-16 06:53:04', 123456788),
(188, '2024-04-18 00:00:16', 1234567890),
(189, '2024-04-20 02:31:12', 123456788),
(191, '2024-04-20 04:20:20', 1023456789),
(192, '2024-04-22 06:16:21', 123456788),
(193, '2024-04-22 07:21:07', 123456788),
(194, '2024-04-22 07:21:56', 123456788),
(195, '2024-04-22 07:45:44', 123456788),
(196, '2024-04-22 08:26:29', 123456788),
(197, '2024-04-22 08:30:15', 123456788),
(198, '2024-04-22 08:32:30', 123456788),
(199, '2024-04-22 08:34:36', 123456788),
(200, '2024-04-22 09:39:00', 123456788),
(201, '2024-04-22 09:43:04', 123456788),
(202, '2024-04-22 09:54:15', 123456788),
(203, '2024-04-22 09:56:32', 123456788),
(204, '2024-04-22 10:06:32', 123456788),
(205, '2024-04-22 11:00:48', 123456788),
(206, '2024-04-22 13:09:26', 123456788),
(207, '2024-04-22 18:10:46', 123456788),
(209, '2024-04-22 18:26:40', 123456788),
(210, '2024-04-23 12:52:40', 123456788),
(211, '2024-04-23 19:24:01', 123456788),
(212, '2024-04-23 22:33:11', 123456788),
(213, '2024-04-23 22:34:09', 123456788),
(214, '2024-04-23 22:37:33', 123456788),
(215, '2024-04-24 06:43:18', 123456788),
(218, '2024-04-25 01:52:01', 123456788),
(220, '2024-04-25 03:31:15', 1234567890),
(221, '2024-04-25 03:39:32', 1234567890),
(223, '2025-04-25 03:53:10', 123456788),
(225, '2024-04-25 11:58:00', 123456788),
(226, '2024-04-25 13:42:16', 1110456214),
(227, '2024-04-25 13:43:44', 1234567890),
(228, '2024-04-25 14:26:17', 1110456214),
(229, '2024-04-25 14:27:34', 123456788),
(230, '2024-04-25 14:33:04', 123456788),
(231, '2024-04-26 07:09:40', 1110456214),
(232, '2024-04-26 07:57:30', 1110456214),
(233, '2024-04-27 14:39:24', 1110456214),
(234, '2024-04-28 11:05:57', 1110456214),
(235, '2024-04-28 11:08:30', 1110456214),
(236, '2024-04-28 11:10:57', 1110456214),
(237, '2024-04-28 11:13:10', 1110456214),
(238, '2024-04-28 11:16:19', 1110456214),
(239, '2024-04-28 11:18:31', 1110456214),
(240, '2024-04-28 11:40:30', 1110456214),
(241, '2024-04-28 12:07:33', 1110456214),
(242, '2024-04-28 12:19:32', 1110456214),
(243, '2024-04-28 12:19:59', 1110456214),
(244, '2024-04-28 13:02:34', 123456788),
(245, '2024-04-28 14:37:10', 1110456214),
(246, '2024-04-28 23:25:43', 123456788),
(247, '2024-04-30 12:26:28', 1110456214),
(248, '2024-04-30 12:30:05', 1110456214),
(249, '2024-04-30 22:51:40', 1110456214),
(250, '2024-04-30 22:53:01', 123456788),
(251, '2024-05-01 10:39:54', 1110456214),
(252, '2024-05-01 10:59:10', 123456788),
(253, '2024-05-01 11:40:51', 123456788),
(254, '2024-05-01 11:44:32', 1023456789),
(255, '2024-05-01 12:05:03', 123456788),
(256, '2024-05-01 15:58:48', 123456788),
(257, '2024-05-01 16:56:28', 1110456214),
(258, '2024-05-01 17:30:05', 123456788),
(259, '2024-05-01 17:41:48', 123456788),
(260, '2024-05-01 17:57:20', 1110456214),
(261, '2024-05-01 17:59:29', 123456788),
(262, '2024-05-01 18:28:49', 1110456214),
(263, '2024-05-01 19:35:13', 123456788),
(264, '2024-05-01 19:39:05', 1110456214),
(265, '2024-05-01 19:56:04', 1234567890),
(266, '2024-05-01 20:45:47', 123456788),
(267, '2024-05-01 21:05:46', 1110456214),
(268, '2024-05-02 02:06:22', 123456788),
(269, '2024-05-02 06:14:57', 1110567985),
(270, '2024-05-02 17:02:36', 1110456214),
(271, '2024-05-03 08:01:48', 123456788),
(272, '2024-05-03 23:18:38', 123456788),
(273, '2024-05-04 00:42:56', 123456788),
(274, '2024-05-04 00:43:24', 123456788),
(275, '2024-05-04 00:44:11', 123456788),
(276, '2024-05-04 00:45:43', 123456788),
(277, '2024-05-04 00:46:33', 123456788),
(278, '2024-05-04 00:47:15', 123456788),
(279, '2024-05-04 01:00:54', 123456788),
(280, '2024-05-04 01:02:32', 123456788),
(281, '2024-05-04 01:05:22', 123456788),
(282, '2024-05-04 01:16:39', 123456788),
(283, '2024-05-04 01:27:42', 123456788),
(284, '2024-05-04 21:18:36', 1110456214),
(285, '2024-05-04 21:19:24', 1110456214);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usu`
--

CREATE TABLE `estado_usu` (
  `id_esta_usu` tinyint(4) NOT NULL,
  `nom_esta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_usu`
--

INSERT INTO `estado_usu` (`id_esta_usu`, `nom_esta`) VALUES
(1, 'activo'),
(2, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `ficha` int(7) NOT NULL,
  `id_forma` tinyint(4) NOT NULL,
  `id_jornada` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`ficha`, `id_forma`, `id_jornada`) VALUES
(1230123, 2, 1),
(1234567, 3, 2),
(1234568, 2, 4),
(2500591, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion`
--

CREATE TABLE `formacion` (
  `id_forma` tinyint(4) NOT NULL,
  `nom_forma` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formacion`
--

INSERT INTO `formacion` (`id_forma`, `nom_forma`) VALUES
(2, 'soldadura'),
(3, 'carpinteria en alumnio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta`
--

CREATE TABLE `herramienta` (
  `codigo_barra_herra` varchar(500) NOT NULL,
  `id_tp_herra` tinyint(4) NOT NULL,
  `nombre_herra` varchar(20) NOT NULL,
  `id_marca` tinyint(4) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `esta_herra` enum('disponible','prestado','dañado','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta`
--

INSERT INTO `herramienta` (`codigo_barra_herra`, `id_tp_herra`, `nombre_herra`, `id_marca`, `descripcion`, `cantidad`, `imagen`, `esta_herra`) VALUES
('6618ba9e1569b6707', 2, 'taladrokhkh', 1, 'funciona con cargadornkknk ', 23, '2XMFaiFBA33TfkY001GftHQM6D6-mobile-Photoroom.png-Photoroom.png', 'disponible'),
('6618baec23e7e8656', 1, 'palustre', 1, 'tapar agujeros', 0, 'client.jpg', 'prestado'),
('662761152e65d2051', 1, 'bjjhhjhjhj', 1, 'jhjhjhh', 0, 'angora-turco-xl-1280x720x80xX-Photoroom.png-Photoroom.png', 'prestado'),
('6627628e204e01573', 2, 'kknnknkn', 2, 'nknnknn', 0, '2XMFaiFBA33TfkY001GftHQM6D6-mobile-Photoroom.png-Photoroom.png', 'prestado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id_jornada` tinyint(4) NOT NULL,
  `tp_jornada` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jornada`
--

INSERT INTO `jornada` (`id_jornada`, `tp_jornada`) VALUES
(1, 'mañana'),
(2, 'tarde'),
(3, 'noche'),
(4, 'madrugada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `licencia` varchar(25) NOT NULL,
  `esta_licen` enum('activo','inactivo','','') NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `nit_empre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`licencia`, `esta_licen`, `fecha_ini`, `fecha_fin`, `nit_empre`) VALUES
('65f90c71aeba5', 'activo', '2024-04-09', '2025-04-09', '89999034-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_herra`
--

CREATE TABLE `marca_herra` (
  `id_marca` tinyint(4) NOT NULL,
  `nom_marca` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca_herra`
--

INSERT INTO `marca_herra` (`id_marca`, `nom_marca`) VALUES
(1, 'caterpillar'),
(2, 'hechiza'),
(3, 'pajarito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo_herra`
--

CREATE TABLE `prestamo_herra` (
  `id_presta` tinyint(4) NOT NULL,
  `fecha_adqui` date NOT NULL,
  `dias` tinyint(4) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo_herra`
--

INSERT INTO `prestamo_herra` (`id_presta`, `fecha_adqui`, `dias`, `fecha_entrega`, `documento`) VALUES
(2, '2024-05-01', 2, '2024-05-03', 1023456789),
(3, '2024-05-01', 3, '2024-05-04', 1234567890),
(4, '2024-05-01', 2, '2024-05-03', 1023456789),
(5, '2024-05-02', 3, '2024-05-05', 1110567985),
(6, '2024-05-04', 2, '2024-05-06', 1110567986),
(7, '2024-05-04', 2, '2024-05-06', 1110567986),
(8, '2024-05-04', 1, '2024-05-05', 1110567986),
(9, '2024-05-04', 4, '2024-05-08', 1110567986),
(10, '2024-05-04', 2, '2024-05-06', 1110567986),
(11, '2024-05-04', 1, '2024-05-05', 1110567986),
(12, '2024-05-04', 1, '2024-05-05', 1110567986),
(13, '2024-05-04', 1, '2024-05-05', 1110567986),
(14, '2024-05-04', 1, '2024-05-05', 1110567986);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` tinyint(4) NOT NULL,
  `descripcion` text NOT NULL,
  `id_deta_presta` tinyint(4) NOT NULL,
  `documento` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id_reporte`, `descripcion`, `id_deta_presta`, `documento`, `fecha`) VALUES
(1, '', 3, 1023456789, '2024-05-04 21:38:50'),
(2, 'dañada', 5, 1234567890, '2024-05-04 22:17:09'),
(3, '', 4, 1023456789, '2024-05-04 22:18:34'),
(4, 'dañada', 7, 1110567985, '2024-05-04 22:21:45'),
(5, 'dañada', 7, 1110567985, '2024-05-04 22:23:01'),
(6, 'dañada', 7, 1110567985, '2024-05-04 22:26:38'),
(7, '', 14, 1110567986, '2024-05-04 23:08:19'),
(8, 'daasasasa', 15, 1110567986, '2024-05-04 23:16:03'),
(9, 'daasasasa', 15, 1110567986, '2024-05-04 23:16:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` tinyint(4) NOT NULL,
  `nom_rol` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nom_rol`) VALUES
(1, 'Administrador'),
(2, 'Instructor'),
(3, 'Aprendiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp_docu`
--

CREATE TABLE `tp_docu` (
  `id_tp_docu` tinyint(4) NOT NULL,
  `nom_tp_docu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tp_docu`
--

INSERT INTO `tp_docu` (`id_tp_docu`, `nom_tp_docu`) VALUES
(1, 'tarjeta identidad'),
(2, 'cedula ciudadanía'),
(3, 'cedula extranjeria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tp_herra`
--

CREATE TABLE `tp_herra` (
  `id_tp_herra` tinyint(4) NOT NULL,
  `nom_tp_herra` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tp_herra`
--

INSERT INTO `tp_herra` (`id_tp_herra`, `nom_tp_herra`) VALUES
(1, 'manual'),
(2, 'eléctrica'),
(3, 'hidráulica '),
(4, 'semi-electrica'),
(5, 'ultrasonica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tri_contra`
--

CREATE TABLE `tri_contra` (
  `documento` int(11) NOT NULL,
  `id_tp_docu` tinyint(4) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `id_rol` tinyint(4) NOT NULL,
  `fecha` datetime NOT NULL,
  `nit_empre` varchar(10) NOT NULL,
  `accion_usu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tri_contra`
--

INSERT INTO `tri_contra` (`documento`, `id_tp_docu`, `nombre`, `apellido`, `contrasena`, `correo`, `id_rol`, `fecha`, `nit_empre`, `accion_usu`) VALUES
(123456788, 2, 'plinio', 'noruega', '$2y$10$EE/26/srinuQhFp16k.iq.7SHL/y76kl43Qg7QkanhoiPxBeRLMkS', 'pliniojose1@gmail.com', 2, '2024-04-14 15:47:40', '89999034-1', 'Actualización'),
(1110567986, 2, 'julian', 'calderon', '$2y$12$wy2R1CV9ZfaR1j.XSDtGKed6fqHSF2vmSlRTMwomLwdTgkPdPReqm', 'jfcalderona16@gmail.com', 1, '2024-04-20 00:47:02', '0', 'Actualización'),
(1110567986, 2, 'julian', 'calderon', '$2y$12$wy2R1CV9ZfaR1j.XSDtGKed6fqHSF2vmSlRTMwomLwdTgkPdPReqm', 'jfcalderona16@gmail.com', 1, '2024-04-20 00:47:03', '0', 'Actualización'),
(1110567986, 2, 'julian', 'calderon', '$2y$12$wy2R1CV9ZfaR1j.XSDtGKed6fqHSF2vmSlRTMwomLwdTgkPdPReqm', 'jfcalderona16@gmail.com', 1, '2024-04-20 00:47:13', '0', 'Actualización'),
(1110567986, 2, 'julian', 'calderon', '$2y$12$wy2R1CV9ZfaR1j.XSDtGKed6fqHSF2vmSlRTMwomLwdTgkPdPReqm', 'jfcalderona16@gmail.com', 1, '2024-04-20 00:47:21', '0', 'Actualización'),
(2147483647, 2, 'gilberto', 'atuesta', '$2y$10$cBE6bpGjjuufKylhYQjvpeza0yYhdH5hAo9SDIh0KVbXnva4oPLDi', 'gilbertoatuesta@gmail.com', 3, '2024-04-20 00:52:03', '89999034-1', 'Actualización'),
(1234567890, 2, 'felipe', 'calderon aguirre', '$2y$12$Wo2Hipe2aOaKaKvGG8/dXeZMjOaTNkKc/bsosCOSj9wd6oER.BlLO', 'jfcalderon62@gmai.com', 4, '2024-04-20 00:52:12', '89999034-1', 'Actualización'),
(1023456789, 2, 'fabricio', 'herrera', '$2y$10$pmFzUAo0BM5zeL3ahA6VlutADajIIQIwfs//Jdnn6VMLY3T3zP/ta', 'frabricio123@gmail.com', 4, '2024-04-20 00:52:20', '89999034-1', 'Actualización'),
(123456788, 2, 'plinio', 'noruega', '$2y$12$9El79WRIjfrbd3R7GqA.gOT/LlHFC8bQbJpWZPz8GnHRjG4pRU7iy', 'pliniojose1@gmail.com', 2, '2024-04-20 00:52:28', '89999034-1', 'Actualización'),
(123456788, 2, 'plinio', 'noruega', '$2y$12$9El79WRIjfrbd3R7GqA.gOT/LlHFC8bQbJpWZPz8GnHRjG4pRU7iy', 'pliniojose1@gmail.com', 1, '2024-04-20 00:57:14', '89999034-1', 'Actualización'),
(123456788, 2, 'plinio', 'noruega', '$2y$12$9El79WRIjfrbd3R7GqA.gOT/LlHFC8bQbJpWZPz8GnHRjG4pRU7iy', 'jfcalderona16@gmail.com', 1, '2024-04-20 02:08:18', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'noruega', '$2y$12$9El79WRIjfrbd3R7GqA.gOT/LlHFC8bQbJpWZPz8GnHRjG4pRU7iy', 'jfcalderona16@gmail.com', 1, '2024-04-20 02:08:25', '89999034-1', 'Actualización'),
(1234565432, 2, 'BKKKNKNNKNKN', 'nknkknknknkn', '$2y$10$6mWv2jbUr5jGchTrLcu1cOuck/3sJ1/OzPS0b7IBaIWAMGyXgnVw6', 'nkknknkn@gmail.com', 1, '2024-04-23 17:42:49', '1234567-8', 'Actualización'),
(1234565432, 2, 'BKKKNKNNKNKN', 'nknkknknknkn', '$2y$10$6mWv2jbUr5jGchTrLcu1cOuck/3sJ1/OzPS0b7IBaIWAMGyXgnVw6', 'kjkjkjjjjjj@gmail.com', 1, '2024-04-23 17:54:38', '1234567-8', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$9El79WRIjfrbd3R7GqA.gOT/LlHFC8bQbJpWZPz8GnHRjG4pRU7iy', 'jfcalderona16@gmail.com', 1, '2024-04-23 22:02:36', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$0praf7d.jWvA/4Wm8QthhOcIqqjMA9q7FB0N/sdeLZXOwqCnNeFSS', 'jfcalderona16@gmail.com', 1, '2024-04-23 22:04:43', '89999034-1', 'Actualización'),
(123456788, 2, 'JKAJJAAJJ', 'kjajkajjak', '$2y$12$0praf7d.jWvA/4Wm8QthhOcIqqjMA9q7FB0N/sdeLZXOwqCnNeFSS', 'jfcalderona@gmail.com', 1, '2024-04-23 22:08:54', '89999034-1', 'Actualización'),
(2147483647, 2, 'gilberto', 'atuesta', '$2y$10$cBE6bpGjjuufKylhYQjvpeza0yYhdH5hAo9SDIh0KVbXnva4oPLDi', 'gilbertoatuesta@gmail.com', 2, '2024-04-23 22:09:50', '89999034-1', 'Actualización'),
(2147483647, 2, 'GILBERTO', 'aranazazu', '$2y$10$cBE6bpGjjuufKylhYQjvpeza0yYhdH5hAo9SDIh0KVbXnva4oPLDi', 'gilberto@gmail.com', 2, '2024-04-23 22:11:50', '89999034-1', 'Actualización'),
(2147483647, 2, 'GILBERTO', 'aranazazu', '$2y$10$cBE6bpGjjuufKylhYQjvpeza0yYhdH5hAo9SDIh0KVbXnva4oPLDi', 'gilberto@gmail.com', 2, '2024-04-23 22:14:06', '89999034-1', 'Actualización'),
(123456788, 2, 'JULIAN', 'calderon', '$2y$12$0praf7d.jWvA/4Wm8QthhOcIqqjMA9q7FB0N/sdeLZXOwqCnNeFSS', 'jfcalderona16@gmail.com', 1, '2024-04-23 22:31:01', '89999034-1', 'Actualización'),
(123456788, 2, 'JULIAN', 'calderon', '$2y$12$F.WTge3XIFQ5G.fpOGO8Buri3.nBJ/5usXDQVbBVjJPS73t6mfuQm', 'jfcalderona16@gmail.com', 1, '2024-04-23 22:32:04', '89999034-1', 'Actualización'),
(123456788, 2, 'JULIAN', 'calderon', '$2y$12$xDjM7fFr9M2FppDbNrdoO.8DIB3BUGgPzq6g0rY7kMbncRlI/uWEm', 'jfcalderona16@gmail.com', 1, '2024-04-23 22:33:23', '89999034-1', 'Actualización'),
(101022233, 2, 'lkalkallaklk', 'klkslklsklsk', '$2y$10$nOy4tWueIsWJ/nbHVFnjeeuiBGb1xr.qTJLD8U0dkVQ9b6Lq0eus2', 'lklslsklslk@gmail.com', 2, '2024-04-24 09:00:38', '89999034-1', 'Actualización'),
(101022233, 2, 'lkalkallaklk', 'klkslklsklsk', '$2y$10$nOy4tWueIsWJ/nbHVFnjeeuiBGb1xr.qTJLD8U0dkVQ9b6Lq0eus2', 'jfcalderona16@gmail.com', 2, '2024-04-24 09:02:14', '89999034-1', 'Actualización'),
(101022233, 2, 'lkalkallaklk', 'klkslklsklsk', '$2y$12$lVhjq5w89iYk2L.ncD.VN.77EZQwyCBQGGIhCbVq7IRFMvZc21p6O', 'jfcalderona16@gmail.com', 2, '2024-04-24 10:54:58', '89999034-1', 'Actualización'),
(1234567890, 2, 'felipe', 'calderon aguirre', '$2y$12$Wo2Hipe2aOaKaKvGG8/dXeZMjOaTNkKc/bsosCOSj9wd6oER.BlLO', 'jfcalderon62@gmai.com', 3, '2024-04-25 03:32:45', '89999034-1', 'Actualización'),
(1110456214, 2, 'yareth', 'nombreraro', '$2y$10$nRBz7qsQc8Nv4ESbxWLz/.HWpVX6938IOJtnilyOTOqjPj6scvg66', 'lklklklklklkl@gmail.com', 2, '2024-04-25 13:41:34', '89999034-1', 'Actualización'),
(1110456214, 2, 'yareth', 'nombreraro', '$2y$10$nRBz7qsQc8Nv4ESbxWLz/.HWpVX6938IOJtnilyOTOqjPj6scvg66', 'yarethl@gmail.com', 2, '2024-04-25 13:42:47', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$xDjM7fFr9M2FppDbNrdoO.8DIB3BUGgPzq6g0rY7kMbncRlI/uWEm', 'jfcalderona16@gmail.com', 1, '2024-04-28 23:26:43', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$xDjM7fFr9M2FppDbNrdoO.8DIB3BUGgPzq6g0rY7kMbncRlI/uWEm', 'jfcalderona@gmail.com', 1, '2024-04-28 23:29:44', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$q0rOmwIN4Wy5WGMhui1anuA3d04aQHVsKzueg9FuvEwnjnZ4CECEC', 'jfcalderona@gmail.com', 1, '2024-04-28 23:30:52', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$q0rOmwIN4Wy5WGMhui1anuA3d04aQHVsKzueg9FuvEwnjnZ4CECEC', 'jfcalderona16@gmail.com', 1, '2024-04-28 23:36:03', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$5ddkSuMQ4HKSgUEDn9TUjObOGE3tBnygEikX0Q71mhcOvP9p9KuOC', 'jfcalderona16@gmail.com', 1, '2024-04-30 09:06:53', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$.tyMu8b2lELs3DvbO6zl5OiiOZwQ6cpDVX6WAK7ciUHx1iiMLrEWe', 'jfcalderona16@gmail.com', 1, '2024-04-30 09:09:00', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$rRi6dHwLqFC5LvftAP81fOByG60kP6e4K7/JKdnhK1roIQCf1nqIy', 'jfcalderona16@gmail.com', 1, '2024-04-30 09:09:49', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$EmvIPuF5.ozU3y9ON7YgoOJ0LYk74tF7absyYQyGmtteMn0CC/EW.', 'jfcalderona16@gmail.com', 1, '2024-05-01 20:46:18', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$Aqa9UrPQ5Q2stdO4UjMWaeRdRhu/jv4FMEf6sP2IC5li7Ar/OABJu', 'jfcalderona16@gmail.com', 1, '2024-05-01 20:46:49', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$uhDkL8tNi/cPZNzTI04ite9QIV92hFWJAD1kqZMaEZlcIr9P8rj8O', 'jfcalderona16@gmail.com', 1, '2024-05-01 20:55:41', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$G6l9V0MxlnxEqJPYNMub9OKku6unvG0FDYRhWYezm.Q2Ma1kLljfu', 'jfcalderona16@gmail.com', 1, '2024-05-01 20:58:35', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$5ZXRpE8k0iAs/dMGBrGnmuJV1QOo3nHYuxSwC1ZoTL1wIeTXmIOV6', 'jfcalderona16@gmail.com', 1, '2024-05-01 20:59:20', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$68sIlwdLSY8nnwGfKBgwgOpUG1eicKxmoLI3rFXRqDKDMVqG.B.U.', 'jfcalderona16@gmail.com', 1, '2024-05-01 21:00:42', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$jilHcN2WxMLGjsCU3Ojpm.U5BScqjWMdKaTVzlxieAgkoQYecqZR2', 'jfcalderona16@gmail.com', 1, '2024-05-01 21:01:35', '89999034-1', 'Actualización');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` int(11) NOT NULL,
  `id_tp_docu` tinyint(4) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `codigo_barras` varchar(500) NOT NULL,
  `fecha_registro` date NOT NULL,
  `terminos` enum('si','no','','') NOT NULL,
  `id_rol` tinyint(4) NOT NULL,
  `id_esta_usu` tinyint(4) NOT NULL,
  `nit_empre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `id_tp_docu`, `nombre`, `apellido`, `contrasena`, `correo`, `codigo_barras`, `fecha_registro`, `terminos`, `id_rol`, `id_esta_usu`, `nit_empre`) VALUES
(123456788, 2, 'julian', 'calderon', '$2y$12$pbpHfAlWjsc5c0A6IdtOfeUCzRUXrrLxKFyNAqpw66arTGirK8iv2', 'jfcalderona16@gmail.com', '65f90c1b907b97430', '2024-03-18', 'si', 1, 1, '89999034-1'),
(1023456789, 2, 'fabricio', 'herrera', '$2y$10$pmFzUAo0BM5zeL3ahA6VlutADajIIQIwfs//Jdnn6VMLY3T3zP/ta', 'frabricio123@gmail.com', '6618979f00cf53229', '2024-04-11', 'si', 3, 1, '89999034-1'),
(1110456214, 2, 'ohanys', 'nombreraro', '$2y$10$nRBz7qsQc8Nv4ESbxWLz/.HWpVX6938IOJtnilyOTOqjPj6scvg66', 'yarethl@gmail.com', '662a944f17eb38813', '2024-04-25', 'si', 2, 1, '89999034-1'),
(1110546897, 2, 'cristian', 'huertas', '$2y$10$6BfeIelvDCJwFcYbHkO5/u2tjObMX/QQP5kLPciAUCvLuamB5ttti', 'huertas@gmail.com', '6631c820283849031', '2024-04-30', 'si', 2, 1, '89999034-1'),
(1110567985, 1, 'plinio', 'quintero', '$2y$10$5KqvDE3gDAJlC5eXsiA.F.foGnpe1M0VgfzmOPwd6BP3.H6sriG6i', 'plinio@gmail.com', '66335cca4492e4983', '2024-05-02', 'si', 3, 1, '89999034-1'),
(1110567986, 1, 'felipe', 'aguirre', '$2y$10$eQHe7zZ8fOoVlvIvZYoN7O1oFdpO6yiNESuVXbUSIsjE9hYp02H2e', 'aguirre@gmail.com', '6634dffbe78bb1497', '2024-05-03', 'si', 3, 1, '89999034-1'),
(1234567890, 2, 'mauricio', 'calderon ', '$2y$12$Wo2Hipe2aOaKaKvGG8/dXeZMjOaTNkKc/bsosCOSj9wd6oER.BlLO', 'jfcalderon62@gmai.com', '65f4ef9d298b15013', '2024-03-15', 'si', 3, 1, '89999034-1'),
(2147483647, 1, 'aranazau', 'jaalaal', '$2y$10$5NoPbtZ6yTpLllRk8ZLNgO0wSKcWPjYTm8sk/.gBXWqwlZG9HOqyK', 'jkakajkja@gmail.com', '6631b8ba6b3e31653', '2024-04-30', 'si', 3, 1, '89999034-1');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `actualizar_contrasena` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    DECLARE old_password VARCHAR(255);
    DECLARE count_existing_passwords INT;

    SET old_password = OLD.contrasena;
    INSERT INTO tri_contra (documento, id_tp_docu, nombre, apellido, contrasena, correo, id_rol, fecha, nit_empre, accion_usu)
    VALUES (OLD.documento, OLD.id_tp_docu, OLD.nombre, OLD.apellido, old_password, OLD.correo, OLD.id_rol, NOW(), OLD.nit_empre, 'Actualización');

    SELECT COUNT(*) INTO count_existing_passwords FROM tri_contra WHERE contrasena = NEW.contrasena;

    IF count_existing_passwords >= 5 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La nueva contraseña ya ha sido utilizada anteriormente. Por favor, escriba una nueva.';
    END IF;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD PRIMARY KEY (`id_deta_presta`),
  ADD KEY `id_presta` (`id_presta`),
  ADD KEY `codigo_barra_herra` (`codigo_barra_herra`);

--
-- Indices de la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  ADD PRIMARY KEY (`id_deta_ficha`),
  ADD KEY `documento` (`documento`),
  ADD KEY `ficha` (`ficha`);

--
-- Indices de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD PRIMARY KEY (`id_deta_reporte`),
  ADD KEY `id_reporte` (`id_reporte`),
  ADD KEY `codigo_barra_herra` (`codigo_barra_herra`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`nit_empre`);

--
-- Indices de la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `documento` (`documento`);

--
-- Indices de la tabla `estado_usu`
--
ALTER TABLE `estado_usu`
  ADD PRIMARY KEY (`id_esta_usu`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`ficha`),
  ADD KEY `id_forma` (`id_forma`),
  ADD KEY `id_jornada` (`id_jornada`);

--
-- Indices de la tabla `formacion`
--
ALTER TABLE `formacion`
  ADD PRIMARY KEY (`id_forma`);

--
-- Indices de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD PRIMARY KEY (`codigo_barra_herra`),
  ADD KEY `id_tp_herra` (`id_tp_herra`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id_jornada`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`licencia`),
  ADD KEY `nit_empre` (`nit_empre`);

--
-- Indices de la tabla `marca_herra`
--
ALTER TABLE `marca_herra`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  ADD PRIMARY KEY (`id_presta`),
  ADD KEY `documento` (`documento`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `documento` (`documento`),
  ADD KEY `id_deta_presta` (`id_deta_presta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tp_docu`
--
ALTER TABLE `tp_docu`
  ADD PRIMARY KEY (`id_tp_docu`);

--
-- Indices de la tabla `tp_herra`
--
ALTER TABLE `tp_herra`
  ADD PRIMARY KEY (`id_tp_herra`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `usuario_ibfk_1` (`id_tp_docu`),
  ADD KEY `usuario_ibfk_3` (`id_rol`),
  ADD KEY `usuario_ibfk_5` (`nit_empre`),
  ADD KEY `id_esta_usu` (`id_esta_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  MODIFY `id_deta_presta` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  MODIFY `id_deta_ficha` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  MODIFY `id_deta_reporte` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  MODIFY `id_entrada` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT de la tabla `formacion`
--
ALTER TABLE `formacion`
  MODIFY `id_forma` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marca_herra`
--
ALTER TABLE `marca_herra`
  MODIFY `id_marca` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  MODIFY `id_presta` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tp_herra`
--
ALTER TABLE `tp_herra`
  MODIFY `id_tp_herra` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD CONSTRAINT `detalle_prestamo_ibfk_2` FOREIGN KEY (`id_presta`) REFERENCES `prestamo_herra` (`id_presta`),
  ADD CONSTRAINT `detalle_prestamo_ibfk_3` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`);

--
-- Filtros para la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  ADD CONSTRAINT `deta_ficha_ibfk_2` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `deta_ficha_ibfk_3` FOREIGN KEY (`ficha`) REFERENCES `ficha` (`ficha`);

--
-- Filtros para la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD CONSTRAINT `deta_reporte_ibfk_1` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id_reporte`),
  ADD CONSTRAINT `deta_reporte_ibfk_2` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`);

--
-- Filtros para la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  ADD CONSTRAINT `entrada_usu_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`id_forma`) REFERENCES `formacion` (`id_forma`),
  ADD CONSTRAINT `ficha_ibfk_2` FOREIGN KEY (`id_jornada`) REFERENCES `jornada` (`id_jornada`);

--
-- Filtros para la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD CONSTRAINT `herramienta_ibfk_1` FOREIGN KEY (`id_tp_herra`) REFERENCES `tp_herra` (`id_tp_herra`),
  ADD CONSTRAINT `herramienta_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca_herra` (`id_marca`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`);

--
-- Filtros para la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  ADD CONSTRAINT `prestamo_herra_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `reporte_ibfk_2` FOREIGN KEY (`id_deta_presta`) REFERENCES `detalle_prestamo` (`id_deta_presta`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tp_docu`) REFERENCES `tp_docu` (`id_tp_docu`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`),
  ADD CONSTRAINT `usuario_ibfk_7` FOREIGN KEY (`id_esta_usu`) REFERENCES `estado_usu` (`id_esta_usu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
