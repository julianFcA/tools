-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2024 a las 01:14:42
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
  `id_deta_presta` int(4) NOT NULL,
  `cant_herra` tinyint(4) NOT NULL,
  `codigo_barra_herra` varchar(500) NOT NULL,
  `id_presta` int(4) NOT NULL,
  `estado_presta` enum('prestado','incompleto','devuelto','reportado','tarde','bloqueado','reportado una parte') NOT NULL,
  `cant_devolucion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_ficha`
--

CREATE TABLE `deta_ficha` (
  `id_deta_ficha` tinyint(4) NOT NULL,
  `ficha` int(7) NOT NULL,
  `documento` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deta_reporte`
--

CREATE TABLE `deta_reporte` (
  `id_deta_reporte` int(4) NOT NULL,
  `id_reporte` int(4) NOT NULL,
  `codigo_barra_herra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nit_empre` varchar(12) NOT NULL,
  `nom_empre` text NOT NULL,
  `direcc_empre` varchar(30) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `correo_empre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit_empre`, `nom_empre`, `direcc_empre`, `telefono`, `correo_empre`) VALUES
('899999034-1', 'sena centro de aprendizaje', '141- Sector, Cra. 45 Sur #1255', '2709600', '   servicioalciudadano@sena.edu.co');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_usu`
--

CREATE TABLE `entrada_usu` (
  `id_entrada` int(5) NOT NULL,
  `fecha_entrada` datetime NOT NULL,
  `documento` bigint(11) NOT NULL
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
  `nom_forma` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL
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
  `esta_herra` enum('disponible','prestado','dañado','') NOT NULL,
  `nit_empre` varchar(12) NOT NULL
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
  `nit_empre` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`licencia`, `esta_licen`, `fecha_ini`, `fecha_fin`, `nit_empre`) VALUES
('6645f34e2fca6', 'activo', '2024-05-16', '2025-05-16', '899999034-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_herra`
--

CREATE TABLE `marca_herra` (
  `id_marca` tinyint(4) NOT NULL,
  `nom_marca` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo_herra`
--

CREATE TABLE `prestamo_herra` (
  `id_presta` int(4) NOT NULL,
  `fecha_adqui` date NOT NULL,
  `dias` tinyint(4) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `documento` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(4) NOT NULL,
  `descripcion` text NOT NULL,
  `id_deta_presta` int(4) NOT NULL,
  `documento` bigint(11) NOT NULL,
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
  `nom_tp_herra` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL
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
  `fecha` datetime NOT NULL,
  `nit_empre` varchar(10) NOT NULL,
  `accion_usu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` bigint(11) NOT NULL,
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
  `nit_empre` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `id_tp_docu`, `nombre`, `apellido`, `contrasena`, `correo`, `codigo_barras`, `fecha_registro`, `terminos`, `id_rol`, `id_esta_usu`, `nit_empre`) VALUES
(28741078, 2, 'cesar', 'esquivel', '$2y$10$jbUGbmVjvExaWEvuBNKkM.GC28J3uTtUX1UhKcDlrFEiZ.T48ThPm', 'calderon@gmail.com', '66470677148bf9889', '2024-05-17', 'si', 1, 1, '899999034-1'),
(111056789, 2, 'lesley', 'aguirre', '$2y$10$1fp5c024QEmidZVTAhC03uzXsMXbXvyc0Ncr4wHblEC1lDQTV6mcm', 'aguirre@gmail.com', '664cc9d97f9bc1914', '2024-05-21', 'si', 3, 1, '899999034-1'),
(111056879, 1, 'angel', 'rico', '$2y$10$3MEEYlooDXAf7Hubce4teuTJMexf2gvPmtObns2Jj/A3dwtdLGQAy', 'rico@gmail.com', '664d032e3e9a98910', '2024-05-21', 'si', 3, 1, '899999034-1'),
(1110567984, 2, 'ana', 'cano', '$2y$10$AEQ/s8mTGmc9wJUFcy/pW.nzYJ6pzbMWbi0jreKgsmWbomh5mhQjO', 'cano@gmail.com', '664d02e34b43c1454', '2024-05-21', 'si', 2, 1, '899999034-1'),
(1110567986, 2, 'julian', 'calderon', '$2y$10$Vxey6kTqSeaj/tpx.5xiWOhkxS3BwxtUm4onkQk/ujFgAjVcEnQhq', 'jfcalderona16@gmail.com', '664cc9902085a5229', '2024-05-21', 'si', 2, 1, '899999034-1');

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `actualizar_contrasena` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    DECLARE old_password VARCHAR(255);
    DECLARE count_existing_passwords INT;

    SET old_password = OLD.contrasena;
    INSERT INTO tri_contra (documento, id_tp_docu, nombre, apellido, contrasena, fecha, nit_empre, accion_usu)
    VALUES (OLD.documento, OLD.id_tp_docu, OLD.nombre, OLD.apellido, old_password,  NOW(), OLD.nit_empre, 'Actualización');

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
  ADD KEY `codigo_barra_herra` (`codigo_barra_herra`),
  ADD KEY `id_presta` (`id_presta`);

--
-- Indices de la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  ADD PRIMARY KEY (`id_deta_ficha`),
  ADD KEY `ficha` (`ficha`),
  ADD KEY `documento` (`documento`);

--
-- Indices de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD PRIMARY KEY (`id_deta_reporte`),
  ADD KEY `codigo_barra_herra` (`codigo_barra_herra`),
  ADD KEY `id_reporte` (`id_reporte`);

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
  ADD KEY `id_marca` (`id_marca`),
  ADD KEY `nit_empre` (`nit_empre`);

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
  ADD KEY `id_esta_usu` (`id_esta_usu`),
  ADD KEY `nit_empre` (`nit_empre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  MODIFY `id_deta_presta` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  MODIFY `id_deta_ficha` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  MODIFY `id_deta_reporte` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `entrada_usu`
--
ALTER TABLE `entrada_usu`
  MODIFY `id_entrada` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT de la tabla `formacion`
--
ALTER TABLE `formacion`
  MODIFY `id_forma` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marca_herra`
--
ALTER TABLE `marca_herra`
  MODIFY `id_marca` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `prestamo_herra`
--
ALTER TABLE `prestamo_herra`
  MODIFY `id_presta` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tp_herra`
--
ALTER TABLE `tp_herra`
  MODIFY `id_tp_herra` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD CONSTRAINT `detalle_prestamo_ibfk_3` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`),
  ADD CONSTRAINT `detalle_prestamo_ibfk_4` FOREIGN KEY (`id_presta`) REFERENCES `prestamo_herra` (`id_presta`);

--
-- Filtros para la tabla `deta_ficha`
--
ALTER TABLE `deta_ficha`
  ADD CONSTRAINT `deta_ficha_ibfk_3` FOREIGN KEY (`ficha`) REFERENCES `ficha` (`ficha`),
  ADD CONSTRAINT `deta_ficha_ibfk_4` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`);

--
-- Filtros para la tabla `deta_reporte`
--
ALTER TABLE `deta_reporte`
  ADD CONSTRAINT `deta_reporte_ibfk_2` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`),
  ADD CONSTRAINT `deta_reporte_ibfk_3` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id_reporte`);

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
  ADD CONSTRAINT `herramienta_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca_herra` (`id_marca`),
  ADD CONSTRAINT `herramienta_ibfk_3` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`);

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
  ADD CONSTRAINT `reporte_ibfk_3` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `reporte_ibfk_4` FOREIGN KEY (`id_deta_presta`) REFERENCES `detalle_prestamo` (`id_deta_presta`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tp_docu`) REFERENCES `tp_docu` (`id_tp_docu`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `usuario_ibfk_7` FOREIGN KEY (`id_esta_usu`) REFERENCES `estado_usu` (`id_esta_usu`),
  ADD CONSTRAINT `usuario_ibfk_8` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
