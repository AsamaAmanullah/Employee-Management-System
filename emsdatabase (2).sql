-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2024 at 08:57 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emsdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountdetails`
--

DROP TABLE IF EXISTS `accountdetails`;
CREATE TABLE IF NOT EXISTS `accountdetails` (
  `Acc_ID` int NOT NULL AUTO_INCREMENT,
  `Acc_No` decimal(20,0) DEFAULT NULL,
  `Branch` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bank_ID` int DEFAULT NULL,
  `EMP_ID` int DEFAULT NULL,
  PRIMARY KEY (`Acc_ID`),
  KEY `EMP_ID` (`EMP_ID`),
  KEY `Bank_ID` (`Bank_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accountdetails`
--

INSERT INTO `accountdetails` (`Acc_ID`, `Acc_No`, `Branch`, `Bank_ID`, `EMP_ID`) VALUES
(1, 201200110017666, NULL, 1, 1),
(2, 207200165900279, NULL, 1, 2),
(3, 2620012569845, NULL, 1, NULL),
(4, 8090002486, NULL, 14, NULL),
(5, 2678954621, NULL, 14, NULL),
(6, 2678954621, NULL, 31, NULL),
(7, 8080006357, NULL, 1, 9),
(8, 8080006359, NULL, 10, 10),
(9, 262000536985, NULL, 27, 11),
(10, 262000568456, NULL, 27, 20),
(11, 2620025689, NULL, 27, 21),
(19, 26200345632, 'Anuradhapura', 27, 30);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Date` date DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Arrival_time` time DEFAULT NULL,
  `Leave_time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `EMP_ID` int DEFAULT NULL,
  `member_no` varchar(50) DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=376 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `Date`, `Name`, `Arrival_time`, `Leave_time`, `status`, `EMP_ID`, `member_no`, `attendance_date`) VALUES
(273, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-03'),
(272, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-03'),
(271, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-03'),
(270, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-03'),
(269, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-03'),
(268, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-03'),
(267, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-03'),
(266, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-03'),
(265, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-03'),
(264, NULL, NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-03'),
(14, '2024-07-06', 'K.G.H Ramyalatha', '08:00:00', '16:00:00', 'Present', 1, '201', NULL),
(15, '2024-07-06', 'Wimala K.D.H.U.P', '08:00:00', '16:00:00', 'Present', 10, '321', NULL),
(16, '2024-07-06', 'Anoma Pathirana', '08:00:00', '16:00:00', 'Present', 11, '300', NULL),
(17, '2024-07-06', 'kamala Perera', '08:00:00', '16:00:00', 'Present', 18, '111', NULL),
(18, '2024-07-06', 'S.E. Himali', '08:00:00', '16:00:00', 'Present', 19, '1', NULL),
(19, '2024-07-06', 'Sisira  Kumara', '08:00:00', '16:00:00', 'Present', 20, '298', NULL),
(20, '2024-07-06', 'Anula piris', '08:00:00', '16:00:00', 'Present', 21, '222', NULL),
(21, '2024-07-06', 'Danuki amaya', '08:00:00', '16:00:00', 'Present', 30, '210', NULL),
(22, '2024-07-06', 'B.D Abekon Banda', '08:00:00', '16:00:00', 'Present', 2, '93', NULL),
(23, '2024-07-06', 'Kamalawathi Piris', '08:00:00', '16:00:00', 'Present', 7, '205', NULL),
(24, '2024-07-06', 'Wimal K.D.P', '08:00:00', '16:00:00', 'Present', 9, '320', NULL),
(25, '2024-07-05', 'K.G.H Ramyalatha', '08:00:00', '12:00:00', 'Present', 1, '201', NULL),
(26, '2024-07-05', 'B.D Abekon Banda', '08:00:00', '12:00:00', 'Present', 2, '93', NULL),
(27, '2024-07-05', 'Kamalawathi Piris', '08:00:00', '12:00:00', 'Present', 7, '205', NULL),
(28, '2024-07-05', 'Wimal K.D.P', '08:00:00', '12:00:00', 'Present', 9, '320', NULL),
(29, '2024-07-05', 'Wimala K.D.H.U.P', '08:00:00', '12:00:00', 'Present', 10, '321', NULL),
(30, '2024-07-05', 'Anoma Pathirana', '08:00:00', '12:00:00', 'Present', 11, '300', NULL),
(31, '2024-07-05', 'kamala Perera', '08:00:00', '12:00:00', 'Present', 18, '111', NULL),
(32, '2024-07-05', 'S.E. Himali', '08:00:00', '12:00:00', 'Present', 19, '1', NULL),
(33, '2024-07-05', 'Sisira  Kumara', NULL, NULL, 'Absent', 20, '298', NULL),
(34, '2024-07-05', 'Anula piris', NULL, NULL, 'Absent', 21, '222', NULL),
(35, '2024-07-05', 'Danuki amaya', NULL, NULL, 'Absent', 30, '210', NULL),
(295, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-04'),
(294, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-04'),
(293, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-04'),
(292, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-04'),
(291, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-04'),
(290, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-04'),
(289, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-04'),
(288, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-04'),
(287, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-04'),
(286, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-04'),
(285, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-04'),
(58, '2024-07-02', 'Danuki amaya', '08:00:00', '16:00:00', 'Present', 30, '210', NULL),
(59, '2024-07-02', 'K.G.H Ramyalatha', '08:00:00', '16:00:00', 'Present', 1, '201', NULL),
(60, '2024-07-02', 'S.E. Himali', '08:00:00', '16:00:00', 'Present', 19, '1', NULL),
(61, '2024-07-02', 'Anula piris', '08:00:00', '16:00:00', 'Present', 21, '222', NULL),
(62, '2024-07-02', 'B.D Abekon Banda', '08:00:00', '16:00:00', 'Present', 2, '93', NULL),
(63, '2024-07-02', 'kamala Perera', '08:00:00', '16:00:00', 'Present', 18, '111', NULL),
(64, '2024-07-02', 'Sisira  Kumara', '08:00:00', '16:00:00', 'Present', 20, '298', NULL),
(65, '2024-07-02', 'Kamalawathi Piris', '08:00:00', '16:00:00', 'Present', 7, '205', NULL),
(66, '2024-07-02', 'Wimal K.D.P', '08:00:00', '16:00:00', 'Present', 9, '320', NULL),
(67, '2024-07-02', 'Wimala K.D.H.U.P', '08:00:00', '16:00:00', 'Present', 10, '321', NULL),
(68, '2024-07-02', 'Anoma Pathirana', '08:00:00', '16:00:00', 'Present', 11, '300', NULL),
(70, '2024-07-01', 'K.G.H Ramyalatha', '08:00:00', '16:00:00', 'Present', 1, '201', NULL),
(71, '2024-07-01', 'S.E. Himali', '08:00:00', '16:00:00', 'Present', 19, '1', NULL),
(72, '2024-07-01', 'Anula piris', '08:00:00', '16:00:00', 'Present', 21, '222', NULL),
(73, '2024-07-01', 'B.D Abekon Banda', '08:00:00', '16:00:00', 'Present', 2, '93', NULL),
(74, '2024-07-01', 'kamala Perera', '08:00:00', '16:00:00', 'Present', 18, '111', NULL),
(75, '2024-07-01', 'Sisira  Kumara', '08:00:00', '16:00:00', 'Present', 20, '298', NULL),
(76, '2024-07-01', 'Kamalawathi Piris', '08:00:00', '16:00:00', 'Present', 7, '205', NULL),
(77, '2024-07-01', 'Wimal K.D.P', '08:00:00', '16:00:00', 'Present', 9, '320', NULL),
(78, '2024-07-01', 'Wimala K.D.H.U.P', '08:00:00', '16:00:00', 'Present', 10, '321', NULL),
(79, '2024-07-01', 'Anoma Pathirana', '08:00:00', '16:00:00', 'Present', 11, '300', NULL),
(233, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(232, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(231, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(230, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(229, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(228, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(227, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(226, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(225, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(224, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(223, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(91, '2024-07-10', 'Danuki amaya', '08:00:00', '12:00:00', 'Present', 30, '210', NULL),
(92, '2024-07-10', 'K.G.H Ramyalatha', '08:00:00', '12:00:00', 'Present', 1, '201', NULL),
(93, '2024-07-10', 'S.E. Himali', '08:00:00', '12:00:00', 'Present', 19, '1', NULL),
(94, '2024-07-10', 'Anula piris', '08:00:00', '12:00:00', 'Present', 21, '222', NULL),
(95, '2024-07-10', 'B.D Abekon Banda', '08:00:00', '12:00:00', 'Present', 2, '93', NULL),
(96, '2024-07-10', 'kamala Perera', '08:00:00', '12:00:00', 'Present', 18, '111', NULL),
(97, '2024-07-10', 'Sisira  Kumara', '08:00:00', '16:00:00', 'Present', 20, '298', NULL),
(98, '2024-07-10', 'Kamalawathi Piris', '08:00:00', '16:00:00', 'Present', 7, '205', NULL),
(99, '2024-07-10', 'Wimal K.D.P', '08:00:00', '16:00:00', 'Present', 9, '320', NULL),
(100, '2024-07-10', 'Wimala K.D.H.U.P', '08:00:00', '16:00:00', 'Present', 10, '321', NULL),
(101, '2024-07-10', 'Anoma Pathirana', '08:00:00', '16:00:00', 'Present', 11, '300', NULL),
(263, NULL, NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-03'),
(113, '2024-07-12', 'Danuki amaya', '08:00:00', '16:00:00', 'Present', 30, '210', NULL),
(114, '2024-07-12', 'K.G.H Ramyalatha', '08:00:00', '16:00:00', 'Present', 1, '201', NULL),
(115, '2024-07-12', 'S.E. Himali', '08:00:00', '16:00:00', 'Present', 19, '1', NULL),
(116, '2024-07-12', 'Anula piris', '08:00:00', '16:00:00', 'Present', 21, '222', NULL),
(117, '2024-07-12', 'B.D Abekon Banda', '08:00:00', '16:00:00', 'Present', 2, '93', NULL),
(118, '2024-07-12', 'kamala Perera', '08:00:00', '16:00:00', 'Present', 18, '111', NULL),
(119, '2024-07-12', 'Sisira  Kumara', '08:00:00', '16:00:00', 'Present', 20, '298', NULL),
(120, '2024-07-12', 'Kamalawathi Piris', '08:00:00', '16:00:00', 'Present', 7, '205', NULL),
(121, '2024-07-12', 'Wimal K.D.P', '08:00:00', '16:00:00', 'Present', 9, '320', NULL),
(122, '2024-07-12', 'Wimala K.D.H.U.P', '08:00:00', '16:00:00', 'Present', 10, '321', NULL),
(123, '2024-07-12', 'Anoma Pathirana', '08:00:00', '16:00:00', 'Present', 11, '300', NULL),
(135, NULL, NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, '2024-06-01'),
(136, NULL, NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, '2024-06-01'),
(137, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-06-01'),
(138, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-06-01'),
(139, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-06-01'),
(140, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-06-01'),
(141, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-06-01'),
(142, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-06-01'),
(143, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-06-01'),
(144, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-06-01'),
(145, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-06-01'),
(146, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-06-03'),
(147, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-06-03'),
(148, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-06-03'),
(149, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-06-03'),
(150, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-06-03'),
(151, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-06-03'),
(152, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-06-03'),
(153, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-06-03'),
(154, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-06-03'),
(155, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-06-03'),
(156, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-06-03'),
(157, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-06-03'),
(158, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-06-03'),
(159, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-06-03'),
(160, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-06-03'),
(161, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-06-03'),
(162, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-06-03'),
(163, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-06-03'),
(164, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-06-03'),
(165, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-06-03'),
(166, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-06-03'),
(167, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-06-03'),
(168, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-06-03'),
(169, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-06-03'),
(170, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-06-03'),
(171, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-06-03'),
(172, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-06-03'),
(173, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-06-03'),
(174, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-06-03'),
(175, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-06-03'),
(176, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-06-03'),
(177, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-06-03'),
(178, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-06-03'),
(179, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-08'),
(180, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-08'),
(181, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-08'),
(182, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-08'),
(183, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-08'),
(184, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-08'),
(185, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-08'),
(186, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-08'),
(187, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-08'),
(188, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-08'),
(189, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-08'),
(190, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-01'),
(191, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-01'),
(192, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-01'),
(193, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-01'),
(194, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-01'),
(195, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-01'),
(196, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-01'),
(197, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-01'),
(198, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-01'),
(199, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-01'),
(200, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-01'),
(201, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-09'),
(202, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-09'),
(203, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(204, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(205, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(206, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(207, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(208, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(209, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(210, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(211, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(212, NULL, NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-09'),
(213, NULL, NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-09'),
(214, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(215, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(216, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(217, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(218, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(219, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(220, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(221, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(222, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(234, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(235, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(236, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(237, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(238, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(239, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(240, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(241, NULL, NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-09'),
(242, NULL, NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-09'),
(243, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(244, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(245, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(246, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(247, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(248, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(249, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(250, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(251, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(252, NULL, NULL, '08:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-09'),
(253, NULL, NULL, '08:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-09'),
(254, NULL, NULL, '08:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(255, NULL, NULL, '08:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(256, NULL, NULL, '08:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(257, NULL, NULL, '08:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(258, NULL, NULL, '08:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(259, NULL, NULL, '08:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(260, NULL, NULL, '08:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(261, NULL, NULL, '08:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(262, NULL, NULL, '08:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(274, NULL, NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, '2024-07-09'),
(275, NULL, NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, '2024-07-09'),
(276, NULL, NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, '2024-07-09'),
(277, NULL, NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, '2024-07-09'),
(278, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-09'),
(279, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-09'),
(280, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-09'),
(281, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-09'),
(282, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-09'),
(283, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-09'),
(284, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-09'),
(296, NULL, NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, '2024-07-04'),
(297, NULL, NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, '2024-07-04'),
(298, NULL, NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, '2024-07-04'),
(299, NULL, NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, '2024-07-04'),
(300, NULL, NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, '2024-07-04'),
(301, NULL, NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, '2024-07-04'),
(302, NULL, NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, '2024-07-04'),
(303, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, NULL),
(304, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, NULL),
(305, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, NULL),
(306, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, NULL),
(307, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, NULL),
(308, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, NULL),
(309, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, NULL),
(310, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, NULL),
(311, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, NULL),
(375, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 11, NULL, NULL),
(374, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 10, NULL, NULL),
(373, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 9, NULL, NULL),
(372, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 7, NULL, NULL),
(371, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 20, NULL, NULL),
(370, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 18, NULL, NULL),
(369, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 2, NULL, NULL),
(368, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 21, NULL, NULL),
(367, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 19, NULL, NULL),
(366, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 1, NULL, NULL),
(365, '2024-07-09', '', '20:00:00', '16:00:00', 'Present', 30, NULL, NULL),
(334, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, NULL),
(335, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, NULL),
(336, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, NULL),
(337, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, NULL),
(338, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, NULL),
(339, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, NULL),
(340, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, NULL),
(341, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, NULL),
(342, '2024-07-04', NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, NULL),
(364, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 11, NULL, NULL),
(363, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 10, NULL, NULL),
(362, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 9, NULL, NULL),
(361, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 7, NULL, NULL),
(360, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 20, NULL, NULL),
(359, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 18, NULL, NULL),
(358, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 2, NULL, NULL),
(357, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 21, NULL, NULL),
(356, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 19, NULL, NULL),
(355, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 1, NULL, NULL),
(354, '2024-07-09', NULL, '20:00:00', '16:00:00', 'Present', 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bankdetails`
--

DROP TABLE IF EXISTS `bankdetails`;
CREATE TABLE IF NOT EXISTS `bankdetails` (
  `Bank_ID` int NOT NULL AUTO_INCREMENT,
  `Bank_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Bank_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bankdetails`
--

INSERT INTO `bankdetails` (`Bank_ID`, `Bank_Name`) VALUES
(1, 'Amana Bank PLC'),
(2, 'Asia Asset Finance PLC'),
(3, 'Axis Bank'),
(4, 'Bank of Ceylon'),
(5, 'Cargills Bank limited'),
(6, 'ICICI Bank Ltd'),
(7, 'Central Finance PLC'),
(8, 'Citi Bank'),
(9, 'Citizen Development Business Finance PLC'),
(10, 'Commercial Bank PLC'),
(11, 'Commercial Credit & Finance PLC'),
(12, 'Commercial Leasing and Finance'),
(13, 'Deutsche Bank'),
(14, 'DFCC Bank PLC'),
(15, 'Dialog Finance PLC'),
(16, 'Fintrex Finance Limited'),
(17, 'Habib Bank Ltd'),
(18, 'Hatton National Bank PLC'),
(19, 'HDFC Bank'),
(20, 'Lanka Orix Finance PLC'),
(21, 'LB Finance PLC'),
(22, 'MCB Bank'),
(23, 'National Development Bank PLC'),
(24, 'National Savings Bank'),
(25, 'Nations Trust Bank PLC'),
(26, 'Pan Asia Banking Cooporation PLC'),
(27, 'Peoples Bank'),
(28, 'Peoples Leasing $ Finance PLC'),
(29, 'Regional Development Bank'),
(30, 'Richard Pieris Finance PLC'),
(31, 'Sampath Bank PLC'),
(32, 'Sanasa Development Bank'),
(33, 'Sarvodaya Development Finance'),
(34, 'Seylan Bank PLC'),
(35, 'Sri Lanka Operations Public Bank'),
(36, 'No bank selected');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `Category_ID` varchar(20) NOT NULL,
  `Category_Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Category_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `Category_Name`) VALUES
('1', 'Liquid'),
('2', 'Washes'),
('3', 'Brooms'),
('4', 'Brushes'),
('5', 'Cleaners'),
('6', 'Polish');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `EMP_ID` int NOT NULL AUTO_INCREMENT,
  `Member_No` int NOT NULL,
  `F_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `L_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NIC` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mobile` int DEFAULT NULL,
  `Gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Position_ID` int DEFAULT NULL,
  `work_ID` int DEFAULT NULL,
  `Pay_ID` int DEFAULT NULL,
  `Bank_ID` int DEFAULT NULL,
  PRIMARY KEY (`EMP_ID`),
  KEY `Pay_ID` (`Pay_ID`),
  KEY `Position_ID` (`Position_ID`),
  KEY `work_ID` (`work_ID`),
  KEY `Bank_ID` (`Bank_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EMP_ID`, `Member_No`, `F_name`, `L_name`, `NIC`, `Mobile`, `Gender`, `Address`, `DOB`, `Position_ID`, `work_ID`, `Pay_ID`, `Bank_ID`) VALUES
(1, 201, 'K.G.H', 'Ramyalatha', '746211520V', 76359659, 'Female', 'Mathale', '1974-02-02', 3, 1, 1, NULL),
(2, 93, 'B.D', 'Abekon Banda', '196723501570', 712365699, 'Male', 'Kurunegala', '1967-03-03', 2, 6, 1, NULL),
(7, 205, 'Kamalawathi', 'Piris', '959542681V', 778542361, 'Male', 'Kurunegala', '1995-12-12', 1, 8, 2, NULL),
(9, 320, 'Wimal', 'K.D.P', '199825631254', 776934187, 'Male', 'Trincomalee', '1998-01-15', 2, 8, 1, NULL),
(10, 321, 'Wimala', 'K.D.H.U.P', '199825631253', 774564522, 'Female', 'Trincomalee', '1999-05-07', 1, 8, 2, 10),
(11, 300, 'Anoma', 'Pathirana', '636082923V', 772365448, 'Female', 'Trincomalee', '1963-05-12', 2, 8, 2, 27),
(18, 111, 'kamala', 'Perera', '622565238V', 715695363, 'Female', 'Kurunegala', '1962-12-12', 1, 6, 1, 36),
(19, 1, 'S.E.', 'Himali', '742563472V', 772646654, 'Female', '37 1/2, Mile post, Anuradhapura', '1974-09-04', 4, 1, 3, 36),
(20, 298, 'Sisira ', 'Kumara', '616082923V', 713490919, 'Male', 'Kurunegala', '1961-09-03', 1, 6, 2, 27),
(21, 222, 'Anula', 'piris', '613686254V', 713496256, 'Female', 'Anuradhapura', '1996-02-04', 2, 5, 2, 27),
(30, 210, 'Danuki', 'amaya', '635695632V', 763696885, 'Male', 'Anuradhapura', '1963-01-02', 2, NULL, 2, 27);

-- --------------------------------------------------------

--
-- Table structure for table `emp_leaves`
--

DROP TABLE IF EXISTS `emp_leaves`;
CREATE TABLE IF NOT EXISTS `emp_leaves` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `EMP_ID` int DEFAULT NULL,
  `leave_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `leave_duration` enum('Half Day','Full Day') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Position_id` int DEFAULT NULL,
  PRIMARY KEY (`leave_id`),
  KEY `Position_id` (`Position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emp_leaves`
--

INSERT INTO `emp_leaves` (`leave_id`, `EMP_ID`, `leave_type`, `from_date`, `to_date`, `leave_duration`, `notes`, `submission_date`, `Position_id`) VALUES
(1, 1, 'Sick Leave', '2024-05-01', '2024-05-03', 'Full Day', 'asd', '2024-05-20 02:03:29', 3),
(3, 9, 'Sick Leave', '2024-05-04', '2024-05-05', 'Full Day', 'Sick', '2024-05-04 11:43:12', 2),
(7, 11, 'Sick Leave', '2024-05-04', '2024-05-04', 'Half Day', 'Half Day', '2024-05-04 12:01:16', 1),
(8, NULL, 'Sick Leave', '2024-06-04', '2024-06-07', 'Half Day', 'no note', '2024-06-02 12:30:08', 0),
(9, NULL, 'Sick Leave', '2024-06-10', '2024-06-12', 'Full Day', 'ABC note', '2024-06-02 12:32:18', 0),
(10, NULL, 'Sick Leave', '2024-06-17', '2024-06-19', 'Half Day', 'hi hi hi.....', '2024-06-02 12:36:04', 1),
(11, NULL, NULL, '2024-06-04', '2024-06-18', 'Half Day', 'fgfdg', '2024-06-02 12:41:28', 1),
(12, NULL, 'Sick Leave', '2024-06-04', '2024-06-18', 'Half Day', 'gdg', '2024-06-02 12:41:51', 1),
(13, 14, 'k', '2024-06-11', '2024-06-21', 'Half Day', 'hfhc', '2024-06-02 15:32:43', 45),
(14, 10, 'Sick Leave', '2024-06-01', '2024-06-04', 'Half Day', '147', '2024-06-02 15:35:00', 1),
(15, 10, 'Sick Leave', '2024-06-03', '2024-06-04', 'Full Day', 'dfbzsnfddb', '2024-06-02 15:35:55', 1),
(16, 10, 'Sick Leave', '2024-06-04', '2024-06-05', 'Half Day', 'hfh', '2024-06-02 15:41:38', 1),
(17, 10, 'Sick Leave', '2024-06-04', '2024-06-05', 'Half Day', '', '2024-06-02 15:44:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `Tool_ID` int NOT NULL AUTO_INCREMENT,
  `Tool_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Price` double DEFAULT NULL,
  `Quantity` int DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `report_ID` int DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  `Category_ID` int DEFAULT NULL,
  PRIMARY KEY (`Tool_ID`),
  KEY `report_ID` (`report_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Tool_ID`, `Tool_name`, `Price`, `Quantity`, `purchase_date`, `report_ID`, `deleted_date`, `Category_ID`) VALUES
(1, 'Cair Broom', 1000, 10, '2022-12-13', 1, NULL, NULL),
(2, 'Plastic Broom', 3000, 7, '2022-11-23', 2, NULL, NULL),
(3, 'Eakle', 2003, 7, '2024-07-09', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE IF NOT EXISTS `leaves` (
  `L_ID` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (`L_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`L_ID`, `description`, `count`) VALUES
('L12', 'Sick Leave', 3),
('L13', 'casual leave', 2),
('L14', 'Sick Leave', 1);

-- --------------------------------------------------------

--
-- Table structure for table `paymethod`
--

DROP TABLE IF EXISTS `paymethod`;
CREATE TABLE IF NOT EXISTS `paymethod` (
  `Pay_ID` int NOT NULL,
  `Pay_method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Pay_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paymethod`
--

INSERT INTO `paymethod` (`Pay_ID`, `Pay_method`) VALUES
(1, 'By Cash'),
(2, 'By Deposit'),
(3, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

DROP TABLE IF EXISTS `payroll`;
CREATE TABLE IF NOT EXISTS `payroll` (
  `id` int NOT NULL AUTO_INCREMENT,
  `EMP_ID` int DEFAULT NULL,
  `total_working_days` int DEFAULT NULL,
  `total_deduction` decimal(10,2) DEFAULT NULL,
  `other_earnings` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `EMP_ID` (`EMP_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `EMP_ID`, `total_working_days`, `total_deduction`, `other_earnings`, `tax_amount`, `net_salary`, `created_at`) VALUES
(2, 10, 0, 455.00, 789.00, 22.00, 312.00, '2024-06-08 22:38:33'),
(3, 11, 29, 2.00, 1.00, 5.00, 21744.00, '2024-06-08 22:39:36'),
(4, 10, 29, 200.00, 1500.00, 100.00, 30200.00, '2024-06-09 00:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `payrollsheet`
--

DROP TABLE IF EXISTS `payrollsheet`;
CREATE TABLE IF NOT EXISTS `payrollsheet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2407 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrollsheet`
--

INSERT INTO `payrollsheet` (`id`, `title`, `from_date`, `to_date`, `create_at`, `update_at`) VALUES
(2406, 'hi hi', '2024-06-01', '2024-06-20', '2024-06-06 06:50:02', '2024-06-06 06:50:02'),
(2301, 'abc', '2024-06-01', '2024-06-30', '2024-06-06 11:03:35', '2024-06-06 11:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `Position_ID` int NOT NULL,
  `Position_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Position_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`Position_ID`, `Position_name`, `salary`) VALUES
(1, 'Supervisor', 1000.00),
(2, 'Labour', 750.00),
(3, 'Accountant', 900.00),
(4, 'Admin', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
CREATE TABLE IF NOT EXISTS `report` (
  `report_ID` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  PRIMARY KEY (`report_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_ID`, `name`, `issue_date`) VALUES
(1, 'Surface Cleaning Tools Report', '2022-12-31'),
(2, 'Floor Cleaning Tools Report', '2022-11-30'),
(3, 'Salary', '2023-01-31'),
(4, 'Attendance', '2023-08-30');

-- --------------------------------------------------------

--
-- Table structure for table `saved_reports`
--

DROP TABLE IF EXISTS `saved_reports`;
CREATE TABLE IF NOT EXISTS `saved_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_title` varchar(255) NOT NULL,
  `report_content` text NOT NULL,
  `saved_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saved_reports`
--

INSERT INTO `saved_reports` (`id`, `report_title`, `report_content`, `saved_datetime`, `created_at`) VALUES
(1, 'as', '<div style=\"text-align: center; margin-bottom: 20px;\"><img src=\"icons/logo.jpeg\" alt=\"Company Logo\" style=\"height: 100px;\"><h1>Himali janitorial service</h1><p>No 37 1/2 Post Mahabulankulama Anuradhapura</p><p>Email: Himalijanitorialservice@gmail.com</p><p>Telephone: +94 77 264 6654</p></div><h2 style=\"text-align: center; margin-bottom: 20px;\">as</h2><p><strong>Report Date:</strong> 2024-07-08 15:54:24</p><p><strong>Supervisor:</strong> Malshi Rathnayake</p><p>Email: Malshi.@Himalijanitorialservice@gmail.com</p><p>Telephone: +94 987 654 321</p><table class=\"table table-bordered mt-4\"><thead class=\"thead-dark\"><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead><tbody></tbody></table><div style=\"margin-top: 50px; text-align: right;\"><p>Supervisor Signature:</p><img src=\"supervisor_sign.png\" alt=\"Supervisor Signature\" style=\"height: 50px;\"></div>', '2024-07-08 15:54:24', '2024-07-08 15:54:24'),
(2, 'w', '<div style=\"text-align: center; margin-bottom: 20px;\"><img src=\"icons/logo.jpeg\" alt=\"Company Logo\" style=\"height: 100px;\"><h1>Himali janitorial service</h1><p>No 37 1/2 Post Mahabulankulama Anuradhapura</p><p>Email: Himalijanitorialservice@gmail.com</p><p>Telephone: +94 77 264 6654</p></div><h2 style=\"text-align: center; margin-bottom: 20px;\">w</h2><p><strong>Report Date:</strong> 2024-07-08 15:54:42</p><p><strong>Supervisor:</strong> Malshi Rathnayake</p><p>Email: Malshi.@Himalijanitorialservice@gmail.com</p><p>Telephone: +94 987 654 321</p><table class=\"table table-bordered mt-4\"><thead class=\"thead-dark\"><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead><tbody></tbody></table><div style=\"margin-top: 50px; text-align: right;\"><p>Supervisor Signature:</p><img src=\"supervisor_sign.png\" alt=\"Supervisor Signature\" style=\"height: 50px;\"></div>', '2024-07-08 15:54:42', '2024-07-08 15:54:42'),
(3, 'm', '<div style=\"text-align: center; margin-bottom: 20px;\"><img src=\"icons/logo.jpeg\" alt=\"Company Logo\" style=\"height: 100px;\"><h1>Himali janitorial service</h1><p>No 37 1/2 Post Mahabulankulama Anuradhapura</p><p>Email: Himalijanitorialservice@gmail.com</p><p>Telephone: +94 77 264 6654</p></div><h2 style=\"text-align: center; margin-bottom: 20px;\">m</h2><p><strong>Report Date:</strong> 2024-07-09 01:19:17</p><p><strong>Supervisor:</strong> Malshi Rathnayake</p><p>Email: Malshi.@Himalijanitorialservice@gmail.com</p><p>Telephone: +94 987 654 321</p><table class=\"table table-bordered mt-4\"><thead class=\"thead-dark\"><tr><th>Tool ID</th><th>Tool Name</th><th>Price</th><th>Quantity</th><th>Purchase Date</th></tr></thead><tbody></tbody></table><div style=\"margin-top: 50px; text-align: right;\"><p>Supervisor Signature:</p><img src=\"supervisor_sign.png\" alt=\"Supervisor Signature\" style=\"height: 50px;\"></div>', '2024-07-09 01:19:17', '2024-07-09 01:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_ID` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EMP_ID` int DEFAULT NULL,
  PRIMARY KEY (`user_ID`),
  KEY `user_ibfk_1` (`EMP_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `UserName`, `Password`, `EMP_ID`) VALUES
('1', 'Admin1', 'Admin1', 19),
('', 'wimala11', '456', 9),
('2', '1', '1', 1),
('3', '3', '3', 7),
('4', '4', '4', 19);

-- --------------------------------------------------------

--
-- Table structure for table `workplace`
--

DROP TABLE IF EXISTS `workplace`;
CREATE TABLE IF NOT EXISTS `workplace` (
  `work_ID` int NOT NULL AUTO_INCREMENT,
  `Work_Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Work_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `No_of_workers` int NOT NULL,
  `Person_in_charge_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Person_in_charge_telephone` int DEFAULT NULL,
  PRIMARY KEY (`work_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workplace`
--

INSERT INTO `workplace` (`work_ID`, `Work_Address`, `Work_name`, `No_of_workers`, `Person_in_charge_name`, `Person_in_charge_telephone`) VALUES
(1, 'Anuradhapura Town', 'Main Branch', 0, 'H.E.Himali', 713490948),
(2, 'Main street, Matale', 'Telecom - Mathale', 0, 'K.Siriwardhana', 777885263),
(4, 'Hospital Road, Mannar', 'CEB - Mannar', 0, NULL, NULL),
(5, '249 B, Rex Building, Main St, Anuradhapura', 'Toyota - Anuradhapura', 0, NULL, NULL),
(6, 'Kandy Road, Kurunegala', 'Telecom - Kurunegala', 0, NULL, NULL),
(7, 'Thisa wewa, Anuradhapura', 'Water board - Thisa wewa', 0, NULL, NULL),
(8, 'Inner harbour Road, Trincomalee', 'Telecom - Trincomalee', 15, 'K.Amala', 715623856),
(9, 'Naddukka, Mannar', 'Thambapavani Wind farm - Mannar', 0, 'K.G.Piris', 715263859),
(10, 'Town Road, Anuradhapura', 'Telecom - Anuradhapura', 10, 'A.M.Dayan', 772226445);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
