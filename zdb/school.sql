-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2021 at 03:32 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `level_id`, `class_name`, `status`, `teacher_id`, `course_id`) VALUES
(1, 3, '1', 1, 0, 1),
(3, 4, '1', 1, 0, 1),
(4, 5, '1', 1, 0, 1),
(5, 6, '1', 1, 0, 1),
(6, 7, '1', 1, 0, 1),
(7, 1, 'ຫ້ອງ 1', 1, 7, 1),
(8, 5, 'ຫ້ອງ 1', 1, 4, 1),
(9, 4, 'ຫ້ອງ 1', 1, 4, 1),
(10, 3, 'ຫ້ອງ 1', 1, 8, 1),
(11, 6, 'ຫ້ອງ 1', 1, 4, 1),
(12, 7, 'ຫ້ອງ 1', 1, 4, 1),
(13, 8, 'ຫ້ອງ 1', 1, 5, 5),
(14, 0, 'p5', 0, 4, 1),
(15, 1, 'p5', 0, 4, 6),
(16, 1, 'p5', 0, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `status`) VALUES
(1, 'ປໍ 3', 1),
(2, 'ປໍ 2', 1),
(3, 'ປໍ 1', 1),
(5, 'ປໍ 4', 1),
(6, 'ປໍ 5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_detail`
--

DROP TABLE IF EXISTS `course_detail`;
CREATE TABLE IF NOT EXISTS `course_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `detail_number` int(11) NOT NULL,
  `remark` text NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_detail`
--

INSERT INTO `course_detail` (`detail_id`, `course_id`, `subject_id`, `teacher_id`, `detail_number`, `remark`) VALUES
(1, 1, 3, 4, 8, 'no'),
(2, 1, 2, 4, 7, 'hoo'),
(3, 2, 3, 4, 7, 'no'),
(4, 2, 2, 4, 6, 'hoo'),
(7, 1, 7, 4, 5, ''),
(8, 1, 4, 4, 4, 'ຫັ'),
(9, 3, 3, 2, 1, 'okok'),
(10, 3, 7, 5, 1, ''),
(11, 3, 3, 2, 1, 'okok'),
(12, 3, 2, 5, 2, ''),
(13, 1, 10, 5, 1, ''),
(14, 1, 9, 5, 2, ''),
(15, 1, 8, 5, 3, ''),
(16, 1, 6, 4, 9, '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `register_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `tax` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `total` double NOT NULL,
  `remark` text,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `register_id`, `year_id`, `invoice_date`, `username`, `status`, `amount`, `tax`, `discount`, `total`, `remark`) VALUES
(1, 1, 1, '2021-02-27', 'phone', 0, 2000, 10, 20, 200000, 'no remark'),
(2, 2, 1, '2021-02-27', 'phone', 0, 2000, 10, 20, 200000, 'no remark'),
(3, 3, 1, '2021-04-27', 'phone', 0, 2000, 10, 20, 200000, 'no remark'),
(4, 2, 1, '2021-05-07', 'phone', 0, 2000, 10, 20, 200000, 'no remark'),
(5, 4, 1, '2021-03-28', 'phone', 0, 600000, 0, 0, 600000, ''),
(6, 5, 1, '2021-05-28', 'phone', 0, 600000, 0, 0, 600000, ''),
(7, 6, 1, '2021-03-28', 'phone', 0, 600000, 0, 0, 600000, ''),
(8, 7, 1, '2021-03-28', 'phone', 0, 600000, 0, 0, 600000, ''),
(9, 9, 1, '2021-03-28', 'phone', 0, 600000, 0, 0, 600000, '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

DROP TABLE IF EXISTS `invoice_detail`;
CREATE TABLE IF NOT EXISTS `invoice_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `detail_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  `last_update` date NOT NULL,
  `remark` text,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`detail_id`, `invoice_id`, `detail_name`, `status`, `quantity`, `price`, `total`, `last_update`, `remark`) VALUES
(1, 1, 'stdd', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(2, 1, 'stdd22', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(3, 2, 'stdd', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(4, 2, 'stdd22', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(5, 3, 'stdd', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(6, 3, 'stdd22', 0, 2, 200000, 400000, '2021-02-27', 'hello'),
(7, 4, 'stdd', 0, 2, 200000, 400000, '2021-03-07', 'hello'),
(8, 4, 'stdd22', 0, 2, 200000, 400000, '2021-03-07', 'hello'),
(9, 5, 'àº„à»ˆàº²àº®àº½àº™ 1 à»€àº”àº·àº­àº™', 0, 1, 600000, 600000, '2021-03-28', ''),
(10, 6, 'àº„à»ˆàº²àº®àº½àº™ 1 à»€àº”àº·àº­àº™', 0, 1, 600000, 600000, '2021-03-28', ''),
(11, 7, 'àº„à»ˆàº²àº®àº½àº™ 1 à»€àº”àº·àº­àº™', 0, 1, 600000, 600000, '2021-03-28', ''),
(12, 8, 'àº„à»ˆàº²àº®àº½àº™ 1 à»€àº”àº·àº­àº™', 0, 1, 600000, 600000, '2021-03-28', ''),
(13, 9, 'àº„à»ˆàº²àº®àº½àº™ 1 à»€àº”àº·àº­àº™', 0, 1, 600000, 600000, '2021-03-28', '');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(70) NOT NULL,
  `price` double NOT NULL,
  `next_month` int(11) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `price`, `next_month`, `remark`) VALUES
(1, 'std', 2000, 0, 'no have'),
(3, 'std2', 2000, 0, 'no have'),
(4, 'std3', 2000, 0, 'no have'),
(5, 'std4', 2000, 0, 'no have'),
(6, 'ຄ່າຮຽນ 1 ເດືອນ', 600000, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE IF NOT EXISTS `level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level_name`, `status`) VALUES
(1, 'ອະນຸບານ', 1),
(3, 'ປໍ 1', 1),
(4, 'ປໍ 2', 1),
(5, 'ປໍ 3', 1),
(6, 'ປໍ 4', 1),
(7, 'ປໍ 5', 1),
(8, 'ປໍ ກຽມ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

DROP TABLE IF EXISTS `month`;
CREATE TABLE IF NOT EXISTS `month` (
  `month_id` int(11) NOT NULL AUTO_INCREMENT,
  `month_name` varchar(50) NOT NULL,
  `month_parent` int(11) NOT NULL,
  `month_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`month_id`, `month_name`, `month_parent`, `month_number`) VALUES
(1, 'ພາກຮຽນ I', 0, 5),
(2, 'ພາກຮຽນ II', 0, 11),
(3, 'ເດືອນ 9', 1, 1),
(4, 'ເດືອນ 10', 1, 2),
(5, 'ເດືອນ 11', 1, 3),
(6, 'ເດືອນ 12', 1, 4),
(8, 'ເດືອນ 2', 2, 7),
(9, 'ເດືອນ 3', 2, 8),
(10, 'ເດືອນ 4', 2, 9),
(11, 'ເດືອນ 5', 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `register_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `year_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_payment` date NOT NULL,
  PRIMARY KEY (`register_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`register_id`, `student_id`, `class_id`, `register_date`, `year_id`, `user_id`, `date_payment`) VALUES
(1, 1, 8, '2021-02-07', 1, 2, '2025-10-11'),
(2, 7, 8, '2021-02-07', 1, 2, '2025-10-11'),
(3, 8, 9, '2021-02-07', 1, 2, '0000-00-00'),
(4, 16, 11, '2021-02-07', 1, 2, '0000-00-00'),
(5, 17, 11, '2021-02-07', 1, 2, '2021-10-10'),
(6, 18, 11, '2021-02-07', 1, 2, '2021-10-10'),
(7, 27, 13, '2021-02-13', 1, 7, '2021-02-13'),
(8, 20, 1, '2021-02-13', 1, 2, '2021-10-10'),
(9, 26, 11, '2021-03-27', 1, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `permission` text NOT NULL,
  `default_department` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `permission`, `default_department`) VALUES
(1, 'for addmin', '{\"manage\":true,\"user\":true,\"role\":true,\"product\":true,\"menu\":true,\"department\":true,\"setting\":true,\"dashbord\":true,\"sale\":true,\"change_department\":true,\"report\":true,\"report_ticket\":true,\"report_order\":true}', 8),
(3, 'for addmins2', 'add only', 1),
(4, 'for addmins3', 'add only', 1),
(5, 'for addmins546', 'insert only', 2),
(7, 'for addmins54', 'insert only', 2);

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

DROP TABLE IF EXISTS `school_year`;
CREATE TABLE IF NOT EXISTS `school_year` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` text,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`year_id`, `year_name`, `status`, `remark`) VALUES
(1, '2019-2021', 1, 'no'),
(3, '2018-2019', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `score_number` int(11) NOT NULL,
  `register_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`score_id`, `score_number`, `register_id`, `month_id`, `subject_id`) VALUES
(1, 9, 4, 3, 4),
(2, 8, 5, 3, 4),
(3, 7, 6, 3, 4),
(4, 6, 9, 3, 4),
(5, 4, 9, 3, 7),
(6, 5, 4, 3, 7),
(7, 8, 5, 3, 7),
(8, 8, 6, 3, 7),
(9, 10, 9, 3, 2),
(10, 8, 4, 3, 2),
(11, 6, 5, 3, 2),
(12, 7, 6, 3, 2),
(13, 8, 9, 3, 3),
(14, 8, 4, 3, 3),
(15, 4, 5, 3, 3),
(16, 7, 6, 3, 3),
(17, 10, 9, 3, 10),
(18, 8, 4, 3, 10),
(19, 6, 5, 3, 10),
(20, 8, 6, 3, 10),
(21, 5, 9, 4, 10),
(22, 6, 4, 4, 10),
(23, 8, 5, 4, 10),
(24, 9, 6, 4, 10),
(25, 5, 9, 5, 10),
(26, 5, 4, 5, 10),
(27, 6, 5, 5, 10),
(28, 4, 6, 5, 10),
(29, 9, 9, 6, 10),
(30, 8, 4, 6, 10),
(31, 8, 5, 6, 10),
(32, 9, 6, 6, 10),
(33, 4, 9, 1, 10),
(34, 6, 4, 1, 10),
(35, 10, 5, 1, 10),
(36, 5, 6, 1, 10),
(37, 8, 9, 3, 9),
(38, 9, 4, 3, 9),
(39, 8, 5, 3, 9),
(40, 9, 6, 3, 9),
(41, 7, 9, 4, 9),
(42, 8, 4, 4, 9),
(43, 5, 5, 4, 9),
(44, 6, 6, 4, 9),
(45, 4, 9, 5, 9),
(46, 6, 4, 5, 9),
(47, 8, 5, 5, 9),
(48, 9, 6, 5, 9),
(49, 8, 9, 3, 8),
(50, 9, 4, 3, 8),
(51, 7, 5, 3, 8),
(52, 8, 6, 3, 8),
(53, 7, 9, 4, 8),
(54, 9, 4, 4, 8),
(55, 8, 5, 4, 8),
(56, 7, 6, 4, 8),
(57, 7, 9, 5, 8),
(58, 8, 4, 5, 8),
(59, 7, 5, 5, 8),
(60, 7, 6, 5, 8),
(61, 7, 9, 6, 8),
(62, 8, 4, 6, 8),
(63, 9, 5, 6, 8),
(64, 7, 6, 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date NOT NULL,
  `birth_address` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `guardian` text NOT NULL,
  `tribes` varchar(50) NOT NULL,
  `remark` text,
  `image` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `surname`, `gender`, `birthday`, `birth_address`, `address`, `guardian`, `tribes`, `remark`, `image`, `status`) VALUES
(1, 'phone', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', NULL, NULL),
(2, 'phone', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', NULL, NULL),
(3, 'phone', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', NULL, NULL),
(4, 'phone', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', 'student-phone -1999-01-10.png', NULL),
(5, 'ພອນ', 'sdasda', '1', '1999-01-10', 'asdasdas', 'vangphamone', '{\"data\":[]}', 'ລາວສູງ', 'no', '', NULL),
(6, 'ສຸນີຕາ23', 'ວັງສຳພັນ12', '1', '1999-01-10', 'parklay', 'vangphamone', 'khamxang', 'laos', 'no', '', NULL),
(7, 'ພອນ', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', 'student-ພອນ-1999-01-10.png', NULL),
(8, 'ພອນ', '', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', 'student-ພອນ--1999-01-10.png', NULL),
(16, 'ສຸນີຕາ1', 'ວັງສຳພັນ', '1', '1999-01-10', 'asdas', 'vangphamone', '{\"data\":[]}', 'ລາວເທິງ', '', '', NULL),
(17, 'ສຸນີຕາ1', 'ວັງສຳພັນ', '1', '1999-01-10', 'wdasd', 'vangphamone', '{\"data\":[]}', 'ລາວເທິງ', 'no', '', NULL),
(18, 'ສຸນີຕາ2', 'ວັງສຳພັນ', '1', '1999-01-10', 'asd', 'vangphamone', '{\"data\":[]}', 'ລາວສູງ', 'no', '', NULL),
(19, 'ສຸນີຕາ23', 'ວັງສຳພັນ12', '1', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', 'student-ສຸນີຕາ23-ວັງສຳພັນ12-1999-01-10.png', NULL),
(20, 'ສຸນີຕາ23', 'ວັງສຳພັນ12', '0', '1999-01-10', '', 'vangphamone', 'khamxang', 'laos', 'no', 'student-ສຸນີຕາ23-ວັງສຳພັນ12-1999-01-10.png', NULL),
(21, 'ສຸນີຕາ23', 'ວັງສຳພັນ12', '0', '1999-01-10', 'parklay', 'vangphamone', 'khamxang', 'laos', 'no', 'student-ສຸນີຕາ23-ວັງສຳພັນ12-1999-01-10.png', NULL),
(22, 'ສຸນີຕາ23', 'ວັງສຳພັນ12', '0', '1999-01-10', 'parklay', 'vangphamone', 'khamxang', 'laos', 'no', '', NULL),
(23, 'ໂຊກໄຊ', 'ແກ້ວພິລາວັນ', '0', '1996-01-29', '', 'ໂພນປາເປົ້າ ເມືອງສັດຕະນາກ ນະຄອນຫຼວງວຽງຈັນ', 'Array', 'ລາວລຸ່ມ', 'ັຫກັຫ', '', NULL),
(24, 'ັຫກັຫກ', 'ັຫກັຫກັຫ', '0', '2021-01-27', '', '5555555555555555555555', 'Array', 'ລາວລຸ່ມ', 'ັຫກັຫກ', '', NULL),
(25, 'ັຫກັຫກ', 'ັຫກັຫກັ', '0', '2021-01-27', '', 'ັຫກັຫກັຫກັ', 'Array', 'ລາວລຸ່ມ', 'ັຫກັຫກ', '', NULL),
(26, 'asdasd', 'asdasdsa', '0', '2021-01-01', 'asdasdasd', 'asdasdas', '{\"data\":[{\"name\":\"sdasd\",\"job\":\"asdasd\",\"phone\":\"asdasd\",\"address\":\"asdas\"},{\"name\":\"asdasd\",\"job\":\"asdasd\",\"phone\":\"asdasd\",\"address\":\"asdasdas\"}]}', 'ລາວລຸ່ມ', '', '', NULL),
(27, 'ສຸນີຕາ2', 'ວັງສຳພັນ12', '0', '2000-01-01', 'parklay ', 'vangphamone', '{\"data\":[{\"name\":\"sdsad\",\"job\":\"asdasd\",\"phone\":\"asdas\",\"address\":\"asdas\"},{\"name\":\"asdasd\",\"job\":\"asdasd\",\"phone\":\"asdasdas\",\"address\":\"asdasd\"}]}', 'ລາວເທິງ', 'no', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `status`) VALUES
(2, 'ພາສາລາວ', 1),
(3, 'ຄະນິສາດ', 1),
(4, 'ຫັດແຕ່ງ', 1),
(5, 'ໂລກອ້ອມຕົວ', 1),
(6, 'ຫັດຂຽນງາມ', 1),
(7, 'ຫັດແຕ້ມຮູມ', 1),
(8, 'ຫັດຂຽນທວຍ', 1),
(9, 'ກີລາ', 1),
(10, 'ສິນລະປະດົນຕີ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `name`, `surname`, `gender`, `birthday`, `address`, `phonenumber`, `status`, `image`) VALUES
(4, 'nono', 'ນາຍຍົກ', 'male', '1999-01-10', 'vangphamone', '0202156469871', 1, 'student-nono-ນາຍຍົກ-1999-01-10.jpeg'),
(5, 'ສຸນີຕາ1', 'ວັງສຳພັນ', 'female', '1999-01-10', 'vangphamone', '0205654142354', 1, 'student-ສຸນີຕາ1-ວັງສຳພັນ-1999-01-10.jpeg'),
(6, 'ສຸນີຕາ1', 'ວັງສຳພັນ', 'female', '1999-01-10', 'vangphamone', '0205654142354', 1, 'student-ສຸນີຕາ1-ວັງສຳພັນ-1999-01-10.jpeg'),
(7, 'ຈັນໃດ', 'ວັງສຳພັນ', '1', '1999-01-10', 'vangphamoneຫັກັຫກ', '0205654142354', 77777777, ''),
(8, 'ອຳພອນ ກກກ', 'ແກ້ວພືມພາ', '1', '2021-02-01', 'ດອນກອຍ ເມືອງສີສັດຕະນາກ ນະຄອງຫຼວງວຽງຈັນ', '77455669', 77455669, 'student-ອຳພອນ ກກກ-ແກ້ວພືມພາ-2021-02-01.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `remark` text,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `username`, `password`, `status`, `remark`, `role_id`) VALUES
(1, 'phone', 'admin', '123456', 1, 'no', 1),
(3, 'phone', 'user5', '123456', 1, 'no', 0),
(5, 'phone', 'aasa', 'aaaaaasaa', 1, 'no', 1),
(6, 'phone', 'aasasal', 'aaaaaasaas', 1, 'no', 1),
(7, 'phone', 'aasasal1', 'aaaaaasaas', 1, 'no', 1),
(8, 'phone', 'aasasal2', 'aaaaaasaas', 1, 'no', 1),
(9, 'phone', 'aasasal3', 'aaaaaasaas', 1, 'no', 1),
(10, 'phone', 'aasasa4', 'aaaaaasaas', 1, 'no', 1),
(11, 'phone', 'aasasa5', 'aaaaaasaas', 1, 'no', 1),
(12, 'phone', 'aasasa6', 'aaaaaasaas', 1, 'no', 1),
(13, 'phone', 'aasasa7', 'aaaaaasaas', 1, 'no', 1),
(14, 'phone', 'aasasa8', 'aaaaaasaas', 1, 'no', 1),
(15, 'phone', 'aasasa9', 'aaaaaasaas', 1, 'no', 1),
(16, 'phone', 'aasasa10', 'aaaaaasaas', 1, 'no', 1),
(17, 'phone', 'aasasa111', 'aaaaaasaas', 1, 'no', 1),
(18, 'da', 'asa', 'asasadfdfdf', 0, 'ada', 5),
(19, 'dfdfd', 'dfdf', 'dfdfdfdfdf', 1, 'dfdfdf', 4),
(20, 'sdsd', 'sdsdsds', 'sdsdsdsdsd', 0, 'sdsds', 5),
(21, 'sdsd', 'sdsds', 'sdsdsds', 1, 'sd', 5),
(22, 'sds', 'sdsd', 'ssdsdsd', 1, 'sds', 5),
(23, 'sdsd', 'adadad', 'asddadad', 1, 'dsadasd', 4),
(24, '222', '222332ewwewe', 'dsdsdsdsds', 0, '22', 1),
(25, 'phone', 'aasasa', 'aaaaaasaas', 1, 'no', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
