-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: renovandolaweb.com    Database: renovand_abogados
-- ------------------------------------------------------
-- Server version	5.5.42-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abonos`
--

DROP TABLE IF EXISTS `abonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abonos` (
  `idAbono` int(11) NOT NULL AUTO_INCREMENT,
  `idRegistro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` float NOT NULL,
  PRIMARY KEY (`idAbono`),
  KEY `fk_Abonos_registro1_idx` (`idRegistro`),
  CONSTRAINT `fk_Abonos_registro1` FOREIGN KEY (`idRegistro`) REFERENCES `registro` (`idRegistro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cat_pendientes`
--

DROP TABLE IF EXISTS `cat_pendientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_pendientes` (
  `idpendiente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idpendiente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `domicilio` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `ciudad` varchar(45) DEFAULT NULL,
  `CP` varchar(10) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `fecha_Nacimiento` date DEFAULT NULL,
  `fechaAlta` date DEFAULT NULL,
  `CURP` varchar(20) DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `correos`
--

DROP TABLE IF EXISTS `correos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `correos` (
  `idcorreo` int(11) NOT NULL AUTO_INCREMENT,
  `idcliente` int(11) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cuerpo` varchar(3000) DEFAULT NULL,
  `destinatario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcorreo`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `diligencias`
--

DROP TABLE IF EXISTS `diligencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diligencias` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `hora` varchar(10) NOT NULL,
  `lugar` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_diligencias_usuarios1_idx` (`idUsuario`),
  CONSTRAINT `fk_diligencias_usuarios1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `etapaProcesal`
--

DROP TABLE IF EXISTS `etapaProcesal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etapaProcesal` (
  `idetapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  PRIMARY KEY (`idetapa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `juzgado_materia`
--

DROP TABLE IF EXISTS `juzgado_materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `juzgado_materia` (
  `idjuzgado` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  PRIMARY KEY (`idjuzgado`,`idmateria`),
  KEY `fk_juzgados_has_materia_materia1_idx` (`idmateria`),
  KEY `fk_juzgados_has_materia_juzgados1_idx` (`idjuzgado`),
  CONSTRAINT `fk_juzgados_has_materia_juzgados1` FOREIGN KEY (`idjuzgado`) REFERENCES `juzgados` (`idjuzgado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_juzgados_has_materia_materia1` FOREIGN KEY (`idmateria`) REFERENCES `materia` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `juzgados`
--

DROP TABLE IF EXISTS `juzgados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `juzgados` (
  `idjuzgado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `municipio` int(11) NOT NULL,
  PRIMARY KEY (`idjuzgado`),
  KEY `fk_juzgados_municipios1_idx` (`municipio`),
  CONSTRAINT `fk_juzgados_municipios1` FOREIGN KEY (`municipio`) REFERENCES `municipios` (`idmunicipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `materia`
--

DROP TABLE IF EXISTS `materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materia` (
  `idMateria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idMateria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mes`
--

DROP TABLE IF EXISTS `mes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mes` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `municipios`
--

DROP TABLE IF EXISTS `municipios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipios` (
  `idmunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idmunicipio`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificacion` (
  `idnotificacion` int(11) NOT NULL AUTO_INCREMENT,
  `idReceptor` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `idEmisor` int(11) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idnotificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pendientes`
--

DROP TABLE IF EXISTS `pendientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pendientes` (
  `idpendiente` int(11) NOT NULL AUTO_INCREMENT,
  `hora` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `id_cat_pendiente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idpendiente`),
  KEY `fk_pendientes_cat_pendientes1_idx` (`id_cat_pendiente`),
  KEY `fk_pendientes_usuarios1_idx` (`id_usuario`),
  CONSTRAINT `fk_pendientes_cat_pendientes1` FOREIGN KEY (`id_cat_pendiente`) REFERENCES `cat_pendientes` (`idpendiente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pendientes_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `personalJuridico`
--

DROP TABLE IF EXISTS `personalJuridico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personalJuridico` (
  `idPersonal` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `tipoPersonal` tinyint(1) NOT NULL,
  `idJuzgado` int(11) NOT NULL,
  PRIMARY KEY (`idPersonal`),
  KEY `fk_personalJuridico_juzgados1_idx` (`idJuzgado`),
  CONSTRAINT `fk_personalJuridico_juzgados1` FOREIGN KEY (`idJuzgado`) REFERENCES `juzgados` (`idjuzgado`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registro`
--

DROP TABLE IF EXISTS `registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro` (
  `idRegistro` int(11) NOT NULL AUTO_INCREMENT,
  `expediente` varchar(45) DEFAULT NULL,
  `juicio` varchar(45) DEFAULT NULL,
  `via` int(11) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `activo` tinyint(4) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `id_materia` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estadoProcesal` int(11) NOT NULL,
  `idJuez` int(11) DEFAULT NULL,
  `idSecretarioCausas` int(11) DEFAULT NULL,
  `idJuzgado` int(11) NOT NULL,
  PRIMARY KEY (`idRegistro`),
  KEY `fk_registro_materia_idx` (`id_materia`),
  KEY `fk_registro_clientes1_idx` (`id_cliente`),
  KEY `fk_registro_usuarios1_idx` (`id_usuario`),
  KEY `fk_registro_estadoProcesal1_idx` (`id_estadoProcesal`),
  KEY `fk_registro_personalJuridico1_idx` (`idJuez`),
  KEY `fk_registro_personalJuridico2_idx` (`idSecretarioCausas`),
  KEY `fk_registro_juzgados1_idx` (`idJuzgado`),
  CONSTRAINT `fk_registro_clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_etapa` FOREIGN KEY (`id_estadoProcesal`) REFERENCES `etapaProcesal` (`idetapa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_juzgados1` FOREIGN KEY (`idJuzgado`) REFERENCES `juzgados` (`idjuzgado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`idMateria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_personalJuridico1` FOREIGN KEY (`idJuez`) REFERENCES `personalJuridico` (`idPersonal`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_personalJuridico2` FOREIGN KEY (`idSecretarioCausas`) REFERENCES `personalJuridico` (`idPersonal`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `v_PersonalJuridico`
--

DROP TABLE IF EXISTS `v_PersonalJuridico`;
/*!50001 DROP VIEW IF EXISTS `v_PersonalJuridico`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_PersonalJuridico` AS SELECT 
 1 AS `nombre`,
 1 AS `idPersonal`,
 1 AS `tipoPersonal`,
 1 AS `juzgado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_abonos`
--

DROP TABLE IF EXISTS `v_abonos`;
/*!50001 DROP VIEW IF EXISTS `v_abonos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_abonos` AS SELECT 
 1 AS `idRegistro`,
 1 AS `expediente`,
 1 AS `nombre`,
 1 AS `total`,
 1 AS `deuda`,
 1 AS `abonado`,
 1 AS `estado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_getPendientes`
--

DROP TABLE IF EXISTS `v_getPendientes`;
/*!50001 DROP VIEW IF EXISTS `v_getPendientes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_getPendientes` AS SELECT 
 1 AS `idpendiente`,
 1 AS `hora`,
 1 AS `fecha`,
 1 AS `lugar`,
 1 AS `fecha_formato`,
 1 AS `nombre`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_juzgadoMateria`
--

DROP TABLE IF EXISTS `v_juzgadoMateria`;
/*!50001 DROP VIEW IF EXISTS `v_juzgadoMateria`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_juzgadoMateria` AS SELECT 
 1 AS `idjuzgado`,
 1 AS `Juzgado`,
 1 AS `idMateria`,
 1 AS `materia`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_juzgado_materia`
--

DROP TABLE IF EXISTS `v_juzgado_materia`;
/*!50001 DROP VIEW IF EXISTS `v_juzgado_materia`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_juzgado_materia` AS SELECT 
 1 AS `nombre`,
 1 AS `idjuzgado`,
 1 AS `idMateria`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_juzgados`
--

DROP TABLE IF EXISTS `v_juzgados`;
/*!50001 DROP VIEW IF EXISTS `v_juzgados`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_juzgados` AS SELECT 
 1 AS `idjuzgado`,
 1 AS `juzgado`,
 1 AS `descripcion`,
 1 AS `idmunicipio`,
 1 AS `municipio`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_pendientes`
--

DROP TABLE IF EXISTS `v_pendientes`;
/*!50001 DROP VIEW IF EXISTS `v_pendientes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_pendientes` AS SELECT 
 1 AS `id`,
 1 AS `hora`,
 1 AS `fecha`,
 1 AS `lugar`,
 1 AS `nombre`,
 1 AS `usuario`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_registro`
--

DROP TABLE IF EXISTS `v_registro`;
/*!50001 DROP VIEW IF EXISTS `v_registro`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `v_registro` AS SELECT 
 1 AS `idRegistro`,
 1 AS `expediente`,
 1 AS `juicio`,
 1 AS `via`,
 1 AS `total`,
 1 AS `observaciones`,
 1 AS `activo`,
 1 AS `fecha`,
 1 AS `materia`,
 1 AS `idMateria`,
 1 AS `cliente`,
 1 AS `idCliente`,
 1 AS `usuario`,
 1 AS `idEtapa`,
 1 AS `estadoProcesal`,
 1 AS `Juez`,
 1 AS `idJuez`,
 1 AS `idSecretario`,
 1 AS `Secretario`,
 1 AS `Juzgado`,
 1 AS `idjuzgado`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `via`
--

DROP TABLE IF EXISTS `via`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `via` (
  `idvia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idvia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'renovand_abogados'
--

--
-- Dumping routines for database 'renovand_abogados'
--
/*!50003 DROP FUNCTION IF EXISTS `estadoExpediente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`renovand_injuri`@`%` FUNCTION `estadoExpediente`(registro int) RETURNS varchar(50) CHARSET latin1
BEGIN
	declare estado varchar(50);
    if (select f_deuda(registro) > 0) then set estado = "Pendiente"; else set estado = "Liquidado"; END IF;
RETURN estado;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `f_abonado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`renovand_injuri`@`%` FUNCTION `F_ABONADO`(registro INT) RETURNS int(11)
BEGIN
	declare abono INT;
    SET abono = 0;
	set abono = (select sum(monto) as abonado from abonos where idRegistro = registro);
    if(abono is null) then set abono = 0; end if;
RETURN abono;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `f_deuda` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`renovand_injuri`@`%` FUNCTION `F_DEUDA`(registro int) RETURNS int(11)
BEGIN
	DECLARE deuda INT;
    set deuda = (select total - f_abonado(registro) from registro where idRegistro = registro);
RETURN deuda;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `f_tipoPersonal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`renovand_injuri`@`%` FUNCTION `F_TIPOPERSONAL`(tipo INT) RETURNS varchar(50) CHARSET utf8
BEGIN
	DECLARE tipoPersonal nvarchar(50);
	IF(tipo = 1) then set tipoPersonal = "Juez"; else set tipoPersonal = "Secretario de Causas"; END IF;
RETURN tipoPersonal;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_guardarRegistroAbono` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`renovand_injuri`@`%` PROCEDURE `sp_guardarRegistroAbono`(p_expediente varchar(45),
											p_juicio varchar(45),
                                            p_via int, 
                                            p_total decimal,
                                            p_observaciones varchar(300),
                                            p_idMateria int,
                                            p_idCliente int,
                                            p_idUsuario int,
                                            p_idEstadoP int,
                                            p_Juez int,
                                            p_secretario int,
                                            p_idJuzgado int,
                                            p_abono int)
BEGIN
declare id int;
declare fecha date;
set fecha = (SELECT CURDATE());
Insert into registro(expediente,juicio,via,total,observaciones,activo,fecha_creacion,id_materia,id_cliente,id_usuario,id_estadoProcesal,idJuez,idSecretarioCausas,idJuzgado)
values (p_expediente,p_juicio,p_via,p_total,p_observaciones,'1',fecha,p_idMateria,p_idCliente,p_idUsuario,p_idEstadoP,p_Juez,p_secretario,p_idjuzgado);
set id = (select @@identity);
INSERT INTO abonos(idRegistro,fecha,monto) values (id,fecha,p_abono);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `v_PersonalJuridico`
--

/*!50001 DROP VIEW IF EXISTS `v_PersonalJuridico`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_PersonalJuridico` AS select `p`.`nombre` AS `nombre`,`p`.`idPersonal` AS `idPersonal`,`F_TIPOPERSONAL`(`p`.`tipoPersonal`) AS `tipoPersonal`,`j`.`nombre` AS `juzgado` from (`personalJuridico` `p` join `juzgados` `j` on((`p`.`idJuzgado` = `j`.`idjuzgado`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_abonos`
--

/*!50001 DROP VIEW IF EXISTS `v_abonos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_abonos` AS select `r`.`idRegistro` AS `idRegistro`,`r`.`expediente` AS `expediente`,`c`.`nombre` AS `nombre`,`r`.`total` AS `total`,`F_DEUDA`(`r`.`idRegistro`) AS `deuda`,`F_ABONADO`(`r`.`idRegistro`) AS `abonado`,`estadoExpediente`(`r`.`idRegistro`) AS `estado` from (`registro` `r` join `clientes` `c` on((`r`.`id_cliente` = `c`.`idCliente`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_getPendientes`
--

/*!50001 DROP VIEW IF EXISTS `v_getPendientes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_getPendientes` AS select `p`.`idpendiente` AS `idpendiente`,`p`.`hora` AS `hora`,`p`.`fecha` AS `fecha`,`p`.`lugar` AS `lugar`,date_format(`p`.`fecha`,'%d-%m-%Y') AS `fecha_formato`,`cp`.`nombre` AS `nombre` from (`pendientes` `p` join `cat_pendientes` `cp` on((`p`.`id_cat_pendiente` = `cp`.`idpendiente`))) where (`p`.`fecha` >= curdate()) order by `p`.`fecha` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_juzgadoMateria`
--

/*!50001 DROP VIEW IF EXISTS `v_juzgadoMateria`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_juzgadoMateria` AS select `j`.`idjuzgado` AS `idjuzgado`,`j`.`nombre` AS `Juzgado`,`m`.`idMateria` AS `idMateria`,`m`.`nombre` AS `materia` from ((`juzgados` `j` join `juzgado_materia` `jm` on((`j`.`idjuzgado` = `jm`.`idjuzgado`))) join `materia` `m` on((`jm`.`idmateria` = `m`.`idMateria`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_juzgado_materia`
--

/*!50001 DROP VIEW IF EXISTS `v_juzgado_materia`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_juzgado_materia` AS select `m`.`nombre` AS `nombre`,`j`.`idjuzgado` AS `idjuzgado`,`m`.`idMateria` AS `idMateria` from ((`juzgado_materia` `jm` join `juzgados` `j` on((`jm`.`idjuzgado` = `j`.`idjuzgado`))) join `materia` `m` on((`jm`.`idmateria` = `m`.`idMateria`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_juzgados`
--

/*!50001 DROP VIEW IF EXISTS `v_juzgados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_juzgados` AS select `j`.`idjuzgado` AS `idjuzgado`,`j`.`nombre` AS `juzgado`,`j`.`descripcion` AS `descripcion`,`m`.`idmunicipio` AS `idmunicipio`,`m`.`nombre` AS `municipio` from (`juzgados` `j` join `municipios` `m` on((`j`.`municipio` = `m`.`idmunicipio`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_pendientes`
--

/*!50001 DROP VIEW IF EXISTS `v_pendientes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand_injuri`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_pendientes` AS select `p`.`idpendiente` AS `id`,`p`.`hora` AS `hora`,`p`.`fecha` AS `fecha`,`p`.`lugar` AS `lugar`,`cp`.`nombre` AS `nombre`,`u`.`usuario` AS `usuario` from ((`pendientes` `p` join `cat_pendientes` `cp` on((`p`.`id_cat_pendiente` = `cp`.`idpendiente`))) join `usuarios` `u` on((`u`.`idUsuario` = `p`.`id_usuario`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_registro`
--

/*!50001 DROP VIEW IF EXISTS `v_registro`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`renovand`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `v_registro` AS select `r`.`idRegistro` AS `idRegistro`,`r`.`expediente` AS `expediente`,`r`.`juicio` AS `juicio`,`v`.`nombre` AS `via`,`r`.`total` AS `total`,`r`.`observaciones` AS `observaciones`,`r`.`activo` AS `activo`,date_format(`r`.`fecha_creacion`,'%d-%m-%Y') AS `fecha`,`m`.`nombre` AS `materia`,`m`.`idMateria` AS `idMateria`,`c`.`nombre` AS `cliente`,`c`.`idCliente` AS `idCliente`,`u`.`usuario` AS `usuario`,`e`.`idetapa` AS `idEtapa`,`e`.`nombre` AS `estadoProcesal`,`p`.`nombre` AS `Juez`,`p`.`idPersonal` AS `idJuez`,`pJ`.`idPersonal` AS `idSecretario`,`pJ`.`nombre` AS `Secretario`,`j`.`nombre` AS `Juzgado`,`j`.`idjuzgado` AS `idjuzgado` from ((((((((`registro` `r` join `materia` `m` on((`r`.`id_materia` = `m`.`idMateria`))) join `clientes` `c` on((`r`.`id_cliente` = `c`.`idCliente`))) join `usuarios` `u` on((`r`.`id_usuario` = `u`.`idUsuario`))) join `via` `v` on((`r`.`via` = `v`.`idvia`))) join `etapaProcesal` `e` on((`r`.`id_estadoProcesal` = `e`.`idetapa`))) left join `personalJuridico` `p` on((`r`.`idJuez` = `p`.`idPersonal`))) left join `personalJuridico` `pJ` on((`r`.`idSecretarioCausas` = `pJ`.`idPersonal`))) join `juzgados` `j` on((`r`.`idJuzgado` = `j`.`idjuzgado`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-18 16:14:19
