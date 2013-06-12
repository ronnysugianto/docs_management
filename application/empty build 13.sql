-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2013 at 10:52 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `enterprise`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) NOT NULL,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) NOT NULL,
  `other_business_type` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_city` varchar(255) NOT NULL,
  `company_province` varchar(255) NOT NULL,
  `customer_groupid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Tidak Aktif' COMMENT 'AKTIF\\nTIDAK AKTIF\\nBLACKLIST\\nBELUM TERVERIFIKASI',
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `credit_limit` varchar(255) NOT NULL,
  `pkp` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Pribadi' COMMENT 'Pribadi\\nPerusahaan',
  `other_type` varchar(255) DEFAULT NULL,
  `term_of_payment` varchar(255) NOT NULL DEFAULT 'Tunai' COMMENT 'Tunai\\nKredit',
  `time_of_credit` varchar(255) DEFAULT NULL COMMENT '30 Hari',
  `method_of_payment` varchar(255) NOT NULL DEFAULT 'Tunai' COMMENT 'TUNAI\\nTRANSFER\\nCEK',
  `bank` varchar(255) DEFAULT NULL COMMENT 'BCA\\nBRI\\nBNI',
  `other_bank` varchar(255) DEFAULT NULL,
  `average_purchase` varchar(255) NOT NULL COMMENT '1 - 10jt\\n10 - 30jt\\n30 - 50jt\\n50 - 100jt\\n100 - 200jt\\n> 200jt',
  `photo` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `contact_person_1` varchar(255) DEFAULT NULL,
  `contact_person_2` varchar(255) DEFAULT NULL,
  `phone_person_1` varchar(255) DEFAULT NULL,
  `phone_person_2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customerid`),
  UNIQUE KEY `customerid_UNIQUE` (`customerid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_customer_user1_idx` (`created_by`),
  KEY `fk_customer_user2_idx` (`modified_by`),
  KEY `fk_customer_customer_group1_idx` (`customer_groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE `customer_group` (
  `customer_groupid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_1` varchar(255) NOT NULL,
  `discount_2` varchar(255) NOT NULL,
  `discount_3` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`customer_groupid`),
  UNIQUE KEY `groupid_UNIQUE` (`customer_groupid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_customer_group_user1_idx` (`created_by`),
  KEY `fk_customer_group_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`departmentid`),
  UNIQUE KEY `departmentid_UNIQUE` (`departmentid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_department_user1_idx` (`created_by`),
  KEY `fk_department_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feature`
--

CREATE TABLE `feature` (
  `featureid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`featureid`),
  UNIQUE KEY `featureid_UNIQUE` (`featureid`),
  UNIQUE KEY `featurecol_UNIQUE` (`name`),
  KEY `fk_feature_user1_idx` (`created_by`),
  KEY `fk_feature_user2_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

--
-- Dumping data for table `feature`
--

INSERT INTO `feature` (`featureid`, `name`, `description`, `status`, `created_date`, `modified_date`, `created_by`, `modified_by`) VALUES
(1, 'Department List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(2, 'Department Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(3, 'Department Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(4, 'Department Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(5, 'Department Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(11, 'User List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(12, 'User Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(13, 'User Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(14, 'User Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(15, 'User Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(16, 'User Edit Password', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(21, 'Warehouse List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(22, 'Warehouse Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(23, 'Warehouse Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(24, 'Warehouse Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(25, 'Warehouse Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(31, 'Product List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(32, 'Product Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(33, 'Product Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(34, 'Product Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(35, 'Product Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(41, 'Supplier List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(42, 'Supplier Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(43, 'Supplier Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(44, 'Supplier Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(45, 'Supplier Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(51, 'Group Customer List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(52, 'Group Customer Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(53, 'Group Customer Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(54, 'Group Customer Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(55, 'Group Customer Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(61, 'Customer List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(62, 'Customer Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(63, 'Customer Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(64, 'Customer Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(65, 'Customer Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(71, 'Salesman List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(72, 'Salesman Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(73, 'Salesman Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(74, 'Salesman Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(75, 'Salesman Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(81, 'Inventory List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(82, 'Inventory Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(83, 'Inventory Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(84, 'Inventory Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(85, 'Inventory Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(101, 'Request Order List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(102, 'Request Order Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(103, 'Request Order Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(104, 'Request Order Add Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(105, 'Request Order Edit Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(106, 'Request Order Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(107, 'Request Order Detail Edit Status', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(108, 'Request Order Show Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(109, 'Request Order Delete Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(110, 'Request Order Print', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(111, 'Purchase Order List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(112, 'Purchase Order Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(113, 'Purchase Order Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(114, 'Purchase Order Add Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(115, 'Purchase Order Edit Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(116, 'Purchase Order Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(117, 'Purchase Order Edit Status', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(118, 'Purchase Order Show Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(119, 'Purchase Order Delete Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(120, 'Purchase Order Print', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(121, 'Receipt Order List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(122, 'Receipt Order Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(123, 'Receipt Order Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(124, 'Receipt Order Add Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(125, 'Receipt Order Edit Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(126, 'Receipt Order Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(127, 'Receipt Order Edit Status', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(128, 'Receipt Order Show Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(129, 'Receipt Order Delete Detail', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(130, 'Receipt Order Print', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(131, 'Forecast View', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(132, 'Statistic', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(133, 'Forecast Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(134, 'Forecast Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(141, 'Product Group List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(142, 'Product Group Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(143, 'Product Group Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(144, 'Product Group Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(145, 'Product Group Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(151, 'Product Category List', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(152, 'Product Category Add', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(153, 'Product Category Edit', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(154, 'Product Category Delete', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(155, 'Product Category Show', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(161, 'Report PP vs PO', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(162, 'Report PO vs PB', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(163, 'Report Item vs Vendor', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(164, 'Report Vendor vs Item', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(165, 'Report All Item vs Vendor', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(166, 'Report All Vendor vs Item', NULL, 'Aktif', '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forecast_product`
--

CREATE TABLE `forecast_product` (
  `january` int(11) NOT NULL,
  `february` int(11) NOT NULL,
  `march` int(11) NOT NULL,
  `april` int(11) NOT NULL,
  `may` int(11) NOT NULL,
  `june` int(11) NOT NULL,
  `july` int(11) NOT NULL,
  `august` int(11) NOT NULL,
  `september` int(11) NOT NULL,
  `october` int(11) NOT NULL,
  `november` int(11) NOT NULL,
  `december` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `productid` int(11) NOT NULL,
  KEY `fk_forecast_product_product1_idx` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forecast_salesman`
--

CREATE TABLE `forecast_salesman` (
  `january` int(11) NOT NULL,
  `february` int(11) NOT NULL,
  `march` int(11) NOT NULL,
  `april` int(11) NOT NULL,
  `may` int(11) NOT NULL,
  `june` int(11) NOT NULL,
  `july` int(11) NOT NULL,
  `august` int(11) NOT NULL,
  `september` int(11) NOT NULL,
  `october` int(11) NOT NULL,
  `november` int(11) NOT NULL,
  `december` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `salesmanid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  KEY `fk_forecast_salesman_salesman1_idx` (`salesmanid`),
  KEY `fk_forecast_salesman_product1_idx` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `warehouseid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`inventoryid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_inventory_warehouse1_idx` (`warehouseid`),
  KEY `fk_inventory_product1_idx` (`productid`),
  KEY `fk_inventory_user1_idx` (`created_by`),
  KEY `fk_inventory_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `hpp` double NOT NULL DEFAULT '0',
  `description` varchar(4096) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif' COMMENT 'AKTIF\\nTIDAK AKTIF',
  `minimum_stock` int(11) NOT NULL DEFAULT '0',
  `total_stock` int(11) NOT NULL DEFAULT '0',
  `smallest_unit` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `product_groupid` int(11) NOT NULL,
  `product_categoryid` int(11) NOT NULL,
  PRIMARY KEY (`productid`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `productid_UNIQUE` (`productid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_product_user1_idx` (`created_by`),
  KEY `fk_product_user2_idx` (`modified_by`),
  KEY `fk_product_product_group1_idx` (`product_groupid`),
  KEY `fk_product_product_category1_idx` (`product_categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `product_categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`product_categoryid`),
  UNIQUE KEY `product_categoryid_UNIQUE` (`product_categoryid`),
  UNIQUE KEY `product_categorycol_UNIQUE` (`code`),
  KEY `fk_product_category_user1_idx` (`created_by`),
  KEY `fk_product_category_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_group`
--

CREATE TABLE `product_group` (
  `product_groupid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`product_groupid`),
  UNIQUE KEY `product_groupid_UNIQUE` (`product_groupid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_product_group_user1_idx` (`created_by`),
  KEY `fk_product_group_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `purchase_orderid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `period` varchar(255) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `print_quantity` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `term_of_payment` varchar(255) DEFAULT NULL,
  `additional_cost` double NOT NULL DEFAULT '0',
  `additional_description` varchar(255) DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT '0',
  `total_discount` double NOT NULL DEFAULT '0',
  `final_price` double NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`purchase_orderid`),
  KEY `fk_purchase_order_supplier2_idx` (`supplierid`),
  KEY `fk_purchase_order_department2_idx` (`departmentid`),
  KEY `fk_purchase_order_user1_idx` (`created_by`),
  KEY `fk_purchase_order_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail`
--

CREATE TABLE `purchase_order_detail` (
  `purchase_order_detailid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `display_quantity` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `purchase_orderid` int(11) NOT NULL,
  `request_order_detailid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `total_receipt` int(11) NOT NULL DEFAULT '0',
  `display_total_receipt` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `measurement_unitid` int(11) NOT NULL,
  PRIMARY KEY (`purchase_order_detailid`,`purchase_orderid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_purchase_order_detail_purchase_order1_idx` (`purchase_orderid`),
  KEY `fk_purchase_order_detail_request_order_detail1_idx` (`request_order_detailid`,`request_orderid`),
  KEY `fk_purchase_order_detail_user1_idx` (`created_by`),
  KEY `fk_purchase_order_detail_user2_idx` (`modified_by`),
  KEY `fk_purchase_order_detail_unit_conversion1_idx` (`measurement_unitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail_history`
--

CREATE TABLE `purchase_order_detail_history` (
  `purchase_order_detailid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` double NOT NULL,
  `discount` double DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `total_receipt` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `purchase_orderid` int(11) NOT NULL,
  `purchase_historyid` int(11) NOT NULL,
  `request_order_detailid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  `display_total_receipt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`purchase_order_detailid`,`purchase_orderid`,`purchase_historyid`),
  KEY `fk_purchase_order_detail_user1_idx` (`created_by`),
  KEY `fk_purchase_order_detail_user2_idx` (`modified_by`),
  KEY `fk_purchase_order_detail_history_purchase_order_history1_idx` (`purchase_orderid`,`purchase_historyid`),
  KEY `fk_purchase_order_detail_history_request_order_detail1_idx` (`request_order_detailid`,`request_orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail_partial_delivery`
--

CREATE TABLE `purchase_order_detail_partial_delivery` (
  `purchase_order_detail_partial_deliveryid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `display_quantity` int(11) NOT NULL,
  `estimation_arrival_date` datetime DEFAULT NULL,
  `estimation_delivery_type` varchar(255) DEFAULT NULL,
  `estimation_delivery_month` datetime DEFAULT NULL,
  `estimation_arrival_type` varchar(255) DEFAULT NULL,
  `estimation_arrival_month` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `purchase_order_detailid` int(11) NOT NULL,
  `purchase_orderid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `measurement_unitid` int(11) NOT NULL,
  PRIMARY KEY (`purchase_order_detail_partial_deliveryid`,`purchase_order_detailid`,`purchase_orderid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_purchase_order_detail_partial_delivery_purchase_order_de_idx` (`purchase_order_detailid`,`purchase_orderid`),
  KEY `fk_purchase_order_detail_partial_delivery_user1_idx` (`created_by`),
  KEY `fk_purchase_order_detail_partial_delivery_user2_idx` (`modified_by`),
  KEY `fk_purchase_order_detail_partial_delivery_unit_conversion1_idx` (`measurement_unitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail_partial_delivery_history`
--

CREATE TABLE `purchase_order_detail_partial_delivery_history` (
  `purchase_order_detail_partial_deliveryid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `estimation_arrival_date` datetime DEFAULT NULL,
  `estimation_delivery_type` varchar(255) DEFAULT NULL,
  `estimation_delivery_month` datetime DEFAULT NULL,
  `estimation_arrival_type` varchar(255) DEFAULT NULL,
  `estimation_arrival_month` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `purchase_order_detailid` int(11) NOT NULL,
  `purchase_orderid` int(11) NOT NULL,
  `purchase_historyid` int(11) NOT NULL,
  PRIMARY KEY (`purchase_order_detail_partial_deliveryid`,`purchase_order_detailid`,`purchase_orderid`,`purchase_historyid`),
  KEY `fk_purchase_order_detail_partial_delivery_user1_idx` (`created_by`),
  KEY `fk_purchase_order_detail_partial_delivery_user2_idx` (`modified_by`),
  KEY `fk_purchase_order_detail_partial_delivery_history_purchase__idx` (`purchase_order_detailid`,`purchase_orderid`,`purchase_historyid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_history`
--

CREATE TABLE `purchase_order_history` (
  `purchase_orderid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `period` varchar(255) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `print_quantity` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `term_of_payment` varchar(255) DEFAULT NULL,
  `additional_cost` double NOT NULL DEFAULT '0',
  `additional_description` varchar(255) DEFAULT NULL,
  `total_price` double NOT NULL DEFAULT '0',
  `total_discount` double NOT NULL DEFAULT '0',
  `final_price` double NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `purchase_historyid` int(11) NOT NULL,
  PRIMARY KEY (`purchase_orderid`,`purchase_historyid`),
  KEY `fk_purchase_order_supplier2_idx` (`supplierid`),
  KEY `fk_purchase_order_department2_idx` (`departmentid`),
  KEY `fk_purchase_order_user1_idx` (`created_by`),
  KEY `fk_purchase_order_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_order`
--

CREATE TABLE `receipt_order` (
  `receipt_orderid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `receipt_date` datetime NOT NULL,
  `period` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `print_quantity` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`receipt_orderid`),
  KEY `fk_receipt_order_supplier1_idx` (`supplierid`),
  KEY `fk_receipt_order_user1_idx` (`created_by`),
  KEY `fk_receipt_order_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_order_detail`
--

CREATE TABLE `receipt_order_detail` (
  `receipt_orderid` int(11) NOT NULL,
  `receipt_order_detailid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `display_quantity` int(11) NOT NULL,
  `inventoryid` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `purchase_order_detailid` int(11) NOT NULL,
  `purchase_orderid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `measurement_unitid` int(11) NOT NULL,
  PRIMARY KEY (`receipt_orderid`,`receipt_order_detailid`),
  KEY `fk_receipt_order_detail_receipt_order1_idx` (`receipt_orderid`),
  KEY `fk_receipt_order_detail_inventory1_idx` (`inventoryid`),
  KEY `fk_receipt_order_detail_purchase_order_detail1_idx` (`purchase_order_detailid`,`purchase_orderid`),
  KEY `fk_receipt_order_detail_user1_idx` (`created_by`),
  KEY `fk_receipt_order_detail_user2_idx` (`modified_by`),
  KEY `fk_receipt_order_detail_unit_conversion1_idx` (`measurement_unitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order`
--

CREATE TABLE `request_order` (
  `request_orderid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `request_date` datetime NOT NULL,
  `period` varchar(255) NOT NULL,
  `from_departmentid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'LOKAL\\nIMPORT',
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `print_quantity` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu' COMMENT 'MENUNGGU\\nDISETUJUI\\nDITOLAK',
  `currency` varchar(255) DEFAULT 'IDR' COMMENT 'Skip',
  `term_of_payment` varchar(255) DEFAULT NULL COMMENT 'Skip',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `to_departmentid` int(11) NOT NULL,
  PRIMARY KEY (`request_orderid`),
  UNIQUE KEY `purchase_orderid_UNIQUE` (`request_orderid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_purchase_order_department1_idx` (`from_departmentid`),
  KEY `fk_request_order_user1_idx` (`created_by`),
  KEY `fk_request_order_user2_idx` (`modified_by`),
  KEY `fk_request_order_department1_idx` (`to_departmentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order_detail`
--

CREATE TABLE `request_order_detail` (
  `request_order_detailid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `display_quantity` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `productid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `total_purchase` int(11) NOT NULL DEFAULT '0',
  `total_finish_purchase` int(11) NOT NULL DEFAULT '0',
  `display_total_purchase` int(11) NOT NULL DEFAULT '0',
  `display_total_finish_purchase` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `measurement_unitid` int(11) NOT NULL,
  PRIMARY KEY (`request_order_detailid`,`request_orderid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_request_order_detail_product1_idx` (`productid`),
  KEY `fk_request_order_detail_request_order1_idx` (`request_orderid`),
  KEY `fk_request_order_detail_user1_idx` (`created_by`),
  KEY `fk_request_order_detail_user2_idx` (`modified_by`),
  KEY `fk_request_order_detail_unit_conversion1_idx` (`measurement_unitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order_detail_history`
--

CREATE TABLE `request_order_detail_history` (
  `request_order_detailid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `productid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `total_purchase` int(11) NOT NULL DEFAULT '0',
  `total_finish_purchase` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `request_historyid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  `display_total_purchase` int(11) NOT NULL DEFAULT '0',
  `display_total_finish_purchase` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_order_detailid`,`request_historyid`,`request_orderid`),
  KEY `fk_request_order_detail_product1_idx` (`productid`),
  KEY `fk_request_order_detail_user1_idx` (`created_by`),
  KEY `fk_request_order_detail_user2_idx` (`modified_by`),
  KEY `fk_request_order_detail_history_request_order_history1_idx` (`request_historyid`,`request_orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order_detail_partial_delivery`
--

CREATE TABLE `request_order_detail_partial_delivery` (
  `request_order_detail_partial_deliveryid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `display_quantity` int(11) NOT NULL,
  `estimation_arrival_date` datetime DEFAULT NULL,
  `estimation_delivery_type` varchar(255) DEFAULT NULL,
  `estimation_delivery_month` datetime DEFAULT NULL,
  `estimation_arrival_type` varchar(255) DEFAULT NULL,
  `estimation_arrival_month` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `request_order_detailid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `measurement_unitid` int(11) NOT NULL,
  PRIMARY KEY (`request_order_detail_partial_deliveryid`,`request_order_detailid`,`request_orderid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_request_order_detail_partial_delivery_request_order_deta_idx` (`request_order_detailid`,`request_orderid`),
  KEY `fk_request_order_detail_partial_delivery_user1_idx` (`created_by`),
  KEY `fk_request_order_detail_partial_delivery_user2_idx` (`modified_by`),
  KEY `fk_request_order_detail_partial_delivery_unit_conversion1_idx` (`measurement_unitid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order_detail_partial_delivery_history`
--

CREATE TABLE `request_order_detail_partial_delivery_history` (
  `request_order_detail_partial_deliveryid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `estimation_arrival_date` datetime DEFAULT NULL,
  `estimation_delivery_type` varchar(255) DEFAULT NULL,
  `estimation_delivery_month` datetime DEFAULT NULL,
  `estimation_arrival_type` varchar(255) DEFAULT NULL,
  `estimation_arrival_month` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `request_order_detailid` int(11) NOT NULL,
  `request_historyid` int(11) NOT NULL,
  `request_orderid` int(11) NOT NULL,
  PRIMARY KEY (`request_order_detail_partial_deliveryid`,`request_order_detailid`,`request_historyid`,`request_orderid`),
  KEY `fk_request_order_detail_partial_delivery_user1_idx` (`created_by`),
  KEY `fk_request_order_detail_partial_delivery_user2_idx` (`modified_by`),
  KEY `fk_request_order_detail_partial_delivery_history_request_or_idx` (`request_order_detailid`,`request_historyid`,`request_orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_order_history`
--

CREATE TABLE `request_order_history` (
  `request_orderid` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `request_date` datetime NOT NULL,
  `period` varchar(255) NOT NULL,
  `from_departmentid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'LOKAL\\nIMPORT',
  `product_type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `print_quantity` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'Menunggu' COMMENT 'MENUNGGU\\nDISETUJUI\\nDITOLAK',
  `currency` varchar(255) DEFAULT 'IDR' COMMENT 'Skip',
  `term_of_payment` varchar(255) DEFAULT NULL COMMENT 'Skip',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `upload` varchar(255) DEFAULT NULL,
  `to_departmentid` int(11) NOT NULL,
  `request_historyid` int(11) NOT NULL,
  PRIMARY KEY (`request_historyid`,`request_orderid`),
  KEY `fk_purchase_order_department1_idx` (`from_departmentid`),
  KEY `fk_request_order_user1_idx` (`created_by`),
  KEY `fk_request_order_user2_idx` (`modified_by`),
  KEY `fk_request_order_department1_idx` (`to_departmentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `salesmanid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`salesmanid`),
  UNIQUE KEY `salesmanid_UNIQUE` (`salesmanid`),
  KEY `fk_salesman_user1_idx` (`created_by`),
  KEY `fk_salesman_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sale_order`
--

CREATE TABLE `sale_order` (
  `soid` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `customerid` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `salesmanid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`soid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_sale_order_customer1_idx` (`customerid`),
  KEY `fk_sale_order_salesman1_idx` (`salesmanid`),
  KEY `fk_sale_order_user1_idx` (`created_by`),
  KEY `fk_sale_order_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `so_items`
--

CREATE TABLE `so_items` (
  `soitemid` bigint(20) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `discount` tinyint(4) NOT NULL,
  `extradiscount` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `soid` bigint(20) NOT NULL,
  `productid` int(11) NOT NULL,
  PRIMARY KEY (`soitemid`),
  KEY `fk_so_items_sale_order1_idx` (`soid`),
  KEY `fk_so_items_product1_idx` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `npwp` varchar(255) NOT NULL,
  `term_of_payment` varchar(255) NOT NULL DEFAULT 'Tunai' COMMENT 'TUNAI\\nKREDIT',
  `time_of_credit` varchar(255) DEFAULT NULL COMMENT '30 Hari',
  `credit_limit` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif' COMMENT 'AKTIF\\nTIDAK AKTIF',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`supplierid`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `supplierid_UNIQUE` (`supplierid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_supplier_user1_idx` (`created_by`),
  KEY `fk_supplier_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `unit_conversion`
--

CREATE TABLE `unit_conversion` (
  `measurement_unitid` int(11) NOT NULL AUTO_INCREMENT,
  `measurement_unit` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `productid` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`measurement_unitid`),
  KEY `fk_unit_conversion_product1_idx` (`productid`),
  KEY `fk_unit_conversion_user1_idx` (`created_by`),
  KEY `fk_unit_conversion_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_salt` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif' COMMENT 'AKTIF\\nTIDAK AKTIF',
  `description` varchar(4096) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userid_UNIQUE` (`userid`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `fk_user_user1_idx` (`created_by`),
  KEY `fk_user_user2_idx` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `fullname`, `password`, `password_salt`, `status`, `description`, `last_login`, `created_date`, `modified_date`, `created_by`, `modified_by`) VALUES
(1, 'admin', 'Administrator', '21232f297a57a5a743894a0e4a801fc35e8593e46de87670dcc2bb36cc5e70356f30e9b5ff11f60c444d3d44a2fef7c1517b24b1', 'ff11f60c444d3d44a2fef7c1517b24b1', 'Aktif', NULL, NULL, '2012-11-01 00:00:00', '2012-11-01 00:00:00', 1, 1);

INSERT INTO `salesman` (`salesmanid`, `code`, `name`, `address`, `city`, `mobile`, `photo`, `status`, `created_date`, `modified_date`, `created_by`, `modified_by`) VALUES
(1, 'M-0001', 'Salesman SSIS', 'Margomulyo', 'Surabaya', '-', 'no_image.jpg', 'Aktif', '2013-04-22 11:24:52', '2013-04-22 11:25:50', 1, 1);
-- --------------------------------------------------------

--
-- Table structure for table `user_department`
--

CREATE TABLE `user_department` (
  `userid` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `fk_user_department_department1_idx` (`departmentid`),
  KEY `fk_user_department_user1_idx` (`userid`),
  KEY `fk_user_department_user2_idx` (`created_by`),
  KEY `fk_user_department_user3_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_feature`
--

CREATE TABLE `user_feature` (
  `userid` int(11) NOT NULL,
  `featureid` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`featureid`),
  KEY `fk_user_feature_feature1_idx` (`featureid`),
  KEY `fk_user_feature_user1_idx` (`userid`),
  KEY `fk_user_feature_user2_idx` (`created_by`),
  KEY `fk_user_feature_user3_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_feature`
--

INSERT INTO `user_feature` (`userid`, `featureid`, `created_date`, `modified_date`, `created_by`, `modified_by`) VALUES
(1, 1, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 2, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 3, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 4, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 5, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 11, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 12, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 13, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 14, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 15, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 16, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 21, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 22, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 23, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 24, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 25, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 31, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 32, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 33, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 34, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 35, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 41, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 42, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 43, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 44, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 45, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 51, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 52, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 53, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 54, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 55, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 61, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 62, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 63, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 64, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 65, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 71, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 72, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 73, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 74, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 75, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 81, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 82, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 83, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 84, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 85, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 101, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 102, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 103, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 104, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 105, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 106, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 107, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 108, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 109, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 110, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 111, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 112, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 113, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 114, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 115, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 116, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 117, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 118, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 119, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 120, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 121, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 122, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 123, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 124, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 125, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 126, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 127, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 128, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 129, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 130, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 131, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 132, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 133, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 134, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 141, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 142, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 143, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 144, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 145, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 151, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 152, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 153, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 154, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 155, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 161, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 162, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 163, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 164, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 165, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1),
(1, 166, '2011-01-12 00:00:00', '2011-01-12 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `warehouseid` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif' COMMENT 'AKTIF\\nTIDAK AKTIF',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`warehouseid`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `warehouseid_UNIQUE` (`warehouseid`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_warehouse_user1_idx` (`created_by`),
  KEY `fk_warehouse_user2_idx` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_customer_group1` FOREIGN KEY (`customer_groupid`) REFERENCES `customer_group` (`customer_groupid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customer_group`
--
ALTER TABLE `customer_group`
  ADD CONSTRAINT `fk_customer_group_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customer_group_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_department_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_department_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `feature`
--
ALTER TABLE `feature`
  ADD CONSTRAINT `fk_feature_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_feature_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forecast_product`
--
ALTER TABLE `forecast_product`
  ADD CONSTRAINT `fk_forecast_product_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forecast_salesman`
--
ALTER TABLE `forecast_salesman`
  ADD CONSTRAINT `fk_forecast_salesman_salesman1` FOREIGN KEY (`salesmanid`) REFERENCES `salesman` (`salesmanid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_forecast_salesman_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_inventory_warehouse1` FOREIGN KEY (`warehouseid`) REFERENCES `warehouse` (`warehouseid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inventory_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_product_group1` FOREIGN KEY (`product_groupid`) REFERENCES `product_group` (`product_groupid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_product_category1` FOREIGN KEY (`product_categoryid`) REFERENCES `product_category` (`product_categoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `fk_product_category_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_category_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_group`
--
ALTER TABLE `product_group`
  ADD CONSTRAINT `fk_product_group_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_product_group_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `fk_purchase_order_supplier2` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`supplierid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_department2` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
  ADD CONSTRAINT `fk_purchase_order_detail_purchase_order1` FOREIGN KEY (`purchase_orderid`) REFERENCES `purchase_order` (`purchase_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_request_order_detail1` FOREIGN KEY (`request_order_detailid`, `request_orderid`) REFERENCES `request_order_detail` (`request_order_detailid`, `request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_unit_conversion1` FOREIGN KEY (`measurement_unitid`) REFERENCES `unit_conversion` (`measurement_unitid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order_detail_history`
--
ALTER TABLE `purchase_order_detail_history`
  ADD CONSTRAINT `fk_purchase_order_detail_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_history_purchase_order_history1` FOREIGN KEY (`purchase_orderid`, `purchase_historyid`) REFERENCES `purchase_order_history` (`purchase_orderid`, `purchase_historyid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_history_request_order_detail1` FOREIGN KEY (`request_order_detailid`, `request_orderid`) REFERENCES `request_order_detail` (`request_order_detailid`, `request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order_detail_partial_delivery`
--
ALTER TABLE `purchase_order_detail_partial_delivery`
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_purchase_order_deta1` FOREIGN KEY (`purchase_order_detailid`, `purchase_orderid`) REFERENCES `purchase_order_detail` (`purchase_order_detailid`, `purchase_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_unit_conversion1` FOREIGN KEY (`measurement_unitid`) REFERENCES `unit_conversion` (`measurement_unitid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order_detail_partial_delivery_history`
--
ALTER TABLE `purchase_order_detail_partial_delivery_history`
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_detail_partial_delivery_history_purchase_or1` FOREIGN KEY (`purchase_order_detailid`, `purchase_orderid`, `purchase_historyid`) REFERENCES `purchase_order_detail_history` (`purchase_order_detailid`, `purchase_orderid`, `purchase_historyid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `purchase_order_history`
--
ALTER TABLE `purchase_order_history`
  ADD CONSTRAINT `fk_purchase_order_supplier20` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`supplierid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_department20` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_purchase_order_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `receipt_order`
--
ALTER TABLE `receipt_order`
  ADD CONSTRAINT `fk_receipt_order_supplier1` FOREIGN KEY (`supplierid`) REFERENCES `supplier` (`supplierid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `receipt_order_detail`
--
ALTER TABLE `receipt_order_detail`
  ADD CONSTRAINT `fk_receipt_order_detail_receipt_order1` FOREIGN KEY (`receipt_orderid`) REFERENCES `receipt_order` (`receipt_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_detail_inventory1` FOREIGN KEY (`inventoryid`) REFERENCES `inventory` (`inventoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_detail_purchase_order_detail1` FOREIGN KEY (`purchase_order_detailid`, `purchase_orderid`) REFERENCES `purchase_order_detail` (`purchase_order_detailid`, `purchase_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_detail_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_detail_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_receipt_order_detail_unit_conversion1` FOREIGN KEY (`measurement_unitid`) REFERENCES `unit_conversion` (`measurement_unitid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order`
--
ALTER TABLE `request_order`
  ADD CONSTRAINT `fk_purchase_order_department1` FOREIGN KEY (`from_departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_department1` FOREIGN KEY (`to_departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order_detail`
--
ALTER TABLE `request_order_detail`
  ADD CONSTRAINT `fk_request_order_detail_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_request_order1` FOREIGN KEY (`request_orderid`) REFERENCES `request_order` (`request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_unit_conversion1` FOREIGN KEY (`measurement_unitid`) REFERENCES `unit_conversion` (`measurement_unitid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order_detail_history`
--
ALTER TABLE `request_order_detail_history`
  ADD CONSTRAINT `fk_request_order_detail_product10` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_history_request_order_history1` FOREIGN KEY (`request_historyid`, `request_orderid`) REFERENCES `request_order_history` (`request_historyid`, `request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order_detail_partial_delivery`
--
ALTER TABLE `request_order_detail_partial_delivery`
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_request_order_detail1` FOREIGN KEY (`request_order_detailid`, `request_orderid`) REFERENCES `request_order_detail` (`request_order_detailid`, `request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_unit_conversion1` FOREIGN KEY (`measurement_unitid`) REFERENCES `unit_conversion` (`measurement_unitid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order_detail_partial_delivery_history`
--
ALTER TABLE `request_order_detail_partial_delivery_history`
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_detail_partial_delivery_history_request_orde1` FOREIGN KEY (`request_order_detailid`, `request_historyid`, `request_orderid`) REFERENCES `request_order_detail_history` (`request_order_detailid`, `request_historyid`, `request_orderid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `request_order_history`
--
ALTER TABLE `request_order_history`
  ADD CONSTRAINT `fk_purchase_order_department10` FOREIGN KEY (`from_departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_user10` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_user20` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_request_order_department10` FOREIGN KEY (`to_departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `salesman`
--
ALTER TABLE `salesman`
  ADD CONSTRAINT `fk_salesman_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_salesman_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sale_order`
--
ALTER TABLE `sale_order`
  ADD CONSTRAINT `fk_sale_order_customer1` FOREIGN KEY (`customerid`) REFERENCES `customer` (`customerid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sale_order_salesman1` FOREIGN KEY (`salesmanid`) REFERENCES `salesman` (`salesmanid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sale_order_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sale_order_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `so_items`
--
ALTER TABLE `so_items`
  ADD CONSTRAINT `fk_so_items_sale_order1` FOREIGN KEY (`soid`) REFERENCES `sale_order` (`soid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_so_items_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `fk_supplier_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_supplier_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `unit_conversion`
--
ALTER TABLE `unit_conversion`
  ADD CONSTRAINT `fk_unit_conversion_product1` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unit_conversion_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unit_conversion_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_department`
--
ALTER TABLE `user_department`
  ADD CONSTRAINT `fk_user_department_department1` FOREIGN KEY (`departmentid`) REFERENCES `department` (`departmentid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_department_user1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_department_user2` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_department_user3` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_feature`
--
ALTER TABLE `user_feature`
  ADD CONSTRAINT `fk_user_feature_feature1` FOREIGN KEY (`featureid`) REFERENCES `feature` (`featureid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_feature_user1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_feature_user2` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_feature_user3` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `fk_warehouse_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_warehouse_user2` FOREIGN KEY (`modified_by`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
