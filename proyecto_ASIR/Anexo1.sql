-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: monitoring_server
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `almacenamiento`
--

DROP TABLE IF EXISTS `almacenamiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `almacenamiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dispositivos_usb` text DEFAULT NULL,
  `uso_disco` text DEFAULT NULL,
  `modulos_kernel` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `almacenamiento`
--

LOCK TABLES `almacenamiento` WRITE;
/*!40000 ALTER TABLE `almacenamiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `almacenamiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_sistema`
--

DROP TABLE IF EXISTS `estado_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ultimo_reinicio` datetime DEFAULT NULL,
  `tiempo_actividad` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_sistema`
--

LOCK TABLES `estado_sistema` WRITE;
/*!40000 ALTER TABLE `estado_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interfaces_red`
--

DROP TABLE IF EXISTS `interfaces_red`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interfaces_red` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interfaz_nombre` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `ip_asiganda` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interfaces_red`
--

LOCK TABLES `interfaces_red` WRITE;
/*!40000 ALTER TABLE `interfaces_red` DISABLE KEYS */;
/*!40000 ALTER TABLE `interfaces_red` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recursos_sistema`
--

DROP TABLE IF EXISTS `recursos_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recursos_sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpu_uso` varchar(100) DEFAULT NULL,
  `ram_total` text DEFAULT NULL,
  `procesos_activos` text DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recursos_sistema`
--

LOCK TABLES `recursos_sistema` WRITE;
/*!40000 ALTER TABLE `recursos_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `recursos_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `red_servidor`
--

DROP TABLE IF EXISTS `red_servidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `red_servidor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dns_dominio` varchar(200) DEFAULT NULL,
  `ip_servidor` varchar(200) DEFAULT NULL,
  `ip_detail_servidor` text DEFAULT NULL,
  `sist_operativo` varchar(200) DEFAULT NULL,
  `version_so` varchar(200) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `red_servidor`
--

LOCK TABLES `red_servidor` WRITE;
/*!40000 ALTER TABLE `red_servidor` DISABLE KEYS */;
/*!40000 ALTER TABLE `red_servidor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-23 22:13:47
