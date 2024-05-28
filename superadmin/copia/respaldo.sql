-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: herramientas
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `deta_ficha`
--

DROP TABLE IF EXISTS `deta_ficha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deta_ficha` (
  `id_deta_ficha` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ficha` int(7) NOT NULL,
  `documento` bigint(11) NOT NULL,
  PRIMARY KEY (`id_deta_ficha`),
  KEY `ficha` (`ficha`),
  KEY `documento` (`documento`),
  CONSTRAINT `deta_ficha_ibfk_3` FOREIGN KEY (`ficha`) REFERENCES `ficha` (`ficha`),
  CONSTRAINT `deta_ficha_ibfk_4` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deta_ficha`
--

LOCK TABLES `deta_ficha` WRITE;
/*!40000 ALTER TABLE `deta_ficha` DISABLE KEYS */;
/*!40000 ALTER TABLE `deta_ficha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deta_reporte`
--

DROP TABLE IF EXISTS `deta_reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deta_reporte` (
  `id_deta_reporte` int(4) NOT NULL AUTO_INCREMENT,
  `id_reporte` int(4) NOT NULL,
  `codigo_barra_herra` varchar(255) NOT NULL,
  PRIMARY KEY (`id_deta_reporte`),
  KEY `codigo_barra_herra` (`codigo_barra_herra`),
  KEY `id_reporte` (`id_reporte`),
  CONSTRAINT `deta_reporte_ibfk_2` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`),
  CONSTRAINT `deta_reporte_ibfk_3` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id_reporte`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deta_reporte`
--

LOCK TABLES `deta_reporte` WRITE;
/*!40000 ALTER TABLE `deta_reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `deta_reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_prestamo`
--

DROP TABLE IF EXISTS `detalle_prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_prestamo` (
  `id_deta_presta` int(4) NOT NULL AUTO_INCREMENT,
  `cant_herra` tinyint(4) NOT NULL,
  `codigo_barra_herra` varchar(500) NOT NULL,
  `id_presta` int(4) NOT NULL,
  `estado_presta` enum('prestado','incompleto','devuelto','reportado','tarde','bloqueado','reportado una parte') NOT NULL,
  `cant_devolucion` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_deta_presta`),
  KEY `codigo_barra_herra` (`codigo_barra_herra`),
  KEY `id_presta` (`id_presta`),
  CONSTRAINT `detalle_prestamo_ibfk_3` FOREIGN KEY (`codigo_barra_herra`) REFERENCES `herramienta` (`codigo_barra_herra`),
  CONSTRAINT `detalle_prestamo_ibfk_4` FOREIGN KEY (`id_presta`) REFERENCES `prestamo_herra` (`id_presta`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_prestamo`
--

LOCK TABLES `detalle_prestamo` WRITE;
/*!40000 ALTER TABLE `detalle_prestamo` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_prestamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `nit_empre` varchar(12) NOT NULL,
  `nom_empre` text NOT NULL,
  `direcc_empre` varchar(30) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `correo_empre` varchar(50) NOT NULL,
  PRIMARY KEY (`nit_empre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES ('899999034-1','sena centro de aprendizaje','141- Sector, Cra. 45 Sur #1255','2709600','servicioalciudadano@sena.edu.co');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrada_usu`
--

DROP TABLE IF EXISTS `entrada_usu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrada_usu` (
  `id_entrada` int(5) NOT NULL AUTO_INCREMENT,
  `fecha_entrada` datetime NOT NULL,
  `documento` bigint(11) NOT NULL,
  PRIMARY KEY (`id_entrada`),
  KEY `documento` (`documento`),
  CONSTRAINT `entrada_usu_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=467 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrada_usu`
--

LOCK TABLES `entrada_usu` WRITE;
/*!40000 ALTER TABLE `entrada_usu` DISABLE KEYS */;
/*!40000 ALTER TABLE `entrada_usu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_usu`
--

DROP TABLE IF EXISTS `estado_usu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado_usu` (
  `id_esta_usu` tinyint(4) NOT NULL,
  `nom_esta` text NOT NULL,
  PRIMARY KEY (`id_esta_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_usu`
--

LOCK TABLES `estado_usu` WRITE;
/*!40000 ALTER TABLE `estado_usu` DISABLE KEYS */;
INSERT INTO `estado_usu` VALUES (1,'activo'),(2,'inactivo');
/*!40000 ALTER TABLE `estado_usu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ficha`
--

DROP TABLE IF EXISTS `ficha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ficha` (
  `ficha` int(7) NOT NULL,
  `id_forma` tinyint(4) NOT NULL,
  `id_jornada` tinyint(4) NOT NULL,
  PRIMARY KEY (`ficha`),
  KEY `id_forma` (`id_forma`),
  KEY `id_jornada` (`id_jornada`),
  CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`id_forma`) REFERENCES `formacion` (`id_forma`),
  CONSTRAINT `ficha_ibfk_2` FOREIGN KEY (`id_jornada`) REFERENCES `jornada` (`id_jornada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ficha`
--

LOCK TABLES `ficha` WRITE;
/*!40000 ALTER TABLE `ficha` DISABLE KEYS */;
/*!40000 ALTER TABLE `ficha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formacion`
--

DROP TABLE IF EXISTS `formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formacion` (
  `id_forma` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom_forma` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`id_forma`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formacion`
--

LOCK TABLES `formacion` WRITE;
/*!40000 ALTER TABLE `formacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `herramienta`
--

DROP TABLE IF EXISTS `herramienta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `herramienta` (
  `codigo_barra_herra` varchar(500) NOT NULL,
  `id_tp_herra` tinyint(4) NOT NULL,
  `nombre_herra` varchar(20) NOT NULL,
  `id_marca` tinyint(4) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `esta_herra` enum('disponible','prestado','dañado','') NOT NULL,
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`codigo_barra_herra`),
  KEY `id_tp_herra` (`id_tp_herra`),
  KEY `id_marca` (`id_marca`),
  KEY `nit_empre` (`nit_empre`),
  CONSTRAINT `herramienta_ibfk_1` FOREIGN KEY (`id_tp_herra`) REFERENCES `tp_herra` (`id_tp_herra`),
  CONSTRAINT `herramienta_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca_herra` (`id_marca`),
  CONSTRAINT `herramienta_ibfk_3` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `herramienta`
--

LOCK TABLES `herramienta` WRITE;
/*!40000 ALTER TABLE `herramienta` DISABLE KEYS */;
/*!40000 ALTER TABLE `herramienta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jornada`
--

DROP TABLE IF EXISTS `jornada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jornada` (
  `id_jornada` tinyint(4) NOT NULL AUTO_INCREMENT,
  `tp_jornada` text NOT NULL,
  PRIMARY KEY (`id_jornada`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jornada`
--

LOCK TABLES `jornada` WRITE;
/*!40000 ALTER TABLE `jornada` DISABLE KEYS */;
INSERT INTO `jornada` VALUES (1,'mañana'),(2,'tarde'),(3,'noche'),(4,'madrugada');
/*!40000 ALTER TABLE `jornada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licencia`
--

DROP TABLE IF EXISTS `licencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licencia` (
  `licencia` varchar(25) NOT NULL,
  `esta_licen` enum('activo','inactivo','','') NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`licencia`),
  KEY `nit_empre` (`nit_empre`),
  CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licencia`
--

LOCK TABLES `licencia` WRITE;
/*!40000 ALTER TABLE `licencia` DISABLE KEYS */;
INSERT INTO `licencia` VALUES ('6645f34e2fca6','activo','2024-05-16','2025-05-16','899999034-1');
/*!40000 ALTER TABLE `licencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca_herra`
--

DROP TABLE IF EXISTS `marca_herra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca_herra` (
  `id_marca` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom_marca` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca_herra`
--

LOCK TABLES `marca_herra` WRITE;
/*!40000 ALTER TABLE `marca_herra` DISABLE KEYS */;
/*!40000 ALTER TABLE `marca_herra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prestamo_herra`
--

DROP TABLE IF EXISTS `prestamo_herra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamo_herra` (
  `id_presta` int(4) NOT NULL AUTO_INCREMENT,
  `fecha_adqui` date NOT NULL,
  `dias` tinyint(4) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `documento` bigint(11) NOT NULL,
  PRIMARY KEY (`id_presta`),
  KEY `documento` (`documento`),
  CONSTRAINT `prestamo_herra_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prestamo_herra`
--

LOCK TABLES `prestamo_herra` WRITE;
/*!40000 ALTER TABLE `prestamo_herra` DISABLE KEYS */;
/*!40000 ALTER TABLE `prestamo_herra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte` (
  `id_reporte` int(4) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `id_deta_presta` int(4) NOT NULL,
  `documento` bigint(11) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_reporte`),
  KEY `documento` (`documento`),
  KEY `id_deta_presta` (`id_deta_presta`),
  CONSTRAINT `reporte_ibfk_3` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`),
  CONSTRAINT `reporte_ibfk_4` FOREIGN KEY (`id_deta_presta`) REFERENCES `detalle_prestamo` (`id_deta_presta`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `id_rol` tinyint(4) NOT NULL,
  `nom_rol` text NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Administrador'),(2,'Instructor'),(3,'Aprendiz');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tp_docu`
--

DROP TABLE IF EXISTS `tp_docu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_docu` (
  `id_tp_docu` tinyint(4) NOT NULL,
  `nom_tp_docu` text NOT NULL,
  PRIMARY KEY (`id_tp_docu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tp_docu`
--

LOCK TABLES `tp_docu` WRITE;
/*!40000 ALTER TABLE `tp_docu` DISABLE KEYS */;
INSERT INTO `tp_docu` VALUES (1,'tarjeta identidad'),(2,'cedula ciudadanía'),(3,'cedula extranjeria');
/*!40000 ALTER TABLE `tp_docu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tp_herra`
--

DROP TABLE IF EXISTS `tp_herra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_herra` (
  `id_tp_herra` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom_tp_herra` text NOT NULL,
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`id_tp_herra`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tp_herra`
--

LOCK TABLES `tp_herra` WRITE;
/*!40000 ALTER TABLE `tp_herra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tp_herra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tri_contra`
--

DROP TABLE IF EXISTS `tri_contra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tri_contra`
--

LOCK TABLES `tri_contra` WRITE;
/*!40000 ALTER TABLE `tri_contra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tri_contra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `nit_empre` varchar(12) NOT NULL,
  PRIMARY KEY (`documento`),
  KEY `usuario_ibfk_1` (`id_tp_docu`),
  KEY `usuario_ibfk_3` (`id_rol`),
  KEY `id_esta_usu` (`id_esta_usu`),
  KEY `nit_empre` (`nit_empre`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tp_docu`) REFERENCES `tp_docu` (`id_tp_docu`),
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  CONSTRAINT `usuario_ibfk_7` FOREIGN KEY (`id_esta_usu`) REFERENCES `estado_usu` (`id_esta_usu`),
  CONSTRAINT `usuario_ibfk_8` FOREIGN KEY (`nit_empre`) REFERENCES `empresa` (`nit_empre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (28741078,2,'cesar','esquivel','$2y$10$jbUGbmVjvExaWEvuBNKkM.GC28J3uTtUX1UhKcDlrFEiZ.T48ThPm','calderon@gmail.com','66470677148bf9889','2024-05-17','si',1,1,'899999034-1'),(1110567986,2,'julian','calderon','$2y$10$J1c0gza0VgWgr8YHCVdGJuZlzhhgqg/GHvyyOm.YvWhSRva7N1ie6','julian6@gmail.com','665556496f2f61471','2024-05-27','si',1,1,'899999034-1');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `actualizar_contrasena` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    DECLARE old_password VARCHAR(255);
    DECLARE count_existing_passwords INT;

    SET old_password = OLD.contrasena;
    INSERT INTO tri_contra (documento, id_tp_docu, nombre, apellido, contrasena, fecha, nit_empre, accion_usu)
    VALUES (OLD.documento, OLD.id_tp_docu, OLD.nombre, OLD.apellido, old_password,  NOW(), OLD.nit_empre, 'Actualización');

    SELECT COUNT(*) INTO count_existing_passwords FROM tri_contra WHERE contrasena = NEW.contrasena;

    IF count_existing_passwords >= 5 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La nueva contraseña ya ha sido utilizada anteriormente. Por favor, escriba una nueva.';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-27 23:57:16
