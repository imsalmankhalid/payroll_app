-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2024 at 04:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genhr`
--

-- --------------------------------------------------------

--
-- Table structure for table `addition`
--

CREATE TABLE `addition` (
  `addi_id` int(14) NOT NULL,
  `salary_id` int(14) NOT NULL,
  `basic` varchar(128) DEFAULT NULL,
  `medical` varchar(64) DEFAULT NULL,
  `house_rent` varchar(64) DEFAULT NULL,
  `conveyance` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `addition`
--

INSERT INTO `addition` (`addi_id`, `salary_id`, `basic`, `medical`, `house_rent`, `conveyance`) VALUES
(25, 25, '2500.00', '250.00', '2000.00', '250.00'),
(26, 26, '3500.00', '350.00', '2800.00', '350.00');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `type` enum('Present','Permanent') DEFAULT 'Present'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `ass_id` int(14) NOT NULL,
  `catid` varchar(14) NOT NULL,
  `ass_name` varchar(256) DEFAULT NULL,
  `ass_brand` varchar(128) DEFAULT NULL,
  `ass_model` varchar(256) DEFAULT NULL,
  `ass_code` varchar(256) DEFAULT NULL,
  `configuration` varchar(512) DEFAULT NULL,
  `purchasing_date` varchar(128) DEFAULT NULL,
  `ass_price` varchar(128) DEFAULT NULL,
  `ass_qty` varchar(64) DEFAULT NULL,
  `in_stock` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_category`
--

CREATE TABLE `assets_category` (
  `cat_id` int(14) NOT NULL,
  `cat_status` enum('ASSETS','LOGISTIC') NOT NULL DEFAULT 'ASSETS',
  `cat_name` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assets_category`
--

INSERT INTO `assets_category` (`cat_id`, `cat_status`, `cat_name`) VALUES
(1, 'ASSETS', 'TAB'),
(2, 'ASSETS', 'Computer'),
(3, 'ASSETS', 'Laptop'),
(4, 'LOGISTIC', 'tab');

-- --------------------------------------------------------

--
-- Table structure for table `assign_leave`
--

CREATE TABLE `assign_leave` (
  `id` int(14) NOT NULL,
  `app_id` varchar(11) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(14) NOT NULL,
  `day` varchar(256) DEFAULT NULL,
  `hour` varchar(255) NOT NULL,
  `total_day` varchar(64) DEFAULT NULL,
  `dateyear` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_task`
--

CREATE TABLE `assign_task` (
  `id` int(14) NOT NULL,
  `task_id` int(14) NOT NULL,
  `project_id` int(14) NOT NULL,
  `assign_user` varchar(64) DEFAULT NULL,
  `user_type` enum('Team Head','Collaborators') NOT NULL DEFAULT 'Collaborators'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `atten_date` varchar(64) DEFAULT NULL,
  `signin_time` time DEFAULT NULL,
  `signout_time` time DEFAULT NULL,
  `working_hour` varchar(64) DEFAULT NULL,
  `place` varchar(255) NOT NULL,
  `absence` varchar(128) DEFAULT NULL,
  `overtime` varchar(128) DEFAULT NULL,
  `earnleave` varchar(128) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `emp_id`, `atten_date`, `signin_time`, `signout_time`, `working_hour`, `place`, `absence`, `overtime`, `earnleave`, `status`) VALUES
(1012, '123456', '2023-12-01', '08:30:00', '06:00:00', '02 h 30 m', 'office', NULL, NULL, NULL, 'E'),
(1013, '4455', '2023-12-01', '08:00:00', '06:00:00', '02 h 0 m', 'office', NULL, NULL, NULL, 'E'),
(1014, '4455', '2023-12-04', '08:00:00', '18:00:00', '10 h 0 m', 'office', NULL, NULL, NULL, 'A'),
(1015, '99', '2023-12-20', '07:00:00', '18:30:00', '11 h 30 m', 'office', NULL, NULL, NULL, 'A'),
(1016, '99', '2023-12-27', '07:00:00', '17:00:00', '10 h 0 m', 'office', NULL, NULL, NULL, 'A'),
(1017, '99', '2023-12-26', '08:00:00', '16:00:00', '08 h 0 m', 'office', NULL, NULL, NULL, 'A'),
(1018, '99', '2024-01-09', '07:59:00', '18:00:00', '10 h 1 m', 'office', NULL, NULL, NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

CREATE TABLE `bank_info` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `holder_name` varchar(256) DEFAULT NULL,
  `bank_name` varchar(256) DEFAULT NULL,
  `branch_name` varchar(256) DEFAULT NULL,
  `account_number` varchar(256) DEFAULT NULL,
  `account_type` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `de_id` int(14) NOT NULL,
  `salary_id` int(14) NOT NULL,
  `provident_fund` varchar(64) DEFAULT NULL,
  `bima` varchar(64) DEFAULT NULL,
  `tax` varchar(64) DEFAULT NULL,
  `others` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`de_id`, `salary_id`, `provident_fund`, `bima`, `tax`, `others`) VALUES
(25, 25, '', '', '', ''),
(26, 26, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dep_name`) VALUES
(2, 'Administration'),
(3, 'Finance, HR, & Admininstration'),
(4, 'Research'),
(5, 'Information Technology'),
(6, 'Support');

-- --------------------------------------------------------

--
-- Table structure for table `desciplinary`
--

CREATE TABLE `desciplinary` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `action` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `des_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `des_name`) VALUES
(2, 'President'),
(3, 'Chief Executive Officer (CEO)'),
(4, 'Chief Finance & Admin Officer'),
(5, 'Sr. Finance & Admin Officer - I'),
(6, 'Jr. Finance & Admin Officer'),
(7, 'Senior Research Associate-1'),
(8, 'Research Associate-1'),
(9, 'Junior Research Associate'),
(10, 'Research Assistant'),
(11, 'Sr. Office Assistant'),
(12, 'Office Assistant'),
(13, 'IT Analyst'),
(14, 'Cook');

-- --------------------------------------------------------

--
-- Table structure for table `earned_leave`
--

CREATE TABLE `earned_leave` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `present_date` varchar(64) DEFAULT NULL,
  `hour` varchar(64) DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `earned_leave`
--

INSERT INTO `earned_leave` (`id`, `em_id`, `present_date`, `hour`, `status`) VALUES
(26, 'Mir1685', '0', '0', '1'),
(27, 'Rah1682', '0', '0', '1'),
(28, 'edr1432', '0', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(128) DEFAULT NULL,
  `edu_type` varchar(256) DEFAULT NULL,
  `institute` varchar(256) DEFAULT NULL,
  `result` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `em_code` varchar(64) DEFAULT NULL,
  `des_id` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `em_email` varchar(64) DEFAULT NULL,
  `em_password` varchar(512) NOT NULL,
  `em_role` enum('ADMIN','EMPLOYEE','SUPER ADMIN') NOT NULL DEFAULT 'EMPLOYEE',
  `em_address` varchar(512) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `em_gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `em_phone` varchar(64) DEFAULT NULL,
  `em_birthday` varchar(128) DEFAULT NULL,
  `em_blood_group` enum('O+','O-','A+','A-','B+','B-','AB+','OB+') DEFAULT NULL,
  `em_joining_date` varchar(128) DEFAULT NULL,
  `em_contact_end` varchar(128) DEFAULT NULL,
  `em_image` varchar(128) DEFAULT NULL,
  `em_nid` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `em_id`, `em_code`, `des_id`, `dep_id`, `first_name`, `last_name`, `em_email`, `em_password`, `em_role`, `em_address`, `status`, `em_gender`, `em_phone`, `em_birthday`, `em_blood_group`, `em_joining_date`, `em_contact_end`, `em_image`, `em_nid`) VALUES
(10, 'Soy1332', '99', 12, 2, 'Adeline ', 'Daphne', 'abc@gmail.com', '996a3778768a2c3ea7c5b586fdfc92051dfdd39c', 'SUPER ADMIN', NULL, 'ACTIVE', 'Female', '01723177901', '2017-12-26', 'B+', '2018-01-06', '2018-01-06', 'Soy13321.jpg', '132154566556'),
(36, 'Doe1753', '123456', 12, 2, 'Jhon', 'Doe', 'admin@gmail.com', 'cd5ea73cd58f827fa78eef7197b8ee606c99b2e6', 'SUPER ADMIN', NULL, 'ACTIVE', 'Male', 'admin123456', '2019-02-13', 'O+', '2019-02-15', '2019-02-22', 'Doe1753.jpg', '01253568955555'),
(37, 'Doe1754', '123444', 12, 2, 'Jhon', 'Doe', 'employee@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'EMPLOYEE', NULL, 'ACTIVE', 'Male', 'abc123456', '2019-02-13', 'O+', '2019-02-15', '2019-02-22', 'Doe1753.jpg', '01253568955555'),
(38, 'Ver1716', '4455', 13, 5, 'Alana Thompson', 'Vera Boyle', 'sydugo@mailinator.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'EMPLOYEE', NULL, 'ACTIVE', '', 'Vero molestias ', '2010-06-12', 'AB+', '2023-01-20', '', NULL, 'A do rem nobis minim');

-- --------------------------------------------------------

--
-- Table structure for table `employee_file`
--

CREATE TABLE `employee_file` (
  `id` int(14) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `file_title` varchar(512) DEFAULT NULL,
  `file_url` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_assets`
--

CREATE TABLE `emp_assets` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `assets_id` int(11) NOT NULL,
  `given_date` date NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_experience`
--

CREATE TABLE `emp_experience` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(256) DEFAULT NULL,
  `exp_company` varchar(128) DEFAULT NULL,
  `exp_com_position` varchar(128) DEFAULT NULL,
  `exp_com_address` varchar(128) DEFAULT NULL,
  `exp_workduration` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave`
--

CREATE TABLE `emp_leave` (
  `id` int(11) NOT NULL,
  `em_id` varchar(64) DEFAULT NULL,
  `typeid` int(14) NOT NULL,
  `leave_type` varchar(64) DEFAULT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `end_date` varchar(64) DEFAULT NULL,
  `leave_duration` varchar(128) DEFAULT NULL,
  `apply_date` varchar(64) DEFAULT NULL,
  `reason` varchar(1024) DEFAULT NULL,
  `leave_status` enum('Approve','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_penalty`
--

CREATE TABLE `emp_penalty` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `penalty_id` int(11) NOT NULL,
  `penalty_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

CREATE TABLE `emp_salary` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `total` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `emp_salary`
--

INSERT INTO `emp_salary` (`id`, `emp_id`, `type_id`, `total`) VALUES
(25, 'Ver1716', 2, '5000'),
(26, 'Soy1332', 2, '7000');

-- --------------------------------------------------------

--
-- Table structure for table `emp_training`
--

CREATE TABLE `emp_training` (
  `id` int(11) NOT NULL,
  `trainig_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_visit`
--

CREATE TABLE `field_visit` (
  `id` int(14) NOT NULL,
  `project_id` varchar(256) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `field_location` varchar(512) NOT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `approx_end_date` varchar(28) NOT NULL,
  `total_days` varchar(64) DEFAULT NULL,
  `notes` varchar(500) NOT NULL,
  `actual_return_date` varchar(28) NOT NULL,
  `status` enum('Approved','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve',
  `attendance_updated` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `holiday_name` varchar(256) DEFAULT NULL,
  `from_date` varchar(64) DEFAULT NULL,
  `to_date` varchar(64) DEFAULT NULL,
  `number_of_days` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `holiday_name`, `from_date`, `to_date`, `number_of_days`, `year`) VALUES
(5, 'Christmas', '2023-12-25', '2023-12-25', '0', '12-2023');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `type_id` int(14) NOT NULL,
  `name` varchar(64) NOT NULL,
  `leave_day` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`type_id`, `name`, `leave_day`, `status`) VALUES
(1, 'Casual Leave', '21', 1),
(2, 'Sick Leave', '15', 1),
(3, 'Maternity Leave', '90', 1),
(4, 'Paternal Leave', '7', 1),
(5, 'Earned leave', '', 1),
(7, 'Public Holiday', '', 1),
(8, 'Optional Leave', '', 1),
(9, 'Leave without Pay', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(256) DEFAULT NULL,
  `amount` varchar(256) DEFAULT NULL,
  `interest_percentage` varchar(256) DEFAULT NULL,
  `total_amount` varchar(64) DEFAULT NULL,
  `total_pay` varchar(64) DEFAULT NULL,
  `total_due` varchar(64) DEFAULT NULL,
  `installment` varchar(256) DEFAULT NULL,
  `loan_number` varchar(256) DEFAULT NULL,
  `loan_details` varchar(256) DEFAULT NULL,
  `approve_date` varchar(256) DEFAULT NULL,
  `install_period` varchar(256) DEFAULT NULL,
  `status` enum('Granted','Deny','Pause','Done') NOT NULL DEFAULT 'Pause'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_installment`
--

CREATE TABLE `loan_installment` (
  `id` int(14) NOT NULL,
  `loan_id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `loan_number` varchar(256) DEFAULT NULL,
  `install_amount` varchar(256) DEFAULT NULL,
  `pay_amount` varchar(64) DEFAULT NULL,
  `app_date` varchar(256) DEFAULT NULL,
  `receiver` varchar(256) DEFAULT NULL,
  `install_no` varchar(256) DEFAULT NULL,
  `notes` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `loan_installment`
--

INSERT INTO `loan_installment` (`id`, `loan_id`, `emp_id`, `loan_number`, `install_amount`, `pay_amount`, `app_date`, `receiver`, `install_no`, `notes`) VALUES
(27, 33, 'Isl1385', '4008291', '5000', NULL, '2018-04-21', 'dsf dsf ds fds fdsf ds', '1', 'sf ds fsd fds fsd fdsf ds fsd'),
(28, 33, 'Isl1385', '4008291', '5000', NULL, '2018-04-04', 'dsdsff dsf ds f', '0', 'f dsfdsf dsfs'),
(29, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-04-05', NULL, '4', NULL),
(30, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-06-05', NULL, '3', NULL),
(31, 34, 'EMP1254478', '18194827', '5000', NULL, '2018-06-07', NULL, '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logistic_asset`
--

CREATE TABLE `logistic_asset` (
  `log_id` int(14) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `qty` varchar(64) DEFAULT NULL,
  `entry_date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `logistic_asset`
--

INSERT INTO `logistic_asset` (`log_id`, `name`, `qty`, `entry_date`) VALUES
(1, 'Lubricant', '30', '12/25/17');

-- --------------------------------------------------------

--
-- Table structure for table `logistic_assign`
--

CREATE TABLE `logistic_assign` (
  `ass_id` int(14) NOT NULL,
  `asset_id` int(14) NOT NULL,
  `assign_id` varchar(64) DEFAULT NULL,
  `project_id` int(14) NOT NULL,
  `task_id` int(14) NOT NULL,
  `log_qty` varchar(64) DEFAULT NULL,
  `start_date` varchar(64) DEFAULT NULL,
  `end_date` varchar(64) DEFAULT NULL,
  `back_date` varchar(64) DEFAULT NULL,
  `back_qty` varchar(64) DEFAULT NULL,
  `remarks` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `file_url` varchar(256) DEFAULT NULL,
  `date` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(64) NOT NULL,
  `owner_position` varchar(64) DEFAULT NULL,
  `note` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_salary`
--

CREATE TABLE `pay_salary` (
  `pay_id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `type_id` int(14) NOT NULL,
  `month` varchar(64) DEFAULT NULL,
  `year` varchar(64) DEFAULT NULL,
  `paid_date` varchar(64) DEFAULT NULL,
  `total_days` varchar(64) DEFAULT NULL,
  `basic` varchar(64) DEFAULT NULL,
  `medical` varchar(64) DEFAULT NULL,
  `house_rent` varchar(64) DEFAULT NULL,
  `bonus` varchar(64) DEFAULT NULL,
  `bima` varchar(64) DEFAULT NULL,
  `tax` varchar(64) DEFAULT NULL,
  `provident_fund` varchar(64) DEFAULT NULL,
  `loan` varchar(64) DEFAULT NULL,
  `total_pay` varchar(128) DEFAULT NULL,
  `addition` int(128) NOT NULL,
  `diduction` int(128) NOT NULL,
  `status` enum('Paid','Process') DEFAULT 'Process',
  `paid_type` enum('Hand Cash','Bank') NOT NULL DEFAULT 'Bank'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pay_salary`
--

INSERT INTO `pay_salary` (`pay_id`, `emp_id`, `type_id`, `month`, `year`, `paid_date`, `total_days`, `basic`, `medical`, `house_rent`, `bonus`, `bima`, `tax`, `provident_fund`, `loan`, `total_pay`, `addition`, `diduction`, `status`, `paid_type`) VALUES
(32, 'Ver1716', 0, 'December', '2023', '2023-12-13', '208.0', '5000', NULL, NULL, NULL, NULL, NULL, NULL, '0', '5000.32', 0, 0, 'Paid', 'Hand Cash'),
(33, 'Soy1332', 0, 'December', '2023', '2023-12-27', '20', '7000', NULL, NULL, NULL, NULL, NULL, NULL, '0', '673.00', 0, 6326, 'Paid', 'Hand Cash');

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(11) NOT NULL,
  `penalty_name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(14) NOT NULL,
  `pro_name` varchar(128) DEFAULT NULL,
  `pro_start_date` varchar(128) DEFAULT NULL,
  `pro_end_date` varchar(128) DEFAULT NULL,
  `pro_description` varchar(1024) DEFAULT NULL,
  `pro_summary` varchar(512) DEFAULT NULL,
  `pro_status` enum('upcoming','complete','running') NOT NULL DEFAULT 'running',
  `progress` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_file`
--

CREATE TABLE `project_file` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `file_details` varchar(1028) DEFAULT NULL,
  `file_url` varchar(256) DEFAULT NULL,
  `assigned_to` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_expenses`
--

CREATE TABLE `pro_expenses` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `assign_to` varchar(64) DEFAULT NULL,
  `details` varchar(512) DEFAULT NULL,
  `amount` varchar(256) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_notes`
--

CREATE TABLE `pro_notes` (
  `id` int(14) NOT NULL,
  `assign_to` varchar(64) DEFAULT NULL,
  `pro_id` int(14) NOT NULL,
  `details` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_task`
--

CREATE TABLE `pro_task` (
  `id` int(14) NOT NULL,
  `pro_id` int(14) NOT NULL,
  `task_title` varchar(256) DEFAULT NULL,
  `start_date` varchar(128) DEFAULT NULL,
  `end_date` varchar(128) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `task_type` enum('Office','Field') NOT NULL DEFAULT 'Office',
  `status` enum('running','complete','cancel') DEFAULT 'running',
  `location` varchar(512) DEFAULT NULL,
  `return_date` varchar(128) DEFAULT NULL,
  `total_days` varchar(128) DEFAULT NULL,
  `create_date` varchar(128) DEFAULT NULL,
  `approve_status` enum('Approved','Not Approve','Rejected') NOT NULL DEFAULT 'Not Approve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pro_task_assets`
--

CREATE TABLE `pro_task_assets` (
  `id` int(11) NOT NULL,
  `pro_task_id` int(11) NOT NULL,
  `assign_id` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_type`
--

CREATE TABLE `salary_type` (
  `id` int(14) NOT NULL,
  `salary_type` varchar(256) DEFAULT NULL,
  `create_date` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `salary_type`
--

INSERT INTO `salary_type` (`id`, `salary_type`, `create_date`) VALUES
(1, 'Hourly', '2017-11-22'),
(2, 'Monthly', '2017-12-30'),
(3, 'hhfgf', '2017-12-29'),
(4, 'Hourly', '2018-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `sitelogo` varchar(128) DEFAULT NULL,
  `sitetitle` varchar(256) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `copyright` varchar(128) DEFAULT NULL,
  `contact` varchar(128) DEFAULT NULL,
  `currency` varchar(128) DEFAULT NULL,
  `symbol` varchar(64) DEFAULT NULL,
  `system_email` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `address2` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sitelogo`, `sitetitle`, `description`, `copyright`, `contact`, `currency`, `symbol`, `system_email`, `address`, `address2`) VALUES
(1, 'HRPAYROLL11.png', 'Poppel HR & Payroll', 'PÖPPEL Abfallwirtschaft und Städtereinigung GmbH - DAS SIND WIR', 'Germany', '+49944150560', 'EUR', '$', 'michael.poeppel@poeppel.de', 'Am Kastlacker 6, 93309 Kelheim', 'Kelheim');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(14) NOT NULL,
  `emp_id` varchar(64) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `google_plus` varchar(512) DEFAULT NULL,
  `skype_id` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `to-do_list`
--

CREATE TABLE `to-do_list` (
  `id` int(14) NOT NULL,
  `user_id` varchar(64) DEFAULT NULL,
  `to_dodata` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `value` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addition`
--
ALTER TABLE `addition`
  ADD PRIMARY KEY (`addi_id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`ass_id`);

--
-- Indexes for table `assets_category`
--
ALTER TABLE `assets_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `assign_leave`
--
ALTER TABLE `assign_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_task`
--
ALTER TABLE `assign_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_info`
--
ALTER TABLE `bank_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`de_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desciplinary`
--
ALTER TABLE `desciplinary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `earned_leave`
--
ALTER TABLE `earned_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_file`
--
ALTER TABLE `employee_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_assets`
--
ALTER TABLE `emp_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_experience`
--
ALTER TABLE `emp_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leave`
--
ALTER TABLE `emp_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_penalty`
--
ALTER TABLE `emp_penalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_salary`
--
ALTER TABLE `emp_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_visit`
--
ALTER TABLE `field_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_installment`
--
ALTER TABLE `loan_installment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistic_asset`
--
ALTER TABLE `logistic_asset`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `logistic_assign`
--
ALTER TABLE `logistic_assign`
  ADD PRIMARY KEY (`ass_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_salary`
--
ALTER TABLE `pay_salary`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_file`
--
ALTER TABLE `project_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_expenses`
--
ALTER TABLE `pro_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_notes`
--
ALTER TABLE `pro_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_task`
--
ALTER TABLE `pro_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pro_task_assets`
--
ALTER TABLE `pro_task_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_type`
--
ALTER TABLE `salary_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `to-do_list`
--
ALTER TABLE `to-do_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addition`
--
ALTER TABLE `addition`
  MODIFY `addi_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `ass_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `assets_category`
--
ALTER TABLE `assets_category`
  MODIFY `cat_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assign_leave`
--
ALTER TABLE `assign_leave`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `assign_task`
--
ALTER TABLE `assign_task`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT for table `bank_info`
--
ALTER TABLE `bank_info`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `de_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `desciplinary`
--
ALTER TABLE `desciplinary`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `earned_leave`
--
ALTER TABLE `earned_leave`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `employee_file`
--
ALTER TABLE `employee_file`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `emp_assets`
--
ALTER TABLE `emp_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_experience`
--
ALTER TABLE `emp_experience`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `emp_leave`
--
ALTER TABLE `emp_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `emp_penalty`
--
ALTER TABLE `emp_penalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_salary`
--
ALTER TABLE `emp_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `field_visit`
--
ALTER TABLE `field_visit`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `type_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `loan_installment`
--
ALTER TABLE `loan_installment`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `logistic_asset`
--
ALTER TABLE `logistic_asset`
  MODIFY `log_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logistic_assign`
--
ALTER TABLE `logistic_assign`
  MODIFY `ass_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pay_salary`
--
ALTER TABLE `pay_salary`
  MODIFY `pay_id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_file`
--
ALTER TABLE `project_file`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pro_expenses`
--
ALTER TABLE `pro_expenses`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pro_notes`
--
ALTER TABLE `pro_notes`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pro_task`
--
ALTER TABLE `pro_task`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pro_task_assets`
--
ALTER TABLE `pro_task_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_type`
--
ALTER TABLE `salary_type`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `to-do_list`
--
ALTER TABLE `to-do_list`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
