-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 09:13 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addproduct`
--

CREATE TABLE `addproduct` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL,
  `product_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `addstocks`
--

CREATE TABLE `addstocks` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL,
  `Storage_location` varchar(100) NOT NULL,
  `product_status` varchar(100) NOT NULL,
  `date_` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addstocks`
--

INSERT INTO `addstocks` (`id`, `category`, `productname`, `quantity`, `Storage_location`, `product_status`, `date_`) VALUES
(2, 'DETERGENTS', 'zonrox', 2, '', 'Available', '2024-04-12 21:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `aten_id` int(20) NOT NULL,
  `atn_user_id` int(20) NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `total_duration` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`aten_id`, `atn_user_id`, `in_time`, `out_time`, `total_duration`) VALUES
(12, 1, '2024-05-09 15:53:29', '2024-05-09 15:53:34', '00:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(50, 'CLEANING MATERIALS'),
(51, 'EQUIPMENT');

-- --------------------------------------------------------

--
-- Table structure for table `home_tasks`
--

CREATE TABLE `home_tasks` (
  `home_id` int(11) NOT NULL,
  `user_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `tdate` date NOT NULL,
  `dtime` text NOT NULL,
  `status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home_tasks`
--

INSERT INTO `home_tasks` (`home_id`, `user_no`, `name`, `activity`, `tdate`, `dtime`, `status`) VALUES
(62, 21, 'joshua Balingasa', 'Clean Living Room', '2024-05-10', '4:49:pm', '1'),
(63, 21, 'joshua Balingasa', 'BUILDING', '2024-05-10', '', '0'),
(68, 26, 'Test Account', 'Bedroom', '2024-05-13', '', '0'),
(69, 26, 'Test Account', 'Master Bedroom', '2024-05-13', '', '0'),
(70, 26, 'Test Account', 'Living room', '2024-05-13', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ims_user`
--

CREATE TABLE `ims_user` (
  `userid` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` enum('admin','member') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ims_user`
--

INSERT INTO `ims_user` (`userid`, `email`, `password`, `name`, `type`, `status`) VALUES
(1, 'admin@mail.com', 'admin', 'Administrator', 'admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `items_in_use`
--

CREATE TABLE `items_in_use` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_used` int(11) DEFAULT NULL,
  `price_id` int(100) NOT NULL,
  `date_used` date DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items_in_use`
--

INSERT INTO `items_in_use` (`id`, `name`, `product_id`, `quantity_used`, `price_id`, `date_used`, `status`) VALUES
(75, 'itan', 29, 3, 0, '2024-04-23', 'USED'),
(83, 'benjie', 29, 1, 0, '2024-05-02', 'USED'),
(84, 'boss man', 29, 7, 0, '2024-05-02', 'USED'),
(86, 'boss mayy', 29, 6, 0, '2024-05-02', 'USED'),
(87, 'itanto', 33, 5, 0, '2024-05-02', 'USED'),
(91, 'reymark', 33, 1, 0, '2024-05-02', 'USED'),
(93, 'lester', 31, 3, 0, '2024-05-02', 'USED'),
(94, 'mandreek', 28, 6, 0, '2024-05-05', 'IN USE');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_list`
--

CREATE TABLE `payroll_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Monthly, 2= Semi-Monthly, 3= Daily',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payroll_list`
--

INSERT INTO `payroll_list` (`id`, `code`, `start_date`, `end_date`, `type`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(9, '1234', '2024-05-13', '2024-05-14', 1, 1, 0, '2024-05-13 16:59:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payslip`
--

CREATE TABLE `payslip` (
  `id` int(11) NOT NULL,
  `payroll_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `commission_percent` decimal(5,2) NOT NULL,
  `project_based_pay` decimal(10,2) NOT NULL,
  `gross_pay` decimal(10,2) NOT NULL,
  `income_tax_percent` decimal(5,2) NOT NULL,
  `total_pay` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payslip`
--

INSERT INTO `payslip` (`id`, `payroll_id`, `employee_id`, `commission_percent`, `project_based_pay`, `gross_pay`, `income_tax_percent`, `total_pay`, `created_at`) VALUES
(13, 9, 35, '5.00', '10000.00', '10000.00', '0.02', '9800.00', '2024-05-13 09:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` varchar(100) NOT NULL,
  `storage_id` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL,
  `price` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `add_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `category_id`, `storage_id`, `quantity`, `price`, `status`, `add_at`) VALUES
(28, 'washing washing', 'EQUIPMENT', 'ROOFTOP', 28, 30, 'AVAILABLE', '2024-04-24 01:30:58'),
(29, 'Zonrox', 'CLEANING MATERIALS', 'STORAGE A ', 0, 30, 'AVAILABLE', '2024-04-24 01:41:01'),
(31, 'GLOVES', 'EQUIPMENT', 'STORAGE A', 40, 5, 'AVAILABLE', '2024-05-02 22:59:44'),
(33, 'hair net', 'CLEANING MATERIALS', 'STORAGE A ', 6, 10, 'AVAILABLE', '2024-05-02 23:05:56'),
(35, 'TOWEL', 'EQUIPMENT', 'STORAGE B', 23, 10, 'AVAILABLE', '2024-05-03 01:12:45'),
(36, 'AIR CLEANING MACHINE', 'MACHINE', 'STORAGE A', 23, 1000, 'AVAILABLE', '2024-05-03 01:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `reqnumber` varchar(11) NOT NULL,
  `staff` varchar(50) NOT NULL,
  `assignee_name` varchar(50) NOT NULL,
  `assignee_id` int(50) NOT NULL,
  `reqdatetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `reqnumber`, `staff`, `assignee_name`, `assignee_id`, `reqdatetime`) VALUES
(8, 'RQ1', 'HRM', 'EMPLOYEE', 1, '2024-05-13 11:05:47'),
(9, 'RQ2', 'HRM', 'EMPLOYEE', 2, '2024-05-13 11:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `storage_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `storage_name`) VALUES
(14, 'STORAGE A '),
(16, 'STORAGE B ');

-- --------------------------------------------------------

--
-- Table structure for table `task_info`
--

CREATE TABLE `task_info` (
  `task_id` int(50) NOT NULL,
  `t_title` varchar(120) NOT NULL,
  `t_description` text DEFAULT NULL,
  `t_start_time` datetime DEFAULT NULL,
  `t_end_time` datetime DEFAULT NULL,
  `t_user_id` int(20) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = incomplete, 1 = In progress, 2 = complete'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `user_id` int(20) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `temp_password` varchar(100) DEFAULT NULL,
  `user_role` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='2';

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`user_id`, `fullname`, `username`, `email`, `password`, `temp_password`, `user_role`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', NULL, 1),
(35, 'Rico Jovan G. Pitpit', 'ricopitpit', 'pitpit@gmail.com', '98361fea4a29b4d3679896b374f43c66', '240842', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_no` int(11) NOT NULL,
  `image` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_no`, `image`, `name`, `password`, `email`, `address`, `mobile`, `status`) VALUES
(21, '7615-403509.jpg', 'joshua Balingasa', '123', 'joshuaBalingasa@gmail.com', '7 orovista village', '09462886584', '1'),
(23, '8614-3.jpg', 'ronnini', '123', 'hiwagaalias@gmail.com', 'ier0i0eriere', '090902092', '1'),
(25, '4545-504652.png', 'joshua yng', '123', 'joshyng@gmail.com', 'dvdvvdvd', '09467556581', '0'),
(26, '6765-asdwd.png', 'Test Account', '051602143', 'test@gmail.com', '#13 st qc', '0900654654', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addproduct`
--
ALTER TABLE `addproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addstocks`
--
ALTER TABLE `addstocks`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_tasks`
--
ALTER TABLE `home_tasks`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `items_in_use`
--
ALTER TABLE `items_in_use`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_no`),
  ADD UNIQUE KEY `user_no` (`user_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addproduct`
--
ALTER TABLE `addproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addstocks`
--
ALTER TABLE `addstocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_info`
--
ALTER TABLE `attendance_info`
  MODIFY `aten_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `home_tasks`
--
ALTER TABLE `home_tasks`
  MODIFY `home_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `items_in_use`
--
ALTER TABLE `items_in_use`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `payroll_list`
--
ALTER TABLE `payroll_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payslip`
--
ALTER TABLE `payslip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `task_info`
--
ALTER TABLE `task_info`
  MODIFY `task_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items_in_use`
--
ALTER TABLE `items_in_use`
  ADD CONSTRAINT `items_in_use_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `payslip`
--
ALTER TABLE `payslip`
  ADD CONSTRAINT `payslip_fk_payroll_id` FOREIGN KEY (`payroll_id`) REFERENCES `payroll_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
