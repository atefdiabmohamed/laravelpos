-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 12:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `account_type` int(11) NOT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT 0,
  `parent_account_number` bigint(20) DEFAULT NULL,
  `account_number` bigint(20) NOT NULL,
  `start_balance_status` tinyint(4) NOT NULL COMMENT 'e 1-credit -2 debit 3-balanced',
  `start_balance` decimal(10,2) NOT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `other_table_FK` bigint(20) DEFAULT NULL,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'هل مفعل',
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `account_type`, `is_parent`, `parent_account_number`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `other_table_FK`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`) VALUES
(1, 'الموردين الاب', 9, 1, NULL, 1, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:43:44', '2022-09-22 22:43:44', 1, 1, '2022-09-22'),
(2, 'البنوك الاب', 9, 1, NULL, 2, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:43:59', '2022-09-22 22:43:59', 1, 1, '2022-09-22'),
(3, 'العملاء الاب', 9, 1, NULL, 3, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:44:13', '2022-09-22 22:44:13', 1, 1, '2022-09-22'),
(4, 'عاطف دياب محمد', 2, 0, 1, 4, 1, '-5000.00', '-86600.00', 1, NULL, 1, 1, '2022-09-22 22:45:06', '2022-12-19 01:27:46', 1, 1, '2022-09-22'),
(5, 'بنك فيصل الاسلامي', 6, 0, 2, 5, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 23:00:51', '2022-10-09 04:23:21', 1, 1, '2022-09-22'),
(6, 'محمود محمد', 2, 0, 1, 6, 3, '0.00', '-18900.00', 2, NULL, 1, 1, '2022-09-22 23:29:29', '2022-09-30 09:14:22', 1, 1, '2022-09-22'),
(7, 'المريوطي للبقالة', 3, 0, 3, 7, 2, '5000.00', '5000.00', 3, NULL, 1, 1, '2022-10-03 06:07:00', '2022-11-19 10:39:00', 1, 1, '2022-10-03'),
(8, 'الحساب الاب للمناديب', 9, 1, NULL, 8, 3, '0.00', '0.00', NULL, NULL, 1, 1, '2022-10-06 02:52:13', '2022-10-06 14:30:09', 1, 1, '2022-10-06'),
(9, 'الموظفين الاب', 9, 1, NULL, 9, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-10-06 02:52:31', '2022-10-06 02:52:31', 1, 1, '2022-10-06'),
(10, 'المصروفات الاب', 7, 1, NULL, 10, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-10-06 03:44:39', '2022-10-06 03:44:39', 1, 1, '2022-10-06'),
(11, 'كافتريا الرحاب', 7, 0, 10, 11, 1, '-900.00', '-500.00', NULL, NULL, 1, NULL, '2022-10-06 03:45:25', '2022-10-08 00:34:35', 1, 1, '2022-10-06'),
(12, 'مطعم الاحمدي', 7, 0, 10, 12, 1, '-350.00', '-350.00', NULL, NULL, 1, 1, '2022-10-06 03:47:56', '2022-10-08 00:33:33', 1, 1, '2022-10-06'),
(13, 'كافتريا  الاندلس', 7, 0, 12, 13, 1, '-350.00', '-350.00', NULL, NULL, 1, NULL, '2022-10-06 03:48:36', '2022-10-06 03:48:36', 1, 1, '2022-10-06'),
(14, 'بنك فيصل', 6, 0, 2, 14, 2, '100000.00', '50000.00', NULL, NULL, 1, 1, '2022-10-06 03:49:48', '2022-10-31 13:33:40', 1, 1, '2022-10-06'),
(15, 'فواتير الغاز', 7, 0, 10, 15, 3, '0.00', '0.00', NULL, NULL, 1, 1, '2022-10-06 14:16:20', '2022-10-06 14:29:21', 0, 1, '2022-10-06'),
(16, 'محمود السيد علي', 3, 0, 3, 16, 2, '5000.00', '4500.00', 4, 'تأخر سداد', 1, 1, '2022-10-06 14:39:03', '2022-11-19 11:13:50', 1, 1, '2022-10-06'),
(17, 'الاحمدي للفراخ المجمده', 2, 0, 1, 17, 1, '-5000.00', '-5000.00', 3, 'بانتظار طلبية رقم 15', 1, NULL, '2022-10-06 15:00:21', '2022-10-08 01:57:42', 1, 1, '2022-10-06'),
(18, 'ابو مازن  للفراخ المجمده', 2, 0, 1, 18, 1, '-5000.00', '-5000.00', 4, 'بانتظار طلبية', 1, 1, '2022-10-06 15:02:02', '2022-10-06 15:03:11', 0, 1, '2022-10-06'),
(19, 'محمود البنا', 4, 0, 8, 19, 1, '-500.00', '-500.00', 2, 'احسن مندوب', 1, 1, '2022-10-06 17:14:47', '2022-10-08 01:24:08', 1, 1, '2022-10-06'),
(20, 'معاذ ابو جبل', 4, 0, 8, 20, 3, '0.00', '0.00', 3, NULL, 1, 1, '2022-10-06 17:19:33', '2022-10-08 01:24:19', 1, 1, '2022-10-06'),
(21, 'البدري للحوم المجمده', 2, 0, 1, 21, 1, '0.00', '-48100.00', 5, NULL, 1, 1, '2022-10-07 23:56:14', '2022-12-18 01:44:06', 1, 1, '2022-10-07'),
(22, 'محمود عز الدين', 3, 0, 3, 22, 3, '0.00', '0.00', 5, NULL, 1, NULL, '2022-10-27 23:11:59', '2022-10-27 23:11:59', 1, 1, '2022-10-27'),
(23, 'عز الدين علي', 3, 0, 3, 23, 3, '0.00', '0.00', 6, NULL, 1, NULL, '2022-10-27 23:27:39', '2022-10-27 23:27:39', 1, 1, '2022-10-27'),
(24, 'حمدي خليفه علي', 3, 0, 3, 24, 3, '0.00', '0.00', 7, NULL, 1, NULL, '2022-10-27 23:28:52', '2022-10-27 23:28:52', 1, 1, '2022-10-27'),
(25, 'علي هاشم محمود السيد', 3, 0, 3, 25, 3, '0.00', '0.00', 8, NULL, 1, NULL, '2022-10-27 23:29:37', '2022-12-02 13:56:50', 1, 1, '2022-10-27'),
(26, 'عمر علي السيد', 3, 0, 3, 26, 3, '0.00', '500.00', 9, NULL, 1, NULL, '2022-10-28 16:07:47', '2022-12-05 23:24:37', 1, 1, '2022-10-28'),
(27, 'محمود هاشم احمد', 3, 0, 3, 27, 3, '0.00', '0.00', 10, NULL, 1, NULL, '2022-10-28 16:16:36', '2022-11-06 09:23:20', 1, 1, '2022-10-28'),
(28, 'السيد ابو الوفا', 3, 0, 3, 28, 3, '0.00', '0.00', 11, NULL, 1, NULL, '2022-10-28 17:59:29', '2022-10-28 17:59:29', 1, 1, '2022-10-28'),
(29, 'حمدان عيسي سلام', 3, 0, 3, 29, 3, '0.00', '0.00', 12, NULL, 1, NULL, '2022-10-28 18:02:52', '2022-10-31 15:48:08', 1, 1, '2022-10-28'),
(30, 'منصور سالم البدري', 3, 0, 3, 30, 3, '0.00', '0.00', 13, NULL, 1, NULL, '2022-10-30 00:16:23', '2022-11-06 09:19:58', 1, 1, '2022-10-30'),
(31, 'فوزي السيد حمدان', 3, 0, 3, 31, 3, '0.00', '-1000.00', 14, NULL, 1, NULL, '2022-10-31 09:28:00', '2022-11-06 09:32:41', 1, 1, '2022-10-31'),
(32, 'هاشم محمد احمد السيد', 4, 0, 8, 32, 1, '-1000.00', '-194.00', 4, NULL, 1, NULL, '2022-11-06 08:56:28', '2022-12-08 02:16:38', 1, 1, '2022-11-06'),
(33, 'شركة الرميزان للأجهزة الثقيله', 9, 0, 10, 33, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-11-22 17:41:58', '2022-12-02 13:39:13', 1, 1, '2022-11-22'),
(34, 'الحساب المالي الاب لخطوط الانتاج', 9, 1, NULL, 34, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2023-01-04 02:48:02', '2023-01-04 02:48:02', 1, 1, '2023-01-04'),
(36, 'خط انتاج الافران الكبيره', 5, 0, 34, 35, 3, '0.00', '0.00', 1, NULL, 1, 1, '2023-01-04 02:55:26', '2023-01-07 01:02:45', 1, 1, '2023-01-04'),
(37, 'خط اننتاج غسالات عادية', 5, 0, 34, 36, 3, '0.00', '0.00', 2, NULL, 1, NULL, '2023-01-07 01:10:00', '2023-01-07 01:10:00', 1, 1, '2023-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `relatediternalaccounts` tinyint(4) NOT NULL COMMENT 'هل الحساب يتم تكويده من شاشته الداخلية ام من خلال الشاشه الرئيسية للحسابات\r\nواحد داخلي - صفر من الشاشه الرئيسية'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `active`, `relatediternalaccounts`) VALUES
(1, 'رأس المال', 1, 0),
(2, 'مورد', 1, 1),
(3, 'عميل', 1, 1),
(4, 'مندوب', 1, 1),
(5, 'خط انتاج', 1, 1),
(6, 'بنكي', 1, 0),
(7, 'مصروفات', 1, 0),
(8, 'قسم داخلي', 1, 1),
(9, 'عام', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `password`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`) VALUES
(1, 'admin', 'test@gmail.com', 'admin', '$2y$10$qHBrpnmqcJgMX/29x92EA.QbD7T5PWKvYO3p.RH2jclPuE4gEGqBe', '2022-08-27 15:59:31', '2022-08-27 15:59:31', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admins_shifts`
--

CREATE TABLE `admins_shifts` (
  `id` bigint(20) NOT NULL,
  `shift_code` bigint(20) NOT NULL COMMENT 'كود الشفت المستخدم بالربط مع جدول حركة النقدية',
  `admin_id` int(11) NOT NULL,
  `treasuries_id` int(11) NOT NULL,
  `treasuries_balnce_in_shift_start` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'رصيد الخزنة في بدايه استلام الشفت للمستخدم',
  `start_date` datetime NOT NULL COMMENT 'توقيت بدايه الشفت',
  `end_date` datetime DEFAULT NULL,
  `is_finished` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل تم انتهاء الشفت',
  `is_delivered_and_review` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل تم مرراجعه واستلام شفت الخزنة',
  `delivered_to_admin_id` int(11) DEFAULT NULL COMMENT 'كود المستخدم الذي تسلم هذا الشفت واراجعه',
  `delivered_to_admin_sift_id` bigint(20) DEFAULT NULL COMMENT 'كود الشفت الذي تسلم هذا الشفت وارجعه',
  `delivered_to_treasuries_id` int(11) DEFAULT NULL COMMENT 'كود الخزنه التي راجعت واستلمت هذا الشفت',
  `money_should_deviled` decimal(10,2) DEFAULT NULL COMMENT 'النقدية التي يفترض ان تسلم ',
  `what_realy_delivered` decimal(10,2) DEFAULT NULL COMMENT 'المبلغ الفعلي الذي تم تسلمه ',
  `money_state` tinyint(1) DEFAULT NULL COMMENT '0-blanced -1-inability 2-extra \r\nصفر متزن - واحد  يوجد عز - اثنين يوجد زيادة',
  `money_state_value` decimal(10,2) DEFAULT NULL COMMENT 'قيمة العجز او الزياده ان وجدت',
  `receive_type` tinyint(1) DEFAULT NULL COMMENT 'واحد استلام علي نفس الخزنة - اثنين استلام علي خزنة اخري',
  `review_receive_date` datetime DEFAULT NULL COMMENT 'تاريخ مراجعه واستلام هذا الشفت',
  `treasuries_transactions_id` bigint(20) DEFAULT NULL COMMENT 'رقم الايصال بجدول تحصيل النقدية لحركة الخزن',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول شفتات الخزن للمستخدمين ';

--
-- Dumping data for table `admins_shifts`
--

INSERT INTO `admins_shifts` (`id`, `shift_code`, `admin_id`, `treasuries_id`, `treasuries_balnce_in_shift_start`, `start_date`, `end_date`, `is_finished`, `is_delivered_and_review`, `delivered_to_admin_id`, `delivered_to_admin_sift_id`, `delivered_to_treasuries_id`, `money_should_deviled`, `what_realy_delivered`, `money_state`, `money_state_value`, `receive_type`, `review_receive_date`, `treasuries_transactions_id`, `added_by`, `created_at`, `notes`, `com_code`, `date`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, '0.00', '2022-09-17 22:47:52', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2022-09-17 22:47:52', NULL, 1, '2022-09-17', NULL, '2022-09-17 22:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `admins_treasuries`
--

CREATE TABLE `admins_treasuries` (
  `id` int(11) NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `treasuries_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='صلاحيات خزن المستخدمين الخاصة';

--
-- Dumping data for table `admins_treasuries`
--

INSERT INTO `admins_treasuries` (`id`, `admin_id`, `treasuries_id`, `active`, `added_by`, `created_at`, `updated_by`, `updated_at`, `com_code`, `date`) VALUES
(1, 1, 1, 1, 1, '2022-09-16 14:34:11', 1, '2022-09-16 14:34:11', 1, '2022-09-16'),
(2, 1, 3, 1, 1, '2022-09-16 18:39:21', NULL, '2022-09-16 18:39:21', 1, '2022-09-16'),
(3, 1, 4, 1, 1, '2022-09-16 18:39:26', NULL, '2022-09-16 18:39:26', 1, '2022-09-16');

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel_settings`
--

CREATE TABLE `admin_panel_settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(250) NOT NULL,
  `photo` varchar(225) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `general_alert` varchar(150) DEFAULT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `customer_parent_account_number` bigint(20) NOT NULL COMMENT 'رقم الحساب الاب للعملاء',
  `suppliers_parent_account_number` bigint(20) NOT NULL COMMENT 'الحساب الاب للموردين',
  `delegate_parent_account_number` bigint(20) NOT NULL COMMENT 'رقم الحساب المالي  لحساب الاب للمناديب',
  `employees_parent_account_number` bigint(20) NOT NULL COMMENT 'رقم الحساب المالي للموظفين الاب',
  `production_lines_parent_account` bigint(20) NOT NULL COMMENT 'كود الحساب الاب لخطوط الانتاج',
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `system_name`, `photo`, `active`, `general_alert`, `address`, `phone`, `customer_parent_account_number`, `suppliers_parent_account_number`, `delegate_parent_account_number`, `employees_parent_account_number`, `production_lines_parent_account`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `notes`) VALUES
(1, 'حلول للكمبوتير بسوهاج', '1667938745648.png', 1, NULL, 'سوهاج - كوبري النيل', '012659854', 3, 1, 8, 9, 34, 0, 1, '0000-00-00 00:00:00', '2023-01-04 02:48:18', 1, 'الاضافة بالمبيعات  ctrl او enter');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) NOT NULL,
  `customer_code` bigint(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `account_number` bigint(20) NOT NULL,
  `start_balance_status` tinyint(4) NOT NULL COMMENT 'e 1-credit -2 debit 3-balanced',
  `start_balance` decimal(10,2) NOT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phones` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(6, 1, 'سوبر ماركت السلامة', 5, 3, '0.00', '0.00', NULL, 1, 1, '2022-09-10 14:29:09', '2022-10-14 04:13:11', 1, 1, '2022-09-10', 'ش 16', '89858574'),
(7, 2, 'هايبر الرحاب', 6, 3, '0.00', '0.00', NULL, 1, 1, '2022-09-10 14:41:48', '2022-10-14 04:13:06', 1, 1, '2022-09-10', 'ش 16', '056958752'),
(8, 3, 'المريوطي للبقالة', 7, 2, '5000.00', '5000.00', NULL, 1, 1, '2022-10-03 06:07:00', '2022-11-19 10:39:00', 1, 1, '2022-10-03', 'ش 16', '0565985'),
(9, 4, 'محمود السيد علي', 16, 2, '5000.00', '4500.00', 'تأخر سداد', 1, 1, '2022-10-06 14:39:03', '2022-11-19 11:13:50', 1, 1, '2022-10-06', 'ش 15', '056298574'),
(10, 5, 'محمود عز الدين', 22, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-27 23:11:59', '2022-10-27 23:11:59', 1, 1, '2022-10-27', 'ش 16', '5654555456'),
(11, 6, 'عز الدين علي', 23, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-27 23:27:39', '2022-10-27 23:27:39', 1, 1, '2022-10-27', NULL, NULL),
(12, 7, 'حمدي خليفه علي', 24, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-27 23:28:52', '2022-10-27 23:28:52', 1, 1, '2022-10-27', NULL, NULL),
(13, 8, 'علي هاشم محمود السيد', 25, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-27 23:29:37', '2022-12-02 13:56:50', 1, 1, '2022-10-27', NULL, NULL),
(14, 9, 'عمر علي السيد', 26, 3, '0.00', '500.00', NULL, 1, NULL, '2022-10-28 16:07:47', '2022-12-05 23:24:37', 1, 1, '2022-10-28', NULL, NULL),
(15, 10, 'محمود هاشم احمد', 27, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-28 16:16:36', '2022-11-06 09:23:20', 1, 1, '2022-10-28', NULL, NULL),
(16, 11, 'السيد ابو الوفا', 28, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-28 17:59:29', '2022-10-28 17:59:29', 1, 1, '2022-10-28', NULL, NULL),
(17, 12, 'حمدان عيسي سلام', 29, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-28 18:02:52', '2022-10-31 15:48:08', 1, 1, '2022-10-28', NULL, NULL),
(18, 13, 'منصور سالم البدري', 30, 3, '0.00', '0.00', NULL, 1, NULL, '2022-10-30 00:16:23', '2022-11-06 09:19:58', 1, 1, '2022-10-30', NULL, NULL),
(19, 14, 'فوزي السيد حمدان', 31, 3, '0.00', '-1000.00', NULL, 1, NULL, '2022-10-31 09:28:00', '2022-11-06 09:32:41', 1, 1, '2022-10-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delegates`
--

CREATE TABLE `delegates` (
  `id` bigint(20) NOT NULL,
  `delegate_code` bigint(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `account_number` bigint(20) NOT NULL,
  `start_balance_status` tinyint(4) NOT NULL COMMENT 'e 1-credit -2 debit 3-balanced',
  `start_balance` decimal(10,2) NOT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `phones` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `percent_type` tinyint(4) NOT NULL COMMENT 'نوع عمولة المندوب  بشكل عام\r\nواحد اجر ثابت لكل فاتورة - لو اتنين  نسبة بكل فاتورة	',
  `percent_collect_commission` decimal(10,2) NOT NULL COMMENT 'نسبة المندوب بالتحصيل  الفواتير الاجل ',
  `percent_salaes_commission_kataei` decimal(10,2) NOT NULL COMMENT 'نسبة عمولة المندوب بالمبيعات قطاعلي	',
  `percent_salaes_commission_nosjomla` decimal(10,2) NOT NULL COMMENT 'عمول المندوب بمبيعات نص الجملة	',
  `percent_salaes_commission_jomla` decimal(10,2) NOT NULL COMMENT 'نسبة عمولة المندوب بالمبيعات بالجملة	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول المناديب';

--
-- Dumping data for table `delegates`
--

INSERT INTO `delegates` (`id`, `delegate_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `phones`, `address`, `percent_type`, `percent_collect_commission`, `percent_salaes_commission_kataei`, `percent_salaes_commission_nosjomla`, `percent_salaes_commission_jomla`) VALUES
(1, 1, 'المكتب', 6, 0, '0.00', '0.00', NULL, 1, 1, '2022-09-29 00:29:26', '2022-11-09 22:02:56', 1, 1, '2022-09-29', '5446454', NULL, 2, '0.00', '0.00', '0.00', '0.00'),
(2, 2, 'محمود البنا', 19, 1, '-500.00', '-500.00', 'احسن مندوب', 1, 1, '2022-10-06 17:14:47', '2022-10-08 01:24:08', 1, 1, '2022-10-06', '5446454', 'ش 16', 2, '1.75', '1.00', '1.50', '2.00'),
(3, 3, 'معاذ ابو جبل', 20, 3, '0.00', '0.00', 'احسن مندوب', 1, 1, '2022-10-06 17:19:32', '2022-10-08 01:24:19', 1, 1, '2022-10-06', '5446454', 'ش 17', 2, '150.00', '150.00', '150.00', '150.00'),
(4, 4, 'هاشم محمد احمد السيد', 32, 1, '-1000.00', '-194.00', NULL, 1, NULL, '2022-11-06 08:56:28', '2022-12-08 02:16:38', 1, 1, '2022-11-06', NULL, NULL, 2, '0.00', '2.00', '1.00', '0.50');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard`
--

CREATE TABLE `inv_itemcard` (
  `id` bigint(20) NOT NULL,
  `item_code` bigint(20) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `name` varchar(225) NOT NULL,
  `item_type` tinyint(1) NOT NULL COMMENT 'واحد  مخزني - اتنين استهلاكي - ثلاثه عهده',
  `inv_itemcard_categories_id` int(11) NOT NULL,
  `parent_inv_itemcard_id` bigint(20) DEFAULT NULL COMMENT 'كود الصنف الاب له',
  `does_has_retailunit` tinyint(1) NOT NULL COMMENT 'هل للصنف وحده تجزئة',
  `retail_uom_id` int(11) DEFAULT NULL COMMENT 'كود وحده  قياس التجزئة ',
  `uom_id` int(11) NOT NULL COMMENT 'كود وحده  قياس الاب',
  `retail_uom_quntToParent` decimal(10,2) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `com_code` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL COMMENT 'السعر القطاعي بوحدة القياس الاساسية	',
  `nos_gomla_price` decimal(10,2) NOT NULL COMMENT 'سعر النص جملة مع الوحده الاب	',
  `gomla_price` decimal(10,2) NOT NULL COMMENT 'السعر جملة بوحدة القياس الاساسية	',
  `price_retail` decimal(10,2) DEFAULT NULL COMMENT 'السعر القطاعي بوحدة قياس التجزئة	',
  `nos_gomla_price_retail` decimal(10,2) DEFAULT NULL COMMENT 'سعر النص جملة قطاعي مع الوحده التجزئة	',
  `gomla_price_retail` decimal(10,2) DEFAULT NULL COMMENT 'السعر الجملة بوحدة قياس التجزئة	',
  `cost_price` decimal(10,2) NOT NULL COMMENT 'متوسط التكلفة للصنف بالوحدة الاساسية	',
  `cost_price_retail` decimal(10,2) DEFAULT NULL COMMENT 'متوسط التكلفة للصنف بوحدة قياس التجزئة	',
  `has_fixced_price` tinyint(1) NOT NULL COMMENT 'هل للصنف سعر ثابت بالفواتير  او قابل للتغير بالفواتير',
  `All_QUENTITY` decimal(10,2) DEFAULT NULL COMMENT 'كل كمية الصنف بوحده الاب مباشره بدون اي تحويلات',
  `QUENTITY` decimal(10,3) DEFAULT NULL COMMENT 'كل الكمية بوحده الاب بدون الفكه في حاله  لديه وحده تجزئة',
  `QUENTITY_Retail` decimal(10,3) DEFAULT NULL COMMENT 'كمية التجزئة المتبقية من الوحده الاب في حالة وجود وحده تجزئة للصنف',
  `QUENTITY_all_Retails` decimal(10,3) DEFAULT NULL COMMENT 'كل الكمية محولة بوحده التجزئة ',
  `photo` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inv_itemcard`
--

INSERT INTO `inv_itemcard` (`id`, `item_code`, `barcode`, `name`, `item_type`, `inv_itemcard_categories_id`, `parent_inv_itemcard_id`, `does_has_retailunit`, `retail_uom_id`, `uom_id`, `retail_uom_quntToParent`, `added_by`, `created_at`, `updated_at`, `updated_by`, `active`, `date`, `com_code`, `price`, `nos_gomla_price`, `gomla_price`, `price_retail`, `nos_gomla_price_retail`, `gomla_price_retail`, `cost_price`, `cost_price_retail`, `has_fixced_price`, `All_QUENTITY`, `QUENTITY`, `QUENTITY_Retail`, `QUENTITY_all_Retails`, `photo`) VALUES
(1, 1, 'item1', 'شماعات بلاستيك', 1, 6, 0, 0, NULL, 10, NULL, 1, '2022-12-19 01:27:11', '2023-01-10 00:43:33', NULL, 1, '2022-12-19', 1, '20.00', '18.00', '16.00', NULL, NULL, NULL, '14.00', NULL, 1, '948.00', '948.000', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_batches`
--

CREATE TABLE `inv_itemcard_batches` (
  `id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT 'كود المخزن',
  `item_code` int(11) NOT NULL COMMENT 'كود الصنف الالي ',
  `inv_uoms_id` int(11) NOT NULL COMMENT 'كود الوحده الاب ',
  `unit_cost_price` decimal(10,2) NOT NULL COMMENT 'سعر الشراء للوحده',
  `quantity` decimal(10,2) NOT NULL COMMENT 'الكمية بالوحده الاب',
  `total_cost_price` decimal(10,2) NOT NULL COMMENT 'اجمالي سعر شراء الباتش ككل',
  `production_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `auto_serial` bigint(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_send_to_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول  باتشات الاصناف بالمخازن';

--
-- Dumping data for table `inv_itemcard_batches`
--

INSERT INTO `inv_itemcard_batches` (`id`, `store_id`, `item_code`, `inv_uoms_id`, `unit_cost_price`, `quantity`, `total_cost_price`, `production_date`, `expired_date`, `com_code`, `auto_serial`, `added_by`, `created_at`, `updated_at`, `updated_by`, `is_send_to_archived`) VALUES
(1, 1, 1, 10, '14.00', '948.00', '13272.00', NULL, NULL, 1, 1, 1, '2022-12-19 01:27:46', '2023-01-10 00:43:32', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_categories`
--

CREATE TABLE `inv_itemcard_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول فئات الاصناف';

--
-- Dumping data for table `inv_itemcard_categories`
--

INSERT INTO `inv_itemcard_categories` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم ومجمدات', '2022-09-02 00:35:47', '2022-09-02 00:35:47', 1, NULL, 1, '2022-09-02', 1),
(3, 'حبوب', '2022-09-02 00:56:29', '2022-09-02 00:56:29', 1, NULL, 1, '2022-09-02', 1),
(4, 'مخللات', '2022-09-02 01:21:06', '2022-09-02 01:21:06', 1, NULL, 1, '2022-09-02', 1),
(5, 'بقوليات', '2022-10-11 08:34:41', '2022-10-14 03:38:39', 1, 1, 1, '2022-10-11', 1),
(6, 'خردوات', '2022-12-19 01:26:03', '2022-12-19 01:26:03', 1, NULL, 1, '2022-12-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_movements`
--

CREATE TABLE `inv_itemcard_movements` (
  `id` bigint(20) NOT NULL,
  `inv_itemcard_movements_categories` int(11) NOT NULL,
  `item_code` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT 'كود المخزن',
  `items_movements_types` int(11) NOT NULL,
  `FK_table` bigint(20) NOT NULL,
  `FK_table_details` bigint(20) NOT NULL,
  `byan` varchar(100) NOT NULL,
  `quantity_befor_movement` varchar(60) NOT NULL COMMENT 'بكل المخازن',
  `quantity_after_move` varchar(60) NOT NULL COMMENT 'بكل المخازن',
  `added_by` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `com_code` int(11) NOT NULL,
  `quantity_befor_move_store` varchar(60) NOT NULL COMMENT 'كل الكمية للصنف قبل الحركة  بالمخزن المحدد مع الحركة',
  `quantity_after_move_store` varchar(60) NOT NULL COMMENT 'كل الكمية للصنف بعد الحركة  بالمخزن المحدد مع الحركة'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inv_itemcard_movements`
--

INSERT INTO `inv_itemcard_movements` (`id`, `inv_itemcard_movements_categories`, `item_code`, `store_id`, `items_movements_types`, `FK_table`, `FK_table_details`, `byan`, `quantity_befor_movement`, `quantity_after_move`, `added_by`, `date`, `created_at`, `com_code`, `quantity_befor_move_store`, `quantity_after_move_store`) VALUES
(1, 1, 1, 1, 1, 6, 12, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 6', 'عدد  0 وحده', 'عدد  1000 وحده', 1, '2022-12-19', '2022-12-19 01:27:46', 1, 'عدد  0 وحده', 'عدد  1000 وحده'),
(2, 3, 1, 1, 6, 1, 1, 'جرد بالمخازن للباتش رقم 1 جرد رقم 1', 'عدد  1000 وحده', 'عدد  950 وحده', 1, '2022-12-19', '2022-12-19 01:30:02', 1, 'عدد  1000 وحده', 'عدد  950 وحده'),
(3, 1, 1, 1, 3, 4, 13, ' نظير مرتجع مشتريات عام الي المورد الاحمدي للفراخ المجمده فاتورة رقم 4', 'عدد  950 وحده', 'عدد  949 وحده', 1, '2023-01-10', '2023-01-10 00:43:26', 1, 'عدد  950 وحده', 'عدد  949 وحده'),
(4, 1, 1, 1, 3, 4, 14, ' نظير مرتجع مشتريات عام الي المورد الاحمدي للفراخ المجمده فاتورة رقم 4', 'عدد  949 وحده', 'عدد  948 وحده', 1, '2023-01-10', '2023-01-10 00:43:32', 1, 'عدد  949 وحده', 'عدد  948 وحده');

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_movements_categories`
--

CREATE TABLE `inv_itemcard_movements_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inv_itemcard_movements_categories`
--

INSERT INTO `inv_itemcard_movements_categories` (`id`, `name`) VALUES
(1, 'حركة علي المشتريات'),
(2, 'حركة علي المبيعات'),
(3, 'حركة علي المخازن');

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_movements_types`
--

CREATE TABLE `inv_itemcard_movements_types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inv_itemcard_movements_types`
--

INSERT INTO `inv_itemcard_movements_types` (`id`, `type`) VALUES
(1, 'مشتريات '),
(2, 'مرتجع مشتريات بأصل الفاتورة'),
(3, 'مرتجع مشتريات عام'),
(4, 'مبيعات'),
(5, 'مرتجع مبيعات عام'),
(6, 'جرد بالمخازن'),
(7, 'مرتجع صرف داخلي لمندوب'),
(8, 'تحويل بين مخازن'),
(9, 'مبيعات صرف مباشر لعميل'),
(10, 'مبيعات صرف لمندوب التوصيل'),
(11, 'صرف خامات لخط التصنيع'),
(12, 'رد خامات من خط التصنيع'),
(13, 'استلام انتاج تام من خط التصنيع'),
(14, 'رد انتاج تام الي خط التصنيع'),
(15, 'حذف الصنف من تفاصيل فاتورة مبيعات مفتوحة'),
(16, 'حذف الصنف من تفاصيل فاتورة مرتجع مبيعات عام مفتوحة');

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_exchange`
--

CREATE TABLE `inv_production_exchange` (
  `id` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT 'واحد صرف خامات من المخزن للخط - اتنثين مرتجع خامات من الخط للمخزن',
  `auto_serial` bigint(20) NOT NULL,
  `inv_production_order_auto_serial` bigint(20) DEFAULT NULL,
  `order_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `production_lines_code` bigint(20) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL COMMENT 'اجمالي الفاتورة قبل الخصم',
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'نواع الخصم - واحد خصم نسبة  - اثنين خصم يدوي قيمة',
  `discount_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة نسبة الخصم',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'نسبة الضريبة ',
  `total_cost_items` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'اجمالي الاصناف فقط',
  `tax_value` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة الضريبة القيمة المضافة',
  `total_befor_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة',
  `account_number` bigint(20) NOT NULL,
  `money_for_account` decimal(10,2) DEFAULT NULL,
  `pill_type` tinyint(1) NOT NULL COMMENT 'نوع الفاتورة - كاش او اجل  - واحد واثنين',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `treasuries_transactions_id` bigint(20) DEFAULT NULL,
  `Supplier_balance_befor` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد المورد قبل الفاتروة',
  `Supplier_balance_after` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد المورد بعد الفاتروة',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `store_id` bigint(20) NOT NULL COMMENT 'كود المخزن المستلم للفاتورة',
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول مشتريات ومترجعات المودين ';

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_exchange_details`
--

CREATE TABLE `inv_production_exchange_details` (
  `id` bigint(20) NOT NULL,
  `inv_production_exchange_auto_serial` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL,
  `com_code` int(11) NOT NULL,
  `deliverd_quantity` decimal(10,2) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `isparentuom` tinyint(1) NOT NULL COMMENT '1-main -0 retail',
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `item_code` bigint(20) NOT NULL,
  `batch_auto_serial` bigint(20) DEFAULT NULL COMMENT 'رقم الباتش بالمخزن التي تم تخزنن الصنف بها',
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_card_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل اصناف امر الصرف  الخامات  لخط الانتاج';

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_lines`
--

CREATE TABLE `inv_production_lines` (
  `id` bigint(20) NOT NULL,
  `production_lines_code` bigint(20) NOT NULL,
  `name` varchar(225) NOT NULL,
  `account_number` bigint(20) NOT NULL,
  `start_balance_status` tinyint(4) NOT NULL COMMENT 'e 1-credit -2 debit 3-balanced',
  `start_balance` decimal(10,2) NOT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phones` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول خطوط الانتاج الورش';

--
-- Dumping data for table `inv_production_lines`
--

INSERT INTO `inv_production_lines` (`id`, `production_lines_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(1, 1, 'خط انتاج الافران الكبيره', 35, 3, '0.00', '0.00', NULL, 1, 1, '2023-01-04 02:55:26', '2023-01-07 01:02:45', 1, 1, '2023-01-04', 'المنطقه الرابعه من المصنع الشرقي', '0125645658'),
(2, 2, 'خط اننتاج غسالات عادية', 36, 3, '0.00', '0.00', NULL, 1, NULL, '2023-01-07 01:09:59', '2023-01-07 01:09:59', 1, 1, '2023-01-07', 'المنطقه الثالثه من المصنع الشرقي', '0126598555');

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_order`
--

CREATE TABLE `inv_production_order` (
  `id` bigint(20) NOT NULL,
  `auto_serial` bigint(20) NOT NULL,
  `production_plane` text NOT NULL,
  `production_plan_date` date NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'حالة الاعتماد',
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل مغلق وتم',
  `closed_by` int(11) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='امر التشغيل للانتاج';

--
-- Dumping data for table `inv_production_order`
--

INSERT INTO `inv_production_order` (`id`, `auto_serial`, `production_plane`, `production_plan_date`, `is_approved`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `approved_by`, `approved_at`, `is_closed`, `closed_by`, `closed_at`, `date`) VALUES
(3, 2, '150 فرن حجم كبير - عرائس - لمخزن صابرين القبلي', '2022-12-29', 1, 1, 1, '2022-12-29 01:02:20', '2023-01-02 10:07:43', 1, 1, '2023-01-02 10:00:24', 1, 1, '2023-01-02 10:07:43', '2022-12-29'),
(4, 3, 'انتاج 1500 فرن كبير', '2023-01-02', 0, 1, NULL, '2023-01-02 10:23:03', '2023-01-02 10:23:03', 1, NULL, NULL, 0, NULL, NULL, '2023-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `inv_stores_inventory`
--

CREATE TABLE `inv_stores_inventory` (
  `id` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT 'مخزن الجرد',
  `inventory_date` date NOT NULL,
  `inventory_type` tinyint(1) NOT NULL COMMENT 'واحد جرد يومي - اثنين جرد اسبوعي - ثلاثه جرد شهري - اربعه جرد سنوي ',
  `auto_serial` bigint(20) NOT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل امر الجرد مغلق ومرحل',
  `total_cost_batches` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `cloased_by` int(11) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول جرد المخازن';

--
-- Dumping data for table `inv_stores_inventory`
--

INSERT INTO `inv_stores_inventory` (`id`, `store_id`, `inventory_date`, `inventory_type`, `auto_serial`, `is_closed`, `total_cost_batches`, `notes`, `added_by`, `date`, `created_at`, `updated_by`, `updated_at`, `com_code`, `cloased_by`, `closed_at`) VALUES
(1, 1, '2022-12-19', 1, 1, 1, '13300.00', NULL, 1, '2022-12-19', '2022-12-19 01:28:25', NULL, '2022-12-19 01:32:36', 1, 1, '2022-12-19 01:32:36'),
(2, 3, '2022-12-23', 1, 2, 0, '0.00', NULL, 1, '2022-12-23', '2022-12-23 22:51:47', NULL, '2022-12-23 22:51:47', 1, NULL, NULL),
(3, 4, '2022-12-23', 3, 3, 0, '0.00', NULL, 1, '2022-12-23', '2022-12-23 22:51:54', NULL, '2022-12-23 22:51:54', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_stores_inventory_details`
--

CREATE TABLE `inv_stores_inventory_details` (
  `id` bigint(20) NOT NULL,
  `inv_stores_inventory_auto_serial` bigint(20) NOT NULL,
  `item_code` bigint(20) NOT NULL,
  `inv_uoms_id` int(11) NOT NULL,
  `batch_auto_serial` bigint(20) NOT NULL,
  `old_quantity` decimal(10,2) NOT NULL,
  `new_quantity` decimal(10,2) NOT NULL,
  `diffrent_quantity` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit_cost_price` decimal(10,2) NOT NULL,
  `total_cost_price` decimal(10,2) NOT NULL,
  `production_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `notes` varchar(225) DEFAULT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cloased_by` int(11) DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل امر الجرد';

--
-- Dumping data for table `inv_stores_inventory_details`
--

INSERT INTO `inv_stores_inventory_details` (`id`, `inv_stores_inventory_auto_serial`, `item_code`, `inv_uoms_id`, `batch_auto_serial`, `old_quantity`, `new_quantity`, `diffrent_quantity`, `unit_cost_price`, `total_cost_price`, `production_date`, `expired_date`, `notes`, `is_closed`, `added_by`, `created_at`, `updated_by`, `updated_at`, `cloased_by`, `closed_at`, `com_code`) VALUES
(1, 1, 1, 10, 1, '1000.00', '950.00', '-50.00', '14.00', '13300.00', NULL, NULL, '50 شماعه هوالك بسبب سؤء التنزيل وتنزل غرامه علي امين المخزن', 1, 1, '2022-12-19 01:29:07', 1, '2022-12-19 01:30:02', 1, '2022-12-19 01:30:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_uoms`
--

CREATE TABLE `inv_uoms` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `is_master` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الوحدات';

--
-- Dumping data for table `inv_uoms`
--

INSERT INTO `inv_uoms` (`id`, `name`, `is_master`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'شكارة', 1, '2022-09-01 10:07:50', '2022-09-01 10:07:50', 1, 1, 1, '2022-09-01', 1),
(2, 'طبق واحد كيلوا', 0, '2022-09-01 10:20:39', '2022-09-01 10:20:39', 1, NULL, 1, '2022-09-01', 1),
(4, 'كيلوا 90 جرام', 0, '2022-09-01 10:30:29', '2022-09-01 10:30:29', 1, NULL, 1, '2022-09-01', 1),
(5, 'كرتونة كوبيات', 1, '2022-09-21 22:22:14', '2022-10-10 09:35:50', 1, 1, 1, '2022-09-21', 1),
(6, 'علبة', 0, '2022-09-21 22:22:25', '2022-10-10 09:24:48', 1, 1, 1, '2022-09-21', 1),
(7, 'نول', 1, '2022-10-10 09:10:41', '2022-10-10 09:10:41', 1, NULL, 1, '2022-10-10', 1),
(8, 'متر', 1, '2022-10-10 09:11:02', '2022-10-10 09:35:19', 1, 1, 1, '2022-10-10', 1),
(9, 'كيس 1 ك', 0, '2022-10-11 08:38:25', '2022-10-11 08:38:25', 1, NULL, 1, '2022-10-11', 1),
(10, 'وحده', 1, '2022-12-19 01:26:35', '2022-12-19 01:26:35', 1, NULL, 1, '2022-12-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_08_135041_account_types', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mov_type`
--

CREATE TABLE `mov_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `in_screen` tinyint(1) NOT NULL COMMENT '1-dissmissal 2-collect',
  `is_private_internal` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='الحركة علي الخزنة';

--
-- Dumping data for table `mov_type`
--

INSERT INTO `mov_type` (`id`, `name`, `active`, `in_screen`, `is_private_internal`) VALUES
(1, 'مراجعة واستلام نقدية شفت علي نفس الخزنة', 1, 2, 1),
(2, 'مراجعة واستلام نقدية شفت خزنة اخري', 1, 2, 1),
(3, 'صرف مبلغ لحساب مالي', 1, 1, 0),
(4, 'تحصيل مبلغ من حساب مالي', 1, 2, 0),
(5, 'تحصيل ايراد مبيعات', 1, 2, 0),
(6, 'صرف نظير مرتجع مبيعات', 1, 1, 0),
(8, 'صرف سلفة علي راتب موظف', 1, 1, 1),
(9, 'صرف نظير مشتريات من مورد', 1, 1, 0),
(10, 'تحصيل نظير مرتجع مشتريات الي مورد', 1, 2, 0),
(16, 'ايراد زيادة راس المال', 1, 2, 0),
(17, 'مصاريف شراء مثل النولون', 1, 1, 0),
(18, 'صرف للإيداع البنكي', 1, 1, 0),
(21, 'رد سلفة علي راتب موظف', 1, 2, 1),
(22, 'تحصيل خصومات موظفين', 1, 2, 1),
(24, 'صرف مرتب لموظف', 1, 1, 1),
(25, 'سحب من البنك\r\n', 1, 2, 0),
(26, 'صرف لرد رأس المال', 1, 1, 0),
(27, 'صرف بفاتورة خدمات مقدمة لنا', 1, 1, 0),
(28, 'تحصيل بفاتورة خدمات نقدمها للغير', 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices`
--

CREATE TABLE `sales_invoices` (
  `id` bigint(20) NOT NULL,
  `sales_matrial_types` int(11) DEFAULT NULL COMMENT 'فئة الفاتورة',
  `auto_serial` bigint(20) NOT NULL,
  `invoice_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `is_has_customer` tinyint(1) NOT NULL COMMENT 'هل الفاتورة مرتبطه بعميل - واحد يبقي نعم - لو صفر يبقي عميل طياري بدون عميل',
  `customer_code` bigint(20) DEFAULT NULL COMMENT 'كود العميل',
  `delegate_code` bigint(20) DEFAULT NULL COMMENT 'كود المندوب',
  `delegate_commission_percent_type` decimal(10,2) DEFAULT NULL,
  `delegate_commission_percent` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'نسبة عمولة المندوب',
  `delegate_commission_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة عمولة المندوب',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL,
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'نواع الخصم - واحد خصم نسبة  - اثنين خصم يدوي قيمة',
  `discount_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة نسبة الخصم',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'نسبة الضريبة ',
  `total_cost_items` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'اجمالي الاصناف فقط',
  `tax_value` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة الضريبة القيمة المضافة',
  `total_befor_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة',
  `account_number` bigint(20) DEFAULT NULL,
  `money_for_account` decimal(10,2) DEFAULT NULL,
  `pill_type` tinyint(1) DEFAULT NULL COMMENT 'نوع الفاتورة - كاش او اجل  - واحد واثنين',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `treasuries_transactions_id` bigint(20) DEFAULT NULL,
  `customer_balance_befor` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد العميل قبل الفاتروة',
  `customer_balance_after` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد العميل بعد الفاتروة',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `sales_item_type` tinyint(1) NOT NULL COMMENT 'e	نوع البيع مع الصنف واحد قطاعي - اتنين نص جمية -ثلاثه جملة	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='المبيعات للعملاء';

--
-- Dumping data for table `sales_invoices`
--

INSERT INTO `sales_invoices` (`id`, `sales_matrial_types`, `auto_serial`, `invoice_date`, `is_has_customer`, `customer_code`, `delegate_code`, `delegate_commission_percent_type`, `delegate_commission_percent`, `delegate_commission_value`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `customer_balance_befor`, `customer_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `date`, `sales_item_type`) VALUES
(1, 3, 1, '2022-11-05', 0, NULL, 1, '2.00', '2.00', '20.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', NULL, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-05 00:08:53', '2022-11-05 00:09:08', 1, 1, '2022-11-05', 1),
(2, 3, 2, '2022-11-05', 0, NULL, 1, '2.00', '10.00', '100.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', NULL, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-05 00:10:10', '2022-11-05 00:12:08', 1, 1, '2022-11-05', 1),
(3, 1, 3, '2022-11-05', 0, NULL, 1, '2.00', '5.00', '54.72', 1, 1, NULL, NULL, '0.00', '0.00', '14.00', '960.00', '134.40', '1094.40', '1094.40', NULL, '1094.40', 1, '1094.40', '0.00', NULL, NULL, NULL, 1, '2022-11-05 00:12:31', '2022-11-05 00:13:08', 1, 1, '2022-11-05', 2),
(4, 3, 4, '2022-11-06', 0, NULL, 4, '2.00', '2.00', '-114.00', 1, 1, NULL, NULL, '0.00', '0.00', '14.00', '5000.00', '700.00', '5700.00', '5700.00', NULL, '5700.00', 1, '5700.00', '0.00', NULL, NULL, NULL, 1, '2022-11-06 09:00:38', '2022-11-06 09:02:08', 1, 1, '2022-11-06', 1),
(5, 4, 5, '2022-11-06', 0, NULL, 4, '2.00', '2.00', '-20.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', NULL, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-06 09:17:07', '2022-11-06 09:17:29', 1, 1, '2022-11-06', 1),
(6, 4, 6, '2022-11-06', 0, NULL, 4, '2.00', '2.00', '-20.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', NULL, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-06 09:18:07', '2022-11-06 09:18:17', 1, 1, '2022-11-06', 1),
(7, 4, 7, '2022-11-08', 1, 1, 1, '2.00', '10.00', '-114.00', 1, 1, NULL, NULL, '0.00', '0.00', '14.00', '1000.00', '140.00', '1140.00', '1140.00', 5, '1140.00', 1, '1140.00', '0.00', NULL, NULL, NULL, 1, '2022-11-08 22:24:13', '2022-11-08 22:24:26', 1, 1, '2022-11-08', 1),
(8, 4, 8, '2022-11-08', 1, 1, 4, NULL, '0.00', '0.00', 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, 1, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-11-08 22:30:37', '2022-11-08 22:30:37', NULL, NULL, '2022-11-08', 1),
(10, 4, 9, '2022-11-09', 0, NULL, 1, NULL, '0.00', '0.00', 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, 1, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-11-09 22:20:04', '2022-11-09 22:20:04', NULL, NULL, '2022-11-09', 1),
(11, 4, 10, '2022-11-09', 0, NULL, 1, NULL, '0.00', '0.00', 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, 1, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-11-09 22:24:36', '2022-11-09 22:24:36', NULL, NULL, '2022-11-09', 1),
(12, 4, 11, '2022-11-09', 0, NULL, 1, '2.00', '0.00', '0.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', NULL, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-09 22:29:58', '2022-11-09 22:51:50', 1, 1, '2022-11-09', 1),
(13, 4, 12, '2022-11-17', 1, 4, 4, '2.00', '2.00', '-20.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 16, '1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-11-17 22:42:49', '2022-11-17 22:42:59', 1, 1, '2022-11-17', 1),
(14, 4, 13, '2022-11-19', 1, 4, 4, '2.00', '2.00', '-20.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 16, '1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-11-19 10:47:59', '2022-11-19 10:48:08', 1, 1, '2022-11-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices_details`
--

CREATE TABLE `sales_invoices_details` (
  `id` bigint(20) NOT NULL,
  `sales_invoices_auto_serial` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL,
  `sales_item_type` tinyint(1) NOT NULL COMMENT 'نوع البيع مع الصنف\r\nواحد قطاعي - اتنين نص جمية -ثلاثه جملة',
  `item_code` bigint(20) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `batch_auto_serial` bigint(20) DEFAULT NULL COMMENT 'رقم الباتش بالمخزن التي تم خروج الصنف منها ',
  `quantity` decimal(10,4) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `is_normal_orOther` tinyint(1) NOT NULL COMMENT 'واحد بيع عادي\r\nاتنين بونص \r\nثلاثه دعاية\r\nهالك \r\n- كلهم بدون سعر',
  `isparentuom` tinyint(1) NOT NULL COMMENT '1-main -0 retail',
  `com_code` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `sales_invoices_details`
--

INSERT INTO `sales_invoices_details` (`id`, `sales_invoices_auto_serial`, `store_id`, `sales_item_type`, `item_code`, `uom_id`, `batch_auto_serial`, `quantity`, `unit_price`, `total_price`, `is_normal_orOther`, `isparentuom`, `com_code`, `invoice_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `production_date`, `expire_date`, `date`) VALUES
(1, 1, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-05', 1, '2022-11-05 00:09:04', NULL, '2022-11-05 00:09:04', NULL, NULL, '2022-11-05'),
(2, 2, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-05', 1, '2022-11-05 00:10:22', NULL, '2022-11-05 00:10:22', NULL, NULL, '2022-11-05'),
(3, 3, 1, 2, 4, 5, 1, '1.0000', '960.00', '960.00', 1, 1, 1, '2022-11-05', 1, '2022-11-05 00:12:38', NULL, '2022-11-05 00:12:38', NULL, NULL, '2022-11-05'),
(4, 4, 1, 1, 2, 1, 3, '5.0000', '1000.00', '5000.00', 1, 1, 1, '2022-11-06', 1, '2022-11-06 09:01:28', NULL, '2022-11-06 09:01:28', NULL, NULL, '2022-11-06'),
(5, 5, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-06', 1, '2022-11-06 09:17:17', NULL, '2022-11-06 09:17:17', NULL, NULL, '2022-11-06'),
(6, 6, 1, 1, 5, 1, 5, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-06', 1, '2022-11-06 09:18:14', NULL, '2022-11-06 09:18:14', NULL, NULL, '2022-11-06'),
(7, 7, 1, 1, 5, 1, 5, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-08', 1, '2022-11-08 22:24:21', NULL, '2022-11-08 22:24:21', NULL, NULL, '2022-11-08'),
(13, 11, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-09', 1, '2022-11-09 22:51:28', NULL, '2022-11-09 22:51:28', NULL, NULL, '2022-11-09'),
(14, 12, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-17', 1, '2022-11-17 22:42:57', NULL, '2022-11-17 22:42:57', NULL, NULL, '2022-11-17'),
(15, 13, 1, 1, 4, 5, 1, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-11-19', 1, '2022-11-19 10:48:05', NULL, '2022-11-19 10:48:05', NULL, NULL, '2022-11-19');

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices_return`
--

CREATE TABLE `sales_invoices_return` (
  `id` bigint(20) NOT NULL,
  `return_type` tinyint(1) NOT NULL COMMENT 'واحد مرتجع بأصل الفاتورة - اثنين مرتجع عام',
  `sales_matrial_types` int(11) DEFAULT NULL COMMENT 'فئة الفاتورة',
  `auto_serial` bigint(20) NOT NULL,
  `invoice_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `is_has_customer` tinyint(1) NOT NULL COMMENT 'هل الفاتورة مرتبطه بعميل - واحد يبقي نعم - لو صفر يبقي عميل طياري بدون عميل',
  `customer_code` bigint(20) DEFAULT NULL COMMENT 'كود العميل',
  `delegate_code` bigint(20) DEFAULT NULL COMMENT 'كود المندوب',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL,
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'نواع الخصم - واحد خصم نسبة  - اثنين خصم يدوي قيمة',
  `discount_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة نسبة الخصم',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'نسبة الضريبة ',
  `total_cost_items` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'اجمالي الاصناف فقط',
  `tax_value` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة الضريبة القيمة المضافة',
  `total_befor_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة',
  `account_number` bigint(20) DEFAULT NULL,
  `money_for_account` decimal(10,2) DEFAULT NULL,
  `pill_type` tinyint(1) DEFAULT NULL COMMENT 'نوع الفاتورة - كاش او اجل  - واحد واثنين',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `treasuries_transactions_id` bigint(20) DEFAULT NULL,
  `customer_balance_befor` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد العميل قبل الفاتروة',
  `customer_balance_after` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد العميل بعد الفاتروة',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='مرتجع المبيعات للعملاء';

--
-- Dumping data for table `sales_invoices_return`
--

INSERT INTO `sales_invoices_return` (`id`, `return_type`, `sales_matrial_types`, `auto_serial`, `invoice_date`, `is_has_customer`, `customer_code`, `delegate_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `customer_balance_befor`, `customer_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `date`) VALUES
(2, 2, 1, 1, '2022-10-31', 1, 1, 3, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '4000.00', '0.00', '4000.00', '4000.00', 5, '-4000.00', 2, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-10-31 09:51:55', '2022-10-31 13:29:20', 1, 1, '2022-10-31'),
(3, 2, 3, 2, '2022-10-31', 1, 4, 3, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 16, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-10-31 13:30:04', '2022-10-31 13:30:28', 1, 1, '2022-10-31'),
(4, 2, 1, 3, '2022-10-31', 1, 14, 3, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 31, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-10-31 13:38:03', '2022-10-31 13:38:14', 1, 1, '2022-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices_return_details`
--

CREATE TABLE `sales_invoices_return_details` (
  `id` bigint(20) NOT NULL,
  `sales_invoices_auto_serial` bigint(20) NOT NULL,
  `store_id` int(11) NOT NULL,
  `sales_item_type` tinyint(1) NOT NULL COMMENT 'نوع البيع مع الصنف\r\nواحد قطاعي - اتنين نص جمية -ثلاثه جملة',
  `item_code` bigint(20) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `batch_auto_serial` bigint(20) DEFAULT NULL COMMENT 'رقم الباتش بالمخزن التي تم خروج الصنف منها ',
  `quantity` decimal(10,4) NOT NULL,
  `unit_cost_price` decimal(10,2) DEFAULT NULL COMMENT 'في حاله المرتجع بدون تحديد باتش للمرتجع',
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `is_normal_orOther` tinyint(1) NOT NULL COMMENT 'واحد بيع عادي\r\nاتنين بونص \r\nثلاثه دعاية\r\nهالك \r\n- كلهم بدون سعر',
  `isparentuom` tinyint(1) NOT NULL COMMENT '1-main -0 retail',
  `com_code` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل اصناف فاتورة مرتجع المبيعات';

--
-- Dumping data for table `sales_invoices_return_details`
--

INSERT INTO `sales_invoices_return_details` (`id`, `sales_invoices_auto_serial`, `store_id`, `sales_item_type`, `item_code`, `uom_id`, `batch_auto_serial`, `quantity`, `unit_cost_price`, `unit_price`, `total_price`, `is_normal_orOther`, `isparentuom`, `com_code`, `invoice_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `production_date`, `expire_date`, `date`) VALUES
(1, 1, 1, 1, 3, 1, NULL, '1.0000', '900.00', '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:01:16', NULL, '2022-10-31 13:01:16', '2022-10-05', '2023-10-31', '2022-10-31'),
(2, 1, 1, 1, 3, 1, NULL, '1.0000', '900.00', '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:02:31', NULL, '2022-10-31 13:02:31', '2022-10-05', '2023-10-31', '2022-10-31'),
(3, 1, 1, 1, 3, 1, 7, '1.0000', NULL, '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:05:15', NULL, '2022-10-31 13:05:15', NULL, NULL, '2022-10-31'),
(4, 1, 1, 1, 4, 5, NULL, '1.0000', '90.00', '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:06:16', NULL, '2022-10-31 13:06:16', NULL, NULL, '2022-10-31'),
(8, 2, 1, 1, 3, 1, 7, '1.0000', NULL, '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:30:16', NULL, '2022-10-31 13:30:16', NULL, NULL, '2022-10-31'),
(9, 3, 1, 1, 3, 1, 7, '1.0000', NULL, '1000.00', '1000.00', 1, 1, 1, '2022-10-31', 1, '2022-10-31 13:38:10', NULL, '2022-10-31 13:38:10', NULL, NULL, '2022-10-31');

-- --------------------------------------------------------

--
-- Table structure for table `sales_matrial_types`
--

CREATE TABLE `sales_matrial_types` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_matrial_types`
--

INSERT INTO `sales_matrial_types` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم', '2022-08-31 23:42:35', '2022-08-04 23:42:35', 1, 1, 1, '2022-08-31', 1),
(3, 'فراخ', '2022-09-01 01:22:25', '2022-09-01 01:22:25', 1, NULL, 1, '2022-09-01', 1),
(4, 'بقوليات', '2022-10-10 09:06:58', '2022-10-12 03:45:48', 1, 1, 1, '2022-10-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `type` tinyint(1) NOT NULL COMMENT '1- done for us 2- we done for other',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='خدمات نقدمها للغير ومقدمه لنا ';

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `active`, `type`, `added_by`, `created_at`, `updated_by`, `updated_at`, `com_code`, `date`) VALUES
(1, 'ميزان بسكول كبير', 1, 1, 1, '2022-11-22 17:06:09', 1, '2022-11-22 17:06:09', 1, '2022-11-22'),
(3, 'طباعه', 1, 2, 1, '2022-11-23 16:12:14', NULL, '2022-11-23 16:12:14', 1, '2022-11-23'),
(4, 'تركيب كاميرات مراقبة', 1, 2, 1, '2022-11-23 16:12:34', NULL, '2022-11-23 16:12:34', 1, '2022-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `services_with_orders`
--

CREATE TABLE `services_with_orders` (
  `id` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '1-for us 2-for other',
  `auto_serial` bigint(20) NOT NULL,
  `order_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL COMMENT 'ملاحظات',
  `total_services` decimal(10,2) DEFAULT 0.00,
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'نواع الخصم - واحد خصم نسبة  - اثنين خصم يدوي قيمة',
  `discount_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة نسبة الخصم',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'نسبة الضريبة ',
  `tax_value` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة الضريبة القيمة المضافة',
  `total_befor_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة',
  `is_account_number` tinyint(1) NOT NULL,
  `entity_name` varchar(150) DEFAULT NULL COMMENT 'اسم الجهه في حالة انه ليس حساب مالي',
  `account_number` bigint(20) DEFAULT NULL COMMENT 'رقم الحساب المالي المقدم له الخدمه او المقدم لنا الخدمة',
  `money_for_account` decimal(10,2) DEFAULT NULL,
  `pill_type` tinyint(1) NOT NULL COMMENT 'نوع الفاتورة - كاش او اجل  - واحد واثنين',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `treasuries_transactions_id` bigint(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `services_with_orders`
--

INSERT INTO `services_with_orders` (`id`, `order_type`, `auto_serial`, `order_date`, `is_approved`, `com_code`, `notes`, `total_services`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `tax_value`, `total_befor_discount`, `total_cost`, `is_account_number`, `entity_name`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`) VALUES
(1, 2, 1, '2022-12-01', 1, 1, NULL, '10000.00', NULL, '0.00', '0.00', '0.00', '0.00', '10000.00', '10000.00', 1, NULL, 33, '10000.00', 1, '10000.00', '0.00', NULL, 1, '2022-12-01 01:08:46', '2022-12-01 01:10:34', 1, 1),
(2, 1, 2, '2022-12-01', 1, 1, NULL, '100.00', NULL, '0.00', '0.00', '0.00', '0.00', '100.00', '100.00', 1, '', 33, '-100.00', 1, '100.00', '0.00', NULL, 1, '2022-12-01 01:11:02', '2022-12-01 01:11:27', 1, 1),
(3, 1, 3, '2022-12-01', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 0, 'شركة النور', NULL, NULL, 1, '1000.00', '0.00', NULL, 1, '2022-12-01 01:11:52', '2022-12-01 01:12:03', 1, 1),
(4, 2, 2, '2022-12-01', 1, 1, NULL, '1500.00', NULL, '0.00', '0.00', '0.00', '0.00', '1500.00', '1500.00', 0, 'شكرة النور', NULL, NULL, 1, '1500.00', '0.00', NULL, 1, '2022-12-01 01:13:01', '2022-12-01 01:13:14', 1, 1),
(5, 2, 3, '2022-12-02', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, NULL, 26, '1000.00', 2, '0.00', '1000.00', NULL, 1, '2022-12-02 13:49:43', '2022-12-02 13:50:05', 1, 1),
(6, 2, 4, '2022-12-02', 1, 1, NULL, '500.00', NULL, '0.00', '0.00', '0.00', '0.00', '500.00', '500.00', 1, NULL, 26, '500.00', 2, '0.00', '500.00', NULL, 1, '2022-12-02 13:54:51', '2022-12-02 13:55:17', 1, 1),
(7, 2, 5, '2022-12-02', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, NULL, 26, '1000.00', 2, '0.00', '1000.00', NULL, 1, '2022-12-02 13:57:12', '2022-12-02 13:57:33', 1, 1),
(8, 2, 6, '2022-12-02', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, NULL, 26, '1000.00', 2, '0.00', '1000.00', NULL, 1, '2022-12-02 13:59:44', '2022-12-02 13:59:59', 1, 1),
(9, 1, 4, '2022-12-05', 1, 1, NULL, '500.00', NULL, '0.00', '0.00', '0.00', '0.00', '500.00', '500.00', 1, NULL, 21, '-500.00', 2, '0.00', '500.00', NULL, 1, '2022-12-05 00:36:29', '2022-12-05 00:36:53', 1, 1),
(10, 2, 7, '2022-12-05', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, NULL, 21, '1000.00', 2, '0.00', '1000.00', NULL, 1, '2022-12-05 00:37:12', '2022-12-05 00:37:23', 1, 1),
(11, 1, 5, '2022-12-05', 1, 1, NULL, '500.00', NULL, '0.00', '0.00', '0.00', '0.00', '500.00', '500.00', 1, NULL, 21, '-500.00', 1, '500.00', '0.00', NULL, 1, '2022-12-05 00:39:32', '2022-12-05 00:39:53', 1, 1),
(12, 2, 8, '2022-12-05', 1, 1, NULL, '500.00', NULL, '0.00', '0.00', '0.00', '0.00', '500.00', '500.00', 1, NULL, 21, '500.00', 1, '500.00', '0.00', NULL, 1, '2022-12-05 00:40:11', '2022-12-05 00:40:28', 1, 1),
(13, 1, 6, '2022-12-08', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, '', 32, '-1000.00', 2, '0.00', '1000.00', NULL, 1, '2022-12-08 01:59:23', '2022-12-08 01:59:44', 1, 1),
(14, 2, 9, '2022-12-08', 1, 1, NULL, '2000.00', NULL, '0.00', '0.00', '0.00', '0.00', '2000.00', '2000.00', 1, NULL, 32, '2000.00', 2, '0.00', '2000.00', NULL, 1, '2022-12-08 01:59:56', '2022-12-08 02:00:10', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services_with_orders_details`
--

CREATE TABLE `services_with_orders_details` (
  `id` bigint(20) NOT NULL,
  `services_with_orders_auto_serial` bigint(20) NOT NULL,
  `order_type` tinyint(4) NOT NULL,
  `service_id` int(11) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services_with_orders_details`
--

INSERT INTO `services_with_orders_details` (`id`, `services_with_orders_auto_serial`, `order_type`, `service_id`, `notes`, `total`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `date`) VALUES
(1, 1, 2, 4, '14 كاميرا', '10000.00', 1, NULL, '2022-12-01 01:09:03', '2022-12-01 01:09:03', 1, '2022-12-01'),
(2, 2, 1, 1, NULL, '100.00', 1, NULL, '2022-12-01 01:11:24', '2022-12-01 01:11:24', 1, '2022-12-01'),
(3, 3, 1, 1, NULL, '1000.00', 1, NULL, '2022-12-01 01:12:00', '2022-12-01 01:12:00', 1, '2022-12-01'),
(4, 2, 2, 4, NULL, '1500.00', 1, NULL, '2022-12-01 01:13:10', '2022-12-01 01:13:10', 1, '2022-12-01'),
(5, 3, 2, 4, '3 كاميرات', '1000.00', 1, NULL, '2022-12-02 13:49:56', '2022-12-02 13:49:56', 1, '2022-12-02'),
(6, 4, 2, 3, 'عدد 150 ورقه متعدد الوان وعادي', '500.00', 1, NULL, '2022-12-02 13:55:12', '2022-12-02 13:55:12', 1, '2022-12-02'),
(7, 5, 2, 4, '3 كاميرات', '1000.00', 1, NULL, '2022-12-02 13:57:29', '2022-12-02 13:57:29', 1, '2022-12-02'),
(8, 6, 2, 4, NULL, '1000.00', 1, NULL, '2022-12-02 13:59:53', '2022-12-02 13:59:53', 1, '2022-12-02'),
(9, 4, 1, 1, 'ايجار', '500.00', 1, NULL, '2022-12-05 00:36:41', '2022-12-05 00:36:41', 1, '2022-12-05'),
(10, 7, 2, 4, NULL, '1000.00', 1, NULL, '2022-12-05 00:37:20', '2022-12-05 00:37:20', 1, '2022-12-05'),
(11, 5, 1, 1, NULL, '500.00', 1, NULL, '2022-12-05 00:39:42', '2022-12-05 00:39:42', 1, '2022-12-05'),
(12, 8, 2, 3, NULL, '500.00', 1, NULL, '2022-12-05 00:40:22', '2022-12-05 00:40:22', 1, '2022-12-05'),
(13, 6, 1, 1, NULL, '1000.00', 1, NULL, '2022-12-08 01:59:40', '2022-12-08 01:59:40', 1, '2022-12-08'),
(14, 9, 2, 4, NULL, '2000.00', 1, NULL, '2022-12-08 02:00:05', '2022-12-08 02:00:05', 1, '2022-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phones` varchar(100) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `phones`, `address`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الرئيسي', '01695845', 'شارع النصر ', '2022-09-01 00:59:33', '2022-09-21 00:59:33', 1, 1, 1, '2022-09-07', 1),
(3, 'البقوليات', '6958525', 'شارع 15', '2022-09-01 01:37:04', '2022-10-12 03:49:19', 1, 1, 1, '2022-09-01', 1),
(4, 'المشروبات', '6151', 'شارع النصر', '2022-09-02 21:31:47', '2022-10-12 03:49:44', 1, 1, 1, '2022-09-02', 1),
(5, 'اللحوم المجمدة', '0165987575', 'ش 16 عمارة 4', '2022-10-10 09:09:19', '2022-10-10 09:09:24', 1, 1, 1, '2022-10-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_categories`
--

CREATE TABLE `suppliers_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers_categories`
--

INSERT INTO `suppliers_categories` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم', '2022-09-12 00:25:02', '2022-10-06 14:51:47', 1, 1, 1, '2022-09-12', 1),
(2, 'فراخ', '2022-09-12 00:28:07', '2022-09-12 00:28:07', 1, NULL, 1, '2022-09-12', 1),
(4, 'خضروات', '2022-09-12 00:28:47', '2022-10-06 14:51:54', 1, 1, 1, '2022-09-12', 1),
(5, 'خردوات', '2022-10-06 14:51:44', '2022-10-06 14:51:51', 1, 1, 1, '2022-10-06', 1),
(6, 'خضروات طازجه', '2022-10-07 23:53:45', '2022-10-07 23:53:49', 1, 1, 1, '2022-10-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_with_orders`
--

CREATE TABLE `suppliers_with_orders` (
  `id` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '1-Burshase 2-return on same pill 3-return on general',
  `auto_serial` bigint(20) NOT NULL,
  `DOC_NO` varchar(25) DEFAULT NULL,
  `order_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `suuplier_code` bigint(20) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL COMMENT 'اجمالي الفاتورة قبل الخصم',
  `discount_type` tinyint(1) DEFAULT NULL COMMENT 'نواع الخصم - واحد خصم نسبة  - اثنين خصم يدوي قيمة',
  `discount_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة نسبة الخصم',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة الخصم',
  `tax_percent` decimal(10,2) DEFAULT 0.00 COMMENT 'نسبة الضريبة ',
  `total_cost_items` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'اجمالي الاصناف فقط',
  `tax_value` decimal(10,2) DEFAULT 0.00 COMMENT 'قيمة الضريبة القيمة المضافة',
  `total_befor_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost` decimal(10,2) DEFAULT 0.00 COMMENT 'القيمة الاجمالية النهائية للفاتورة',
  `account_number` bigint(20) NOT NULL,
  `money_for_account` decimal(10,2) DEFAULT NULL,
  `pill_type` tinyint(1) NOT NULL COMMENT 'نوع الفاتورة - كاش او اجل  - واحد واثنين',
  `what_paid` decimal(10,2) DEFAULT 0.00,
  `what_remain` decimal(10,2) DEFAULT 0.00,
  `treasuries_transactions_id` bigint(20) DEFAULT NULL,
  `Supplier_balance_befor` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد المورد قبل الفاتروة',
  `Supplier_balance_after` decimal(10,2) DEFAULT NULL COMMENT 'حالة رصيد المورد بعد الفاتروة',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `store_id` bigint(20) NOT NULL COMMENT 'كود المخزن المستلم للفاتورة',
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `suppliers_with_orders`
--

INSERT INTO `suppliers_with_orders` (`id`, `order_type`, `auto_serial`, `DOC_NO`, `order_date`, `suuplier_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `Supplier_balance_befor`, `Supplier_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `store_id`, `approved_by`) VALUES
(1, 1, 1, '1', '2022-10-25', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '56200.00', '0.00', '56200.00', '56200.00', 4, '-56200.00', 2, '0.00', '56200.00', NULL, NULL, NULL, 1, '2022-10-25 15:25:48', '2022-10-25 15:27:19', 1, 1, 1),
(3, 1, 3, '5', '2022-10-30', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '2000.00', '0.00', '2000.00', '2000.00', 4, '-2000.00', 2, '0.00', '2000.00', NULL, NULL, NULL, 1, '2022-10-30 00:12:14', '2022-10-30 00:12:45', 1, 1, 1),
(4, 1, 4, '6', '2022-10-30', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '10000.00', '0.00', '10000.00', '10000.00', 4, '-10000.00', 2, '0.00', '10000.00', NULL, NULL, NULL, 1, '2022-10-30 00:15:20', '2022-10-30 00:15:50', 1, 1, 1),
(5, 3, 1, NULL, '2022-11-13', 5, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '400.00', '0.00', '400.00', '400.00', 21, '400.00', 2, '0.00', '400.00', NULL, NULL, NULL, 1, '2022-11-13 20:38:39', '2022-11-13 20:39:27', 1, 1, 1),
(7, 3, 2, NULL, '2022-11-13', 5, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 21, '1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-11-13 20:40:25', '2022-11-13 20:41:04', 1, 1, 1),
(8, 3, 3, NULL, '2022-11-15', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '600.00', '0.00', '600.00', '600.00', 4, '600.00', 2, '0.00', '600.00', NULL, NULL, NULL, 1, '2022-11-15 20:36:49', '2022-11-15 20:37:06', 1, 1, 1),
(9, 1, 5, '50', '2022-12-18', 5, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '50000.00', '0.00', '50000.00', '50000.00', 21, '-50000.00', 2, '0.00', '50000.00', NULL, NULL, NULL, 1, '2022-12-18 01:43:50', '2022-12-18 01:44:06', 1, 1, 1),
(10, 1, 6, NULL, '2022-12-19', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '14000.00', '0.00', '14000.00', '14000.00', 4, '-14000.00', 2, '0.00', '14000.00', NULL, NULL, NULL, 1, '2022-12-19 01:27:30', '2022-12-19 01:27:46', 1, 1, 1),
(11, 3, 4, NULL, '2023-01-10', 3, 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '28.00', '0.00', '28.00', '28.00', 17, '28.00', 1, '0.00', '0.00', NULL, NULL, NULL, 1, '2023-01-10 00:41:51', '2023-01-10 00:43:32', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_with_orders_details`
--

CREATE TABLE `suppliers_with_orders_details` (
  `id` bigint(20) NOT NULL,
  `suppliers_with_orders_auto_serial` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL,
  `com_code` int(11) NOT NULL,
  `deliverd_quantity` decimal(10,2) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `isparentuom` tinyint(1) NOT NULL COMMENT '1-main -0 retail',
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `item_code` bigint(20) NOT NULL,
  `batch_auto_serial` bigint(20) DEFAULT NULL COMMENT 'رقم الباتش بالمخزن التي تم تخزنن الصنف بها',
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_card_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `suppliers_with_orders_details`
--

INSERT INTO `suppliers_with_orders_details` (`id`, `suppliers_with_orders_auto_serial`, `order_type`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_auto_serial`, `production_date`, `expire_date`, `item_card_type`) VALUES
(1, 1, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-10-25', 1, '2022-10-25 15:26:02', 1, '2022-10-25 15:26:20', 4, NULL, NULL, NULL, 1),
(2, 1, 1, 1, '20.00', 5, 1, '110.00', '2200.00', '2022-10-25', 1, '2022-10-25 15:26:37', NULL, '2022-10-25 15:26:37', 4, NULL, NULL, NULL, 1),
(3, 1, 1, 1, '20.00', 1, 1, '1000.00', '20000.00', '2022-10-25', 1, '2022-10-25 15:26:59', NULL, '2022-10-25 15:26:59', 2, NULL, '2022-10-01', '2024-10-25', 2),
(4, 1, 1, 1, '30.00', 1, 1, '1100.00', '33000.00', '2022-10-25', 1, '2022-10-25 15:27:11', NULL, '2022-10-25 15:27:11', 2, NULL, '2022-10-01', '2024-10-25', 2),
(5, 3, 1, 1, '10.00', 1, 1, '200.00', '2000.00', '2022-10-30', 1, '2022-10-30 00:12:40', NULL, '2022-10-30 00:12:40', 5, NULL, '2022-10-30', '2025-10-30', 2),
(6, 4, 1, 1, '10.00', 1, 1, '1000.00', '10000.00', '2022-10-30', 1, '2022-10-30 00:15:46', NULL, '2022-10-30 00:15:46', 5, NULL, '2022-10-30', '2025-10-30', 2),
(7, 1, 3, 1, '1.00', 1, 1, '200.00', '200.00', '2022-11-13', 1, '2022-11-13 20:38:57', NULL, '2022-11-13 20:38:57', 5, 5, '2022-10-30', '2025-10-30', 2),
(8, 1, 3, 1, '1.00', 5, 1, '100.00', '200.00', '2022-11-13', 1, '2022-11-13 20:39:03', NULL, '2022-11-13 20:39:03', 4, 1, NULL, NULL, 1),
(9, 2, 3, 1, '1.00', 1, 1, '1000.00', '1000.00', '2022-11-13', 1, '2022-11-13 20:40:55', NULL, '2022-11-13 20:40:55', 2, 3, '2022-10-01', '2024-10-25', 2),
(10, 3, 3, 1, '3.00', 1, 1, '200.00', '600.00', '2022-11-15', 1, '2022-11-15 20:37:00', NULL, '2022-11-15 20:37:00', 5, 5, '2022-10-30', '2025-10-30', 2),
(11, 5, 1, 1, '1000.00', 8, 1, '50.00', '50000.00', '2022-12-18', 1, '2022-12-18 01:44:02', NULL, '2022-12-18 01:44:02', 6, NULL, NULL, NULL, 1),
(12, 6, 1, 1, '1000.00', 10, 1, '14.00', '14000.00', '2022-12-19', 1, '2022-12-19 01:27:42', NULL, '2022-12-19 01:27:42', 1, NULL, NULL, NULL, 1),
(13, 4, 3, 1, '1.00', 10, 1, '14.00', '14.00', '2023-01-10', 1, '2023-01-10 00:43:25', NULL, '2023-01-10 00:43:25', 1, 1, NULL, NULL, 1),
(14, 4, 3, 1, '1.00', 10, 1, '14.00', '14.00', '2023-01-10', 1, '2023-01-10 00:43:32', NULL, '2023-01-10 00:43:32', 1, 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suupliers`
--

CREATE TABLE `suupliers` (
  `id` bigint(20) NOT NULL,
  `suuplier_code` bigint(20) NOT NULL,
  `suppliers_categories_id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `account_number` bigint(20) NOT NULL,
  `start_balance_status` tinyint(4) NOT NULL COMMENT 'e 1-credit -2 debit 3-balanced',
  `start_balance` decimal(10,2) NOT NULL COMMENT 'دائن او مدين او متزن اول المدة',
  `current_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(225) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phones` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `suupliers`
--

INSERT INTO `suupliers` (`id`, `suuplier_code`, `suppliers_categories_id`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(1, 1, 1, 'عاطف دياب محمد', 4, 1, '-5000.00', '-86600.00', NULL, 1, NULL, '2022-09-22 22:45:06', '2022-12-19 01:27:46', 1, 1, '2022-09-22', NULL, NULL),
(2, 2, 2, 'محمود محمد', 6, 3, '0.00', '-18900.00', NULL, 1, NULL, '2022-09-22 23:29:29', '2022-09-30 09:14:22', 1, 1, '2022-09-22', NULL, NULL),
(3, 3, 2, 'الاحمدي للفراخ المجمده', 17, 1, '-5000.00', '-5000.00', 'بانتظار طلبية رقم 15', 1, NULL, '2022-10-06 15:00:21', '2022-10-08 01:57:43', 1, 1, '2022-10-06', 'ش النصر', '0569585285'),
(4, 4, 2, 'ابو مازن  للفراخ المجمده', 18, 1, '-5000.00', '-5000.00', 'بانتظار طلبية', 1, 1, '2022-10-06 15:02:02', '2022-10-06 15:03:11', 0, 1, '2022-10-06', 'ش  النصر', '096258258'),
(5, 5, 1, 'البدري للحوم المجمده', 21, 1, '-5000.00', '-48100.00', NULL, 1, 1, '2022-10-07 23:56:14', '2022-12-18 01:44:06', 1, 1, '2022-10-07', 'ش سيتي', '0152658');

-- --------------------------------------------------------

--
-- Table structure for table `treasuries`
--

CREATE TABLE `treasuries` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `is_master` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'هل خزنة رئيسية -0-1',
  `last_isal_exhcange` bigint(20) NOT NULL COMMENT 'رقم اخر ايصال للصرف',
  `last_isal_collect` bigint(20) NOT NULL COMMENT 'رقم اخر ايصال للتحصيل',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL COMMENT 'for search ',
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `name`, `is_master`, `last_isal_exhcange`, `last_isal_collect`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الرئيسية', 1, 23, 21, '2022-08-30 15:05:08', '2022-12-05 00:40:28', 1, 1, 1, '2022-08-30', 1),
(2, 'كاشير 1  يي  ddd', 0, 1, 1, '2022-08-30 17:14:15', '2022-08-30 18:43:43', 1, 1, 1, '2022-08-30', 0),
(3, 'كاشير 2', 0, 0, 0, '2022-08-30 19:09:55', '2022-08-30 19:09:55', 1, NULL, 1, '2022-08-30', 1),
(4, 'كاشير 3', 0, 0, 0, '2022-08-30 19:10:20', '2022-08-31 09:54:08', 1, 1, 1, '2022-08-30', 1),
(5, 'كاشير 4', 0, 0, 0, '2022-10-06 02:57:25', '2022-10-12 03:29:34', 1, 1, 1, '2022-10-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `treasuries_delivery`
--

CREATE TABLE `treasuries_delivery` (
  `id` int(11) NOT NULL,
  `treasuries_id` int(11) NOT NULL COMMENT 'الخزنة التي سوف تستلم',
  `treasuries_can_delivery_id` int(11) NOT NULL COMMENT 'الخزنة التي سيتم تسليمها',
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `treasuries_delivery`
--

INSERT INTO `treasuries_delivery` (`id`, `treasuries_id`, `treasuries_can_delivery_id`, `created_at`, `added_by`, `updated_by`, `updated_at`, `com_code`) VALUES
(6, 1, 3, '2022-08-31 14:52:37', 1, NULL, '2022-08-31 14:52:37', 1),
(7, 1, 4, '2022-10-06 02:59:45', 1, NULL, '2022-10-06 02:59:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `treasuries_transactions`
--

CREATE TABLE `treasuries_transactions` (
  `id` bigint(20) NOT NULL,
  `auto_serial` bigint(20) NOT NULL COMMENT 'كود تلقائي للحركة ',
  `isal_number` bigint(20) NOT NULL COMMENT 'كود العملية الالي',
  `shift_code` bigint(20) NOT NULL COMMENT 'كود الشفت للمستخدم',
  `money` decimal(10,2) NOT NULL COMMENT 'قيمة المبلغ المصروف او المحصل بالخزنة',
  `treasuries_id` int(11) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `mov_type` int(11) NOT NULL COMMENT 'نوع حركة النقدية ',
  `move_date` date NOT NULL,
  `the_foregin_key` bigint(20) DEFAULT NULL COMMENT 'كود الجدول الاخر المرتبط بالحركة',
  `account_number` bigint(20) DEFAULT NULL COMMENT 'رقم الحساب المالي ',
  `is_account` tinyint(1) DEFAULT NULL COMMENT 'هل هو حساب مالي',
  `money_for_account` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'قيمة المبلغ المستحق للحساب او علي الحساب',
  `byan` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول حركة النقدية بالشفتات';

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins_shifts`
--
ALTER TABLE `admins_shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins_treasuries`
--
ALTER TABLE `admins_treasuries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delegates`
--
ALTER TABLE `delegates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inv_itemcard`
--
ALTER TABLE `inv_itemcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_itemcard_batches`
--
ALTER TABLE `inv_itemcard_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_itemcard_categories`
--
ALTER TABLE `inv_itemcard_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_itemcard_movements`
--
ALTER TABLE `inv_itemcard_movements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_itemcard_movements_categories`
--
ALTER TABLE `inv_itemcard_movements_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_itemcard_movements_types`
--
ALTER TABLE `inv_itemcard_movements_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_production_exchange`
--
ALTER TABLE `inv_production_exchange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_production_exchange_details`
--
ALTER TABLE `inv_production_exchange_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_production_lines`
--
ALTER TABLE `inv_production_lines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_production_order`
--
ALTER TABLE `inv_production_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_stores_inventory`
--
ALTER TABLE `inv_stores_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_stores_inventory_details`
--
ALTER TABLE `inv_stores_inventory_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mov_type`
--
ALTER TABLE `mov_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoices_return`
--
ALTER TABLE `sales_invoices_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoices_return_details`
--
ALTER TABLE `sales_invoices_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_with_orders`
--
ALTER TABLE `services_with_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_with_orders_details`
--
ALTER TABLE `services_with_orders_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers_categories`
--
ALTER TABLE `suppliers_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers_with_orders`
--
ALTER TABLE `suppliers_with_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers_with_orders_details`
--
ALTER TABLE `suppliers_with_orders_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suupliers`
--
ALTER TABLE `suupliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasuries`
--
ALTER TABLE `treasuries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasuries_delivery`
--
ALTER TABLE `treasuries_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins_shifts`
--
ALTER TABLE `admins_shifts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins_treasuries`
--
ALTER TABLE `admins_treasuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `delegates`
--
ALTER TABLE `delegates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_itemcard`
--
ALTER TABLE `inv_itemcard`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_itemcard_batches`
--
ALTER TABLE `inv_itemcard_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_itemcard_categories`
--
ALTER TABLE `inv_itemcard_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements`
--
ALTER TABLE `inv_itemcard_movements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_categories`
--
ALTER TABLE `inv_itemcard_movements_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_types`
--
ALTER TABLE `inv_itemcard_movements_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inv_production_exchange`
--
ALTER TABLE `inv_production_exchange`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_production_exchange_details`
--
ALTER TABLE `inv_production_exchange_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_production_lines`
--
ALTER TABLE `inv_production_lines`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_production_order`
--
ALTER TABLE `inv_production_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inv_stores_inventory`
--
ALTER TABLE `inv_stores_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inv_stores_inventory_details`
--
ALTER TABLE `inv_stores_inventory_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mov_type`
--
ALTER TABLE `mov_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales_invoices_return`
--
ALTER TABLE `sales_invoices_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_invoices_return_details`
--
ALTER TABLE `sales_invoices_return_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services_with_orders`
--
ALTER TABLE `services_with_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `services_with_orders_details`
--
ALTER TABLE `services_with_orders_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `suppliers_categories`
--
ALTER TABLE `suppliers_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers_with_orders`
--
ALTER TABLE `suppliers_with_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `suppliers_with_orders_details`
--
ALTER TABLE `suppliers_with_orders_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `suupliers`
--
ALTER TABLE `suupliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treasuries_delivery`
--
ALTER TABLE `treasuries_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
