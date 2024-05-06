-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2024 a las 09:09:00
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_ficha`
--

CREATE TABLE `deta_ficha` (
  `id_deta_ficha` tinyint(4) NOT NULL,
  `ficha` int(7) NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_reporte`
--

CREATE TABLE `deta_reporte` (
  `id_deta_reporte` tinyint(4) NOT NULL,
  `id_reporte` tinyint(4) NOT NULL,
  `codigo_barra_herra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_usu`
--

CREATE TABLE `entrada_usu` (
  `id_entrada` int(5) NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion`
--

CREATE TABLE `formacion` (
  `id_forma` tinyint(4) NOT NULL,
  `nom_forma` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_herra`
--

CREATE TABLE `marca_herra` (
  `id_marca` tinyint(4) NOT NULL,
  `nom_marca` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` tinyint(4) NOT NULL,
  `descripcion` text NOT NULL,
  `id_deta_presta` tinyint(4) NOT NULL,
  `documento` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(123456788, 2, 'julian', 'calderon', '$2y$12$jilHcN2WxMLGjsCU3Ojpm.U5BScqjWMdKaTVzlxieAgkoQYecqZR2', 'jfcalderona16@gmail.com', 1, '2024-05-01 21:01:35', '89999034-1', 'Actualización'),
(123456788, 2, 'julian', 'calderon', '$2y$12$pbpHfAlWjsc5c0A6IdtOfeUCzRUXrrLxKFyNAqpw66arTGirK8iv2', 'jfcalderona16@gmail.com', 1, '2024-05-05 12:55:33', '89999034-1', 'Actualización'),
(1110567986, 1, 'felipe', 'aguirre', '$2y$10$eQHe7zZ8fOoVlvIvZYoN7O1oFdpO6yiNESuVXbUSIsjE9hYp02H2e', 'aguirre@gmail.com', 3, '2024-05-05 15:06:01', '89999034-1', 'Actualización'),
(1110567986, 1, 'felipe', 'aguirre', '$2y$10$eQHe7zZ8fOoVlvIvZYoN7O1oFdpO6yiNESuVXbUSIsjE9hYp02H2e', 'aguirre@gmail.com', 3, '2024-05-05 15:07:08', '89999034-1', 'Actualización'),
(1110567986, 1, 'felipe', 'aguirre', '$2y$10$eQHe7zZ8fOoVlvIvZYoN7O1oFdpO6yiNESuVXbUSIsjE9hYp02H2e', 'aguirre@gmail.com', 3, '2024-05-05 15:10:21', '89999034-1', 'Actualización'),
(1110567986, 1, 'felipe', 'aguirre', '$2y$10$nRBz7qsQc8Nv4ESbxWLz/.HWpVX6938IOJtnilyOTOqjPj6scvg66', 'aguirre@gmail.com', 3, '2024-05-05 15:27:11', '89999034-1', 'Actualización'),
(1234567890, 2, 'mauricio', 'calderon ', '$2y$12$Wo2Hipe2aOaKaKvGG8/dXeZMjOaTNkKc/bsosCOSj9wd6oER.BlLO', 'jfcalderon62@gmai.com', 3, '2024-05-06 01:44:59', '89999034-1', 'Actualización'),
(1234567890, 2, 'mauricio', 'calderon ', '$2y$12$Wo2Hipe2aOaKaKvGG8/dXeZMjOaTNkKc/bsosCOSj9wd6oER.BlLO', 'jfcalderon62@gmai.com', 3, '2024-05-06 01:45:43', '89999034-1', 'Actualización');

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
  MODIFY `id_deta_presta` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  MODIFY `id_deta_ficha` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  MODIFY `id_deta_reporte` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  MODIFY `id_entrada` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

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
  MODIFY `id_presta` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
