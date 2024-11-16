-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: ebsi_db
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin@admins.com','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_info`
--

DROP TABLE IF EXISTS `attendance_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance_info` (
  `aten_id` int NOT NULL AUTO_INCREMENT,
  `atn_user_id` int NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL,
  `pause_time` datetime DEFAULT NULL,
  `pause_duration` time DEFAULT '00:00:00',
  PRIMARY KEY (`aten_id`)
) ENGINE=MyISAM AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_info`
--

LOCK TABLES `attendance_info` WRITE;
/*!40000 ALTER TABLE `attendance_info` DISABLE KEYS */;
INSERT INTO `attendance_info` VALUES (116,1,'2024-10-17 12:34:59','2024-10-17 12:35:02','00:00:03',NULL,'00:00:00'),(78,1,'2024-09-25 12:12:15','2024-09-25 12:12:21','00:00:06',NULL,'00:00:00'),(76,36,'2024-09-25 12:02:06','2024-09-25 12:02:13','00:00:06',NULL,'00:00:01'),(77,37,'2024-09-25 12:03:16','2024-09-25 12:03:37','00:00:21',NULL,'00:00:00'),(80,1,'2024-09-26 21:00:06','2024-09-26 21:00:39','00:00:17',NULL,'00:00:16'),(118,1,'2024-10-23 08:00:19','2024-10-23 17:00:55','09:00:36',NULL,'00:00:00'),(124,1,'2024-10-30 08:00:27','2024-10-30 16:59:12','08:58:45',NULL,'00:00:00'),(123,35,'2024-10-24 13:48:00','2024-10-24 13:52:24','00:04:24',NULL,'00:00:00'),(125,35,'2024-10-30 08:00:56','2024-10-30 16:59:10','08:58:14',NULL,'00:00:00'),(126,37,'2024-10-30 08:01:46','2024-10-30 16:59:08','08:57:22',NULL,'00:00:00'),(127,38,'2024-10-30 10:05:00','2024-10-30 16:59:05','06:54:05',NULL,'00:00:00'),(128,1,'2024-11-06 08:00:00','2024-11-06 17:00:00','09:00:20',NULL,'00:00:00'),(129,35,'2024-11-06 08:00:00','2024-11-06 16:59:35','08:59:35',NULL,'00:00:00'),(130,38,'2024-11-06 08:00:00','2024-11-06 16:59:31','08:59:31',NULL,'00:00:00'),(131,37,'2024-11-06 08:00:00','2024-11-06 16:59:29','08:59:29',NULL,'00:00:00'),(132,39,'2024-11-06 12:22:38','2024-11-06 13:17:10','00:54:32',NULL,'00:00:00'),(133,1,'2024-11-07 07:45:36','2024-11-07 16:52:19','08:52:19',NULL,'00:00:00'),(134,35,'2024-11-07 07:45:54','2024-11-07 16:52:05','08:52:05',NULL,'00:00:00'),(135,38,'2024-11-07 07:46:10','2024-11-07 16:51:59','08:51:59',NULL,'00:00:00'),(136,37,'2024-11-07 07:46:23','2024-11-07 16:51:52','08:51:52',NULL,'00:00:00'),(137,39,'2024-11-07 10:42:09','2024-11-07 16:51:47','06:09:38',NULL,'00:00:00'),(141,1,'2024-11-14 02:56:58','2024-11-14 17:00:00','14:03:02',NULL,'00:00:00'),(142,15,'2024-11-15 17:48:53','2024-11-15 17:00:00','00:48:53',NULL,'00:00:00');
/*!40000 ALTER TABLE `attendance_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_list`
--

DROP TABLE IF EXISTS `payroll_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Monthly, 2= Semi-Monthly, 3= Daily',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_list`
--

LOCK TABLES `payroll_list` WRITE;
/*!40000 ALTER TABLE `payroll_list` DISABLE KEYS */;
INSERT INTO `payroll_list` VALUES (9,'1234','2024-05-13','2024-05-14',1,1,0,'2024-05-13 16:59:20',NULL);
/*!40000 ALTER TABLE `payroll_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip`
--

DROP TABLE IF EXISTS `payslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payslip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payroll_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `commission_percent` decimal(5,2) NOT NULL,
  `project_based_pay` decimal(10,2) NOT NULL,
  `gross_pay` decimal(10,2) NOT NULL,
  `income_tax_percent` decimal(5,2) NOT NULL,
  `total_pay` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `payroll_id` (`payroll_id`),
  CONSTRAINT `payslip_fk_payroll_id` FOREIGN KEY (`payroll_id`) REFERENCES `payroll_list` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip`
--

LOCK TABLES `payslip` WRITE;
/*!40000 ALTER TABLE `payslip` DISABLE KEYS */;
INSERT INTO `payslip` VALUES (13,9,35,5.00,10000.00,10000.00,0.02,9800.00,'2024-05-13 09:02:06');
/*!40000 ALTER TABLE `payslip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduling`
--

DROP TABLE IF EXISTS `scheduling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scheduling` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `intime` time NOT NULL,
  `outtime` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling`
--

LOCK TABLES `scheduling` WRITE;
/*!40000 ALTER TABLE `scheduling` DISABLE KEYS */;
INSERT INTO `scheduling` VALUES (13,'Admin','2024-10-24','2024-10-26','13:44:00','15:42:00'),(26,'abajag','2024-11-06','2024-11-07','14:30:00','17:00:00'),(27,'Reyes Paul Albert','2024-11-08','2024-11-08','06:00:00','17:00:00'),(28,'Reyes Paul Albert','2024-11-06','2024-11-06','07:00:00','17:00:00');
/*!40000 ALTER TABLE `scheduling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_info`
--

DROP TABLE IF EXISTS `task_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task_info` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `t_title` varchar(120) NOT NULL,
  `t_description` text,
  `t_start_time` datetime DEFAULT NULL,
  `t_end_time` datetime DEFAULT NULL,
  `t_user_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0 = incomplete, 1 = In progress, 2 = complete',
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_info`
--

LOCK TABLES `task_info` WRITE;
/*!40000 ALTER TABLE `task_info` DISABLE KEYS */;
INSERT INTO `task_info` VALUES (9,'Cleaning Room','xdfbhxfdbxf','2024-05-10 12:00:00','2024-05-11 12:00:00',35,1);
/*!40000 ALTER TABLE `task_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_admin` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `em_department` varchar(255) NOT NULL,
  `em_position` varchar(255) NOT NULL,
  `em_status` varchar(255) NOT NULL,
  `em_profile` varchar(255) NOT NULL,
  `user_role` int NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3 COMMENT='2';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'Admin','admin','admin@gmail.com','0192023a7bbd73250516f069df18b500',NULL,'','','','',1),(15,'Balon Itim Na','black','black@black.com','1ffd9e753c8054cc61456ac7fac1ac89','','IT','Programmer','contractual','../assets/images/author/',2),(35,'Rico Jovan G. Pitpit','ricopitpit','pitpit@gmail.com','8f5c17fb3e00b48d89f212b8d98d7514','','','','','',2),(36,'abajag','abajag','ababa@gmail.com','202cb962ac59075b964b07152d234b70','','','','','',2),(37,'lebron','kobi','kobi@gmail.com','ca3a311ca4500526f141cb881a184882','','','','','',2),(38,'Clarence G. Iglesias','clarence','clarence@gmail.com','202cb962ac59075b964b07152d234b70','','','','','',2),(39,'Reyes Paul Albert','albert','reyes@gmail.com','202cb962ac59075b964b07152d234b70','','IT','Programmer','regular','../assets/images/team/me.jpg',2),(40,'CANCERAN TERRACE','terrace','terrace@gmail.com','202cb962ac59075b964b07152d234b70','','IT','Programmer','regular','../assets/images/team/',2);
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_leave`
--

DROP TABLE IF EXISTS `tbl_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_leave` (
  `user_id` int NOT NULL,
  `fullname` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `leave_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `w_pay` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `filed_date` datetime NOT NULL,
  `days` int NOT NULL,
  `reason` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `leave_bal` int DEFAULT NULL,
  `leave_req` int DEFAULT NULL,
  `new_bal` int DEFAULT NULL,
  `ver_by` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `req_by` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT NULL,
  `hr_name` varchar(120) COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `user_id` (`user_id`),
  CONSTRAINT `tbl_leave_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_admin` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_leave`
--

LOCK TABLES `tbl_leave` WRITE;
/*!40000 ALTER TABLE `tbl_leave` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ebsi_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-16 14:49:04
