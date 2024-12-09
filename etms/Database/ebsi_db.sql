-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebsi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@admins.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info`
--

CREATE TABLE `attendance_info` (
  `aten_id` int(11) NOT NULL,
  `atn_user_id` int(11) NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL,
  `pause_time` datetime DEFAULT NULL,
  `pause_duration` time DEFAULT '00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`aten_id`, `atn_user_id`, `in_time`, `out_time`, `total_duration`, `pause_time`, `pause_duration`) VALUES
(116, 1, '2024-10-17 12:34:59', '2024-10-17 12:35:02', '00:00:03', NULL, '00:00:00'),
(78, 1, '2024-09-25 12:12:15', '2024-09-25 12:12:21', '00:00:06', NULL, '00:00:00'),
(76, 36, '2024-09-25 12:02:06', '2024-09-25 12:02:13', '00:00:06', NULL, '00:00:01'),
(77, 37, '2024-09-25 12:03:16', '2024-09-25 12:03:37', '00:00:21', NULL, '00:00:00'),
(80, 1, '2024-09-26 21:00:06', '2024-09-26 21:00:39', '00:00:17', NULL, '00:00:16'),
(118, 1, '2024-10-23 08:00:19', '2024-10-23 17:00:55', '09:00:36', NULL, '00:00:00'),
(124, 1, '2024-10-30 08:00:27', '2024-10-30 16:59:12', '08:58:45', NULL, '00:00:00'),
(123, 35, '2024-10-24 13:48:00', '2024-10-24 13:52:24', '00:04:24', NULL, '00:00:00'),
(125, 35, '2024-10-30 08:00:56', '2024-10-30 16:59:10', '08:58:14', NULL, '00:00:00'),
(126, 37, '2024-10-30 08:01:46', '2024-10-30 16:59:08', '08:57:22', NULL, '00:00:00'),
(127, 38, '2024-10-30 10:05:00', '2024-10-30 16:59:05', '06:54:05', NULL, '00:00:00'),
(128, 1, '2024-11-06 08:00:00', '2024-11-06 17:00:00', '09:00:20', NULL, '00:00:00'),
(129, 35, '2024-11-06 08:00:00', '2024-11-06 16:59:35', '08:59:35', NULL, '00:00:00'),
(130, 38, '2024-11-06 08:00:00', '2024-11-06 16:59:31', '08:59:31', NULL, '00:00:00'),
(131, 37, '2024-11-06 08:00:00', '2024-11-06 16:59:29', '08:59:29', NULL, '00:00:00'),
(132, 39, '2024-11-06 12:22:38', '2024-11-06 13:17:10', '00:54:32', NULL, '00:00:00'),
(133, 1, '2024-11-07 07:45:36', '2024-11-07 16:52:19', '08:52:19', NULL, '00:00:00'),
(134, 35, '2024-11-07 07:45:54', '2024-11-07 16:52:05', '08:52:05', NULL, '00:00:00'),
(135, 38, '2024-11-07 07:46:10', '2024-11-07 16:51:59', '08:51:59', NULL, '00:00:00'),
(136, 37, '2024-11-07 07:46:23', '2024-11-07 16:51:52', '08:51:52', NULL, '00:00:00'),
(137, 39, '2024-11-07 10:42:09', '2024-11-07 16:51:47', '06:09:38', NULL, '00:00:00'),
(141, 1, '2024-11-14 02:56:58', '2024-11-14 17:00:00', '14:03:02', NULL, '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_list`
--

CREATE TABLE `payroll_list` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Monthly, 2= Semi-Monthly, 3= Daily',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_list`
--

INSERT INTO `payroll_list` (`id`, `code`, `start_date`, `end_date`, `type`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(9, '1234', '2024-05-13', '2024-05-14', 1, 1, 0, '2024-05-13 16:59:20', NULL),
(10, '1', '2024-12-06', '2024-12-07', 1, 1, 0, '2024-12-06 21:09:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

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

CREATE TABLE `scheduling` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `intime` time NOT NULL,
  `outtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheduling`
--

INSERT INTO `scheduling` (`id`, `fullname`, `start_date`, `end_date`, `intime`, `outtime`) VALUES
(13, 'Admin', '2024-10-24', '2024-10-26', '13:44:00', '15:42:00'),
(26, 'abajag', '2024-11-06', '2024-11-07', '14:30:00', '17:00:00'),
(27, 'Reyes Paul Albert', '2024-11-08', '2024-11-08', '06:00:00', '17:00:00'),
(28, 'Reyes Paul Albert', '2024-11-06', '2024-11-06', '07:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

CREATE TABLE `task_info` (
  `task_id` int(11) NOT NULL,
  `t_title` varchar(120) NOT NULL,
  `t_description` text DEFAULT NULL,
  `t_start_time` datetime DEFAULT NULL,
  `t_end_time` datetime DEFAULT NULL,
  `t_user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = incomplete, 1 = In progress, 2 = complete'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `task_info`
--

INSERT INTO `task_info` (`task_id`, `t_title`, `t_description`, `t_start_time`, `t_end_time`, `t_user_id`, `status`) VALUES
(9, 'Cleaning Room', 'xdfbhxfdbxf', '2024-05-10 12:00:00', '2024-05-11 12:00:00', 35, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `em_department` varchar(255) NOT NULL,
  `em_position` varchar(255) NOT NULL,
  `em_status` varchar(255) NOT NULL,
  `em_profile` varchar(255) NOT NULL,
  `user_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='2';

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `temp_password`, `em_department`, `em_position`, `em_status`, `em_profile`, `user_role`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', NULL, '', '', '', '', 1),
(15, 'Balon Itim Na', 'black', 'black@black.com', '1ffd9e753c8054cc61456ac7fac1ac89', '', 'IT', 'Programmer', 'contractual', '../assets/images/author/', 2),
(35, 'Rico Jovan G. Pitpit', 'ricopitpit', 'pitpit@gmail.com', '8f5c17fb3e00b48d89f212b8d98d7514', '', '', '', '', '', 2),
(36, 'abajag', 'abajag', 'ababa@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', '', '', 2),
(37, 'lebron', 'kobi', 'kobi@gmail.com', 'ca3a311ca4500526f141cb881a184882', '', '', '', '', '', 2),
(38, 'Clarence G. Iglesias', 'clarence', 'clarence@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', '', '', '', 2),
(39, 'Reyes Paul Albert', 'albert', 'reyes@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'IT', 'Programmer', 'regular', '../assets/images/team/me.jpg', 2),
(40, 'CANCERAN TERRACE', 'terrace', 'terrace@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'IT', 'Programmer', 'regular', '../assets/images/team/', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_leave`
--

CREATE TABLE `tbl_leave` (
  `leave_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `w_pay` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `filed_date` datetime NOT NULL,
  `days` int(11) NOT NULL,
  `reason` longtext NOT NULL,
  `leave_bal` int(11) DEFAULT NULL,
  `leave_req` int(11) DEFAULT NULL,
  `new_bal` int(11) DEFAULT NULL,
  `ver_by` varchar(120) DEFAULT NULL,
  `req_by` varchar(120) DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT NULL,
  `hr_name` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_leave`
--

INSERT INTO `tbl_leave` (`leave_id`, `user_id`, `fullname`, `position`, `department`, `status`, `leave_type`, `w_pay`, `from_date`, `to_date`, `filed_date`, `days`, `reason`, `leave_bal`, `leave_req`, `new_bal`, `ver_by`, `req_by`, `isApproved`, `hr_name`) VALUES
(3, 15, 'Balon Itim Na', 'Programmer', 'IT', 'contractual', 'Undertime', 1, '2024-11-22 00:00:00', '2024-11-23 00:00:00', '2024-11-22 00:00:00', 1, 'lanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigirolanigiro', 1231, 1232, 1233, 'qwe', 'asd', 1, 'qweasd'),
(4, 15, 'Balon Itim Na', 'Programmer', 'IT', 'contractual', 'Absences', 0, '2024-11-23 00:00:00', '2024-11-27 00:00:00', '2024-11-22 00:00:00', 4, 'qweasdzxc', 112, 113, 114, 'qwe', 'asd', 0, 'qweads');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pending_leave`
--

CREATE TABLE `tbl_pending_leave` (
  `pending_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `leave_type` varchar(255) DEFAULT NULL,
  `w_pay` tinyint(1) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `filed_date` datetime NOT NULL,
  `days` int(11) NOT NULL,
  `reason` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance_info`
--
ALTER TABLE `attendance_info`
  ADD PRIMARY KEY (`aten_id`);

--
-- Indexes for table `payroll_list`
--
ALTER TABLE `payroll_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payslip`
--
ALTER TABLE `payslip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_id` (`payroll_id`);

--
-- Indexes for table `scheduling`
--
ALTER TABLE `scheduling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_info`
--
ALTER TABLE `task_info`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`leave_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_pending_leave`
--
ALTER TABLE `tbl_pending_leave`
  ADD PRIMARY KEY (`pending_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_info`
--
ALTER TABLE `attendance_info`
  MODIFY `aten_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `payroll_list`
--
ALTER TABLE `payroll_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `scheduling`
--
ALTER TABLE `scheduling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `task_info`
--
ALTER TABLE `task_info`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_pending_leave`
--
ALTER TABLE `tbl_pending_leave`
  MODIFY `pending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payslip`
--
ALTER TABLE `payslip`
  ADD CONSTRAINT `payslip_fk_payroll_id` FOREIGN KEY (`payroll_id`) REFERENCES `payroll_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD CONSTRAINT `tbl_leave_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_admin` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pending_leave`
--
ALTER TABLE `tbl_pending_leave`
  ADD CONSTRAINT `tbl_pending_leave_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_admin` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
