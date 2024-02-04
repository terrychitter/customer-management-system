-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2024 at 07:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `balance_date` datetime DEFAULT NULL,
  `balance_amount` decimal(10,2) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balances`
--

INSERT INTO `balances` (`id`, `customer_id`, `balance_date`, `balance_amount`, `payment_id`, `invoice_id`) VALUES
(37, 1001, '2024-02-04 00:00:00', 500.00, NULL, 'INV2402041001'),
(40, 1004, '2024-02-04 00:00:00', 400.00, NULL, 'INV2402041004'),
(41, 1006, '2024-02-04 00:00:00', 350.00, NULL, 'INV2402041006'),
(42, 1007, '2024-02-04 00:00:00', 600.00, NULL, 'INV2402041007'),
(43, 1009, '2024-02-04 00:00:00', 650.00, NULL, 'INV2402041009'),
(44, 1010, '2024-02-04 00:00:00', 500.00, NULL, 'INV2402041010'),
(45, 1011, '2024-02-04 00:00:00', 700.00, NULL, 'INV2402041011'),
(46, 1030, '2024-02-04 00:00:00', 600.00, NULL, 'INV2402041030'),
(47, 1031, '2024-02-04 00:00:00', 550.00, NULL, 'INV2402041031'),
(48, 1033, '2024-02-04 00:00:00', 650.00, NULL, 'INV2402041033'),
(49, 1034, '2024-02-04 00:00:00', 500.00, NULL, 'INV2402041034'),
(50, 1036, '2024-02-04 00:00:00', 450.00, NULL, 'INV2402041036'),
(51, 1037, '2024-02-04 00:00:00', 700.00, NULL, 'INV2402041037'),
(52, 1039, '2024-02-04 00:00:00', 550.00, NULL, 'INV2402041039'),
(53, 1040, '2024-02-04 00:00:00', 600.00, NULL, 'INV2402041040'),
(54, 1041, '2024-02-04 00:00:00', 700.00, NULL, 'INV2402041041'),
(55, 1049, '2024-02-04 00:00:00', 600.00, NULL, 'INV2402041049'),
(56, 1050, '2024-02-04 00:00:00', 550.00, NULL, 'INV2402041050'),
(57, 1005, '2024-02-04 00:00:00', 550.00, NULL, 'INV2402041005'),
(58, 1008, '2024-02-04 00:00:00', 450.00, NULL, 'INV2402041008'),
(59, 1012, '2024-02-04 00:00:00', 400.00, NULL, 'INV2402041012'),
(60, 1032, '2024-02-04 00:00:00', 400.00, NULL, 'INV2402041032'),
(63, 1042, '2024-02-04 00:00:00', 350.00, NULL, 'INV2402041042'),
(64, 1005, '2024-02-04 13:44:56', 0.00, 'PMT240204EF1005', NULL),
(65, 1001, '2024-02-04 13:45:27', 100.00, 'PMT240204EF1001', NULL),
(66, 1003, '2024-02-04 13:45:54', -300.00, 'PMT240204EF1003', NULL),
(67, 1006, '2024-02-04 13:47:20', -150.00, 'PMT240204EF1006', NULL),
(68, 1050, '2024-02-04 13:47:39', 310.00, 'PMT240204EF1050', NULL),
(69, 1049, '2024-02-04 13:47:48', 480.00, 'PMT240204EF1049', NULL),
(70, 1049, '2024-02-04 13:47:56', 130.00, 'PMT240204EF1049-2', NULL),
(71, 1049, '2024-02-04 13:48:03', 0.00, 'PMT240204EF1049-3', NULL),
(74, 1042, '2024-02-04 13:50:24', 230.00, 'PMT240204EF1042', NULL),
(75, 1042, '2024-02-04 13:50:35', 110.00, 'PMT240204EF1042-2', NULL),
(76, 1041, '2024-02-04 13:51:15', 400.00, 'PMT240204EF1041', NULL),
(77, 1042, '2024-02-04 13:51:52', 0.00, 'PMT240204EF1042-3', NULL),
(78, 1040, '2024-02-04 13:52:35', 200.00, 'PMT240204EF1040', NULL),
(79, 1039, '2024-02-04 13:53:07', 246.00, 'PMT240204EF1039', NULL),
(81, 1010, '2024-02-04 13:54:24', 140.00, 'PMT240204CA1010', NULL),
(82, 1031, '2024-02-04 13:54:42', 480.00, 'PMT240204CA1031', NULL),
(83, 1007, '2024-02-04 13:55:18', 179.90, 'PMT240204EF1007', NULL),
(84, 1007, '2024-02-04 13:55:29', 0.00, 'PMT240204CA1007', NULL),
(85, 1004, '2024-02-03 13:55:49', -345.00, 'PMT240203CA1004', NULL),
(86, 1008, '2024-02-04 13:56:23', 320.00, 'PMT240204CA1008', NULL),
(87, 1008, '2024-02-04 13:56:29', 20.00, 'PMT240204EF1008', NULL),
(88, 1009, '2024-02-04 13:56:41', 550.00, 'PMT240204EF1009', NULL),
(89, 1011, '2024-02-04 13:57:02', 340.00, 'PMT240204EF1011', NULL),
(90, 1012, '2024-02-04 13:57:16', 280.00, 'PMT240204EF1012', NULL),
(91, 1032, '2024-02-04 13:57:46', -1000.00, 'PMT240204CA1032', NULL),
(92, 1033, '2024-02-04 13:57:59', 350.00, 'PMT240204EF1033', NULL),
(93, 1034, '2024-02-04 13:58:13', 389.25, 'PMT240204EF1034', NULL),
(94, 1035, '2024-02-04 13:58:29', 579.90, 'PMT240204EF1035', NULL),
(95, 1036, '2024-02-03 13:59:38', 339.70, 'PMT240203EF1036', NULL),
(96, 1037, '2024-02-04 13:59:55', 321.00, 'PMT240204EF1037', NULL),
(97, 1038, '2024-02-04 14:00:09', 280.00, 'PMT240204EF1038', NULL),
(98, 1003, '2024-03-04 00:00:00', 400.00, NULL, 'INV2403041003'),
(99, 1002, '2024-03-04 00:00:00', 600.00, NULL, 'INV2403041002'),
(100, 1038, '2024-03-04 00:00:00', 680.00, NULL, 'INV2403041038'),
(101, 1035, '2024-03-04 00:00:00', 1179.90, NULL, 'INV2403041035');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `private_name` varchar(30) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `type` varchar(7) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `branch_code` varchar(10) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `private_name`, `name`, `bank`, `branch`, `type`, `account_number`, `branch_code`, `is_default`) VALUES
(1, 'Bank Account 1', 'Super Cleaners', 'First National Bank', 'Centurion', 'Cheque', '304940321402', '30293', 0),
(2, 'Bank Account 2', 'Super Cleaners', 'Nedbank', 'Centurion', 'Cheque', '40520910942', '40221', 1),
(3, 'Bank Account 3', 'Super Cleaners', 'Capitec', 'Centurion', 'Savings', '039422481389', '444952', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bins`
--

CREATE TABLE `bins` (
  `serial_number` varchar(255) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `comment_title` varchar(255) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `date_time_added` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `customer_id`, `comment_title`, `comment_text`, `date_time_added`) VALUES
(1, 1001, 'Add Bin', 'Added a new bin to the customer account.', '2024-02-03 22:37:29'),
(2, 1001, 'Communication', 'Spoke with the customer regarding their service.', '2024-02-03 22:37:29'),
(3, 1001, 'Fee structure', 'Explained the fee structure to the customer.', '2024-02-03 22:37:29'),
(4, 1002, 'Additional Email', 'Updated customer email for additional notifications.', '2024-02-03 22:37:29'),
(5, 1002, 'No Charge', 'Resolved an issue and provided service at no charge.', '2024-02-03 22:37:29'),
(6, 1002, 'Transfer', 'Initiated a transfer for the customer.', '2024-02-03 22:37:29'),
(7, 1003, 'Schedule', 'Scheduled a service appointment with the customer.', '2024-02-03 22:37:50'),
(8, 1003, 'Bin Details', 'Provided detailed information about the customer\'s bin.', '2024-02-03 22:37:50'),
(9, 1003, 'Communication', 'Followed up with the customer regarding recent communication.', '2024-02-03 22:37:50'),
(10, 1004, 'Fee structure', 'Discussed the fee structure and billing details with the customer.', '2024-02-03 22:37:50'),
(11, 1004, 'Transfer', 'Assisted the customer in transferring their service to a new address.', '2024-02-03 22:37:50'),
(12, 1004, 'Communication', 'Addressed customer concerns raised through communication.', '2024-02-03 22:37:50'),
(13, 1041, 'Communication', 'Updated the customer about recent changes in service.', '2024-02-03 22:37:50'),
(14, 1041, 'Add Bin', 'Added an extra bin to meet customer requirements.', '2024-02-03 22:37:50'),
(15, 1041, 'Schedule', 'Scheduled regular service appointments for the customer.', '2024-02-03 22:37:50'),
(16, 1042, 'Transfer', 'Completed the process of transferring service for the customer.', '2024-02-03 22:37:50'),
(17, 1042, 'No Charge', 'Addressed an issue and provided service at no additional charge.', '2024-02-03 22:37:50'),
(18, 1042, 'Bin Details', 'Provided detailed information about the customer\'s bin specifications.', '2024-02-03 22:37:50'),
(19, 1005, 'Communication', 'Addressed a customer inquiry via email communication.', '2024-02-03 22:38:55'),
(20, 1005, 'Schedule', 'Confirmed upcoming service schedule with the customer.', '2024-02-03 22:38:55'),
(21, 1005, 'Additional Email', 'Updated customer\'s email for additional notifications.', '2024-02-03 22:38:55'),
(22, 1006, 'Communication', 'Followed up with the customer after recent communication.', '2024-02-03 22:38:55'),
(23, 1006, 'Fee structure', 'Explained the updated fee structure to the customer.', '2024-02-03 22:38:55'),
(24, 1006, 'Add Bin', 'Added an additional bin to the customer account as requested.', '2024-02-03 22:38:55'),
(25, 1035, 'No Charge', 'Provided a one-time service at no additional charge.', '2024-02-03 22:38:55'),
(26, 1035, 'Transfer', 'Initiated the process of transferring service for the customer.', '2024-02-03 22:38:55'),
(27, 1035, 'Schedule', 'Scheduled regular service appointments for the customer.', '2024-02-03 22:38:55'),
(28, 1040, 'Bin Details', 'Provided detailed information about the customers bin specifications.', '2024-02-03 22:38:55'),
(29, 1040, 'Communication', 'Addressed customer concerns raised through communication.', '2024-02-03 22:38:55'),
(30, 1040, 'Transfer', 'Assisted the customer in transferring their service to a new address.', '2024-02-03 22:38:55'),
(31, 1001, 'Bin Details', 'Comment text', '2024-02-04 15:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `contact_title` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `customer_id`, `contact_title`, `contact`, `country_code`) VALUES
(1, 1001, 'John Doe', '123456789', '+27'),
(2, 1002, 'Jane Smith', '987654321', '+27'),
(3, 1003, 'Chris Johnson', '456789012', '+27'),
(4, 1004, 'Emily Williams', '789012345', '+27'),
(5, 1005, 'Michael Brown', '123450987', '+27'),
(6, 1006, 'Sophie Anderson', '234567890', '+27'),
(7, 1007, 'Daniel Smith', '345678901', '+27'),
(8, 1008, 'Olivia Taylor', '567890123', '+27'),
(9, 1009, 'Matthew Johnson', '678901234', '+27'),
(10, 1010, 'Ava Wilson', '789012345', '+27'),
(11, 1011, 'Ethan Brown', '890123456', '+27'),
(12, 1012, 'Isabella Miller', '901234567', '+27'),
(13, 1030, 'Emma Davis', '123456789', '+27'),
(14, 1033, 'Jack Thompson', '456789012', '+27'),
(15, 1034, 'Sophia Harris', '567890123', '+27'),
(16, 1035, 'Liam Nelson', '678901234', '+27'),
(17, 1036, 'Avery Cooper', '789012345', '+27'),
(18, 1037, 'Mia Carter', '890123456', '+27'),
(19, 1038, 'Logan Fisher', '901234567', '+27'),
(20, 1039, 'Evelyn Parker', '123456789', '+27'),
(21, 1040, 'Owen Hayes', '234567890', '+27'),
(22, 1041, 'Harper Bryant', '345678901', '+27'),
(23, 1042, 'Jordan Fox', '456789012', '+27');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `account_number` int(11) NOT NULL,
  `title` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `frequency` int(11) DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `monthly_rate` decimal(10,2) DEFAULT NULL,
  `date_joined` date DEFAULT NULL,
  `date_added` date DEFAULT curdate(),
  `bank_account` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`account_number`, `title`, `name`, `surname`, `address`, `suburb`, `city`, `postal_code`, `active`, `email`, `origin`, `frequency`, `day`, `monthly_rate`, `date_joined`, `date_added`, `bank_account`) VALUES
(1001, 'Mr', 'Johnny', 'Doe', '25 Cactus Lane', 'SuburbA', NULL, '12345', 1, 'john.doe@email.com', 'self', 3, 'Monday', 500.00, '2023-02-01', '2023-02-01', 1),
(1002, 'Ms', 'Jane', 'Smith', '456 Oak St', 'SuburbB', 'CityB', '67890', 1, 'jane.smith@email.com', 'facebook', 2, 'Tuesday', 300.00, '2023-03-15', '2023-03-15', 2),
(1003, 'Mr', 'Chris', 'Johnson', '789 Pine St', 'SuburbC', 'CityC', '13579', 1, 'chris.johnson@email.com', 'gmail', 4, 'Wednesday', 700.00, '2023-04-20', '2023-04-20', 1),
(1004, 'Mrs', 'Emily', 'Williams', '101 Elm St', 'SuburbD', 'CityD', '24680', 1, 'emily.williams@email.com', 'instagram', 1, 'Thursday', 400.00, '2023-05-10', '2023-05-10', 3),
(1005, 'Mr', 'Michael', 'Brown', '202 Maple St', 'SuburbE', 'CityE', '97531', 0, 'michael.brown@email.com', 'twitter', 3, 'Friday', 550.00, '2023-06-05', '2023-06-05', 1),
(1006, 'Ms', 'Sophie', 'Anderson', '303 Birch St', 'SuburbF', 'CityF', '86420', 1, 'sophie.anderson@email.com', 'self', 2, 'Monday', 350.00, '2023-07-01', '2023-07-01', 2),
(1007, 'Mr', 'Daniel', 'Smith', '404 Cedar St', 'SuburbG', 'CityG', '75309', 1, 'daniel.smith@email.com', 'facebook', 4, 'Tuesday', 600.00, '2023-08-15', '2023-08-15', 1),
(1008, 'Mrs', 'Olivia', 'Taylor', '505 Pine St', 'SuburbH', 'CityH', '64258', 0, 'olivia.taylor@email.com', 'gmail', 1, 'Wednesday', 450.00, '2023-09-20', '2023-09-20', 3),
(1009, 'Mr', 'Matthew', 'Johnson', '606 Oak St', 'SuburbI', 'CityI', '53147', 1, 'matthew.johnson@email.com', 'instagram', 3, 'Thursday', 650.00, '2023-10-10', '2023-10-10', 1),
(1010, 'Ms', 'Ava', 'Wilson', '707 Elm St', 'SuburbJ', 'CityJ', '42036', 1, 'ava.wilson@email.com', 'twitter', 2, 'Friday', 500.00, '2023-11-05', '2023-11-05', 2),
(1011, 'Mr', 'Ethan', 'Brown', '808 Maple St', 'SuburbK', 'CityK', '30925', 1, 'ethan.brown@email.com', 'self', 4, 'Monday', 700.00, '2023-12-01', '2023-12-01', 1),
(1012, 'Mrs', 'Isabella', 'Miller', '909 Birch St', 'SuburbL', 'CityL', '19874', 0, 'isabella.miller@email.com', 'facebook', 1, 'Tuesday', 400.00, '2024-01-15', '2024-01-15', 3),
(1030, 'Ms', 'Emma', 'Davis', '2021 Cedar St', 'SuburbT', 'CityT', '23456', 1, 'emma.davis@email.com', 'instagram', 2, 'Friday', 600.00, '2024-01-28', '2024-01-28', 1),
(1031, 'Mr', 'William', 'Clark', '111 Pine St', 'SuburbU', 'CityU', '34567', 1, 'william.clark@email.com', 'twitter', 3, 'Monday', 550.00, '2024-02-10', '2024-02-10', 1),
(1032, 'Mrs', 'Grace', 'Wilson', '222 Oak St', 'SuburbV', 'CityV', '45678', 0, 'grace.wilson@email.com', 'self', 2, 'Tuesday', 400.00, '2024-03-20', '2024-03-20', 2),
(1033, 'Mr', 'Jack', 'Thompson', '333 Elm St', 'SuburbW', 'CityW', '56789', 1, 'jack.thompson@email.com', 'instagram', 4, 'Wednesday', 650.00, '2024-04-15', '2024-04-15', 1),
(1034, 'Ms', 'Sophia', 'Harris', '444 Cedar St', 'SuburbX', 'CityX', '67890', 1, 'sophia.harris@email.com', 'facebook', 1, 'Thursday', 500.00, '2024-05-05', '2024-05-05', 3),
(1035, 'Mr', 'Liam', 'Nelson', '555 Maple St', 'SuburbY', 'CityY', '78901', 0, 'liam.nelson@email.com', 'gmail', 3, 'Friday', 600.00, '2024-06-01', '2024-06-01', 1),
(1036, 'Mrs', 'Avery', 'Cooper', '666 Birch St', 'SuburbZ', 'CityZ', '89012', 1, 'avery.cooper@email.com', 'twitter', 2, 'Monday', 450.00, '2024-07-10', '2024-07-10', 2),
(1037, 'Mr', 'Mia', 'Carter', '777 Pine St', 'SuburbAA', 'CityAA', '90123', 1, 'mia.carter@email.com', 'self', 4, 'Tuesday', 700.00, '2024-08-20', '2024-08-20', 1),
(1038, 'Mrs', 'Logan', 'Fisher', '888 Oak St', 'SuburbBB', 'CityBB', '11223', 0, 'logan.fisher@email.com', 'facebook', 1, 'Wednesday', 400.00, '2024-09-15', '2024-09-15', 3),
(1039, 'Mr', 'Evelyn', 'Parker', '999 Elm St', 'SuburbCC', 'CityCC', '33445', 1, 'evelyn.parker@email.com', 'gmail', 3, 'Thursday', 550.00, '2024-10-05', '2024-10-05', 1),
(1040, 'Ms', 'Owen', 'Hayes', '1010 Cedar St', 'SuburbDD', 'CityDD', '55667', 1, 'owen.hayes@email.com', 'instagram', 2, 'Friday', 600.00, '2024-11-01', '2024-11-01', 2),
(1041, 'Mr', 'Harper', 'Bryant', '1111 Pine St', 'SuburbEE', 'CityEE', '77889', 1, 'harper.bryant@email.com', 'twitter', 4, 'Monday', 700.00, '2024-12-10', '2024-12-10', 1),
(1042, 'Mrs', 'Jordan', 'Fox', '1212 Oak St', 'SuburbFF', 'CityFF', '99001', 0, 'jordan.fox@email.com', 'self', 1, 'Tuesday', 350.00, '2025-01-20', '2025-01-20', 3),
(1049, 'Mr', 'Blake', 'Ward', '1818 Birch St', 'SuburbMM', 'CityMM', '12345', 1, 'blake.ward@email.com', 'instagram', 2, 'Friday', 600.00, '2025-02-25', '2025-02-25', 1),
(1050, 'Mrs', 'Peyton', 'Flynn', '1919 Cedar St', 'SuburbNN', 'CityNN', '23456', 1, 'peyton.flynn@email.com', 'twitter', 3, 'Monday', 550.00, '2025-03-15', '2025-03-15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` varchar(255) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `invoice_amount` decimal(10,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `customer_id`, `invoice_amount`, `invoice_date`) VALUES
('INV2402041001', 1001, 500.00, '2024-02-04'),
('INV2402041004', 1004, 400.00, '2024-02-04'),
('INV2402041005', 1005, 550.00, '2024-02-04'),
('INV2402041006', 1006, 350.00, '2024-02-04'),
('INV2402041007', 1007, 600.00, '2024-02-04'),
('INV2402041008', 1008, 450.00, '2024-02-04'),
('INV2402041009', 1009, 650.00, '2024-02-04'),
('INV2402041010', 1010, 500.00, '2024-02-04'),
('INV2402041011', 1011, 700.00, '2024-02-04'),
('INV2402041012', 1012, 400.00, '2024-02-04'),
('INV2402041030', 1030, 600.00, '2024-02-04'),
('INV2402041031', 1031, 550.00, '2024-02-04'),
('INV2402041032', 1032, 400.00, '2024-02-04'),
('INV2402041033', 1033, 650.00, '2024-02-04'),
('INV2402041034', 1034, 500.00, '2024-02-04'),
('INV2402041036', 1036, 450.00, '2024-02-04'),
('INV2402041037', 1037, 700.00, '2024-02-04'),
('INV2402041039', 1039, 550.00, '2024-02-04'),
('INV2402041040', 1040, 600.00, '2024-02-04'),
('INV2402041041', 1041, 700.00, '2024-02-04'),
('INV2402041042', 1042, 350.00, '2024-02-04'),
('INV2402041049', 1049, 600.00, '2024-02-04'),
('INV2402041050', 1050, 550.00, '2024-02-04'),
('INV2403041002', 1002, 600.00, '2024-03-04'),
('INV2403041003', 1003, 400.00, '2024-03-04'),
('INV2403041035', 1035, 1179.90, '2024-03-04'),
('INV2403041038', 1038, 680.00, '2024-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(255) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_type` enum('CASH','EFT') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `customer_id`, `payment_date`, `payment_amount`, `payment_type`) VALUES
('PMT240203CA1004', 1004, '2024-02-03 13:55:49', 745.00, 'CASH'),
('PMT240203EF1036', 1036, '2024-02-03 13:59:38', 110.30, 'EFT'),
('PMT240204CA1007', 1007, '2024-02-04 13:55:29', 179.90, 'CASH'),
('PMT240204CA1008', 1008, '2024-02-04 13:56:23', 130.00, 'CASH'),
('PMT240204CA1010', 1010, '2024-02-04 13:54:24', 360.00, 'CASH'),
('PMT240204CA1031', 1031, '2024-02-04 13:54:42', 70.00, 'CASH'),
('PMT240204CA1032', 1032, '2024-02-04 13:57:46', 1400.00, 'CASH'),
('PMT240204EF1001', 1001, '2024-02-04 13:45:27', 400.00, 'EFT'),
('PMT240204EF1003', 1003, '2024-02-04 13:45:54', 1000.00, 'EFT'),
('PMT240204EF1005', 1005, '2024-02-04 13:44:56', 550.00, 'EFT'),
('PMT240204EF1006', 1006, '2024-02-04 13:47:20', 500.00, 'EFT'),
('PMT240204EF1007', 1007, '2024-02-04 13:55:18', 420.10, 'EFT'),
('PMT240204EF1008', 1008, '2024-02-04 13:56:29', 300.00, 'EFT'),
('PMT240204EF1009', 1009, '2024-02-04 13:56:41', 100.00, 'EFT'),
('PMT240204EF1011', 1011, '2024-02-04 13:57:02', 360.00, 'EFT'),
('PMT240204EF1012', 1012, '2024-02-04 13:57:16', 120.00, 'EFT'),
('PMT240204EF1033', 1033, '2024-02-04 13:57:59', 300.00, 'EFT'),
('PMT240204EF1034', 1034, '2024-02-04 13:58:13', 110.75, 'EFT'),
('PMT240204EF1035', 1035, '2024-02-04 13:58:29', 20.10, 'EFT'),
('PMT240204EF1037', 1037, '2024-02-04 13:59:55', 379.00, 'EFT'),
('PMT240204EF1038', 1038, '2024-02-04 14:00:09', 120.00, 'EFT'),
('PMT240204EF1039', 1039, '2024-02-04 13:53:07', 304.00, 'EFT'),
('PMT240204EF1040', 1040, '2024-02-04 13:52:35', 400.00, 'EFT'),
('PMT240204EF1041', 1041, '2024-02-04 13:51:15', 300.00, 'EFT'),
('PMT240204EF1042', 1042, '2024-02-04 13:50:24', 120.00, 'EFT'),
('PMT240204EF1042-2', 1042, '2024-02-04 13:50:35', 120.00, 'EFT'),
('PMT240204EF1042-3', 1042, '2024-02-04 13:51:52', 110.00, 'EFT'),
('PMT240204EF1049', 1049, '2024-02-04 13:47:48', 120.00, 'EFT'),
('PMT240204EF1049-2', 1049, '2024-02-04 13:47:56', 350.00, 'EFT'),
('PMT240204EF1049-3', 1049, '2024-02-04 13:48:03', 130.00, 'EFT'),
('PMT240204EF1050', 1050, '2024-02-04 13:47:39', 240.00, 'EFT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bins`
--
ALTER TABLE `bins`
  ADD PRIMARY KEY (`serial_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`account_number`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);

--
-- Constraints for table `bins`
--
ALTER TABLE `bins`
  ADD CONSTRAINT `bins_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`account_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
