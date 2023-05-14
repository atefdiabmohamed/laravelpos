-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2023 at 01:38 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `account_type`, `is_parent`, `parent_account_number`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `other_table_FK`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`) VALUES
(1, 'الحساب الاب للموردين', 9, 1, NULL, 1, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2023-05-14 11:31:10', '2023-05-14 11:31:10', 1, 1, '2023-05-14'),
(2, 'الحساب الاب للعملاء', 9, 1, NULL, 2, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2023-05-14 11:31:26', '2023-05-14 11:31:26', 1, 1, '2023-05-14'),
(3, 'الحساب الاب للمناديب', 9, 1, NULL, 3, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2023-05-14 11:31:42', '2023-05-14 11:31:42', 1, 1, '2023-05-14'),
(4, 'البنك الاهلي المصري حساب 1', 6, 0, 4, 4, 3, '0.00', '-10000.00', NULL, NULL, 1, 1, '2023-05-14 11:32:11', '2023-05-14 13:05:14', 1, 1, '2023-05-14'),
(5, 'فواتير الكهرباء', 7, 0, 8, 5, 3, '0.00', '0.00', NULL, NULL, 1, 1, '2023-05-14 11:32:31', '2023-05-14 13:04:03', 1, 1, '2023-05-14'),
(6, 'فواتير الغاز', 7, 0, 8, 6, 3, '0.00', '0.00', NULL, NULL, 1, 1, '2023-05-14 11:32:43', '2023-05-14 11:33:31', 1, 1, '2023-05-14'),
(7, 'نثريات', 7, 0, 8, 7, 3, '0.00', '0.00', NULL, NULL, 1, 1, '2023-05-14 11:33:00', '2023-05-14 11:33:23', 1, 1, '2023-05-14'),
(8, 'مصروفات', 7, 1, NULL, 8, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2023-05-14 11:33:15', '2023-05-14 11:33:15', 1, 1, '2023-05-14'),
(9, 'هايبر الرحاب', 3, 0, 3, 9, 3, '0.00', '0.00', 1, NULL, 1, NULL, '2023-05-14 11:34:09', '2023-05-14 13:00:30', 1, 1, '2023-05-14'),
(10, 'هاير الراية', 3, 0, 3, 10, 2, '5000.00', '6500.00', 2, NULL, 1, NULL, '2023-05-14 11:34:44', '2023-05-14 13:01:58', 1, 1, '2023-05-14'),
(11, 'المكتب', 4, 0, 8, 11, 3, '0.00', '0.00', 1, NULL, 1, NULL, '2023-05-14 11:35:19', '2023-05-14 11:35:19', 1, 1, '2023-05-14'),
(12, 'عاطف دياب محمد أحمد', 4, 0, 8, 12, 1, '-500.00', '-505.00', 2, NULL, 1, NULL, '2023-05-14 11:35:42', '2023-05-14 12:54:32', 1, 1, '2023-05-14'),
(13, 'عاطف دياب محمد', 2, 0, 1, 13, 1, '-5000.00', '-14400.00', 1, NULL, 1, NULL, '2023-05-14 11:36:55', '2023-05-14 13:01:30', 1, 1, '2023-05-14'),
(14, 'خط الانتاج رقم 1', 5, 0, 34, 14, 3, '0.00', '90000.00', 1, NULL, 1, NULL, '2023-05-14 11:44:21', '2023-05-14 11:50:35', 1, 1, '2023-05-14'),
(15, 'مذبح المصنع', 2, 0, 1, 15, 3, '0.00', '-1000000.00', 2, NULL, 1, NULL, '2023-05-14 11:48:39', '2023-05-14 13:07:58', 1, 1, '2023-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
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
  `permission_roles_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `com_code` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `permission_roles_id`, `email`, `username`, `password`, `created_at`, `updated_at`, `added_by`, `updated_by`, `active`, `com_code`, `date`) VALUES
(1, 'الادارة العليا', 1, 'test@gmail.com', 'admin', '$2y$10$qHBrpnmqcJgMX/29x92EA.QbD7T5PWKvYO3p.RH2jclPuE4gEGqBe', '2022-08-27 15:59:31', '2023-04-19 22:22:47', NULL, 1, 1, 1, NULL),
(2, 'محمود علي أحمد السيد', 3, 'm2023@gmail.com', 'm2023', '$2y$10$YFr.tT3k4SOvDAWO9AeuCemvFlTgm1LrUjQrqpsOHEPn.4reJaVnW', '2023-04-15 01:45:13', '2023-04-26 02:29:39', 1, 1, 1, 1, '2023-04-15');

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
  `money_state_value` decimal(10,2) NOT NULL DEFAULT 0.00,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول شفتات الخزن للمستخدمين ';

--
-- Dumping data for table `admins_shifts`
--

INSERT INTO `admins_shifts` (`id`, `shift_code`, `admin_id`, `treasuries_id`, `treasuries_balnce_in_shift_start`, `start_date`, `end_date`, `is_finished`, `is_delivered_and_review`, `delivered_to_admin_id`, `delivered_to_admin_sift_id`, `delivered_to_treasuries_id`, `money_should_deviled`, `what_realy_delivered`, `money_state`, `money_state_value`, `receive_type`, `review_receive_date`, `treasuries_transactions_id`, `added_by`, `created_at`, `notes`, `com_code`, `date`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, '0.00', '2023-05-14 13:03:39', '2023-05-14 13:03:50', 1, 0, NULL, NULL, NULL, '0.00', NULL, NULL, '0.00', NULL, NULL, NULL, 1, '2023-05-14 13:03:39', NULL, 1, '2023-05-14', 1, '2023-05-14 13:03:50'),
(2, 2, 1, 1, '0.00', '2023-05-14 13:03:54', '2023-05-14 13:05:23', 1, 0, NULL, NULL, NULL, '10000.00', NULL, NULL, '0.00', NULL, NULL, NULL, 1, '2023-05-14 13:03:54', NULL, 1, '2023-05-14', 1, '2023-05-14 13:05:23'),
(3, 3, 1, 1, '0.00', '2023-05-14 13:05:35', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, NULL, 1, '2023-05-14 13:05:35', NULL, 1, '2023-05-14', NULL, '2023-05-14 13:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `admins_stores`
--

CREATE TABLE `admins_stores` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='صلاحيات المخازن المستخدمين الخاصة';

--
-- Dumping data for table `admins_stores`
--

INSERT INTO `admins_stores` (`id`, `admin_id`, `store_id`, `active`, `added_by`, `created_at`, `updated_by`, `updated_at`, `com_code`, `date`) VALUES
(1, 1, 2, 1, 1, '2023-05-14 13:03:25', NULL, '2023-05-14 13:03:25', 1, '2023-05-14'),
(2, 1, 1, 1, 1, '2023-05-14 13:03:29', NULL, '2023-05-14 13:03:29', 1, '2023-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `admins_treasuries`
--

CREATE TABLE `admins_treasuries` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `treasuries_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='صلاحيات خزن المستخدمين الخاصة';

--
-- Dumping data for table `admins_treasuries`
--

INSERT INTO `admins_treasuries` (`id`, `admin_id`, `treasuries_id`, `active`, `added_by`, `created_at`, `updated_by`, `updated_at`, `com_code`, `date`) VALUES
(1, 1, 1, 1, 1, '2023-05-14 13:03:19', NULL, '2023-05-14 13:03:19', 1, '2023-05-14'),
(2, 1, 2, 1, 1, '2023-05-14 13:05:56', NULL, '2023-05-14 13:05:56', 1, '2023-05-14');

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
  `notes` text DEFAULT NULL,
  `is_set_Batches_setting` tinyint(1) NOT NULL DEFAULT 0,
  `Batches_setting_type` tinyint(1) DEFAULT NULL COMMENT 'واحد دا يعمل بنظام تعدد الباتشات - اثنين لايعمل بنظام البياتشات فقط باتشه واحده لكل صنف',
  `default_unit` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'واحد البيع الالي بالوحده الاب - اثنين البيع الالي بوحده التجزئة الفرعية'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `system_name`, `photo`, `active`, `general_alert`, `address`, `phone`, `customer_parent_account_number`, `suppliers_parent_account_number`, `delegate_parent_account_number`, `employees_parent_account_number`, `production_lines_parent_account`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `notes`, `is_set_Batches_setting`, `Batches_setting_type`, `default_unit`) VALUES
(1, 'عاطف سوفت للبرمجيات', '1667938745648.png', 1, NULL, 'سوهاج - كوبري النيل', '012659854', 3, 1, 8, 9, 34, 0, 1, '0000-00-00 00:00:00', '2023-04-18 05:24:05', 1, 'الاضافة بالمبيعات  ctrl او enter', 1, 2, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(1, 1, 'هايبر الرحاب', 9, 3, '0.00', '0.00', NULL, 1, NULL, '2023-05-14 11:34:09', '2023-05-14 13:00:30', 1, 1, '2023-05-14', '16 مصر الجديدة', '0115658527'),
(2, 2, 'هاير الراية', 10, 2, '5000.00', '6500.00', NULL, 1, NULL, '2023-05-14 11:34:44', '2023-05-14 13:01:58', 1, 1, '2023-05-14', '25 شارع النصر الجيزة', '0126552444');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول المناديب';

--
-- Dumping data for table `delegates`
--

INSERT INTO `delegates` (`id`, `delegate_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `phones`, `address`, `percent_type`, `percent_collect_commission`, `percent_salaes_commission_kataei`, `percent_salaes_commission_nosjomla`, `percent_salaes_commission_jomla`) VALUES
(1, 1, 'المكتب', 11, 3, '0.00', '0.00', NULL, 1, NULL, '2023-05-14 11:35:19', '2023-05-14 11:35:19', 1, 1, '2023-05-14', NULL, NULL, 2, '0.00', '2.00', '1.00', '0.50'),
(2, 2, 'عاطف دياب محمد أحمد', 12, 1, '-500.00', '-505.00', NULL, 1, NULL, '2023-05-14 11:35:42', '2023-05-14 12:54:32', 1, 1, '2023-05-14', NULL, NULL, 1, '5.00', '5.00', '5.00', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inv_itemcard`
--

INSERT INTO `inv_itemcard` (`id`, `item_code`, `barcode`, `name`, `item_type`, `inv_itemcard_categories_id`, `parent_inv_itemcard_id`, `does_has_retailunit`, `retail_uom_id`, `uom_id`, `retail_uom_quntToParent`, `added_by`, `created_at`, `updated_at`, `updated_by`, `active`, `date`, `com_code`, `price`, `nos_gomla_price`, `gomla_price`, `price_retail`, `nos_gomla_price_retail`, `gomla_price_retail`, `cost_price`, `cost_price_retail`, `has_fixced_price`, `All_QUENTITY`, `QUENTITY`, `QUENTITY_Retail`, `QUENTITY_all_Retails`, `photo`) VALUES
(1, 1, 'item1', 'فراخ شهد', 2, 2, 0, 1, 2, 1, '10.00', 1, '2023-05-14 11:40:58', '2023-05-14 13:00:27', NULL, 1, '2023-05-14', 1, '1200.00', '1100.00', '1000.00', '120.00', '110.00', '100.00', '1000.00', '100.00', 1, '17.00', '17.000', '0.000', '170.000', '1684057258395.jpg'),
(2, 2, 'item2', 'فراخ مذبوحة', 2, 2, 1, 1, 4, 3, '100.00', 1, '2023-05-14 11:47:52', '2023-05-14 11:49:37', NULL, 1, '2023-05-14', 1, '5000.00', '4500.00', '4000.00', '40.00', '35.00', '30.00', '10000.00', '100.00', 1, '90.00', '90.000', '0.000', '9000.000', '1684057672254.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول  باتشات الاصناف بالمخازن';

--
-- Dumping data for table `inv_itemcard_batches`
--

INSERT INTO `inv_itemcard_batches` (`id`, `store_id`, `item_code`, `inv_uoms_id`, `unit_cost_price`, `quantity`, `total_cost_price`, `production_date`, `expired_date`, `com_code`, `auto_serial`, `added_by`, `created_at`, `updated_at`, `updated_by`, `is_send_to_archived`) VALUES
(1, 1, 1, 1, '1200.00', '6.00', '7200.00', '2023-03-01', '2023-08-24', 1, 1, 1, '2023-05-14 11:41:42', '2023-05-14 13:00:26', 1, 0),
(2, 2, 1, 1, '1200.00', '1.00', '1200.00', '2023-03-01', '2023-08-24', 1, 2, 1, '2023-05-14 11:43:37', '2023-05-14 11:43:37', NULL, 0),
(3, 1, 2, 3, '10000.00', '90.00', '900000.00', '2023-04-01', '2023-05-14', 1, 3, 1, '2023-05-14 11:49:20', '2023-05-14 11:49:37', 1, 0),
(4, 2, 1, 1, '1000.00', '10.00', '10000.00', '2023-05-01', '2023-05-31', 1, 4, 1, '2023-05-14 11:50:35', '2023-05-14 11:50:35', NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول فئات الاصناف';

--
-- Dumping data for table `inv_itemcard_categories`
--

INSERT INTO `inv_itemcard_categories` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم', '2023-05-14 11:38:50', '2023-05-14 11:38:50', 1, NULL, 1, '2023-05-14', 1),
(2, 'فراخ', '2023-05-14 11:38:56', '2023-05-14 11:38:56', 1, NULL, 1, '2023-05-14', 1),
(3, 'اسماك', '2023-05-14 11:39:02', '2023-05-14 11:39:02', 1, NULL, 1, '2023-05-14', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inv_itemcard_movements`
--

INSERT INTO `inv_itemcard_movements` (`id`, `inv_itemcard_movements_categories`, `item_code`, `store_id`, `items_movements_types`, `FK_table`, `FK_table_details`, `byan`, `quantity_befor_movement`, `quantity_after_move`, `added_by`, `date`, `created_at`, `com_code`, `quantity_befor_move_store`, `quantity_after_move_store`) VALUES
(1, 1, 1, 1, 1, 1, 1, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 1', 'عدد  0 كرتونة فراخ شهد', 'عدد  10 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:41:42', 1, 'عدد  0 كرتونة فراخ شهد', 'عدد  10 كرتونة فراخ شهد'),
(2, 1, 1, 1, 3, 1, 2, ' نظير مرتجع مشتريات عام الي المورد عاطف دياب محمد فاتورة رقم 1', 'عدد  10 كرتونة فراخ شهد', 'عدد  7 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:42:09', 1, 'عدد  10 كرتونة فراخ شهد', 'عدد  7 كرتونة فراخ شهد'),
(3, 3, 1, 1, 20, 1, 1, ' نظير صرف أصناف  الي مخزن الاستلام  الفرعي بشارع الشهيد أمر تحويل رقم 1', 'عدد  7 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:43:30', 1, 'عدد  7 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد'),
(4, 3, 1, 2, 22, 1, 1, 'نظير اعتماد واستلام امر تحويل وارد من المخزن    الرئيسي امر تحويل رقم 1', 'عدد  6 كرتونة فراخ شهد', 'عدد  7 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:43:38', 1, 'عدد  0 كرتونة فراخ شهد', 'عدد  1 كرتونة فراخ شهد'),
(5, 3, 1, 1, 6, 1, 1, 'جرد بالمخازن للباتش رقم 1 جرد رقم 1', 'عدد  7 كرتونة فراخ شهد', 'عدد  7 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:44:00', 1, 'عدد  6 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد'),
(6, 4, 1, 1, 17, 1, 1, ' نظير ًرف خامات   الي خط انتاج  خط الانتاج رقم 1 فاتورة رقم 1', 'عدد  7 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:45:14', 1, 'عدد  6 كرتونة فراخ شهد', 'عدد  5 كرتونة فراخ شهد'),
(7, 4, 1, 1, 18, 1, 1, ' نظير حذف سطر الصنف من فاتورة صرف خامات  لخط الانتاج      خط الانتاج رقم 1 فاتورة رقم 1', 'عدد  6 كرتونة فراخ شهد', 'عدد  7 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:45:22', 1, 'عدد  5 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد'),
(8, 1, 2, 1, 1, 2, 3, 'نظير مشتريات من المورد  مذبح المصنع فاتورة رقم 2', 'عدد  0 شكارة', 'عدد  100 شكارة', 1, '2023-05-14', '2023-05-14 11:49:20', 1, 'عدد  0 شكارة', 'عدد  100 شكارة'),
(9, 4, 2, 1, 17, 1, 2, ' نظير ًرف خامات   الي خط انتاج  خط الانتاج رقم 1 فاتورة رقم 1', 'عدد  100 شكارة', 'عدد  90 شكارة', 1, '2023-05-14', '2023-05-14 11:49:37', 1, 'عدد  100 شكارة', 'عدد  90 شكارة'),
(10, 4, 1, 2, 19, 1, 1, 'نظير فاتورة استلام انتاج تام من خط الانتاج   خط الانتاج رقم 1 فاتورة رقم 1', 'عدد  7 كرتونة فراخ شهد', 'عدد  17 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 11:50:36', 1, 'عدد  1 كرتونة فراخ شهد', 'عدد  11 كرتونة فراخ شهد'),
(11, 2, 1, 1, 4, 1, 1, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  17 كرتونة فراخ شهد', 'عدد  16 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 12:54:23', 1, 'عدد  6 كرتونة فراخ شهد', 'عدد  5 كرتونة فراخ شهد'),
(12, 2, 1, 1, 5, 1, 1, 'نظير مرتجع مبيعات عام  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  16 كرتونة فراخ شهد', 'عدد  17 كرتونة فراخ شهد', 1, '2023-05-14', '2023-05-14 13:00:26', 1, 'عدد  5 كرتونة فراخ شهد', 'عدد  6 كرتونة فراخ شهد');

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_movements_categories`
--

CREATE TABLE `inv_itemcard_movements_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_itemcard_movements_types`
--

CREATE TABLE `inv_itemcard_movements_types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `inv_production_exchange`
--

INSERT INTO `inv_production_exchange` (`id`, `order_type`, `auto_serial`, `inv_production_order_auto_serial`, `order_date`, `production_lines_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `Supplier_balance_befor`, `Supplier_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `store_id`, `approved_by`) VALUES
(1, 1, 1, 1, '2023-05-14', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '100000.00', '0.00', '100000.00', '100000.00', 14, '100000.00', 2, '0.00', '100000.00', NULL, NULL, NULL, 1, '2023-05-14 11:45:04', '2023-05-14 11:49:42', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_exchange_details`
--

CREATE TABLE `inv_production_exchange_details` (
  `id` bigint(20) NOT NULL,
  `inv_production_exchange_id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل اصناف امر الصرف  الخامات  لخط الانتاج';

--
-- Dumping data for table `inv_production_exchange_details`
--

INSERT INTO `inv_production_exchange_details` (`id`, `inv_production_exchange_id`, `inv_production_exchange_auto_serial`, `order_type`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_auto_serial`, `production_date`, `expire_date`, `item_card_type`) VALUES
(2, 1, 1, 1, 1, '10.00', 3, 1, '10000.00', '100000.00', '2023-05-14', 1, '2023-05-14 11:49:37', NULL, '2023-05-14 11:49:37', 2, 3, '2023-04-01', '2023-05-14', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول خطوط الانتاج الورش';

--
-- Dumping data for table `inv_production_lines`
--

INSERT INTO `inv_production_lines` (`id`, `production_lines_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(1, 1, 'خط الانتاج رقم 1', 14, 3, '0.00', '90000.00', NULL, 1, NULL, '2023-05-14 11:44:21', '2023-05-14 11:50:35', 1, 1, '2023-05-14', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='امر التشغيل للانتاج';

--
-- Dumping data for table `inv_production_order`
--

INSERT INTO `inv_production_order` (`id`, `auto_serial`, `production_plane`, `production_plan_date`, `is_approved`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `approved_by`, `approved_at`, `is_closed`, `closed_by`, `closed_at`, `date`) VALUES
(1, 1, 'انتاج عدد  1000 كرتونة فراخ شهد', '2023-05-01', 1, 1, NULL, '2023-05-14 11:44:48', '2023-05-14 11:44:52', 1, 1, '2023-05-14 11:44:52', 0, NULL, NULL, '2023-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_receive`
--

CREATE TABLE `inv_production_receive` (
  `id` bigint(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT 'واحد استلام منتج تام من  خط الانتاج- اتنثين مرتجع منتج تام الي خط الانتاج ',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `inv_production_receive`
--

INSERT INTO `inv_production_receive` (`id`, `order_type`, `auto_serial`, `inv_production_order_auto_serial`, `order_date`, `production_lines_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `Supplier_balance_befor`, `Supplier_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `store_id`, `approved_by`) VALUES
(1, 1, 1, 1, '2023-05-14', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '10000.00', '0.00', '10000.00', '10000.00', 14, '-10000.00', 2, '0.00', '10000.00', NULL, NULL, NULL, 1, '2023-05-14 11:50:04', '2023-05-14 11:50:35', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_production_receive_details`
--

CREATE TABLE `inv_production_receive_details` (
  `id` bigint(20) NOT NULL,
  `inv_production_receive_id` bigint(20) NOT NULL,
  `inv_production_receive_auto_serial` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل اصناف امر الصرف  الخامات  لخط الانتاج';

--
-- Dumping data for table `inv_production_receive_details`
--

INSERT INTO `inv_production_receive_details` (`id`, `inv_production_receive_id`, `inv_production_receive_auto_serial`, `order_type`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_auto_serial`, `production_date`, `expire_date`, `item_card_type`) VALUES
(1, 1, 1, 1, 1, '10.00', 1, 1, '1000.00', '10000.00', '2023-05-14', 1, '2023-05-14 11:50:31', NULL, '2023-05-14 11:50:31', 1, NULL, '2023-05-01', '2023-05-31', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول جرد المخازن';

--
-- Dumping data for table `inv_stores_inventory`
--

INSERT INTO `inv_stores_inventory` (`id`, `store_id`, `inventory_date`, `inventory_type`, `auto_serial`, `is_closed`, `total_cost_batches`, `notes`, `added_by`, `date`, `created_at`, `updated_by`, `updated_at`, `com_code`, `cloased_by`, `closed_at`) VALUES
(1, 1, '2023-05-14', 1, 1, 1, '7200.00', NULL, 1, '2023-05-14', '2023-05-14 11:43:47', NULL, '2023-05-14 11:44:00', 1, 1, '2023-05-14 11:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `inv_stores_inventory_details`
--

CREATE TABLE `inv_stores_inventory_details` (
  `id` bigint(20) NOT NULL,
  `inv_stores_inventory_id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل امر الجرد';

--
-- Dumping data for table `inv_stores_inventory_details`
--

INSERT INTO `inv_stores_inventory_details` (`id`, `inv_stores_inventory_id`, `inv_stores_inventory_auto_serial`, `item_code`, `inv_uoms_id`, `batch_auto_serial`, `old_quantity`, `new_quantity`, `diffrent_quantity`, `unit_cost_price`, `total_cost_price`, `production_date`, `expired_date`, `notes`, `is_closed`, `added_by`, `created_at`, `updated_by`, `updated_at`, `cloased_by`, `closed_at`, `com_code`) VALUES
(1, 1, 1, 1, 1, 1, '6.00', '6.00', '0.00', '1200.00', '7200.00', '2023-03-01', '2023-08-24', NULL, 1, 1, '2023-05-14 11:43:55', NULL, '2023-05-14 11:44:00', 1, '2023-05-14 11:44:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inv_stores_transfer`
--

CREATE TABLE `inv_stores_transfer` (
  `id` bigint(20) NOT NULL,
  `auto_serial` bigint(20) NOT NULL,
  `transfer_from_store_id` int(11) NOT NULL COMMENT 'مخزن التحويل',
  `transfer_to_store_id` int(11) NOT NULL COMMENT 'مخزن الاستلام',
  `order_date` date NOT NULL COMMENT 'تاريخ التحويل',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `notes` varchar(225) DEFAULT NULL COMMENT 'اجمالي الفاتورة قبل الخصم',
  `items_counter` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_cost_items` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'اجمالي الاصناف فقط',
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `inv_stores_transfer`
--

INSERT INTO `inv_stores_transfer` (`id`, `auto_serial`, `transfer_from_store_id`, `transfer_to_store_id`, `order_date`, `is_approved`, `com_code`, `notes`, `items_counter`, `total_cost_items`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `approved_at`) VALUES
(1, 1, 1, 2, '2023-05-14', 0, 1, NULL, '1.00', '1200.00', 1, '2023-05-14 11:43:14', '2023-05-14 11:43:30', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inv_stores_transfer_details`
--

CREATE TABLE `inv_stores_transfer_details` (
  `id` bigint(20) NOT NULL,
  `inv_stores_transfer_id` bigint(20) NOT NULL,
  `inv_stores_transfer_auto_serial` bigint(20) NOT NULL,
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
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_card_type` tinyint(1) NOT NULL,
  `transfer_from_batch_id` bigint(20) NOT NULL,
  `transfer_to_batch_id` bigint(20) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `is_canceld_receive` tinyint(1) DEFAULT 0,
  `canceld_by` int(11) DEFAULT NULL,
  `canceld_at` datetime DEFAULT NULL,
  `canceld_cause` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل اصناف امر الصرف  الخامات  لخط الانتاج';

--
-- Dumping data for table `inv_stores_transfer_details`
--

INSERT INTO `inv_stores_transfer_details` (`id`, `inv_stores_transfer_id`, `inv_stores_transfer_auto_serial`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `production_date`, `expire_date`, `item_card_type`, `transfer_from_batch_id`, `transfer_to_batch_id`, `is_approved`, `approved_by`, `approved_at`, `is_canceld_receive`, `canceld_by`, `canceld_at`, `canceld_cause`) VALUES
(1, 1, 1, 1, '1.00', 1, 1, '1200.00', '1200.00', '2023-05-14', 1, '2023-05-14 11:43:30', NULL, '2023-05-14 11:43:38', 1, '2023-03-01', '2023-08-24', 2, 1, NULL, 1, 1, '2023-05-14 11:43:38', 0, NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الوحدات';

--
-- Dumping data for table `inv_uoms`
--

INSERT INTO `inv_uoms` (`id`, `name`, `is_master`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'كرتونة فراخ شهد', 1, '2023-05-14 11:38:15', '2023-05-14 11:38:15', 1, NULL, 1, '2023-05-14', 1),
(2, 'كيلوا 90 جرام فراخ شهد', 0, '2023-05-14 11:38:37', '2023-05-14 11:38:37', 1, NULL, 1, '2023-05-14', 1),
(3, 'شكارة', 1, '2023-05-14 11:46:23', '2023-05-14 11:46:23', 1, NULL, 1, '2023-05-14', 1),
(4, 'فرخة', 0, '2023-05-14 11:46:35', '2023-05-14 11:46:35', 1, NULL, 1, '2023-05-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='الحركة علي الخزنة';

--
-- Dumping data for table `mov_type`
--

INSERT INTO `mov_type` (`id`, `name`, `active`, `in_screen`, `is_private_internal`) VALUES
(1, 'مراجعة واستلام نقدية شفت خزنة مستخدم', 1, 2, 1),
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
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_main_menues`
--

CREATE TABLE `permission_main_menues` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول القوائم الرئيسية للصلاحيات';

--
-- Dumping data for table `permission_main_menues`
--

INSERT INTO `permission_main_menues` (`id`, `name`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الضبط العام', '2023-04-13 01:04:52', 1, '2023-04-13 01:04:52', NULL, 1, '2023-04-13', 1),
(2, 'الحسابات', '2023-04-13 01:05:05', 1, '2023-04-13 01:05:05', NULL, 1, '2023-04-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles`
--

CREATE TABLE `permission_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول ادوارالمستخدمين الرئيسي';

--
-- Dumping data for table `permission_roles`
--

INSERT INTO `permission_roles` (`id`, `name`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الادارة العليا', '2023-03-27 01:22:27', 1, '2023-03-27 01:26:42', 1, 1, '2023-03-27', 1),
(2, 'مدخل بيانات', '2023-04-15 01:27:27', 1, '2023-04-15 01:27:27', NULL, 1, '2023-04-15', 1),
(3, 'كاشير', '2023-04-15 01:27:33', 1, '2023-04-15 01:27:33', NULL, 1, '2023-04-15', 1),
(4, 'محاسب', '2023-04-15 01:27:45', 1, '2023-04-15 01:27:45', NULL, 1, '2023-04-15', 1),
(5, 'مدير حسابات', '2023-04-15 01:27:54', 1, '2023-04-15 01:27:54', NULL, 1, '2023-04-15', 1),
(6, 'أمين مخزن', '2023-04-15 01:28:02', 1, '2023-04-15 01:28:02', NULL, 1, '2023-04-15', 1),
(7, 'مندوب مبيعات', '2023-04-15 01:28:11', 1, '2023-04-15 01:28:11', NULL, 1, '2023-04-15', 1),
(8, 'مدير مشتريات', '2023-04-15 01:28:19', 1, '2023-04-15 01:28:19', NULL, 1, '2023-04-15', 1),
(9, 'مراجع شباك', '2023-04-15 01:28:27', 1, '2023-04-15 01:28:27', NULL, 1, '2023-04-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles_main_menus`
--

CREATE TABLE `permission_roles_main_menus` (
  `id` int(11) NOT NULL,
  `permission_roles_id` int(11) NOT NULL,
  `permission_main_menues_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permission_roles_main_menus`
--

INSERT INTO `permission_roles_main_menus` (`id`, `permission_roles_id`, `permission_main_menues_id`, `added_by`, `created_at`, `com_code`) VALUES
(11, 1, 2, 1, '2023-04-13 01:13:28', 1),
(13, 1, 1, 1, '2023-04-17 02:40:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles_sub_menu`
--

CREATE TABLE `permission_roles_sub_menu` (
  `id` int(11) NOT NULL,
  `permission_roles_main_menus_id` int(11) NOT NULL,
  `permission_sub_menues_id` int(11) NOT NULL,
  `permission_roles_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permission_roles_sub_menu`
--

INSERT INTO `permission_roles_sub_menu` (`id`, `permission_roles_main_menus_id`, `permission_sub_menues_id`, `permission_roles_id`, `added_by`, `created_at`) VALUES
(3, 13, 2, 1, 1, '2023-04-18 04:56:16'),
(4, 13, 1, 1, 1, '2023-04-18 04:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `permission_roles_sub_menues_actions`
--

CREATE TABLE `permission_roles_sub_menues_actions` (
  `id` int(11) NOT NULL,
  `permission_roles_sub_menu_id` int(11) NOT NULL,
  `permission_sub_menues_actions_id` int(11) NOT NULL,
  `permission_roles_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permission_roles_sub_menues_actions`
--

INSERT INTO `permission_roles_sub_menues_actions` (`id`, `permission_roles_sub_menu_id`, `permission_sub_menues_actions_id`, `permission_roles_id`, `added_by`, `created_at`) VALUES
(4, 4, 1, 1, 1, '2023-04-18 05:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `permission_sub_menues`
--

CREATE TABLE `permission_sub_menues` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `permission_main_menues_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول القوائم الفرعية للصلاحيات';

--
-- Dumping data for table `permission_sub_menues`
--

INSERT INTO `permission_sub_menues` (`id`, `name`, `permission_main_menues_id`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الضبط العام', 1, '2023-04-13 01:05:26', 1, '2023-04-13 01:05:26', NULL, 1, '2023-04-13', 1),
(2, 'بيانات الخزن', 1, '2023-04-13 01:05:35', 1, '2023-04-13 01:05:35', NULL, 1, '2023-04-13', 1),
(3, 'أنواع الحسابات المالية', 2, '2023-04-13 01:05:52', 1, '2023-04-13 01:05:52', NULL, 1, '2023-04-13', 1),
(4, 'الحسابات المالية', 2, '2023-04-13 01:06:07', 1, '2023-04-13 01:06:07', NULL, 1, '2023-04-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_sub_menues_actions`
--

CREATE TABLE `permission_sub_menues_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `permission_sub_menues_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الصلاحيات النهائية علي القوائم الفلفعرية';

--
-- Dumping data for table `permission_sub_menues_actions`
--

INSERT INTO `permission_sub_menues_actions` (`id`, `name`, `permission_sub_menues_id`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'عرض', 1, '2023-04-13 01:06:22', 1, '2023-04-13 01:06:22', NULL, 1, '2023-04-13', 1),
(2, 'تعديل', 1, '2023-04-13 01:06:29', 1, '2023-04-13 01:06:29', NULL, 1, '2023-04-13', 1),
(3, 'عرض', 2, '2023-04-13 01:06:50', 1, '2023-04-13 01:06:50', NULL, 1, '2023-04-13', 1),
(4, 'اضافة', 2, '2023-04-13 01:06:56', 1, '2023-04-13 01:06:56', NULL, 1, '2023-04-13', 1),
(5, 'تعديل', 2, '2023-04-13 01:07:01', 1, '2023-04-13 01:07:01', NULL, 1, '2023-04-13', 1),
(6, 'حذف', 2, '2023-04-13 01:07:07', 1, '2023-04-13 01:07:07', NULL, 1, '2023-04-13', 1),
(7, 'عرض', 3, '2023-04-13 01:07:26', 1, '2023-04-13 01:07:26', NULL, 1, '2023-04-13', 1),
(8, 'اضافة', 3, '2023-04-13 01:07:34', 1, '2023-04-13 01:07:34', NULL, 1, '2023-04-13', 1),
(9, 'تعديل', 3, '2023-04-13 01:07:40', 1, '2023-04-13 01:07:40', NULL, 1, '2023-04-13', 1),
(10, 'حذف', 3, '2023-04-13 01:07:53', 1, '2023-04-13 01:07:53', NULL, 1, '2023-04-13', 1),
(11, 'عرض', 4, '2023-04-13 01:08:11', 1, '2023-04-13 01:08:11', NULL, 1, '2023-04-13', 1),
(12, 'تعديل', 4, '2023-04-13 01:08:17', 1, '2023-04-13 01:08:17', NULL, 1, '2023-04-13', 1),
(13, 'حذف', 4, '2023-04-13 01:08:23', 1, '2023-04-13 01:08:23', NULL, 1, '2023-04-13', 1),
(14, 'اضافة', 4, '2023-04-13 01:08:33', 1, '2023-04-13 01:08:33', NULL, 1, '2023-04-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='المبيعات للعملاء';

--
-- Dumping data for table `sales_invoices`
--

INSERT INTO `sales_invoices` (`id`, `sales_matrial_types`, `auto_serial`, `invoice_date`, `is_has_customer`, `customer_code`, `delegate_code`, `delegate_commission_percent_type`, `delegate_commission_percent`, `delegate_commission_value`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `customer_balance_befor`, `customer_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `date`, `sales_item_type`) VALUES
(1, 2, 1, '2023-05-14', 1, 1, 2, '1.00', '5.00', '-5.00', 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1200.00', '0.00', '1200.00', '1200.00', 9, '1200.00', 2, '0.00', '0.00', NULL, NULL, NULL, 1, '2023-05-14 12:54:12', '2023-05-14 12:54:32', 1, 1, '2023-05-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices_details`
--

CREATE TABLE `sales_invoices_details` (
  `id` bigint(20) NOT NULL,
  `sales_invoices_id` bigint(20) NOT NULL,
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
  `date` date NOT NULL,
  `itemCostPriceFromBatch` decimal(10,2) NOT NULL COMMENT 'سعر تكلفة شراء وحده البيع للصنف من الباتش المسحوب منها',
  `taoalitemCostPriceFromBatch` decimal(10,2) NOT NULL COMMENT 'اجمالي سعر تكلفة شراء وحده البيع للصنف من الباتش المسحوب منها',
  `item_total_earnings` decimal(10,2) NOT NULL COMMENT 'اجمالي ربح الصنف بالفاتورة'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `sales_invoices_details`
--

INSERT INTO `sales_invoices_details` (`id`, `sales_invoices_id`, `sales_invoices_auto_serial`, `store_id`, `sales_item_type`, `item_code`, `uom_id`, `batch_auto_serial`, `quantity`, `unit_price`, `total_price`, `is_normal_orOther`, `isparentuom`, `com_code`, `invoice_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `production_date`, `expire_date`, `date`, `itemCostPriceFromBatch`, `taoalitemCostPriceFromBatch`, `item_total_earnings`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, '1.0000', '1200.00', '1200.00', 1, 1, 1, '2023-05-14', 1, '2023-05-14 12:54:23', NULL, '2023-05-14 12:54:23', NULL, NULL, '2023-05-14', '1200.00', '1200.00', '0.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='مرتجع المبيعات للعملاء';

--
-- Dumping data for table `sales_invoices_return`
--

INSERT INTO `sales_invoices_return` (`id`, `return_type`, `sales_matrial_types`, `auto_serial`, `invoice_date`, `is_has_customer`, `customer_code`, `delegate_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `customer_balance_befor`, `customer_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `date`) VALUES
(1, 2, 1, 1, '2023-05-14', 1, 1, 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1200.00', '0.00', '1200.00', '1200.00', 9, '-1200.00', 2, '0.00', '1200.00', NULL, NULL, NULL, 1, '2023-05-14 12:54:46', '2023-05-14 13:00:30', 1, 1, '2023-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoices_return_details`
--

CREATE TABLE `sales_invoices_return_details` (
  `id` bigint(20) NOT NULL,
  `sales_invoices_return_id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل اصناف فاتورة مرتجع المبيعات';

--
-- Dumping data for table `sales_invoices_return_details`
--

INSERT INTO `sales_invoices_return_details` (`id`, `sales_invoices_return_id`, `sales_invoices_auto_serial`, `store_id`, `sales_item_type`, `item_code`, `uom_id`, `batch_auto_serial`, `quantity`, `unit_cost_price`, `unit_price`, `total_price`, `is_normal_orOther`, `isparentuom`, `com_code`, `invoice_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `production_date`, `expire_date`, `date`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, '1.0000', NULL, '1200.00', '1200.00', 1, 1, 1, '2023-05-14', 1, '2023-05-14 13:00:26', NULL, '2023-05-14 13:00:26', NULL, NULL, '2023-05-14');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales_matrial_types`
--

INSERT INTO `sales_matrial_types` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم ومجمدات', '2023-05-14 11:37:21', '2023-05-14 11:37:21', 1, NULL, 1, '2023-05-14', 1),
(2, 'منوع', '2023-05-14 11:37:31', '2023-05-14 11:37:31', 1, NULL, 1, '2023-05-14', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='خدمات نقدمها للغير ومقدمه لنا ';

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `active`, `type`, `added_by`, `created_at`, `updated_by`, `updated_at`, `com_code`, `date`) VALUES
(1, 'ميزان بسكول', 1, 1, 1, '2023-05-14 13:00:42', NULL, '2023-05-14 13:00:42', 1, '2023-05-14'),
(2, 'رياشة', 1, 2, 1, '2023-05-14 13:00:59', NULL, '2023-05-14 13:00:59', 1, '2023-05-14');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `services_with_orders`
--

INSERT INTO `services_with_orders` (`id`, `order_type`, `auto_serial`, `order_date`, `is_approved`, `com_code`, `notes`, `total_services`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `tax_value`, `total_befor_discount`, `total_cost`, `is_account_number`, `entity_name`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`) VALUES
(1, 1, 1, '2023-05-14', 1, 1, NULL, '1000.00', NULL, '0.00', '0.00', '0.00', '0.00', '1000.00', '1000.00', 1, NULL, 13, '-1000.00', 2, '0.00', '1000.00', NULL, 1, '2023-05-14 13:01:17', '2023-05-14 13:01:30', 1, 1),
(2, 2, 1, '2023-05-14', 1, 1, NULL, '1500.00', NULL, '0.00', '0.00', '0.00', '0.00', '1500.00', '1500.00', 1, NULL, 10, '1500.00', 2, '0.00', '1500.00', NULL, 1, '2023-05-14 13:01:43', '2023-05-14 13:01:57', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services_with_orders_details`
--

CREATE TABLE `services_with_orders_details` (
  `id` bigint(20) NOT NULL,
  `services_with_orders_id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services_with_orders_details`
--

INSERT INTO `services_with_orders_details` (`id`, `services_with_orders_id`, `services_with_orders_auto_serial`, `order_type`, `service_id`, `notes`, `total`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`, `date`) VALUES
(1, 1, 1, 1, 1, NULL, '1000.00', 1, NULL, '2023-05-14 13:01:26', '2023-05-14 13:01:26', 1, '2023-05-14'),
(2, 2, 1, 2, 2, NULL, '1500.00', 1, NULL, '2023-05-14 13:01:54', '2023-05-14 13:01:54', 1, '2023-05-14');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `phones`, `address`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الرئيسي', '0152565552', 'ش 16 نصر الدين الجيزة', '2023-05-14 11:37:44', '2023-05-14 11:37:57', 1, 1, 1, '2023-05-14', 1),
(2, 'الفرعي بشارع الشهيد', '056556', 'بشارع الشهيد 25 ابراج النصر بالجيزة', '2023-05-14 11:43:03', '2023-05-14 11:43:03', 1, NULL, 1, '2023-05-14', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `suppliers_categories`
--

INSERT INTO `suppliers_categories` (`id`, `name`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'لحوم ومجمدات', '2023-05-14 11:36:12', '2023-05-14 11:36:12', 1, NULL, 1, '2023-05-14', 1),
(2, 'بقوليات', '2023-05-14 11:36:22', '2023-05-14 11:36:22', 1, NULL, 1, '2023-05-14', 1),
(3, 'خردوات', '2023-05-14 11:36:28', '2023-05-14 11:36:28', 1, NULL, 1, '2023-05-14', 1),
(4, 'خامات خط انتاج', '2023-05-14 11:36:38', '2023-05-14 11:36:38', 1, NULL, 1, '2023-05-14', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول مشتريات ومترجعات المودين ';

--
-- Dumping data for table `suppliers_with_orders`
--

INSERT INTO `suppliers_with_orders` (`id`, `order_type`, `auto_serial`, `DOC_NO`, `order_date`, `suuplier_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `Supplier_balance_befor`, `Supplier_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `store_id`, `approved_by`) VALUES
(1, 1, 1, '1', '2023-05-14', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '12000.00', '0.00', '12000.00', '12000.00', 13, '-12000.00', 2, '0.00', '12000.00', NULL, NULL, NULL, 1, '2023-05-14 11:41:19', '2023-05-14 11:41:42', 1, 1, 1),
(2, 3, 1, NULL, '2023-05-14', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '3600.00', '0.00', '3600.00', '3600.00', 13, '3600.00', 2, '0.00', '3600.00', NULL, NULL, NULL, 1, '2023-05-14 11:41:56', '2023-05-14 11:42:17', 1, 1, 1),
(3, 1, 2, '2', '2023-05-14', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000000.00', '0.00', '1000000.00', '1000000.00', 15, '-1000000.00', 2, '0.00', '1000000.00', NULL, NULL, NULL, 1, '2023-05-14 11:48:55', '2023-05-14 11:49:20', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers_with_orders_details`
--

CREATE TABLE `suppliers_with_orders_details` (
  `id` bigint(20) NOT NULL,
  `suppliers_with_order_id` bigint(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `suppliers_with_orders_details`
--

INSERT INTO `suppliers_with_orders_details` (`id`, `suppliers_with_order_id`, `suppliers_with_orders_auto_serial`, `order_type`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_auto_serial`, `production_date`, `expire_date`, `item_card_type`) VALUES
(1, 1, 1, 1, 1, '10.00', 1, 1, '1200.00', '12000.00', '2023-05-14', 1, '2023-05-14 11:41:37', NULL, '2023-05-14 11:41:37', 1, NULL, '2023-03-01', '2023-08-24', 2),
(2, 2, 1, 3, 1, '3.00', 1, 1, '1200.00', '3600.00', '2023-05-14', 1, '2023-05-14 11:42:09', NULL, '2023-05-14 11:42:09', 1, 1, '2023-03-01', '2023-08-24', 2),
(3, 3, 2, 1, 1, '100.00', 3, 1, '10000.00', '1000000.00', '2023-05-14', 1, '2023-05-14 11:49:16', NULL, '2023-05-14 11:49:16', 2, NULL, '2023-04-01', '2023-05-14', 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `suupliers`
--

INSERT INTO `suupliers` (`id`, `suuplier_code`, `suppliers_categories_id`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `address`, `phones`) VALUES
(1, 1, 1, 'عاطف دياب محمد', 13, 1, '-5000.00', '-14400.00', NULL, 1, NULL, '2023-05-14 11:36:54', '2023-05-14 13:01:30', 1, 1, '2023-05-14', NULL, NULL),
(2, 2, 1, 'مذبح المصنع', 15, 3, '0.00', '-1000000.00', NULL, 1, NULL, '2023-05-14 11:48:39', '2023-05-14 13:07:58', 1, 1, '2023-05-14', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `name`, `is_master`, `last_isal_exhcange`, `last_isal_collect`, `created_at`, `updated_at`, `added_by`, `updated_by`, `com_code`, `date`, `active`) VALUES
(1, 'الرئيسية', 1, 0, 1, '2023-05-14 13:02:14', '2023-05-14 13:05:14', 1, NULL, 1, '2023-05-14', 1),
(2, 'كاشير1', 0, 0, 0, '2023-05-14 13:02:30', '2023-05-14 13:02:30', 1, NULL, 1, '2023-05-14', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `treasuries_delivery`
--

INSERT INTO `treasuries_delivery` (`id`, `treasuries_id`, `treasuries_can_delivery_id`, `created_at`, `added_by`, `updated_by`, `updated_at`, `com_code`) VALUES
(1, 2, 2, '2023-05-14 13:02:37', 1, NULL, '2023-05-14 13:02:37', 1),
(2, 2, 1, '2023-05-14 13:02:41', 1, NULL, '2023-05-14 13:02:41', 1),
(3, 1, 2, '2023-05-14 13:02:51', 1, NULL, '2023-05-14 13:02:51', 1),
(4, 1, 1, '2023-05-14 13:06:06', 1, NULL, '2023-05-14 13:06:06', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='جدول حركة النقدية بالشفتات';

--
-- Dumping data for table `treasuries_transactions`
--

INSERT INTO `treasuries_transactions` (`id`, `auto_serial`, `isal_number`, `shift_code`, `money`, `treasuries_id`, `is_approved`, `mov_type`, `move_date`, `the_foregin_key`, `account_number`, `is_account`, `money_for_account`, `byan`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`) VALUES
(1, 1, 1, 2, '10000.00', 1, 1, 25, '2023-05-14', NULL, 4, 1, '-10000.00', 'تحصيل نظير  نظير مرتبات', '2023-05-14 13:05:14', 1, '2023-05-14 13:05:14', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
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
-- Indexes for table `admins_stores`
--
ALTER TABLE `admins_stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `admins_treasuries`
--
ALTER TABLE `admins_treasuries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `treasuries_id` (`treasuries_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_production_exchange_id` (`inv_production_exchange_id`);

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
-- Indexes for table `inv_production_receive`
--
ALTER TABLE `inv_production_receive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_production_receive_details`
--
ALTER TABLE `inv_production_receive_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_production_receive_id` (`inv_production_receive_id`),
  ADD KEY `inv_production_receive_auto_serial` (`inv_production_receive_auto_serial`);

--
-- Indexes for table `inv_stores_inventory`
--
ALTER TABLE `inv_stores_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto_serial` (`auto_serial`);

--
-- Indexes for table `inv_stores_inventory_details`
--
ALTER TABLE `inv_stores_inventory_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_auto_serial` (`batch_auto_serial`),
  ADD KEY `inv_stores_inventory_auto_serial` (`inv_stores_inventory_auto_serial`),
  ADD KEY `inv_stores_inventory_id` (`inv_stores_inventory_id`);

--
-- Indexes for table `inv_stores_transfer`
--
ALTER TABLE `inv_stores_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inv_stores_transfer_details`
--
ALTER TABLE `inv_stores_transfer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_stores_transfer_id` (`inv_stores_transfer_id`);

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
-- Indexes for table `permission_main_menues`
--
ALTER TABLE `permission_main_menues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_roles_main_menus`
--
ALTER TABLE `permission_roles_main_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_roles_id` (`permission_roles_id`),
  ADD KEY `permission_main_menues_id` (`permission_main_menues_id`);

--
-- Indexes for table `permission_roles_sub_menu`
--
ALTER TABLE `permission_roles_sub_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_roles_main_menus_id` (`permission_roles_main_menus_id`);

--
-- Indexes for table `permission_roles_sub_menues_actions`
--
ALTER TABLE `permission_roles_sub_menues_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_roles_sub_menu_id` (`permission_roles_sub_menu_id`),
  ADD KEY `permission_sub_menues_actions_id` (`permission_sub_menues_actions_id`);

--
-- Indexes for table `permission_sub_menues`
--
ALTER TABLE `permission_sub_menues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_main_menues_id` (`permission_main_menues_id`);

--
-- Indexes for table `permission_sub_menues_actions`
--
ALTER TABLE `permission_sub_menues_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_main_menues_id` (`permission_sub_menues_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto_serial` (`auto_serial`);

--
-- Indexes for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoices_auto_serial` (`sales_invoices_auto_serial`),
  ADD KEY `sales_invoices_id` (`sales_invoices_id`);

--
-- Indexes for table `sales_invoices_return`
--
ALTER TABLE `sales_invoices_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoices_return_details`
--
ALTER TABLE `sales_invoices_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoices_auto_serial` (`sales_invoices_auto_serial`),
  ADD KEY `sales_invoices_return_id` (`sales_invoices_return_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_with_orders_id` (`services_with_orders_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_with_order_id` (`suppliers_with_order_id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `account_types`
--
ALTER TABLE `account_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins_shifts`
--
ALTER TABLE `admins_shifts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admins_stores`
--
ALTER TABLE `admins_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admins_treasuries`
--
ALTER TABLE `admins_treasuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_panel_settings`
--
ALTER TABLE `admin_panel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delegates`
--
ALTER TABLE `delegates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_itemcard`
--
ALTER TABLE `inv_itemcard`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_itemcard_batches`
--
ALTER TABLE `inv_itemcard_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inv_itemcard_categories`
--
ALTER TABLE `inv_itemcard_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements`
--
ALTER TABLE `inv_itemcard_movements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_categories`
--
ALTER TABLE `inv_itemcard_movements_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_types`
--
ALTER TABLE `inv_itemcard_movements_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_production_exchange`
--
ALTER TABLE `inv_production_exchange`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_production_exchange_details`
--
ALTER TABLE `inv_production_exchange_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inv_production_lines`
--
ALTER TABLE `inv_production_lines`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_production_order`
--
ALTER TABLE `inv_production_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_production_receive`
--
ALTER TABLE `inv_production_receive`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_production_receive_details`
--
ALTER TABLE `inv_production_receive_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_stores_inventory`
--
ALTER TABLE `inv_stores_inventory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_stores_inventory_details`
--
ALTER TABLE `inv_stores_inventory_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_stores_transfer`
--
ALTER TABLE `inv_stores_transfer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_stores_transfer_details`
--
ALTER TABLE `inv_stores_transfer_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `permission_main_menues`
--
ALTER TABLE `permission_main_menues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permission_roles`
--
ALTER TABLE `permission_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permission_roles_main_menus`
--
ALTER TABLE `permission_roles_main_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permission_roles_sub_menu`
--
ALTER TABLE `permission_roles_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission_roles_sub_menues_actions`
--
ALTER TABLE `permission_roles_sub_menues_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_sub_menues`
--
ALTER TABLE `permission_sub_menues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permission_sub_menues_actions`
--
ALTER TABLE `permission_sub_menues_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_invoices_return`
--
ALTER TABLE `sales_invoices_return`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_invoices_return_details`
--
ALTER TABLE `sales_invoices_return_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services_with_orders`
--
ALTER TABLE `services_with_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services_with_orders_details`
--
ALTER TABLE `services_with_orders_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers_categories`
--
ALTER TABLE `suppliers_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers_with_orders`
--
ALTER TABLE `suppliers_with_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers_with_orders_details`
--
ALTER TABLE `suppliers_with_orders_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suupliers`
--
ALTER TABLE `suupliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treasuries_delivery`
--
ALTER TABLE `treasuries_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins_stores`
--
ALTER TABLE `admins_stores`
  ADD CONSTRAINT `admins_stores_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admins_stores_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admins_treasuries`
--
ALTER TABLE `admins_treasuries`
  ADD CONSTRAINT `admins_treasuries_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admins_treasuries_ibfk_2` FOREIGN KEY (`treasuries_id`) REFERENCES `treasuries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inv_production_exchange_details`
--
ALTER TABLE `inv_production_exchange_details`
  ADD CONSTRAINT `inv_production_exchange_details_ibfk_1` FOREIGN KEY (`inv_production_exchange_id`) REFERENCES `inv_production_exchange` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inv_production_receive_details`
--
ALTER TABLE `inv_production_receive_details`
  ADD CONSTRAINT `inv_production_receive_details_ibfk_1` FOREIGN KEY (`inv_production_receive_id`) REFERENCES `inv_production_receive` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inv_stores_inventory_details`
--
ALTER TABLE `inv_stores_inventory_details`
  ADD CONSTRAINT `inv_stores_inventory_details_ibfk_1` FOREIGN KEY (`inv_stores_inventory_id`) REFERENCES `inv_stores_inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inv_stores_transfer_details`
--
ALTER TABLE `inv_stores_transfer_details`
  ADD CONSTRAINT `inv_stores_transfer_details_ibfk_1` FOREIGN KEY (`inv_stores_transfer_id`) REFERENCES `inv_stores_transfer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_roles_main_menus`
--
ALTER TABLE `permission_roles_main_menus`
  ADD CONSTRAINT `permission_roles_main_menus_ibfk_1` FOREIGN KEY (`permission_roles_id`) REFERENCES `permission_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_roles_main_menus_ibfk_2` FOREIGN KEY (`permission_main_menues_id`) REFERENCES `permission_main_menues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_roles_sub_menu`
--
ALTER TABLE `permission_roles_sub_menu`
  ADD CONSTRAINT `permission_roles_sub_menu_ibfk_1` FOREIGN KEY (`permission_roles_main_menus_id`) REFERENCES `permission_roles_main_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_roles_sub_menues_actions`
--
ALTER TABLE `permission_roles_sub_menues_actions`
  ADD CONSTRAINT `permission_roles_sub_menues_actions_ibfk_1` FOREIGN KEY (`permission_roles_sub_menu_id`) REFERENCES `permission_roles_sub_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_roles_sub_menues_actions_ibfk_2` FOREIGN KEY (`permission_sub_menues_actions_id`) REFERENCES `permission_sub_menues_actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_sub_menues`
--
ALTER TABLE `permission_sub_menues`
  ADD CONSTRAINT `permission_sub_menues_ibfk_1` FOREIGN KEY (`permission_main_menues_id`) REFERENCES `permission_main_menues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_sub_menues_actions`
--
ALTER TABLE `permission_sub_menues_actions`
  ADD CONSTRAINT `permission_sub_menues_actions_ibfk_1` FOREIGN KEY (`permission_sub_menues_id`) REFERENCES `permission_sub_menues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  ADD CONSTRAINT `sales_invoices_details_ibfk_1` FOREIGN KEY (`sales_invoices_id`) REFERENCES `sales_invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_invoices_return_details`
--
ALTER TABLE `sales_invoices_return_details`
  ADD CONSTRAINT `sales_invoices_return_details_ibfk_1` FOREIGN KEY (`sales_invoices_return_id`) REFERENCES `sales_invoices_return` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services_with_orders_details`
--
ALTER TABLE `services_with_orders_details`
  ADD CONSTRAINT `services_with_orders_details_ibfk_1` FOREIGN KEY (`services_with_orders_id`) REFERENCES `services_with_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suppliers_with_orders_details`
--
ALTER TABLE `suppliers_with_orders_details`
  ADD CONSTRAINT `suppliers_with_orders_details_ibfk_1` FOREIGN KEY (`suppliers_with_order_id`) REFERENCES `suppliers_with_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
