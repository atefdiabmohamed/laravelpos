-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2022 at 08:45 PM
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
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `com_code` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `account_type`, `is_parent`, `parent_account_number`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `other_table_FK`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `is_archived`, `com_code`, `date`) VALUES
(1, 'الموردين الاب', 9, 1, NULL, 1, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:43:44', '2022-09-22 22:43:44', 0, 1, '2022-09-22'),
(2, 'البنوك الاب', 9, 1, NULL, 2, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:43:59', '2022-09-22 22:43:59', 0, 1, '2022-09-22'),
(3, 'العملاء الاب', 9, 1, NULL, 3, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 22:44:13', '2022-09-22 22:44:13', 0, 1, '2022-09-22'),
(4, 'عاطف دياب محمد', 2, 0, 1, 4, 1, '-5000.00', '-2110.00', 1, NULL, 1, 1, '2022-09-22 22:45:06', '2022-09-23 22:57:52', 0, 1, '2022-09-22'),
(5, 'بنك فيصل الاسلامي', 6, 0, 2, 5, 3, '0.00', '0.00', NULL, NULL, 1, NULL, '2022-09-22 23:00:51', '2022-09-22 23:00:51', 0, 1, '2022-09-22'),
(6, 'محمود محمد', 2, 0, 1, 6, 3, '0.00', '-18900.00', 2, NULL, 1, 1, '2022-09-22 23:29:29', '2022-09-30 09:14:22', 0, 1, '2022-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `relatediternalaccounts` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `active`, `relatediternalaccounts`) VALUES
(1, 'رأس المال', 1, 0),
(2, 'مورد', 1, 1),
(3, 'عميل', 1, 1),
(4, 'مندوب', 1, 1),
(5, 'موظف', 1, 1),
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
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_panel_settings`
--

INSERT INTO `admin_panel_settings` (`id`, `system_name`, `photo`, `active`, `general_alert`, `address`, `phone`, `customer_parent_account_number`, `suppliers_parent_account_number`, `added_by`, `updated_by`, `created_at`, `updated_at`, `com_code`) VALUES
(1, 'حلول للكمبوتير بسوهاج', '1662736241571.jpg', 1, NULL, 'سوهاج - كوبري النيل', '012659854', 3, 1, 0, 1, '0000-00-00 00:00:00', '2022-09-22 22:44:28', 1);

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
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `city_id`, `address`) VALUES
(6, 1, 'سوبر ماركت السلامة', 5, 3, '0.00', '0.00', NULL, 1, 1, '2022-09-10 14:29:09', '2022-09-10 15:24:25', 1, 1, '2022-09-10', NULL, NULL),
(7, 2, 'هايبر الرحاب', 6, 3, '0.00', '0.00', NULL, 1, 1, '2022-09-10 14:41:48', '2022-09-10 15:24:22', 1, 1, '2022-09-10', NULL, NULL);

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
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `percent_type` tinyint(4) NOT NULL COMMENT 'نوع عمولة المندوب  بشكل عام\r\nواحد اجر ثابت لكل فاتورة - لو اتنين  نسبة بكل فاتورة	',
  `percent_collect_commission` decimal(10,2) NOT NULL COMMENT 'نسبة المندوب بالتحصيل  الفواتير الاجل او الكاش',
  `percent_salaes_commission_kataei` decimal(10,2) NOT NULL COMMENT 'نسبة عمولة المندوب بالمبيعات قطاعلي	',
  `percent_salaes_commission_nosjomla` decimal(10,2) NOT NULL COMMENT 'عمول المندوب بمبيعات نص الجملة	',
  `percent_salaes_commission_jomla` decimal(10,2) NOT NULL COMMENT 'نسبة عمولة المندوب بالمبيعات بالجملة	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول المناديب';

--
-- Dumping data for table `delegates`
--

INSERT INTO `delegates` (`id`, `delegate_code`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `city_id`, `address`, `percent_type`, `percent_collect_commission`, `percent_salaes_commission_kataei`, `percent_salaes_commission_nosjomla`, `percent_salaes_commission_jomla`) VALUES
(1, 1, 'عاطف دياب محمد ', 6, 0, '0.00', '0.00', NULL, 1, 1, '2022-09-29 00:29:26', '2022-09-29 00:29:26', 1, 1, '2022-09-29', NULL, NULL, 0, '0.00', '0.00', '0.00', '0.00');

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
(1, 1, 'item1', 'فراخ شهد ', 2, 1, 0, 1, 4, 1, '10.00', 1, '2022-09-02 22:37:08', '2022-09-26 03:34:09', 1, 1, '2022-09-02', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '900.00', '90.00', 0, '6.00', '6.000', '0.000', '60.000', ''),
(2, 2, 'item2', 'وراك شهد', 2, 1, 1, 1, 4, 1, '10.00', 1, '2022-09-02 22:37:08', '0000-00-00 00:00:00', 1, 1, '2022-09-02', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, NULL, '0.000', '0.000', '0.000', ''),
(3, 3, 'item3', 'فراخ المشهدي', 1, 1, 0, 0, NULL, 1, NULL, 1, '2022-09-05 15:19:07', '2022-09-05 15:19:07', NULL, 1, '2022-09-05', 1, '1000.00', '900.00', '850.00', NULL, NULL, NULL, '800.00', NULL, 1, NULL, NULL, NULL, NULL, '1662383947305.jpg'),
(4, 4, '6345134315', 'كوباية عصير', 1, 1, 0, 1, 6, 5, '10.00', 1, '2022-09-05 15:22:12', '2022-09-30 13:51:31', 1, 1, '2022-09-05', 1, '1000.00', '950.00', '900.00', '70.00', '65.00', '60.00', '100.00', '10.00', 1, '30.00', '30.000', '0.000', '300.000', '1662473487571.jpg');

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
(1, 1, 4, 5, '100.00', '0.00', '0.00', NULL, NULL, 1, 11, 1, '2022-09-30 09:14:22', '2022-09-30 13:51:31', 1, 0),
(2, 1, 1, 1, '1000.00', '1.00', '1000.00', '2022-08-01', '2022-09-26', 1, 12, 1, '2022-09-26 03:34:09', '2022-09-26 03:34:09', NULL, 0),
(3, 1, 1, 1, '900.00', '5.00', '4500.00', '2022-07-01', '2022-09-26', 1, 12, 1, '2022-09-26 03:34:09', '2022-09-26 03:34:09', NULL, 0),
(4, 1, 4, 5, '1000.00', '20.00', '20000.00', NULL, NULL, 1, 13, 1, '2022-09-30 09:12:57', '2022-09-30 09:12:57', NULL, 0),
(5, 3, 4, 5, '100.00', '10.00', '1000.00', NULL, NULL, 1, 13, 1, '2022-09-30 09:13:39', '2022-09-30 09:13:39', NULL, 0);

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
(4, 'مخللات', '2022-09-02 01:21:06', '2022-09-02 01:21:06', 1, NULL, 1, '2022-09-02', 1);

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
(1, 1, 4, 0, 1, 1, 1, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 1', 'عدد  100 كرتونة كوبيات', 'عدد  110 كرتونة كوبيات', 1, '2022-09-22', '2022-09-22 23:02:31', 1, '', ''),
(2, 1, 4, 0, 1, 2, 2, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 2', 'عدد  110 كرتونة كوبيات', 'عدد  120 كرتونة كوبيات', 1, '2022-09-22', '2022-09-22 23:07:27', 1, '', ''),
(3, 1, 4, 0, 1, 3, 3, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 3', 'عدد  120 كرتونة كوبيات', 'عدد  130 كرتونة كوبيات', 1, '2022-09-22', '2022-09-22 23:28:16', 1, '', ''),
(4, 1, 4, 0, 1, 4, 4, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 4', 'عدد  130 كرتونة كوبيات', 'عدد  140 كرتونة كوبيات', 1, '2022-09-22', '2022-09-22 23:30:06', 1, '', ''),
(5, 1, 4, 0, 1, 5, 5, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 5', 'عدد  140 كرتونة كوبيات', 'عدد  150 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 21:51:36', 1, '', ''),
(6, 1, 4, 0, 1, 6, 6, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 6', 'عدد  150 كرتونة كوبيات', 'عدد  160 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 21:52:57', 1, '', ''),
(7, 1, 4, 0, 1, 1, 1, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 1', 'عدد  160 كرتونة كوبيات', 'عدد  170 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:14:43', 1, '', ''),
(8, 1, 4, 0, 1, 1, 2, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 1', 'عدد  0 كرتونة كوبيات', 'عدد  10 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:16:35', 1, '', ''),
(9, 1, 4, 0, 1, 2, 3, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 2', 'عدد  10 كرتونة كوبيات', 'عدد  11 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:18:36', 1, '', ''),
(10, 1, 4, 0, 1, 2, 4, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 2', 'عدد  11 كرتونة كوبيات', 'عدد  12.1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:18:37', 1, '', ''),
(11, 1, 4, 0, 1, 2, 3, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 2', 'عدد  0 كرتونة كوبيات', 'عدد  1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:22:20', 1, '', ''),
(12, 1, 4, 0, 1, 2, 4, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 2', 'عدد  1 كرتونة كوبيات', 'عدد  2.1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:22:20', 1, '', ''),
(13, 1, 4, 0, 1, 1, 1, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 1', 'عدد  0 كرتونة كوبيات', 'عدد  1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:23:32', 1, '', ''),
(14, 1, 4, 0, 1, 1, 2, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 1', 'عدد  1 كرتونة كوبيات', 'عدد  1.1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:23:32', 1, '', ''),
(15, 1, 4, 0, 1, 2, 3, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 2', 'عدد  1.1 كرتونة كوبيات', 'عدد  2.2 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:26:04', 1, '', ''),
(16, 1, 4, 0, 1, 3, 4, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 3', 'عدد  2.2 كرتونة كوبيات', 'عدد  3.2 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:30:27', 1, '', ''),
(17, 1, 4, 0, 1, 4, 5, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 4', 'عدد  3.2 كرتونة كوبيات', 'عدد  4 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:42:46', 1, '', ''),
(18, 1, 4, 0, 1, 5, 6, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 5', 'عدد  4 كرتونة كوبيات', 'عدد  4.1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:44:04', 1, '', ''),
(19, 1, 4, 3, 1, 8, 9, 'نظير مشتريات من المورد  عاطف دياب محمد فاتورة رقم 8', 'عدد  24.1 كرتونة كوبيات', 'عدد  34.1 كرتونة كوبيات', 1, '2022-09-23', '2022-09-23 22:57:52', 1, 'عدد  21.2 كرتونة كوبيات', 'عدد  31.2 كرتونة كوبيات'),
(20, 1, 4, 1, 1, 10, 10, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 10', 'عدد  0 كرتونة كوبيات', 'عدد  10 كرتونة كوبيات', 1, '2022-09-26', '2022-09-26 03:15:47', 1, 'عدد  0 كرتونة كوبيات', 'عدد  10 كرتونة كوبيات'),
(21, 1, 1, 1, 1, 11, 11, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 11', 'عدد  0 شكارة', 'عدد  1 شكارة', 1, '2022-09-26', '2022-09-26 03:34:09', 1, 'عدد  0 شكارة', 'عدد  1 شكارة'),
(22, 1, 1, 1, 1, 11, 12, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 11', 'عدد  1 شكارة', 'عدد  6 شكارة', 1, '2022-09-26', '2022-09-26 03:34:09', 1, 'عدد  1 شكارة', 'عدد  6 شكارة'),
(23, 1, 4, 1, 1, 12, 13, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 12', 'عدد  10 كرتونة كوبيات', 'عدد  30 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 09:12:57', 1, 'عدد  10 كرتونة كوبيات', 'عدد  30 كرتونة كوبيات'),
(24, 1, 4, 3, 1, 9, 14, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 9', 'عدد  30 كرتونة كوبيات', 'عدد  40 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 09:13:39', 1, 'عدد  0 كرتونة كوبيات', 'عدد  10 كرتونة كوبيات'),
(25, 1, 4, 1, 1, 13, 15, 'نظير مشتريات من المورد  محمود محمد فاتورة رقم 13', 'عدد  40 كرتونة كوبيات', 'عدد  50 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 09:14:22', 1, 'عدد  30 كرتونة كوبيات', 'عدد  40 كرتونة كوبيات'),
(26, 2, 4, 1, 4, 1, 21, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  38 كرتونة كوبيات', 'عدد  37 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:42:10', 1, 'عدد  28 كرتونة كوبيات', 'عدد  27 كرتونة كوبيات'),
(27, 2, 4, 1, 4, 1, 22, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  37 كرتونة كوبيات', 'عدد  36 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:42:51', 1, 'عدد  27 كرتونة كوبيات', 'عدد  26 كرتونة كوبيات'),
(28, 2, 4, 1, 4, 1, 23, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  36 كرتونة كوبيات', 'عدد  35 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:44:16', 1, 'عدد  26 كرتونة كوبيات', 'عدد  25 كرتونة كوبيات'),
(29, 2, 4, 1, 4, 1, 24, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  35 كرتونة كوبيات', 'عدد  34 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:45:05', 1, 'عدد  25 كرتونة كوبيات', 'عدد  24 كرتونة كوبيات'),
(30, 2, 4, 1, 4, 1, 25, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  34 كرتونة كوبيات', 'عدد  33 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:45:32', 1, 'عدد  24 كرتونة كوبيات', 'عدد  23 كرتونة كوبيات'),
(31, 2, 4, 1, 4, 1, 26, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  33 كرتونة كوبيات', 'عدد  32 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:48:42', 1, 'عدد  23 كرتونة كوبيات', 'عدد  22 كرتونة كوبيات'),
(32, 2, 4, 1, 4, 1, 27, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  32 كرتونة كوبيات', 'عدد  31 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:50:50', 1, 'عدد  22 كرتونة كوبيات', 'عدد  21 كرتونة كوبيات'),
(33, 2, 4, 1, 4, 1, 28, 'نظير مبيعات  للعميل  هايبر الرحاب فاتورة رقم 1', 'عدد  31 كرتونة كوبيات', 'عدد  30 كرتونة كوبيات', 1, '2022-09-30', '2022-09-30 13:51:31', 1, 'عدد  21 كرتونة كوبيات', 'عدد  20 كرتونة كوبيات');

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
(5, 'مرتجع مبيعات'),
(6, 'صرف داخلي لمندوب'),
(7, 'مرتجع صرف داخلي لمندوب'),
(8, 'تحويل بين مخازن'),
(9, 'مبيعات صرف مباشر لعميل'),
(10, 'مبيعات صرف لمندوب التوصيل'),
(11, 'صرف خامات لخط التصنيع'),
(12, 'رد خامات من خط التصنيع'),
(13, 'استلام انتاج تام من خط التصنيع'),
(14, 'رد انتاج تام الي خط التصنيع');

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
(5, 'كرتونة كوبيات', 1, '2022-09-21 22:22:14', '2022-09-21 22:22:14', 1, NULL, 1, '2022-09-21', 1),
(6, 'علبة', 0, '2022-09-21 22:22:25', '2022-09-21 22:22:25', 1, NULL, 1, '2022-09-21', 1);

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
(26, 'صرف لرد رأس المال', 1, 1, 0);

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
  `sales_matrial_types` int(11) NOT NULL COMMENT 'فئة الفاتورة',
  `auto_serial` bigint(20) NOT NULL,
  `invoice_date` date NOT NULL COMMENT 'تاريخ الفاتورة',
  `is_has_customer` tinyint(1) NOT NULL COMMENT 'هل الفاتورة مرتبطه بعميل - واحد يبقي نعم - لو صفر يبقي عميل طياري بدون عميل',
  `customer_code` bigint(20) DEFAULT NULL COMMENT 'كود العميل',
  `delegate_code` bigint(20) NOT NULL COMMENT 'كود المندوب',
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
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='المبيعات للعملاء';

--
-- Dumping data for table `sales_invoices`
--

INSERT INTO `sales_invoices` (`id`, `sales_matrial_types`, `auto_serial`, `invoice_date`, `is_has_customer`, `customer_code`, `delegate_code`, `is_approved`, `com_code`, `notes`, `discount_type`, `discount_percent`, `discount_value`, `tax_percent`, `total_cost_items`, `tax_value`, `total_befor_discount`, `total_cost`, `account_number`, `money_for_account`, `pill_type`, `what_paid`, `what_remain`, `treasuries_transactions_id`, `customer_balance_befor`, `customer_balance_after`, `added_by`, `created_at`, `updated_at`, `updated_by`, `approved_by`, `date`) VALUES
(3, 3, 1, '2022-09-30', 1, 2, 1, 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-09-30 08:56:21', '2022-09-30 08:56:21', NULL, NULL, '2022-09-30 00:00:00'),
(4, 3, 2, '2022-09-30', 1, 2, 1, 0, 1, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, 1, '2022-09-30 10:06:12', '2022-09-30 10:06:12', NULL, NULL, '2022-09-30 00:00:00');

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
(6, 2, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:30:45', NULL, '2022-09-30 13:30:45', NULL, NULL, '2022-09-30'),
(7, 2, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:32:46', NULL, '2022-09-30 13:32:46', NULL, NULL, '2022-09-30'),
(8, 2, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:32:59', NULL, '2022-09-30 13:32:59', NULL, NULL, '2022-09-30'),
(9, 2, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:33:30', NULL, '2022-09-30 13:33:30', NULL, NULL, '2022-09-30'),
(10, 2, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:33:49', NULL, '2022-09-30 13:33:49', NULL, NULL, '2022-09-30'),
(11, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:36:15', NULL, '2022-09-30 13:36:15', NULL, NULL, '2022-09-30'),
(12, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:39:05', NULL, '2022-09-30 13:39:05', NULL, NULL, '2022-09-30'),
(13, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:39:22', NULL, '2022-09-30 13:39:22', NULL, NULL, '2022-09-30'),
(14, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:40:08', NULL, '2022-09-30 13:40:08', NULL, NULL, '2022-09-30'),
(15, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:40:20', NULL, '2022-09-30 13:40:20', NULL, NULL, '2022-09-30'),
(16, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:40:33', NULL, '2022-09-30 13:40:33', NULL, NULL, '2022-09-30'),
(17, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:40:48', NULL, '2022-09-30 13:40:48', NULL, NULL, '2022-09-30'),
(18, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:40:57', NULL, '2022-09-30 13:40:57', NULL, NULL, '2022-09-30'),
(19, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:41:08', NULL, '2022-09-30 13:41:08', NULL, NULL, '2022-09-30'),
(20, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:41:19', NULL, '2022-09-30 13:41:19', NULL, NULL, '2022-09-30'),
(21, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:42:09', NULL, '2022-09-30 13:42:09', NULL, NULL, '2022-09-30'),
(22, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:42:50', NULL, '2022-09-30 13:42:50', NULL, NULL, '2022-09-30'),
(23, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:44:16', NULL, '2022-09-30 13:44:16', NULL, NULL, '2022-09-30'),
(24, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:45:05', NULL, '2022-09-30 13:45:05', NULL, NULL, '2022-09-30'),
(25, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:45:32', NULL, '2022-09-30 13:45:32', NULL, NULL, '2022-09-30'),
(26, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:48:42', NULL, '2022-09-30 13:48:42', NULL, NULL, '2022-09-30'),
(27, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:50:50', NULL, '2022-09-30 13:50:50', NULL, NULL, '2022-09-30'),
(28, 1, 1, 1, 4, 5, 11, '1.0000', '1000.00', '1000.00', 1, 1, 1, '2022-09-30', 1, '2022-09-30 13:51:31', NULL, '2022-09-30 13:51:31', NULL, NULL, '2022-09-30');

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
(3, 'فراخ', '2022-09-01 01:22:25', '2022-09-01 01:22:25', 1, NULL, 1, '2022-09-01', 1);

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
(3, 'اللحوم', '6958525', 'شارع 15', '2022-09-01 01:37:04', '2022-09-01 01:37:04', 1, NULL, 1, '2022-09-01', 1),
(4, 'الاتشر', '6151', 'شارع النصر', '2022-09-02 21:31:47', '2022-09-02 21:31:47', 1, NULL, 1, '2022-09-02', 1);

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
(1, 'لحوم', '2022-09-12 00:25:02', '2022-09-12 00:27:55', 1, 1, 1, '2022-09-12', 1),
(2, 'فراخ', '2022-09-12 00:28:07', '2022-09-12 00:28:07', 1, NULL, 1, '2022-09-12', 1),
(4, 'خضروات', '2022-09-12 00:28:47', '2022-09-12 00:28:47', 1, NULL, 1, '2022-09-12', 1);

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
(1, 1, 1, '1', '2022-09-23', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '110.00', '0.00', '110.00', '110.00', 6, '-110.00', 2, '0.00', '110.00', NULL, NULL, NULL, 1, '2022-09-23 22:23:09', '2022-09-23 22:23:31', 1, 3, 1),
(2, 1, 2, '2', '2022-09-23', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '110.00', '0.00', '110.00', '110.00', 6, '-110.00', 2, '0.00', '110.00', NULL, NULL, NULL, 1, '2022-09-23 22:25:02', '2022-09-23 22:26:04', 1, 4, 1),
(3, 1, 3, '3', '2022-09-23', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '100.00', '0.00', '100.00', '100.00', 4, '-100.00', 2, '0.00', '100.00', NULL, NULL, NULL, 1, '2022-09-23 22:30:13', '2022-09-23 22:30:27', 1, 1, 1),
(4, 1, 4, '5', '2022-09-23', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '80.00', '0.00', '80.00', '80.00', 6, '-80.00', 2, '0.00', '80.00', NULL, NULL, NULL, 1, '2022-09-23 22:42:33', '2022-09-23 22:42:46', 1, 4, 1),
(5, 1, 5, '7', '2022-09-23', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '10.00', '0.00', '10.00', '10.00', 4, '-10.00', 2, '0.00', '10.00', NULL, NULL, NULL, 1, '2022-09-23 22:43:51', '2022-09-23 22:44:04', 1, 3, 1),
(6, 1, 6, '1', '2022-09-23', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '100.00', '0.00', '100.00', '100.00', 6, '-100.00', 2, '0.00', '100.00', NULL, NULL, NULL, 1, '2022-09-23 22:55:47', '2022-09-23 22:56:01', 1, 3, 1),
(7, 1, 7, '10', '2022-09-23', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 4, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-09-23 22:56:46', '2022-09-23 22:56:58', 1, 3, 1),
(8, 1, 8, '12', '2022-09-23', 1, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 4, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-09-23 22:57:40', '2022-09-23 22:57:52', 1, 3, 1),
(10, 1, 9, '2', '2022-09-24', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 6, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-09-24 17:29:33', '2022-09-30 09:13:39', 1, 3, 1),
(11, 1, 10, '88', '2022-09-26', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 6, '-1000.00', 2, '0.00', '1000.00', NULL, NULL, NULL, 1, '2022-09-26 03:15:15', '2022-09-26 03:15:47', 1, 1, 1),
(12, 1, 11, NULL, '2022-09-26', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '5500.00', '0.00', '5500.00', '5500.00', 6, '-5500.00', 2, '0.00', '5500.00', NULL, NULL, NULL, 1, '2022-09-26 03:33:18', '2022-09-26 03:34:09', 1, 1, 1),
(13, 1, 12, '50', '2022-09-30', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '20000.00', '0.00', '20000.00', '20000.00', 6, '-20000.00', 2, '0.00', '20000.00', NULL, NULL, NULL, 1, '2022-09-30 09:12:40', '2022-09-30 09:12:57', 1, 1, 1),
(14, 1, 13, '51', '2022-09-30', 2, 1, 1, NULL, NULL, '0.00', '0.00', '0.00', '1000.00', '0.00', '1000.00', '1000.00', 6, '-1000.00', 1, '1000.00', '0.00', NULL, NULL, NULL, 1, '2022-09-30 09:14:08', '2022-09-30 09:14:22', 1, 1, 1);

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
  `batch_id` bigint(20) DEFAULT NULL COMMENT 'رقم الباتش بالمخزن التي تم تخزنن الصنف بها',
  `production_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `item_card_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='تفاصيل انصاف فاتورة المشتريات والمرتجعات';

--
-- Dumping data for table `suppliers_with_orders_details`
--

INSERT INTO `suppliers_with_orders_details` (`id`, `suppliers_with_orders_auto_serial`, `order_type`, `com_code`, `deliverd_quantity`, `uom_id`, `isparentuom`, `unit_price`, `total_price`, `order_date`, `added_by`, `created_at`, `updated_by`, `updated_at`, `item_code`, `batch_id`, `production_date`, `expire_date`, `item_card_type`) VALUES
(1, 1, 1, 1, '1.00', 5, 1, '100.00', '100.00', '2022-09-23', 1, '2022-09-23 22:23:18', NULL, '2022-09-23 22:23:18', 4, NULL, NULL, NULL, 1),
(2, 1, 1, 1, '1.00', 6, 0, '10.00', '10.00', '2022-09-23', 1, '2022-09-23 22:23:27', NULL, '2022-09-23 22:23:27', 4, NULL, NULL, NULL, 1),
(3, 2, 1, 1, '11.00', 6, 0, '10.00', '110.00', '2022-09-23', 1, '2022-09-23 22:26:00', NULL, '2022-09-23 22:26:00', 4, NULL, NULL, NULL, 1),
(4, 3, 1, 1, '1.00', 5, 1, '100.00', '100.00', '2022-09-23', 1, '2022-09-23 22:30:22', NULL, '2022-09-23 22:30:22', 4, NULL, NULL, NULL, 1),
(5, 4, 1, 1, '8.00', 6, 0, '10.00', '80.00', '2022-09-23', 1, '2022-09-23 22:42:42', NULL, '2022-09-23 22:42:42', 4, NULL, NULL, NULL, 1),
(6, 5, 1, 1, '1.00', 6, 0, '10.00', '10.00', '2022-09-23', 1, '2022-09-23 22:43:59', NULL, '2022-09-23 22:43:59', 4, NULL, NULL, NULL, 1),
(7, 6, 1, 1, '10.00', 5, 1, '10.00', '100.00', '2022-09-23', 1, '2022-09-23 22:55:57', NULL, '2022-09-23 22:55:57', 4, NULL, NULL, NULL, 1),
(8, 7, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-09-23', 1, '2022-09-23 22:56:54', NULL, '2022-09-23 22:56:54', 4, NULL, NULL, NULL, 1),
(9, 8, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-09-23', 1, '2022-09-23 22:57:48', NULL, '2022-09-23 22:57:48', 4, NULL, NULL, NULL, 1),
(10, 10, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-09-26', 1, '2022-09-26 03:15:40', NULL, '2022-09-26 03:15:40', 4, NULL, NULL, NULL, 1),
(11, 11, 1, 1, '1.00', 1, 1, '1000.00', '1000.00', '2022-09-26', 1, '2022-09-26 03:33:42', NULL, '2022-09-26 03:33:42', 1, NULL, '2022-08-01', '2022-09-26', 2),
(12, 11, 1, 1, '5.00', 1, 1, '900.00', '4500.00', '2022-09-26', 1, '2022-09-26 03:34:03', NULL, '2022-09-26 03:34:03', 1, NULL, '2022-07-01', '2022-09-26', 2),
(13, 12, 1, 1, '20.00', 5, 1, '1000.00', '20000.00', '2022-09-30', 1, '2022-09-30 09:12:52', NULL, '2022-09-30 09:12:52', 4, NULL, NULL, NULL, 1),
(14, 9, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-09-24', 1, '2022-09-30 09:13:34', NULL, '2022-09-30 09:13:34', 4, NULL, NULL, NULL, 1),
(15, 13, 1, 1, '10.00', 5, 1, '100.00', '1000.00', '2022-09-30', 1, '2022-09-30 09:14:17', NULL, '2022-09-30 09:14:17', 4, NULL, NULL, NULL, 1);

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
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول الشجرة المحاسبية العامة';

--
-- Dumping data for table `suupliers`
--

INSERT INTO `suupliers` (`id`, `suuplier_code`, `suppliers_categories_id`, `name`, `account_number`, `start_balance_status`, `start_balance`, `current_balance`, `notes`, `added_by`, `updated_by`, `created_at`, `updated_at`, `active`, `com_code`, `date`, `city_id`, `address`) VALUES
(1, 1, 1, 'عاطف دياب محمد', 4, 1, '-5000.00', '-2110.00', NULL, 1, NULL, '2022-09-22 22:45:06', '2022-09-23 22:57:52', 1, 1, '2022-09-22', NULL, NULL),
(2, 2, 2, 'محمود محمد', 6, 3, '0.00', '-18900.00', NULL, 1, NULL, '2022-09-22 23:29:29', '2022-09-30 09:14:22', 1, 1, '2022-09-22', NULL, NULL);

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
(1, 'الرئيسية', 1, 13, 10, '2022-08-30 15:05:08', '2022-09-30 09:14:22', 1, 1, 1, '2022-08-30', 1),
(2, 'كاشير 1  يي  ddd', 0, 1, 1, '2022-08-30 17:14:15', '2022-08-30 18:43:43', 1, 1, 1, '2022-08-30', 0),
(3, 'كاشير 2', 0, 0, 0, '2022-08-30 19:09:55', '2022-08-30 19:09:55', 1, NULL, 1, '2022-08-30', 1),
(4, 'كاشير 3', 0, 0, 0, '2022-08-30 19:10:20', '2022-08-31 09:54:08', 1, 1, 1, '2022-08-30', 1);

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
(6, 1, 3, '2022-08-31 14:52:37', 1, NULL, '2022-08-31 14:52:37', 1);

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
  `is_account` tinyint(1) NOT NULL COMMENT 'هل هو حساب مالي',
  `money_for_account` decimal(10,2) NOT NULL COMMENT 'قيمة المبلغ المستحق للحساب او علي الحساب',
  `byan` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `com_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='جدول حركة النقدية بالشفتات';

--
-- Dumping data for table `treasuries_transactions`
--

INSERT INTO `treasuries_transactions` (`id`, `auto_serial`, `isal_number`, `shift_code`, `money`, `treasuries_id`, `is_approved`, `mov_type`, `move_date`, `the_foregin_key`, `account_number`, `is_account`, `money_for_account`, `byan`, `created_at`, `added_by`, `updated_at`, `updated_by`, `com_code`) VALUES
(2, 1, 9, 1, '100000.00', 1, 1, 25, '2022-09-22', NULL, 5, 1, '-100000.00', 'تحصيل نظير  قرض', '2022-09-22 23:01:06', 1, '2022-09-22 23:01:06', NULL, 1),
(3, 2, 9, 1, '-1000.00', 1, 1, 9, '2022-09-22', NULL, 4, 1, '1000.00', 'صرف نظير فاتورة مشتريات  رقم1', '2022-09-22 23:02:31', 1, '2022-09-22 23:02:31', NULL, 1),
(4, 3, 10, 1, '-4000.00', 1, 1, 9, '2022-09-22', NULL, 4, 1, '4000.00', 'صرف نظير  مستحق ع الحساب', '2022-09-22 23:04:22', 1, '2022-09-22 23:04:22', NULL, 1),
(5, 4, 11, 1, '-5000.00', 1, 1, 9, '2022-09-22', NULL, 6, 1, '5000.00', 'صرف نظير  تحت الحساب', '2022-09-22 23:34:06', 1, '2022-09-22 23:34:06', NULL, 1),
(6, 5, 12, 1, '-10000.00', 1, 1, 9, '2022-09-22', NULL, 6, 1, '10000.00', 'صرف نظير  تحت الحساب', '2022-09-22 23:34:49', 1, '2022-09-22 23:34:49', NULL, 1),
(7, 6, 10, 1, '5000.00', 1, 1, 10, '2022-09-22', NULL, 6, 1, '-5000.00', 'تحصيل نظير  رد نظير الغاء فاتورة مشتريات لم تحضر', '2022-09-22 23:35:34', 1, '2022-09-22 23:35:34', NULL, 1),
(8, 7, 13, 1, '-1000.00', 1, 1, 9, '2022-09-30', NULL, 6, 1, '1000.00', 'صرف نظير فاتورة مشتريات  رقم13', '2022-09-30 09:14:22', 1, '2022-09-30 09:14:22', NULL, 1);

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
-- Indexes for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delegates`
--
ALTER TABLE `delegates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_itemcard`
--
ALTER TABLE `inv_itemcard`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inv_itemcard_batches`
--
ALTER TABLE `inv_itemcard_batches`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inv_itemcard_categories`
--
ALTER TABLE `inv_itemcard_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements`
--
ALTER TABLE `inv_itemcard_movements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_categories`
--
ALTER TABLE `inv_itemcard_movements_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inv_itemcard_movements_types`
--
ALTER TABLE `inv_itemcard_movements_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `inv_uoms`
--
ALTER TABLE `inv_uoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mov_type`
--
ALTER TABLE `mov_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_invoices`
--
ALTER TABLE `sales_invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_invoices_details`
--
ALTER TABLE `sales_invoices_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sales_matrial_types`
--
ALTER TABLE `sales_matrial_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers_categories`
--
ALTER TABLE `suppliers_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `suppliers_with_orders`
--
ALTER TABLE `suppliers_with_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `suppliers_with_orders_details`
--
ALTER TABLE `suppliers_with_orders_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `suupliers`
--
ALTER TABLE `suupliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treasuries`
--
ALTER TABLE `treasuries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treasuries_delivery`
--
ALTER TABLE `treasuries_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `treasuries_transactions`
--
ALTER TABLE `treasuries_transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
