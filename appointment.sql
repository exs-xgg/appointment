-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2019 at 07:12 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_date` date NOT NULL,
  `appointment_start_time` time NOT NULL,
  `appointment_end_time` time NOT NULL,
  `appointment_client_id` int(11) NOT NULL,
  `appointment_dentist_id` int(11) NOT NULL,
  `appointment_service_id` int(11) NOT NULL,
  `appointment_notes` varchar(180) CHARACTER SET latin1 DEFAULT NULL,
  `appointment_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `appointment_show_up` tinyint(1) NOT NULL DEFAULT '0',
  `appointment_cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `appointment_sms_notification` tinyint(1) NOT NULL DEFAULT '0',
  `appointment_timestamp` datetime NOT NULL,
  PRIMARY KEY (`appointment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `appointment_date`, `appointment_start_time`, `appointment_end_time`, `appointment_client_id`, `appointment_dentist_id`, `appointment_service_id`, `appointment_notes`, `appointment_confirmed`, `appointment_show_up`, `appointment_cancelled`, `appointment_sms_notification`, `appointment_timestamp`) VALUES
(104, '2019-09-29', '12:00:00', '13:00:00', 33, 4, 3, 'a', 0, 0, 1, 0, '2019-08-20 18:26:12'),
(91, '2019-08-18', '11:30:00', '12:30:00', 2, 4, 3, '', 0, 0, 0, 0, '2019-08-16 09:52:19'),
(90, '2019-08-17', '09:00:00', '10:00:00', 33, 4, 3, 'asd', 0, 0, 0, 0, '2019-08-16 09:20:19'),
(89, '2019-08-15', '15:00:00', '15:30:00', 33, 4, 1, 'asd', 0, 0, 0, 0, '2019-08-14 12:01:51'),
(87, '2019-07-31', '14:00:00', '14:30:00', 31, 4, 5, '', 0, 1, 0, 0, '2019-07-17 21:02:37'),
(74, '2019-07-04', '16:00:00', '17:00:00', 2, 4, 3, '', 0, 0, 0, 1, '2019-07-02 08:10:16'),
(75, '2019-07-23', '16:00:00', '17:00:00', 3, 4, 3, '', 0, 0, 0, 0, '2019-07-02 08:29:04'),
(76, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 1, 1, 0, '2019-07-02 08:48:03'),
(77, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 0, 1, 0, '2019-07-02 08:48:52'),
(78, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 0, 1, 0, '2019-07-02 08:49:18'),
(79, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 0, 1, 0, '2019-07-02 08:50:14'),
(80, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 0, 1, 0, '2019-07-02 08:51:47'),
(81, '2019-07-30', '16:30:00', '17:00:00', 3, 4, 4, '', 0, 0, 1, 0, '2019-07-02 08:52:32'),
(82, '2019-07-25', '08:30:00', '09:30:00', 3, 4, 3, '', 0, 0, 1, 0, '2019-07-02 09:01:02'),
(83, '2019-07-07', '10:00:00', '11:00:00', 3, 4, 3, '', 0, 0, 0, 0, '2019-07-03 03:18:47'),
(84, '2019-07-05', '11:00:00', '12:00:00', 3, 4, 3, '', 0, 0, 0, 0, '2019-07-03 03:30:17'),
(85, '2019-07-09', '08:30:00', '09:30:00', 29, 4, 3, 'aeadsf', 0, 0, 1, 0, '2019-07-07 07:08:12'),
(86, '2019-07-23', '15:00:00', '16:00:00', 29, 4, 3, '', 0, 0, 0, 0, '2019-07-07 07:17:44'),
(95, '2019-09-01', '13:00:00', '14:00:00', 33, 4, 3, 'asdaasd', 0, 0, 0, 0, '2019-08-20 18:10:38'),
(88, '2019-08-15', '11:30:00', '12:30:00', 33, 4, 3, 'asd', 0, 0, 1, 0, '2019-08-14 11:59:20'),
(73, '2019-07-03', '17:00:00', '17:30:00', 2, 4, 5, '', 0, 0, 0, 0, '2019-07-02 06:48:35'),
(72, '2019-07-03', '16:00:00', '17:00:00', 3, 4, 3, '', 0, 0, 0, 0, '2019-07-02 06:30:19'),
(71, '2019-07-03', '15:00:00', '16:00:00', 3, 4, 3, '', 0, 0, 0, 0, '2019-07-02 05:37:09'),
(70, '2019-07-03', '13:30:00', '14:30:00', 3, 4, 3, '', 0, 0, 1, 0, '2019-07-02 05:36:42'),
(55, '2019-07-01', '11:00:00', '11:30:00', 2, 4, 1, '', 0, 1, 0, 0, '2019-06-30 08:53:57'),
(56, '2019-07-01', '17:30:00', '18:00:00', 3, 4, 2, '', 0, 0, 0, 0, '2019-06-30 09:57:40'),
(57, '2019-07-01', '18:00:00', '18:30:00', 5, 4, 1, '', 0, 0, 0, 0, '2019-06-30 11:07:32'),
(58, '2019-07-02', '18:00:00', '18:30:00', 5, 4, 3, '', 0, 0, 0, 0, '2019-06-30 21:29:48'),
(96, '2019-09-01', '12:00:00', '13:00:00', 33, 4, 3, 'asd', 0, 0, 0, 0, '2019-08-20 18:11:58'),
(97, '2019-09-08', '13:00:00', '14:00:00', 33, 4, 3, 'asdaa', 0, 0, 0, 0, '2019-08-20 18:12:20'),
(98, '2019-09-08', '17:00:00', '18:00:00', 33, 4, 3, 'asdaaaa', 0, 0, 0, 0, '2019-08-20 18:14:26'),
(99, '2019-09-22', '12:00:00', '13:00:00', 33, 4, 3, 'aa', 0, 0, 0, 0, '2019-08-20 18:19:20'),
(100, '2019-09-22', '13:00:00', '14:00:00', 33, 4, 3, 'aa', 0, 0, 0, 0, '2019-08-20 18:19:32'),
(106, '2019-08-23', '12:00:00', '13:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-08-22 15:21:31'),
(107, '2019-09-03', '08:30:00', '09:30:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-08-29 08:47:43'),
(108, '2019-09-08', '10:30:00', '11:30:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-08-29 17:34:38'),
(109, '2019-09-04', '13:30:00', '14:30:00', 34, 4, 3, '', 0, 0, 1, 1, '2019-08-29 17:41:09'),
(110, '2019-09-18', '15:30:00', '16:30:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-08-29 22:37:22'),
(111, '2019-09-18', '09:30:00', '10:30:00', 28, 4, 3, '', 0, 0, 0, 0, '2019-09-02 21:54:43'),
(112, '2019-09-18', '12:00:00', '13:00:00', 34, 4, 3, '', 0, 1, 0, 0, '2019-09-06 16:10:13'),
(113, '2019-09-17', '12:00:00', '12:30:00', 36, 4, 5, '', 0, 0, 0, 0, '2019-09-06 16:18:51'),
(114, '2019-09-12', '16:00:00', '17:00:00', 36, 4, 3, '', 0, 1, 0, 0, '2019-09-06 16:20:50'),
(115, '2019-09-12', '12:00:00', '12:30:00', 36, 4, 1, '', 0, 1, 0, 0, '2019-09-06 16:22:32'),
(116, '2019-09-19', '16:30:00', '17:30:00', 34, 4, 3, '', 0, 0, 1, 0, '2019-09-06 16:32:38'),
(117, '2019-09-19', '12:30:00', '13:30:00', 34, 4, 3, '', 0, 1, 1, 0, '2019-09-06 16:33:33'),
(118, '2019-09-12', '12:30:00', '13:30:00', 34, 4, 3, '', 0, 0, 1, 0, '2019-09-06 19:56:21'),
(119, '2019-09-12', '09:30:00', '10:30:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-06 19:59:37'),
(120, '2019-09-11', '12:00:00', '13:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-06 21:07:18'),
(121, '2019-09-12', '11:30:00', '12:30:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-06 21:24:55'),
(122, '2019-09-15', '09:00:00', '10:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-07 12:26:07'),
(123, '2019-09-19', '13:30:00', '14:00:00', 34, 4, 1, '', 0, 1, 1, 0, '2019-09-08 13:34:27'),
(124, '2019-09-19', '14:00:00', '14:30:00', 34, 4, 1, '', 0, 1, 1, 0, '2019-09-08 13:34:42'),
(125, '2019-09-19', '14:30:00', '15:00:00', 34, 4, 1, '', 0, 0, 1, 0, '2019-09-08 13:34:56'),
(126, '2019-09-19', '15:00:00', '15:30:00', 34, 4, 1, '', 0, 0, 1, 0, '2019-09-08 13:35:18'),
(127, '2019-09-19', '12:30:00', '13:30:00', 34, 4, 3, '', 0, 0, 1, 0, '2019-09-08 14:56:06'),
(128, '2019-09-09', '13:00:00', '14:00:00', 31, 4, 3, '', 0, 0, 0, 0, '2019-09-08 14:57:51'),
(129, '2019-09-20', '12:30:00', '13:00:00', 34, 4, 1, '', 0, 0, 1, 0, '2019-09-08 14:59:50'),
(130, '2019-09-21', '12:30:00', '13:00:00', 34, 4, 1, '', 0, 0, 1, 0, '2019-09-08 15:03:36'),
(131, '2019-09-20', '15:00:00', '16:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:11:42'),
(132, '2019-09-12', '17:00:00', '18:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:12:13'),
(133, '2019-09-18', '17:00:00', '18:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:12:31'),
(134, '2019-09-11', '17:00:00', '18:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:13:38'),
(135, '2019-09-20', '17:00:00', '18:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:14:46'),
(136, '2019-09-25', '17:00:00', '18:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:15:59'),
(137, '2019-09-26', '12:00:00', '13:00:00', 34, 4, 3, '', 0, 0, 0, 0, '2019-09-08 15:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'client', 'Clients'),
(3, 'dentist', 'Dentists');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `register_confirm`
--

CREATE TABLE IF NOT EXISTS `register_confirm` (
  `register_confirm_id` int(11) NOT NULL AUTO_INCREMENT,
  `register_confirm_user_id` int(11) NOT NULL,
  `register_confirm_email` varchar(45) CHARACTER SET latin1 NOT NULL,
  `register_confirm_code` varchar(45) CHARACTER SET latin1 NOT NULL,
  `register_confirm_timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`register_confirm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `register_confirm`
--

INSERT INTO `register_confirm` (`register_confirm_id`, `register_confirm_user_id`, `register_confirm_email`, `register_confirm_code`, `register_confirm_timestamp`) VALUES
(21, 28, 'asdadda2@asdad.com', '607131', '2019-07-01 20:46:51'),
(20, 27, 'asdadda@asdad.com', '254003', '2019-07-01 11:42:55'),
(22, 29, 'asdadda@asdasdadd.com', '963258', '2019-07-07 15:06:02'),
(23, 30, 'asdasd@asd.com', '608924', NULL),
(24, 31, 'asdaaaaaaadasd@gmail.com', '757691', NULL),
(25, 32, 'aaa@gmail.com', '549063', '2019-07-13 15:09:01'),
(26, 33, 'petealloydbismonte@gmail.com', '247349', '2019-08-13 09:10:08'),
(27, 34, 'kennethgalingan55@gmail.com', '607655', '2019-08-22 15:20:58'),
(28, 35, 'lemuel@gmail.com', '626717', '2019-08-29 08:56:03'),
(29, 36, 'kkmd.99@gmail.com', '644138', '2019-09-06 16:18:04'),
(30, 37, 'patima_susanne07@yahoo.com', '005646', NULL),
(31, 38, 'kenkenken@gmail.com', '106019', NULL),
(32, 39, 'rwrewrwrewr@gmail.com', '837159', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `services_id` int(11) NOT NULL AUTO_INCREMENT,
  `services_name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `services_description` varchar(180) CHARACTER SET latin1 NOT NULL,
  `services_duration` int(11) NOT NULL,
  PRIMARY KEY (`services_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_id`, `services_name`, `services_description`, `services_duration`) VALUES
(1, 'Cleaning', 'Cleaning services', 30),
(2, 'Tooth Extraction', 'Tooth extratction services', 30),
(3, 'Braces', 'Braces Services', 60),
(4, 'Restoration', 'Tooth Restoration', 30),
(5, 'Dentures', 'Dentures', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_email` (`email`),
  UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  UNIQUE KEY `uc_remember_selector` (`remember_selector`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$A.bM0m5xNiqg/2hpSb21F.0rDmG3ft16G3yVbljx1Pzb6pWO69IAS', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1567936639, 1, 'Admin', 'keivn', 'ADMIN', '0910234567891'),
(2, '127.0.0.1', 'a', '$2y$10$e3dqmGq/PFbLJK5ui.3uiu60tc2uwOdKgBqgfRAzqOiEF/EhTTYVi', 'dummyemail12313123@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1268889823, 1565920126, 1, 'Kawhi', 'Leonard', NULL, '0'),
(3, '127.0.0.1', 'b', '$2y$10$7wXh9eKqdOjWNDg3cZzq1eF4WQEo1sm69wuqs6IOFeW4IpQPlR6u2', 'wrc@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1268889823, 1562055101, 1, 'Kevin', 'Durant', NULL, '0'),
(4, '127.0.0.1', 'c', '$2y$10$awcihSW7IeuNo51rGTqxH.JYwjJKnoXpHGPwZLbpxe6x8q/z98lvC', 'pob@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1268889823, 1562483550, 1, 'Evelyn', 'Sico', NULL, '0'),
(27, '::1', 'd', '$2y$10$RBCdzSpMyjQetiua6t3nse0RTmmkqU/k8rGhA3SEhifymUULxMSvq', 'asdadda@asdad.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1561952510, NULL, 1, 'Shanti', 'Dope', NULL, '0'),
(28, '::1', 'e', '$2y$10$NP/fzvea2uv.kqBBhwZAu.2TmI2CpRhI8NO2flZ4og2Dy.ZbHz.Ey', 'asdadda2@asdad.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1561985143, 1561985216, 1, 'Emi', 'Nem', NULL, '0'),
(29, '::1', 'asdasdsasdsad', '$2y$10$Vt84DIccpRuxEBLrzqCPR.uvWnGvLSi/dBfxJjer5paCHhgGT10zS', 'asdadda@asdasdadd.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1562483083, 1562483693, 1, 'asdsad', 'asdasds', NULL, '0'),
(30, '::1', 'ba', '$2y$10$R1elLLeEcglZ.OkXZVmXC.gbVWaRFS0JPaySqZMrXu/fHZShTAgiu', 'asdasd@asd.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1563001373, NULL, 0, 'a', 'b', NULL, '0'),
(31, '128.168.64.14', 'asdasdasdasdasdas', '$2y$10$O580GMx4kp7CQdawXYDcpuuU8ng4EKeSQH7bhpJ56a02/MBOsTFAq', 'asdaaaaaaadasd@gmail.com', '00b72bae2d7d68d94a23', '$2y$10$rcbEw3UbE244QSomh9Aj2eI9uT3e/f5sf1BnbasTR6CrlEJF4nNYi', NULL, NULL, NULL, NULL, NULL, 1563001454, NULL, 0, 'asdasdas', 'asdasdasd', NULL, '0'),
(32, '128.168.64.14', 'asdasdasdasdasdaaaaaaaaaa', '$2y$10$NTNyABHXesf7DUVYJY6BwuEVm47jvLr7D7otx0kJCnNf7LjTuUTYS', 'aaa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1563001699, 1565920024, 1, 'asdasdaaaaaaaaaa', 'asdasdasd', NULL, '0'),
(33, '128.168.64.14', 'testtest', '$2y$10$hhspAyw.X/SgOMOQBUtUjudndQVE/bKBDH.2afIAoFiTIFiXU9No6', 'petealloydbismonte@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1565658579, 1566296514, 1, 'test', 'test', NULL, '123123123'),
(34, '::1', 'GalinganJhanKenneth', '$2y$10$JvurjAJGlBecgVUDzfNXmOK3fjW2U4RAtoigYJ1kyaP.xF70POf7.', 'kennethgalingan55@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1566458382, 1568176846, 1, 'jhan', 'Galingan', NULL, '9095006747'),
(35, '::1', 'fabianlemuel', '$2y$10$NZU3PyKUzz69JOiUaP/lOeKYaU/SETubgaYyoLupHscKgm207gGde', 'lemuel@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1567040112, 1567040182, 1, 'lemuel', 'fabian', NULL, '09123456788'),
(36, '::1', 'Deocampokevinkarl', '$2y$10$YyA2SgPwVEurKlbseLY3aOxFi94aXneUDHy5dbfibnJyuAzmjxTcK', 'kkmd.99@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1567757830, 1567757912, 1, 'kevin karl', 'Deocampo', NULL, '09568861958'),
(37, '::1', 'EspinosaPatima', '$2y$10$4bpIvWVwQqnDP7mVasQkHeNnoowLCoLEgDMofnTfHzQwWM56xUjhm', 'patima_susanne07@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1567759341, NULL, 0, 'Patima', 'Espinosa', NULL, '09456297781'),
(38, '::1', 'kenkenkenkenkenken', '$2y$10$6H2cgEN4/bNWp.BDvORJwOjf8ZEYjPQn.3Zn0MG/jVguoRE8iIP8.', 'kenkenken@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1567920771, NULL, 0, 'kenkenken', 'kenkenken', NULL, '09095006740'),
(39, '::1', 'rwrewrwrwewrwerwrwerwerwr', '$2y$10$EnFy4K/jMHqZ.upwwQ3rYOQ5dVoWuuuKESIIcqbHDiyuBiHKPGRi6', 'rwrewrwrewr@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1567925595, NULL, 0, 'ewrwerwrwerwerwr', 'rwrewrwrw', NULL, '09095006739');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 2),
(5, 4, 3),
(27, 27, 2),
(28, 28, 2),
(29, 29, 2),
(30, 30, 2),
(31, 31, 2),
(32, 32, 2),
(33, 33, 2),
(34, 34, 2),
(35, 35, 2),
(36, 36, 2),
(37, 37, 2),
(38, 38, 2),
(39, 39, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_extra_info`
--

CREATE TABLE IF NOT EXISTS `user_extra_info` (
  `user_extra_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_extra_info_user_id` int(11) NOT NULL,
  `user_extra_info_address` varchar(180) CHARACTER SET latin1 NOT NULL,
  `user_extra_info_birthday` date NOT NULL,
  PRIMARY KEY (`user_extra_info_id`),
  UNIQUE KEY `user_extra_info_user_id_UNIQUE` (`user_extra_info_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user_extra_info`
--

INSERT INTO `user_extra_info` (`user_extra_info_id`, `user_extra_info_user_id`, `user_extra_info_address`, `user_extra_info_birthday`) VALUES
(1, 28, 'Bahay', '2019-02-13'),
(2, 29, 'asdklasd aklsdj', '1991-11-11'),
(3, 30, 'asdasdasd', '2019-07-25'),
(4, 31, 'asdasd', '2019-07-13'),
(5, 32, 'asdasdasd', '2019-07-13'),
(6, 33, 'asdasd', '1993-12-06'),
(7, 34, 'San Jacinto Victoria, Tarlac', '1999-08-01'),
(8, 35, 'San Jacinto Victoria, Tarlac', '1991-01-01'),
(9, 36, 'gerona', '1991-01-01'),
(10, 37, 'tarlac', '2010-12-12'),
(11, 38, 'canarem', '1993-01-01'),
(12, 39, 'canarem', '1999-01-01');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
