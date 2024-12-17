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
INSERT INTO `admin` VALUES (1,'admin','admin@admins.com','0192023a7bbd73250516f069df18b500');
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
  `atn_user_id` varchar(20) DEFAULT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL,
  `pause_time` datetime DEFAULT NULL,
  `pause_duration` time DEFAULT '00:00:00',
  PRIMARY KEY (`aten_id`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_info`
--

LOCK TABLES `attendance_info` WRITE;
/*!40000 ALTER TABLE `attendance_info` DISABLE KEYS */;
INSERT INTO `attendance_info` VALUES (78,'1','2024-09-25 12:12:15','2024-09-25 12:12:21','00:00:06',NULL,'00:00:00'),(80,'1','2024-09-26 21:00:06','2024-09-26 21:00:39','00:00:17',NULL,'00:00:16'),(118,'1','2024-10-23 08:00:19','2024-10-23 17:00:55','09:00:36',NULL,'00:00:00'),(124,'1','2024-10-30 08:00:27','2024-10-30 16:59:12','08:58:45',NULL,'00:00:00'),(128,'1','2024-11-06 08:00:00','2024-11-06 17:00:00','09:00:20',NULL,'00:00:00'),(133,'1','2024-11-07 07:45:36','2024-11-07 16:52:19','08:52:19',NULL,'00:00:00'),(141,'1','2024-11-13 12:05:20','2024-11-14 11:18:10','03:18:10',NULL,'00:00:00'),(143,'1','2024-11-15 10:11:22','2024-11-15 17:00:00','06:48:38',NULL,'00:00:00'),(144,'1','2024-11-27 07:38:22','2024-11-27 17:00:00','09:21:38',NULL,'00:00:00'),(149,'1','2024-11-28 10:03:29','2024-12-09 17:00:00','06:56:31',NULL,'00:00:00');
/*!40000 ALTER TABLE `attendance_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `emp_lname` varchar(255) NOT NULL,
  `emp_fname` varchar(255) NOT NULL,
  `emp_mname` varchar(255) NOT NULL,
  `hire_date` date DEFAULT NULL,
  `sss_number` varchar(20) DEFAULT NULL,
  `p_health_num` varchar(20) DEFAULT NULL,
  `p_ibig_num` varchar(20) DEFAULT NULL,
  `tin_num` varchar(20) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `department` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `pay_type` enum('Monthly','Daily') NOT NULL,
  `b_salary` decimal(10,2) DEFAULT NULL,
  `m_rate` decimal(10,2) DEFAULT NULL,
  `d_rate` decimal(10,2) DEFAULT NULL,
  `company` varchar(255) DEFAULT 'EBSI',
  `tax_stat` enum('Tax Exempted','Single','Married') NOT NULL,
  `emp_civ_stat` enum('Single','Married','Widow/er') NOT NULL,
  `emp_home_addr` varchar(255) NOT NULL,
  `emp_curr_addr` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `emp_email_addr` varchar(255) NOT NULL,
  `mobile_num` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `emp_profile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; /* changed from utf8mb4_0900_ai_ci */
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES ('EBSI2401','Blackwhel De Guia Candila','Candila','Blackwhel','De Guia','2024-12-13','123','456','789','123','2001-01-05','Information Technology','IT Manager','Probationary','Daily',123.00,234.00,345.00,'EBSI','Tax Exempted','Single','191 Don Fabian Extension, Barangay Commonwealth, Quezon City','191 Don Fabian Extension, Barangay Commonwealth, Quezon City','Male','blackwhel.deguia.candila@gmail.com','9567100591','black','1ffd9e753c8054cc61456ac7fac1ac89','','../assets/images/author/Sign_11-29-2024_11.04_1-removebg-preview.png');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees_archives`
--

DROP TABLE IF EXISTS `employees_archives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees_archives` (
  `archive_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `emp_lname` varchar(255) NOT NULL,
  `emp_fname` varchar(255) NOT NULL,
  `emp_mname` varchar(255) NOT NULL,
  `hire_date` date NOT NULL,
  `sss_number` varchar(20) DEFAULT NULL,
  `p_health_num` varchar(20) DEFAULT NULL,
  `p_ibig_num` varchar(20) DEFAULT NULL,
  `tin_num` varchar(20) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `department` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `emp_type` varchar(50) NOT NULL,
  `pay_type` varchar(50) NOT NULL,
  `b_salary` decimal(10,2) DEFAULT NULL,
  `m_rate` decimal(10,2) DEFAULT NULL,
  `d_rate` decimal(10,2) DEFAULT NULL,
  `company` varchar(255) DEFAULT 'EBSI',
  `tax_stat` varchar(50) NOT NULL,
  `emp_civ_stat` varchar(50) NOT NULL,
  `emp_home_addr` varchar(255) NOT NULL,
  `emp_curr_addr` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `emp_email_addr` varchar(255) NOT NULL,
  `mobile_num` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `resign_date` date NOT NULL,
  `type_separation` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`archive_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; /* changed from utf8mb4_0900_ai_ci */
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees_archives`
--

LOCK TABLES `employees_archives` WRITE;
/*!40000 ALTER TABLE `employees_archives` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees_archives` ENABLE KEYS */;
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

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--
DROP TABLE IF EXISTS `payslip`;
CREATE TABLE `payslip` (
  `id` int(11) NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `monthly_pay` decimal(10,2) NOT NULL,
  `basic_pay` decimal(10,2) NOT NULL,
  `daily_pay` decimal(10,2) NOT NULL,
  `hourly_pay` decimal(10,2) NOT NULL,
  `deminimis_allowance` decimal(10,2) NOT NULL,
  `overtime_pay` decimal(10,2) NOT NULL,
  `rest_day_pay` decimal(10,2) NOT NULL,
  `night_pay` decimal(10,2) NOT NULL,
  `legal_holiday_pay` decimal(10,2) NOT NULL,
  `special_holiday_pay` decimal(10,2) NOT NULL,
  `adjustments` decimal(10,2) NOT NULL,
  `total_deductions` decimal(10,2) NOT NULL,
  `total_pay` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payslip`
--

INSERT INTO `payslip` (`id`, `payroll_id`, `employee_id`, `monthly_pay`, `basic_pay`, `daily_pay`, `hourly_pay`, `deminimis_allowance`, `overtime_pay`, `rest_day_pay`, `night_pay`, `legal_holiday_pay`, `special_holiday_pay`, `adjustments`, `total_deductions`, `total_pay`, `created_at`) VALUES
(13, 9, 35, 10000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 9800.00, '2024-05-13 09:02:06');

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduling`
--

LOCK TABLES `scheduling` WRITE;
/*!40000 ALTER TABLE `scheduling` DISABLE KEYS */;
INSERT INTO `scheduling` VALUES (13,'Admin','2024-10-24','2024-10-26','13:44:00','15:42:00'),(27,'Reyes Paul Albert','2024-11-08','2024-11-08','06:00:00','17:00:00'),(28,'Reyes Paul Albert','2024-11-06','2024-11-06','07:00:00','17:00:00'),(88,'Rico Jovan G. Pitpit','2024-11-14','2024-12-13','07:00:00','17:00:00'),(90,'CANCERAN TERRACE','2024-11-15','2024-11-16','07:00:00','17:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=123124 DEFAULT CHARSET=utf8mb3 COMMENT='2';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_admin`
--

LOCK TABLES `tbl_admin` WRITE;
/*!40000 ALTER TABLE `tbl_admin` DISABLE KEYS */;
INSERT INTO `tbl_admin` VALUES (1,'Admin','admin','admin@gmail.com','0192023a7bbd73250516f069df18b500',NULL,'','','','',1);
/*!40000 ALTER TABLE `tbl_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_leave`
--

DROP TABLE IF EXISTS `tbl_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_leave` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
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
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_leave`
--

LOCK TABLES `tbl_leave` WRITE;
/*!40000 ALTER TABLE `tbl_leave` DISABLE KEYS */;
INSERT INTO `tbl_leave` VALUES (3,'EBSI2401','Blackwhel De Guia Candila','IT Manager','Information Technology','Probationary','Sick',1,'2024-12-13 00:00:00','2024-12-14 00:00:00','2024-12-12 00:00:00',2,'Natatae na kase ako',123,456,789,'Lanigidog','Natatae ako hihi',1,'QWEASD'),(4,'EBSI2401','Blackwhel De Guia Candila','IT Manager','Information Technology','Probationary','Absences',1,'2024-12-19 00:00:00','2024-12-27 00:00:00','2024-12-12 00:00:00',9,'Natatae ako',123123,123123,12312313,'QWEASD','QWEASDZXC',0,'QWEASDZXCAD');
/*!40000 ALTER TABLE `tbl_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pending_leave`
--

DROP TABLE IF EXISTS `tbl_pending_leave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_pending_leave` (
  `pending_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `leave_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `w_pay` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `filed_date` datetime NOT NULL,
  `days` int NOT NULL,
  `reason` longtext COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`pending_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pending_leave`
--

LOCK TABLES `tbl_pending_leave` WRITE;
/*!40000 ALTER TABLE `tbl_pending_leave` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pending_leave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_record`
--

DROP TABLE IF EXISTS `upload_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `upload_record` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emp_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_rec` date DEFAULT NULL,
  `in_one` time DEFAULT NULL,
  `out_one` time DEFAULT NULL,
  `in_two` time DEFAULT NULL,
  `out_two` time DEFAULT NULL,
  `in_three` time DEFAULT NULL,
  `out_three` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_record`
--

LOCK TABLES `upload_record` WRITE;
/*!40000 ALTER TABLE `upload_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_record` ENABLE KEYS */;
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

-- Dump completed on 2024-12-13  0:55:04
