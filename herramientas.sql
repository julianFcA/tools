-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-03-2024 a las 20:28:28
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
  `id_herra` tinyint(4) NOT NULL,
  `id_presta` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_reporte`
--

CREATE TABLE `deta_reporte` (
  `id_deta_reporte` tinyint(4) NOT NULL,
  `id_reporte` tinyint(4) NOT NULL,
  `id_esta_herra` tinyint(4) NOT NULL
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
  `correo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit_empre`, `nom_empre`, `direcc_empre`, `telefono`, `correo`) VALUES
('0', 'no_aplica', 'no_aplica', '0', 'no_aplica'),
('89999034-1', 'sena', 'Calle 57 No. 8-69, Bogotá D.C.', '5461500', 'notificacionesjudiciales@sena.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_usu`
--

CREATE TABLE `entrada_usu` (
  `id_entrada` tinyint(4) NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_herra`
--

CREATE TABLE `estado_herra` (
  `id_esta_herra` tinyint(4) NOT NULL,
  `nom_esta_herra` text NOT NULL
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
(0, 'no_aplica'),
(1, 'alturas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta`
--

CREATE TABLE `herramienta` (
  `id_herra` tinyint(4) NOT NULL,
  `id_tp_herra` tinyint(4) NOT NULL,
  `nombre_herra` text NOT NULL,
  `marca` text NOT NULL,
  `descripcion` text NOT NULL,
  `codigo_barra_herra` varchar(500) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('65e2190b8913a', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21953c0b20', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21a1911d6c', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21a6a9a7c8', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21ae2ce620', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21bf4f2f70', '', '2024-03-01', '2026-03-01', '89999034-1'),
('65e21c475cc7d', '', '2024-03-01', '2026-03-01', '89999034-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo_herra`
--

CREATE TABLE `prestamo_herra` (
  `id_presta` tinyint(4) NOT NULL,
  `fecha_adqui` datetime NOT NULL,
  `dias` tinyint(4) NOT NULL,
  `id_entrada_presta` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` tinyint(4) NOT NULL,
  `descripcion` text NOT NULL,
  `id_deta_presta` tinyint(4) NOT NULL,
  `documento` int(11) NOT NULL
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
(1, 'superadministrador'),
(2, 'administrador'),
(3, 'instructor'),
(4, 'aprendiz');

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
  `id_forma` tinyint(4) NOT NULL,
  `ficha` int(8) NOT NULL,
  `id_rol` tinyint(4) NOT NULL,
  `nit_empre` varchar(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `accion_usu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_forma` tinyint(4) NOT NULL,
  `ficha` int(8) NOT NULL,
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

INSERT INTO `usuario` (`documento`, `id_tp_docu`, `nombre`, `apellido`, `contrasena`, `correo`, `id_forma`, `ficha`, `codigo_barras`, `fecha_registro`, `terminos`, `id_rol`, `id_esta_usu`, `nit_empre`) VALUES
(1110567986, 2, 'julian', 'calderon', '$2y$12$Xq96wrjW89QAMdSiOQ6YfuvVrCHXIYMyulPB1wq/49y4Ohd4VBd72', 'jfcalderona16@gmail.com', 0, 0, '0', '2024-02-26', 'si', 1, 1, '0');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `tri_contrasena` BEFORE DELETE ON `usuario` FOR EACH ROW INSERT INTO tri_contra (documento, id_tp_docu, nombre, apellido, contrasena, correo, id_forma, ficha, id_rol, nit_empre, fecha, accion_usu) VALUES (OLD.documento, OLD.id_tp_docu, OLD.nombre, OLD.apellido, OLD.contrasena, OLD.correo, OLD.id_forma, OLD.ficha, OLD.id_rol, OLD.nit_empre, NOW(), CURRENT_USER())
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
  ADD KEY `id_herra` (`id_herra`),
  ADD KEY `id_presta` (`id_presta`);

--
-- Indices de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD PRIMARY KEY (`id_deta_reporte`),
  ADD KEY `id_reporte` (`id_reporte`),
  ADD KEY `id_esta_herra` (`id_esta_herra`);

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
-- Indices de la tabla `estado_herra`
--
ALTER TABLE `estado_herra`
  ADD PRIMARY KEY (`id_esta_herra`);

--
-- Indices de la tabla `estado_usu`
--
ALTER TABLE `estado_usu`
  ADD PRIMARY KEY (`id_esta_usu`);

--
-- Indices de la tabla `formacion`
--
ALTER TABLE `formacion`
  ADD PRIMARY KEY (`id_forma`);

--
-- Indices de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD PRIMARY KEY (`id_herra`),
  ADD KEY `id_tp_herra` (`id_tp_herra`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`licencia`),
  ADD KEY `nit_empre` (`nit_empre`);

--
-- Indices de la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  ADD PRIMARY KEY (`id_presta`),
  ADD KEY `id_entrada_presta` (`id_entrada_presta`);

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
  ADD KEY `id_tp_docu` (`id_tp_docu`),
  ADD KEY `id_forma` (`id_forma`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_esta_usu` (`id_esta_usu`),
  ADD KEY `nit_empre` (`nit_empre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  MODIFY `id_deta_presta` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  MODIFY `id_deta_reporte` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD CONSTRAINT `detalle_prestamo_ibfk_1` FOREIGN KEY (`id_herra`) REFERENCES `herramienta` (`id_herra`),
  ADD CONSTRAINT `detalle_prestamo_ibfk_2` FOREIGN KEY (`id_presta`) REFERENCES `prestamo_herra` (`id_presta`);

--
-- Filtros para la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD CONSTRAINT `deta_reporte_ibfk_1` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id_reporte`),
  ADD CONSTRAINT `deta_reporte_ibfk_2` FOREIGN KEY (`id_esta_herra`) REFERENCES `estado_herra` (`id_esta_herra`);

--
-- Filtros para la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  ADD CONSTRAINT `entrada_usu_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD CONSTRAINT `herramienta_ibfk_1` FOREIGN KEY (`id_tp_herra`) REFERENCES `tp_herra` (`id_tp_herra`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`);

--
-- Filtros para la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  ADD CONSTRAINT `prestamo_herra_ibfk_1` FOREIGN KEY (`id_entrada_presta`) REFERENCES `entrada_usu` (`id_entrada`);

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
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_forma`) REFERENCES `formacion` (`id_forma`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`id_esta_usu`) REFERENCES `estado_usu` (`id_esta_usu`),
  ADD CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
