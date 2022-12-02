-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2022 at 12:03 PM
-- Server version: 10.5.17-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digitall_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_academic_year`
--

CREATE TABLE `gl8m_academic_year` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `published` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_academic_year`
--

INSERT INTO `gl8m_academic_year` (`id`, `year`, `published`) VALUES
(1, '2022', 0),
(2, '2021', 0),
(3, '2020', 0),
(4, '2019', 0),
(5, '2018', 0),
(6, '2017', 0),
(7, '2016', 0),
(8, '2015', 0),
(9, '2014', 0),
(10, '2013', 0),
(11, '2013', 0),
(12, '2014', 0),
(13, '2013', 0),
(14, '2012', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_attendance`
--

CREATE TABLE `gl8m_attendance` (
  `id` int(255) NOT NULL,
  `attendance_date` text COLLATE utf8_bin NOT NULL,
  `class` varchar(255) COLLATE utf8_bin NOT NULL,
  `department` varchar(255) COLLATE utf8_bin NOT NULL,
  `total_student` int(255) NOT NULL,
  `teacher` varchar(255) COLLATE utf8_bin NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_date` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_attendance_info`
--

CREATE TABLE `gl8m_attendance_info` (
  `id` int(255) NOT NULL,
  `entry_by` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `attend` int(255) NOT NULL,
  `attendance_id` int(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_date` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_class`
--

CREATE TABLE `gl8m_class` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `subjects` text DEFAULT NULL,
  `departments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_class`
--

INSERT INTO `gl8m_class` (`id`, `name`, `subjects`, `departments`) VALUES
(6, '+3 Arts', '1,2,3', '1'),
(7, '+3 Commerce', '8,9', '4');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_config`
--

CREATE TABLE `gl8m_config` (
  `id` int(10) NOT NULL,
  `param_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_config`
--

INSERT INTO `gl8m_config` (`id`, `param_data`) VALUES
(1, '{\"site_name\":[\"Infyson Exam Management System\"],\"address\":[\"DLF Cybercity, Bhubaneswar\"],\"email\":[\"admin@admin.com\"],\"phone\":[\"+91 7008124707\"],\"website\":[\"https:\\/\\/exam.infydemo.in\"],\"default_language\":[\"0\"],\"default_theme\":[\"skin-purple\"],\"item_per_list\":[\"10\"],\"image_supported_type\":[\"gif|jpg|png\"],\"image_supported_size\":[\"\"],\"email_form\":[\"debendraster@gmail.com\"],\"from_name\":[\"Debendra\"],\"protocol\":[\"smtp\"],\"smtp_host\":[\"smtp.mailtrap.io\"],\"smtp_port\":[\"2525\"],\"smtp_user\":[\"0e7e66d9e0a6a4\"],\"smtp_pass\":[\"0a1e2b89c30efe\"],\"mail_path\":[\"\"],\"404_title\":[\"Page not found !\"],\"404_browser_title\":[\"404 page not found !\"],\"404_description\":[\"This is not the page you are looking for\"],\"preloader\":[\"0\"],\"preloader_style\":[\"3\"],\"scroll_to_top\":[\"0\"],\"header\":[\"<header class=\\\"custom-navbar sticky\\\">\\r\\n    <div class=\\\"container\\\">\\r\\n        <div class=\\\"row\\\">\\r\\n            <div class=\\\"col-md-2 col-sm-2 col-xs-12 mynew-menu\\\">\\r\\n                <div class=\\\"logo\\\">\\r\\n                    [OFFCANVAS]\\r\\n                   [LOGO]\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n           <div class=\\\"col-md-5 col-sm-5 col-xs-12\\\">\\r\\n               <nav class=\\\"main-menu\\\">\\r\\n                    <div class=\\\"navbar-collapse collapse\\\">\\r\\n                        [LANG_SWITCH]\\r\\n                    <\\/div>\\r\\n                <\\/nav>\\r\\n            <\\/div>\\r\\n            <div class=\\\"col-md-5 col-sm-5 col-xs-12\\\">\\r\\n                <nav class=\\\"main-menu\\\">\\r\\n                    <div class=\\\"navbar-collapse collapse\\\">\\r\\n                        [USER_MENU]\\r\\n                    <\\/div>\\r\\n                <\\/nav>\\r\\n            <\\/div>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n<\\/header>\"],\"header_bg\":[\"\"],\"header_text\":[\"\"],\"body_bg\":[\"\"],\"body_text\":[\"\"],\"footer\":[\"<div class=\\\"footer-text\\\">\\r\\n     <p>\\u00a92022 <strong>Infyson Technology<\\/strong>. All Rights Reserved.<\\/p>\\r\\n<\\/div>\\r\\n<div class=\\\"social-icon\\\">\\r\\n       <a href=\\\"#\\\" title=\\\"facebook\\\" target=\\\"_blank\\\"><i class=\\\"fa fa-facebook\\\"><\\/i><\\/a>\\r\\n       <a href=\\\"#\\\" title=\\\"twitter\\\" target=\\\"_blank\\\"><i class=\\\"fa fa-twitter\\\"><\\/i><\\/a> \\r\\n       <a href=\\\"#\\\" title=\\\"google-plus\\\" target=\\\"_blank\\\"><i class=\\\"fa fa-google-plus\\\"><\\/i><\\/a> \\r\\n       <a href=\\\"#\\\" title=\\\"linkedin\\\" target=\\\"_blank\\\"><i class=\\\"fa fa-linkedin\\\"><\\/i><\\/a> \\r\\n<\\/div>\\r\\n                    \"],\"footer_bg\":[\"\"],\"footer_text\":[\"\"],\"user_activation_mail_subject\":[\"Welcome to BCMS\"],\"user_activation\":[\"Hi, [USER_NAME]\\r\\n\\r\\nYour account has been created. \\r\\nPlease click this link to activate your account.\\r\\n\\r\\n[ACTIVATION_LINK]\"],\"user_activation_text\":[\"Active your account\"],\"enable_user_udate\":[\"on\"],\"user_udate_subject\":[\"Update data\"],\"user_update\":[\"Hi, [USER_NAME]\\r\\n\\r\\nyou update your data on BCMS.\\r\\n\\r\\nTime: [UPDATE_TIME]\"],\"enable_admin_notify\":[\"on\"],\"new_user_notify_admin_subject\":[\"New user registration on BCMS\"],\"new_user_notify_admin\":[\"Hi, Admin\\r\\n\\r\\nYou have one new user registration on your site. \\r\\nUser Details:\\r\\n\\r\\nName:  [USER_NAME]\\r\\nEmail:  [USER_EMAIL]\"],\"forgotpass_subject\":[\"Password reset link for BCMS\"],\"forgotpass\":[\"Hi, [USER_NAME]\\r\\n\\r\\nyour password reset link. please hit on and change your password.\\r\\n\\r\\n[RESET_LINK]\"],\"forgotpass_text\":[\"Reset Password\"],\"enable_pass_update_confirm\":[\"on\"],\"pass_update_cinfirmation_subject\":[\"Password Change Confirmation\"],\"pass_update_cinfirmation\":[\"Hi, [USER_NAME]\\r\\n\\r\\nyour password change successfully.\\r\\n\\r\\nTime: [UPDATE_TIME]\"],\"enable_notice_notify\":[\"on\"],\"notice_subject\":[\"Notice from BCMS\"],\"notice\":[\"Hi, dear\\r\\n\\r\\nYou have new one notice from bcms. please read notice below:\\r\\n\\r\\n[NOTICE_TITLE]\\r\\n[NOTICE_DETAILS]\"],\"default_payment\":[\"1\"],\"currency_code\":[\"INR\"],\"currency_sign\":[\"Rs.\"],\"decimal_places\":[\"2\"],\"currency_position\":[\"before\"],\"default_icon\":[\"i.PNG\"],\"default_favicon\":[\"i1.PNG\"],\"default_logo\":[\"dl.png\"],\"second_logo\":[\"LOGO2.PNG\"],\"404_background\":[\"\"],\"login_background\":[\"\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_courses`
--

CREATE TABLE `gl8m_courses` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_courses`
--

INSERT INTO `gl8m_courses` (`id`, `class_id`, `subject_id`, `name`, `code`) VALUES
(5, 6, 1, 'Course1', 'C1'),
(10, 7, 8, 'Cost Accounting', 'CA');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_course_inquiry`
--

CREATE TABLE `gl8m_course_inquiry` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile` int(30) NOT NULL,
  `nationality` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `program` varchar(250) NOT NULL,
  `qualification` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `caste` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Inquiry, 1 = shortlisted, 2 = entrance_given, 3 = admitted, 4 rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gl8m_course_inquiry`
--

INSERT INTO `gl8m_course_inquiry` (`id`, `name`, `email`, `mobile`, `nationality`, `state`, `city`, `program`, `qualification`, `gender`, `caste`, `status`) VALUES
(3, 'Ali', 'ali@gmail.com', 90076221, 'american', 'manhatan', 'new york', 'BS', 'MS', 'male', 'non', 0),
(4, 'name', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 3),
(5, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 4),
(6, 'deb', 'deb@gmail.com', 2147483647, 'Indian', 'Odisha', 'BBSR', 'Btecj', 'bsc', 'male', 'teli', 0),
(7, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(8, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(9, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(10, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(11, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(12, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(13, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(14, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(15, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(16, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(17, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(18, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(20, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(21, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(22, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(23, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(24, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(25, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(26, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 0),
(27, 'Shaka', 'email', 90078601, 'nationality', 'state', 'city', 'program', 'qualification', 'gender', 'caste', 3);

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_departments`
--

CREATE TABLE `gl8m_departments` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_departments`
--

INSERT INTO `gl8m_departments` (`id`, `name`) VALUES
(1, 'Arts'),
(2, 'Science'),
(3, 'Self Finance'),
(4, 'Commerce');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_exam`
--

CREATE TABLE `gl8m_exam` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `department_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `semistar` int(11) NOT NULL,
  `term` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `form_fillup_start_date` date DEFAULT NULL,
  `form_fillup_last_date` date DEFAULT NULL,
  `form_fee` decimal(10,2) NOT NULL,
  `late_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_exam`
--

INSERT INTO `gl8m_exam` (`id`, `name`, `department_id`, `class_id`, `semistar`, `term`, `type`, `exam_date`, `form_fillup_start_date`, `form_fillup_last_date`, `form_fee`, `late_fee`) VALUES
(1, '1st Term Exam (+2 Arts)', 1, 6, 3, 'MS', 'Theory', '2022-10-01', '2022-09-15', '2022-09-20', '2500.00', '200.00'),
(2, '2nd Term Exam Arts', 1, 7, 2, 'ES', 'Practical', '2022-11-25', '2022-09-01', '2022-09-13', '1000.00', '120.00'),
(3, '1st exam', 2, 7, 4, 'MS', 'Theory', '2022-09-23', '2022-09-30', '2022-09-29', '1800.00', '250.00'),
(4, '1st Sem', 1, 6, 3, 'MS', 'Theory', '2022-11-30', '2022-11-17', '2022-11-30', '500.00', '100.00'),
(5, 'Q+', 1, 6, 3, 'MS', 'Theory', '2022-11-06', '2022-11-28', '2022-11-09', '122.00', '1233.00'),
(6, 'Q+', 1, 6, 3, 'MS', 'Theory', '2022-11-30', '2022-11-24', '2022-11-27', '122.00', '1233.00'),
(7, 'name', 0, 0, 0, '', '', '1970-01-01', '1970-01-01', '1970-01-01', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_exam_card`
--

CREATE TABLE `gl8m_exam_card` (
  `id` int(20) NOT NULL,
  `year` int(20) NOT NULL,
  `department_id` varchar(100) NOT NULL,
  `class_id` varchar(100) NOT NULL,
  `semistar` varchar(100) NOT NULL,
  `paper` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_exam_card`
--

INSERT INTO `gl8m_exam_card` (`id`, `year`, `department_id`, `class_id`, `semistar`, `paper`) VALUES
(4, 1, '1', '1', '2', '1,2,3,7,8,9'),
(5, 3, '3', '4', '1', '5,7'),
(21, 1, '2', '1', '2', '5,7'),
(7, 2, '4', '5', '3', '7,8'),
(24, 2, '1', '1', '1', '1,2,3'),
(25, 1, '1', '1', '3', '1,2,3,4,5,6,7,8,9,10'),
(26, 1, '2', '3', '3', '1,2,3,4,5'),
(28, 1, '2', '4', '4', '1,2,3');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_exam_marks`
--

CREATE TABLE `gl8m_exam_marks` (
  `id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `exam_id` int(255) NOT NULL,
  `class_id` int(255) NOT NULL,
  `subject_id` int(255) NOT NULL,
  `semester` int(10) NOT NULL,
  `term` varchar(250) COLLATE utf8_bin NOT NULL,
  `exam_type` varchar(250) COLLATE utf8_bin NOT NULL,
  `mark` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `roll` varchar(255) COLLATE utf8_bin NOT NULL,
  `year` text COLLATE utf8_bin NOT NULL,
  `add_by` int(255) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_exam_marks`
--

INSERT INTO `gl8m_exam_marks` (`id`, `student_id`, `exam_id`, `class_id`, `subject_id`, `semester`, `term`, `exam_type`, `mark`, `comment`, `roll`, `year`, `add_by`, `add_date`) VALUES
(1, 1, 1, 1, 4, 0, '', '', '36', '', '1', '1', 3, '2022-09-07 04:10:27'),
(2, 1, 2, 1, 1, 0, '', '', '20', '', '1', '1', 1, '2022-09-08 02:21:35'),
(3, 1, 1, 1, 2, 0, '', '', '50', '', '1', '1', 1, '2022-09-08 02:30:43'),
(4, 1, 1, 1, 3, 0, '', '', '40', '', '1', '1', 1, '2022-09-08 02:30:50'),
(5, 1, 1, 1, 1, 0, '', '', '20', '', '1', '1', 1, '2022-09-08 02:31:00'),
(6, 1, 1, 1, 5, 0, '', '', '60', '', '1', '1', 1, '2022-09-08 02:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_fees`
--

CREATE TABLE `gl8m_fees` (
  `id` int(255) NOT NULL,
  `title` text NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` int(10) NOT NULL,
  `is_delete` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_fields`
--

CREATE TABLE `gl8m_fields` (
  `id` int(255) NOT NULL,
  `field_name` text NOT NULL,
  `published` int(255) NOT NULL,
  `type` int(255) NOT NULL,
  `required` int(255) NOT NULL,
  `section` int(255) NOT NULL,
  `option_param` text NOT NULL,
  `field_order` int(255) NOT NULL,
  `profile` int(255) NOT NULL,
  `list` int(255) NOT NULL,
  `biodata` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_fields`
--

INSERT INTO `gl8m_fields` (`id`, `field_name`, `published`, `type`, `required`, `section`, `option_param`, `field_order`, `profile`, `list`, `biodata`) VALUES
(1, 'Father\'s Name', 1, 1, 0, 1, '', 1, 1, 0, 0),
(2, 'Mother\'s Name', 1, 1, 0, 1, '', 2, 1, 0, 0),
(3, 'Blood Group', 1, 1, 0, 1, '', 3, 1, 0, 0),
(4, 'Address', 1, 2, 0, 1, '', 5, 1, 0, 0),
(5, 'Birthday', 1, 6, 0, 1, '', 4, 1, 0, 0),
(6, 'Father Name', 1, 1, 1, 2, '', 2, 1, 0, 0),
(7, 'Mother\'s Name', 1, 1, 1, 2, '', 3, 1, 0, 0),
(8, 'Religion', 1, 1, 0, 2, '', 4, 1, 0, 0),
(9, 'Blood Group', 1, 1, 0, 2, '', 5, 1, 0, 0),
(10, 'Birthday', 1, 6, 1, 2, '', 6, 1, 0, 0),
(12, 'Address', 1, 2, 1, 2, '', 8, 1, 0, 0),
(13, 'Father\'s Name', 1, 1, 1, 3, '', 2, 1, 0, 0),
(14, 'Mother\'s Name', 1, 1, 1, 3, '', 3, 1, 0, 0),
(15, 'Religion', 1, 1, 1, 3, '', 4, 1, 0, 0),
(16, 'Blood Group', 1, 1, 0, 3, '', 5, 1, 0, 0),
(18, 'Birthday', 1, 6, 1, 3, '', 7, 0, 0, 0),
(19, 'Address', 1, 2, 1, 3, '', 8, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_fields_data`
--

CREATE TABLE `gl8m_fields_data` (
  `id` int(255) NOT NULL,
  `fid` int(255) NOT NULL,
  `sid` int(255) NOT NULL,
  `data` text NOT NULL,
  `panel_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_fields_data`
--

INSERT INTO `gl8m_fields_data` (`id`, `fid`, `sid`, `data`, `panel_id`) VALUES
(1, 1, 1, 'father', 1),
(2, 2, 1, 'mother', 1),
(3, 3, 1, 'AB++', 1),
(4, 5, 1, '1990-1-1', 1),
(5, 4, 1, 'Address', 1),
(6, 6, 2, 'NA', 1),
(7, 7, 2, 'NA', 1),
(8, 8, 2, 'Hindu', 1),
(9, 9, 2, 'A+', 1),
(10, 10, 2, '', 1),
(11, 12, 2, 'Bhubaneswar', 1),
(49, 1, 1, 'ALi', 8),
(50, 2, 1, 'ss', 8),
(51, 3, 1, 'AB+', 8),
(52, 5, 1, '02-11-2022', 8),
(53, 4, 1, 'asas', 8),
(54, 1, 1, 'father', 9),
(55, 2, 1, 'mother', 9),
(56, 3, 1, 'AB+', 9),
(57, 5, 1, '1990-1-1', 9),
(58, 4, 1, 'Address', 9),
(59, 1, 1, 'father1', 10),
(60, 2, 1, 'mother2', 10),
(61, 3, 1, 'AB++', 10),
(62, 5, 1, '13-06-7', 10),
(63, 4, 1, 'address2', 10),
(64, 6, 2, 'father', 9),
(65, 7, 2, 'mother', 9),
(66, 8, 2, 'muslim', 9),
(67, 9, 2, 'AB+', 9),
(68, 10, 2, '1990-1-1', 9),
(69, 12, 2, 'Address', 9),
(70, 1, 1, '', 11),
(71, 2, 1, '', 11),
(72, 3, 1, '', 11),
(73, 5, 1, '', 11),
(74, 4, 1, '', 11),
(75, 6, 2, 'father', 10),
(76, 7, 2, 'mother', 10),
(77, 8, 2, 'muslim', 10),
(78, 9, 2, 'AB+', 10),
(79, 10, 2, '1990-1-1', 10),
(80, 12, 2, 'Address', 10),
(81, 1, 1, 'father', 12),
(82, 2, 1, 'mother', 12),
(83, 3, 1, 'AB+', 12),
(84, 5, 1, 'Address', 12),
(85, 4, 1, '1990-1-1', 12),
(86, 1, 1, 'asdafas', 13),
(87, 2, 1, 'rewrwr', 13),
(88, 3, 1, 'sdf+', 13),
(89, 5, 1, 'zvhjv aakg ahdjask dakjsk azkf', 13),
(90, 4, 1, '2002-21-1', 13);

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_fields_section`
--

CREATE TABLE `gl8m_fields_section` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_fields_section`
--

INSERT INTO `gl8m_fields_section` (`id`, `name`) VALUES
(1, 'student'),
(2, 'teacher'),
(3, 'parent');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_fields_type`
--

CREATE TABLE `gl8m_fields_type` (
  `id` int(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_fields_type`
--

INSERT INTO `gl8m_fields_type` (`id`, `type`) VALUES
(1, 'Input Box'),
(2, 'Textarea Box'),
(3, 'Check Box'),
(4, 'Radio Box'),
(5, 'Select Box'),
(6, 'Datepicker');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_form_entries`
--

CREATE TABLE `gl8m_form_entries` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `class_id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exam` varchar(100) NOT NULL,
  `semistar` int(11) NOT NULL,
  `term` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `form_fee` decimal(10,2) DEFAULT NULL,
  `late_fee` decimal(10,2) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_form_entries`
--

INSERT INTO `gl8m_form_entries` (`id`, `student_id`, `student_name`, `department_id`, `department`, `class_id`, `class`, `exam_id`, `exam`, `semistar`, `term`, `date`, `form_fee`, `late_fee`, `total_fee`, `payment_status`) VALUES
(1, 2, 'Debendra Kumar Sahoo', 1, 'Arts', 1, '+2 1st Yr Arts', 1, '1st Term Exam (+2 Arts)', 3, 'MS', '2022-09-15', '2500.00', '23.00', '2500.00', 'Success'),
(2, 2, 'Debendra Kumar Sahoo', 1, 'Arts', 6, '+3 Arts', 4, '1st Sem', 3, 'MS', '2022-11-18', '500.00', '0.00', '500.00', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_grade`
--

CREATE TABLE `gl8m_grade` (
  `id` int(255) NOT NULL,
  `category` int(255) NOT NULL,
  `name` longtext COLLATE utf8_bin NOT NULL,
  `grade_point` text COLLATE utf8_bin NOT NULL,
  `mark_from` int(255) NOT NULL,
  `mark_upto` int(255) NOT NULL,
  `comment` longtext COLLATE utf8_bin NOT NULL,
  `status` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_grade`
--

INSERT INTO `gl8m_grade` (`id`, `category`, `name`, `grade_point`, `mark_from`, `mark_upto`, `comment`, `status`) VALUES
(1, 1, 'A+', '5', 80, 100, 'Excellent', '1'),
(2, 1, 'A', '4', 70, 79, 'Very Good', '1'),
(3, 1, 'A-', '3.5', 60, 69, 'Good', '1'),
(4, 1, 'B', '3', 50, 59, 'Okay', '1'),
(5, 1, 'C', '2', 40, 49, 'Not good', '1'),
(6, 1, 'D', '1', 33, 39, 'Pass', '1'),
(7, 1, 'F', '0', 0, 30, 'Fail', '1'),
(8, 2, 'A+', '5', 20, 25, 'Test', '1'),
(9, 1, 'O', '10', 90, 100, 'Excellent', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_grade_category`
--

CREATE TABLE `gl8m_grade_category` (
  `id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `mark` int(255) NOT NULL,
  `status` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_grade_category`
--

INSERT INTO `gl8m_grade_category` (`id`, `name`, `mark`, `status`) VALUES
(1, 'Term Exam', 100, '1'),
(2, 'Practical', 30, '1');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_languages`
--

CREATE TABLE `gl8m_languages` (
  `id` int(255) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL,
  `title_native` varchar(50) COLLATE utf8_bin NOT NULL,
  `lang_code` char(7) COLLATE utf8_bin NOT NULL,
  `direction` text COLLATE utf8_bin NOT NULL,
  `image` varchar(50) COLLATE utf8_bin NOT NULL,
  `published` int(11) NOT NULL,
  `lang_data` text COLLATE utf8_bin NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL,
  `sys_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_languages`
--

INSERT INTO `gl8m_languages` (`id`, `title`, `title_native`, `lang_code`, `direction`, `image`, `published`, `lang_data`, `data`, `sys_data`) VALUES
(1, 'English', 'English (United Kingdom)', 'en-GB', 'ltl', 'en_gb', 1, '', '{\"site_menu_attendances\":[\"\"],\"site_menu_dashboard\":[\"\"],\"site_menu_login_activity\":[\"\"],\"site_menu_site_logout\":[\"\"],\"site_menu_site_login\":[\"\"],\"site_menu_mark\":[\"\"],\"site_menu_profile\":[\"\"],\"site_menu_account\":[\"\"],\"site_menu_message\":[\"\"],\"site_menu_notice\":[\"\"],\"site_menu_payments\":[\"\"],\"site_menu_subjects\":[\"\"],\"site_menu_exam_card\":[\"\"],\"site_menu_result\":[\"\"],\"site_menu_site_signup\":[\"\"],\"site_dashboard_browser_title\":[\"\"],\"site_browser_my_profile_title\":[\"\"],\"site_browser_student_profile_title\":[\"\"],\"site_browser_log_title\":[\"\"],\"site_browser_my_account_title\":[\"\"],\"site_browser_attendance_title\":[\"\"],\"site_browser_subjects_title\":[\"\"],\"site_browser_exam_card_title\":[\"\"],\"site_browser_result_title\":[\"\"],\"site_msg_details_title\":[\"\"],\"site_browser_message_title\":[\"\"],\"site_browser_message_details_title\":[\"\"],\"site_browser_new_message_title\":[\"\"],\"site_browser_edit_attendances_title\":[\"\"],\"site_browser_addnew_attendances_title\":[\"\"],\"site_browser_payment_list_title\":[\"\"],\"site_browser_payment_title\":[\"\"],\"site_browser_payment_process_title\":[\"\"],\"site_borwser_payment_invoice_title\":[\"\"],\"site_borwser_payment_title\":[\"\"],\"site_browser_addnew_payment_title\":[\"\"],\"site_browser_notice_page_title\":[\"\"],\"site_browser_notice_details_page_title\":[\"\"],\"site_data_update_successfully\":[\"\"],\"site_data_update_failed\":[\"\"],\"site_data_create_successfully\":[\"\"],\"site_data_create_failed\":[\"\"],\"site_search_mismatch\":[\"\"],\"site_payment_successfully\":[\"\"],\"site_review_add_success\":[\"\"],\"site_review_add_failed\":[\"\"],\"site_payment_failed\":[\"\"],\"site_empty_list\":[\"\"],\"site_message_send_successfully\":[\"\"],\"site_message_send_failed\":[\"\"],\"site_select_payment_fees\":[\"\"],\"site_select_payment_type\":[\"\"],\"site_btn_change_password\":[\"\"],\"site_btn_change_photo\":[\"\"],\"site_btn_notice\":[\"\"],\"site_btn_login_activity\":[\"\"],\"site_btn_submit\":[\"\"],\"site_btn_send\":[\"\"],\"site_btn_compose\":[\"\"],\"site_btn_new_attendance\":[\"\"],\"site_btn_edit\":[\"\"],\"site_btn_cancel\":[\"\"],\"site_take_attendances\":[\"\"],\"site_latest_msg_title\":[\"\"],\"site_latest_notice_title\":[\"\"],\"site_welcome_title\":[\"\"],\"site_my_login_activity_title\":[\"\"],\"site_my_account_title\":[\"\"],\"site_sign_up_title\":[\"\"],\"site_sign_up_title_2\":[\"\"],\"site_mesage_title\":[\"\"],\"site_attendance_title\":[\"\"],\"site_subject_title\":[\"\"],\"site_exam_card_title\":[\"\"],\"site_attendance_list_title\":[\"\"],\"site_attendances_manage\":[\"\"],\"site_payment_list_title\":[\"\"],\"site_notice_list_tittle\":[\"\"],\"site_entry_by\":[\"\"],\"site_present_status\":[\"\"],\"site_tab_profile\":[\"\"],\"site_tab_account\":[\"\"],\"site_tab_change_password\":[\"\"],\"site_tab_change_photo\":[\"\"],\"site_form_passowrd\":[\"\"],\"site_form_new_password\":[\"\"],\"site_form_old_password\":[\"\"],\"site_form_retype_password\":[\"\"],\"site_form_email\":[\"\"],\"site_form_enter_roll\":[\"\"],\"site_form_user_name\":[\"\"],\"site_form_phone\":[\"\"],\"site_form_select_group\":[\"\"],\"site_form_class\":[\"\"],\"site_form_department\":[\"\"],\"site_form_subject\":[\"\"],\"site_form_year\":[\"\"],\"site_form_month\":[\"\"],\"site_form_roll\":[\"\"],\"site_form_enter_message\":[\"\"],\"site_form_select_student\":[\"\"],\"site_form_new_message\":[\"\"],\"site_form_student\":[\"\"],\"site_form_parent\":[\"\"],\"site_form_enter_parent_name\":[\"\"],\"site_form_teacher\":[\"\"],\"site_form_enter_name\":[\"\"],\"site_form_enter_teacher_name\":[\"\"],\"site_form_select_exam\":[\"\"],\"site_form_fees\":[\"\"],\"site_form_paid_amount\":[\"\"],\"site_form_payment_method\":[\"\"],\"site_form_payment_form\":[\"\"],\"site_form_total_bill\":[\"\"],\"site_form_due\":[\"\"],\"site_form_all\":[\"\"],\"site_form_paid\":[\"\"],\"site_form_unpaid\":[\"\"],\"site_form_cancel\":[\"\"],\"site_form_under_review\":[\"\"],\"site_form_pending\":[\"\"],\"site_form_select_year\":[\"\"],\"site_form_select_month\":[\"\"],\"site_form_enter_student_roll_name\":[\"\"],\"site_from\":[\"\"],\"site_last_login\":[\"\"],\"site_to\":[\"\"],\"site_unread\":[\"\"],\"site_menu_choose_lang\":[\"\"],\"site_roll\":[\"\"],\"site_email\":[\"\"],\"site_error\":[\"\"],\"site_teacher_name\":[\"\"],\"site_parent_name\":[\"\"],\"site_class\":[\"\"],\"site_child_info\":[\"\"],\"site_phone\":[\"\"],\"site_designation\":[\"\"],\"site_subject\":[\"\"],\"site_student_name\":[\"\"],\"site_department\":[\"\"],\"site_profile_info\":[\"\"],\"site_academic_info\":[\"\"],\"site_signup_request\":[\"\"],\"site_select_here\":[\"\"],\"site_payment_not_fount\":[\"\"],\"site_select_date\":[\"\"],\"site_select_class\":[\"\"],\"site_select_department\":[\"\"],\"site_loading\":[\"\"],\"site_date\":[\"\"],\"site_total_student\":[\"\"],\"site_total_parent\":[\"\"],\"site_teacher_comment\":[\"\"],\"site_sub_total\":[\"\"],\"site_total\":[\"\"],\"site_absent\":[\"\"],\"site_edit\":[\"\"],\"site_exam\":[\"\"],\"site_due\":[\"\"],\"site_fees\":[\"\"],\"site_paid\":[\"\"],\"site_commnet\":[\"\"],\"site_grade\":[\"\"],\"site_obtain_mark\":[\"\"],\"site_print\":[\"\"],\"site_invoice\":[\"\"],\"site_issue\":[\"\"],\"site_status\":[\"\"],\"site_save\":[\"\"],\"site_comment_saving\":[\"\"],\"site_paid_by\":[\"\"],\"site_payment_to\":[\"\"],\"site_total_mark\":[\"\"],\"site_gpa\":[\"\"],\"site_invoice_to\":[\"\"],\"site_student_roll\":[\"\"],\"site_student_class\":[\"\"],\"site_amount\":[\"\"],\"site_review\":[\"\"],\"site_pay_now\":[\"\"],\"site_payment_method\":[\"\"]}', '{\"menu_academics\":[\"\"],\"menu_accounting\":[\"\"],\"menu_class\":[\"\"],\"menu_courses\":[\"Course\"],\"menu_course_inquiry\":[\"Course inquiry\"],\"menu_examcard\":[\"\"],\"menu_configuration\":[\"\"],\"menu_department\":[\"\"],\"menu_dashboard\":[\"\"],\"menu_exams\":[\"\"],\"menu_fees\":[\"\"],\"menu_field_builder\":[\"\"],\"menu_grade\":[\"\"],\"menu_grade_category\":[\"\"],\"menu_incomes\":[\"\"],\"menu_languages\":[\"\"],\"menu_marks\":[\"\"],\"menu_notices\":[\"\"],\"menu_parents\":[\"\"],\"menu_payments\":[\"\"],\"menu_payment_method\":[\"\"],\"menu_setting\":[\"\"],\"menu_subjects\":[\"\"],\"menu_students\":[\"\"],\"menu_teachers\":[\"\"],\"menu_users\":[\"\"],\"menu_year\":[\"\"],\"title_academic_grade_new\":[\"\"],\"title_academic_grade_category_add\":[\"\"],\"title_add_fees\":[\"\"],\"title_accountig\":[\"\"],\"title_add_notice\":[\"\"],\"title_academic\":[\"\"],\"title_academic_year\":[\"\"],\"title_add_user\":[\"\"],\"title_field_add\":[\"\"],\"sub_title_dashboard\":[\"\"],\"title_academic_class\":[\"\"],\"title_academic_courses\":[\"\"],\"title_academic_examcards\":[\"\"],\"title_payment_configuration_method\":[\"\"],\"field_list_sub_title\":[\"\"],\"title_configuration\":[\"\"],\"title_dashboard\":[\"\"],\"title_academic_department\":[\"\"],\"title_academic_grade_edit\":[\"\"],\"title_academic_exam\":[\"\"],\"title_academic_grade_category_edit\":[\"\"],\"title_edit_fees\":[\"\"],\"title_edit_notice\":[\"\"],\"title_field_edit\":[\"\"],\"title_edit_user\":[\"\"],\"title_fees\":[\"\"],\"title_field_list\":[\"\"],\"title_fees_manage\":[\"\"],\"title_academic_grade\":[\"\"],\"title_academic_grade_category\":[\"\"],\"title_income\":[\"\"],\"title_academic_mark\":[\"\"],\"title_notice\":[\"\"],\"title_parent\":[\"\"],\"title_payment\":[\"\"],\"title_payment_method\":[\"\"],\"title_academic_subject\":[\"\"],\"title_student\":[\"\"],\"title_teacher\":[\"\"],\"title_user\":[\"\"],\"btn_add\":[\"\"],\"btn_cancel\":[\"\"],\"btn_change_password\":[\"\"],\"btn_check_login_activity\":[\"\"],\"btn_change_avatar\":[\"\"],\"btn_login\":[\"\"],\"btn_logout\":[\"\"],\"btn_submit\":[\"\"],\"tab_academic\":[\"\"],\"tab_account\":[\"\"],\"tab_subject\":[\"\"],\"tab_email_template\":[\"\"],\"tab_general\":[\"\"],\"tab_media\":[\"\"],\"tab_mail_configuration\":[\"\"],\"tab_404_page\":[\"\"],\"prent_student_info\":[\"\"],\"tab_payment\":[\"\"],\"tab_theme\":[\"\"],\"system_confirm_delete_msg\":[\"\"],\"system_confirm_trush_msg\":[\"\"],\"system_confirm_reactive_msg\":[\"\"],\"system_access_denied\":[\"\"],\"system_data_delete_failed\":[\"\"],\"system_data_update_successfully\":[\"\"],\"system_data_delete_successfully\":[\"\"],\"system_data_create_failed\":[\"\"],\"system_data_update_failed\":[\"\"],\"exam_card_exists_error\":[\"\"],\"system_data_create_successfully\":[\"\"],\"data_create_successfully_activate\":[\"\"],\"system_email_pass_mismatch\":[\"\"],\"system_excel_file_successfully_upload\":[\"\"],\"system_email_registered\":[\"\"],\"system_no_permission\":[\"\"],\"system_reset_pass\":[\"\"],\"system_pass_link_sent\":[\"\"],\"system_email_failed\":[\"\"],\"system_review_add_success\":[\"\"],\"system_review_add_failed\":[\"\"],\"system_please_select_csv_file\":[\"\"],\"system_pass_update_success\":[\"\"],\"system_pass_update_failed\":[\"\"],\"system_sent_details_error\":[\"\"],\"system_somthing_worng\":[\"\"],\"system_search_mitchmatch\":[\"\"],\"system_old_pass_error\":[\"\"],\"system_data_delete_success\":[\"\"],\"system_data_trush_success\":[\"\"],\"system_save_success\":[\"\"],\"system_save_error\":[\"\"],\"system_data_trush_failed\":[\"\"],\"system_pass_success\":[\"\"],\"system_pass_error\":[\"\"],\"add_edit_delete\":[\"\"],\"action\":[\"\"],\"admin\":[\"\"],\"active\":[\"\"],\"comment\":[\"\"],\"delete\":[\"\"],\"date\":[\"\"],\"edit\":[\"\"],\"email\":[\"\"],\"id\":[\"\"],\"inactive\":[\"\"],\"photo\":[\"\"],\"published\":[\"\"],\"profile_view\":[\"\"],\"profile\":[\"\"],\"phone\":[\"\"],\"print\":[\"\"],\"search\":[\"\"],\"search_here\":[\"\"],\"status\":[\"\"],\"show_status\":[\"\"],\"save\":[\"\"],\"saving\":[\"\"],\"select\":[\"\"],\"show_verified\":[\"\"],\"show_group\":[\"\"],\"trush\":[\"\"],\"unverified\":[\"\"],\"unpublished\":[\"\"],\"verified\":[\"\"],\"month_jan\":[\"\"],\"month_feb\":[\"\"],\"month_mar\":[\"\"],\"month_apr\":[\"\"],\"month_may\":[\"\"],\"month_jun\":[\"\"],\"month_jul\":[\"\"],\"month_aug\":[\"\"],\"month_sep\":[\"\"],\"month_oct\":[\"\"],\"month_nov\":[\"\"],\"month_dec\":[\"\"],\"browser_tab_academicyear_list_title\":[\"\"],\"browser_tab_academic_list_title\":[\"\"],\"browser_tab_accounting_dashboard\":[\"\"],\"browser_tab_add_new_year\":[\"\"],\"browser_tab_addnew_class_title\":[\"\"],\"browser_tab_addnew_course_title\":[\"\"],\"browser_tab_addnew_examcard_title\":[\"\"],\"browser_tab_add_new_subject\":[\"\"],\"browser_tab_add_new_department\":[\"\"],\"browser_tab_add_new_exam\":[\"\"],\"browser_tab_fees_add\":[\"\"],\"browser_tab_gcategory_new\":[\"\"],\"browser_tab_grade_new\":[\"\"],\"browser_tab_add_parent\":[\"\"],\"browser_tab_add_new_students_title\":[\"\"],\"browser_tab_teacher_add\":[\"\"],\"browser_tab_attendances_list_title\":[\"\"],\"browser_tab_add_field\":[\"\"],\"browser_tab_class_list_title\":[\"\"],\"browser_tab_courses_list_title\":[\"\"],\"browser_tab_examcard_list_title\":[\"\"],\"browser_tab_change_password\":[\"\"],\"browser_tab_signup_page_title\":[\"\"],\"browser_tab_configuration_page_title\":[\"\"],\"browser_tab_department_list_title\":[\"\"],\"browser_tab_dashboard_page_title\":[\"\"],\"browser_tab_edit_class_title\":[\"\"],\"browser_tab_edit_course_title\":[\"\"],\"browser_tab_edit_examcard_title\":[\"\"],\"browser_tab_edit_year\":[\"\"],\"browser_tab_edit_subject\":[\"\"],\"browser_tab_edit_department\":[\"\"],\"browser_tab_exam_list_title\":[\"\"],\"browser_tab_edit_exam\":[\"\"],\"browser_tab_gcategory_edit\":[\"\"],\"browser_tab_grade_edit\":[\"\"],\"browser_tab_notice_edit\":[\"\"],\"browser_tab_parent_edit\":[\"\"],\"browser_tab_teacher_edit\":[\"\"],\"browser_tab_fees_manage\":[\"\"],\"browser_tab_fees_edit\":[\"\"],\"browser_tab_edit_field\":[\"\"],\"browser_tab_field_list\":[\"\"],\"browser_tab_gcategory_manage\":[\"\"],\"browser_tab_grade_manage\":[\"\"],\"browser_tab_incomes\":[\"\"],\"browser_tab_mark_title\":[\"\"],\"browser_tab_notice_page_title\":[\"\"],\"browser_tab_notice_new\":[\"\"],\"browser_tab_parent_profile\":[\"\"],\"browser_tab_parent_list_title\":[\"\"],\"browser_tab_title_payment\":[\"\"],\"browser_tab_title_payment_invoice\":[\"\"],\"browser_tab_payment_configuration_method\":[\"\"],\"browser_tab_payment\":[\"\"],\"browser_tab_student_profile\":[\"\"],\"browser_tab_students_list_title\":[\"\"],\"browser_tab_subjects_list_title\":[\"\"],\"browser_tab_teacher_profile\":[\"\"],\"browser_tab_teachers_list_title\":[\"\"],\"browser_tab_user_page_title\":[\"\"],\"academic_year_list\":[\"\"],\"add_new_students_title\":[\"\"],\"assign_parent\":[\"\"],\"add_new_parent_title\":[\"\"],\"add_new_parent\":[\"\"],\"ammount\":[\"\"],\"all\":[\"\"],\"404_page_not_found\":[\"\"],\"class_name\":[\"\"],\"class_list\":[\"\"],\"courses_list\":[\"\"],\"exam_cards_list\":[\"\"],\"create_parent_account\":[\"\"],\"childs_name\":[\"\"],\"childs_info\":[\"\"],\"change_avatar\":[\"\"],\"change_password\":[\"\"],\"created_by\":[\"\"],\"cancel\":[\"\"],\"gcat_name\":[\"\"],\"retype_password\":[\"\"],\"department_list\":[\"\"],\"department_name\":[\"\"],\"course_name\":[\"\"],\"course_code\":[\"\"],\"paper\":[\"\"],\"paper_code\":[\"\"],\"designation\":[\"\"],\"due\":[\"\"],\"exam_list\":[\"\"],\"exam_name\":[\"\"],\"exam_date\":[\"\"],\"excel_file_successfully_upload\":[\"\"],\"edit_students_title\":[\"\"],\"edit_parent_title\":[\"\"],\"edit_parent\":[\"\"],\"empty_list\":[\"\"],\"empty_trush\":[\"\"],\"enter_user_details\":[\"\"],\"full_name\":[\"\"],\"fees\":[\"\"],\"fees_title\":[\"\"],\"forget_password\":[\"\"],\"filter_by_month\":[\"\"],\"filter_by_year\":[\"\"],\"filter_by_status\":[\"\"],\"filter_by_section\":[\"\"],\"field_name\":[\"\"],\"field_type\":[\"\"],\"field_section\":[\"\"],\"field_order\":[\"\"],\"grade_name\":[\"\"],\"grade_point\":[\"\"],\"user_group\":[\"\"],\"hit\":[\"\"],\"invoice\":[\"\"],\"issue\":[\"\"],\"income_list\":[\"\"],\"invoice_to\":[\"\"],\"loading\":[\"\"],\"admin_login_activity\":[\"\"],\"login_page_title\":[\"\"],\"mark_from\":[\"\"],\"mark_upto\":[\"\"],\"mark\":[\"\"],\"method\":[\"\"],\"name\":[\"\"],\"new_password\":[\"\"],\"notice_title\":[\"\"],\"notice_content\":[\"\"],\"no_student_found\":[\"\"],\"obtained\":[\"\"],\"or\":[\"\"],\"online\":[\"\"],\"old_password\":[\"\"],\"parents\":[\"\"],\"paid_by\":[\"\"],\"paid\":[\"\"],\"payment_to\":[\"\"],\"parent_assign\":[\"\"],\"enter_roll\":[\"\"],\"parent_name\":[\"\"],\"parent_list\":[\"\"],\"pending\":[\"\"],\"payment_successfully\":[\"\"],\"payment_failed\":[\"\"],\"passowrd\":[\"\"],\"roll_studentname_mark_comment\":[\"\"],\"review_by\":[\"\"],\"review_comment\":[\"\"],\"reactive_successfully\":[\"\"],\"reactive_failed\":[\"\"],\"remembar_me\":[\"\"],\"recently\":[\"\"],\"review\":[\"\"],\"students\":[\"\"],\"select_students\":[\"\"],\"select_exam\":[\"\"],\"select_class\":[\"\"],\"select_subject\":[\"\"],\"select_department\":[\"\"],\"roll\":[\"\"],\"select_role\":[\"\"],\"student_list\":[\"\"],\"select_year\":[\"\"],\"select_grade_category\":[\"\"],\"student_name\":[\"\"],\"sub_total\":[\"\"],\"subject_name\":[\"\"],\"subject_code\":[\"\"],\"subject_type\":[\"\"],\"subject_list\":[\"\"],\"compulsory_subject\":[\"\"],\"honors_subject\":[\"\"],\"optional_subject\":[\"\"],\"select_month\":[\"\"],\"total\":[\"\"],\"title\":[\"\"],\"total_income\":[\"\"],\"teachers\":[\"\"],\"teacher_name\":[\"\"],\"type_parent_name\":[\"\"],\"user_list\":[\"\"],\"users\":[\"\"],\"upload\":[\"\"],\"unpaid\":[\"\"],\"under_review\":[\"\"],\"user_name\":[\"\"],\"user_loged_in\":[\"\"],\"view_details\":[\"\"],\"year\":[\"\"],\"department\":[\"\"],\"class\":[\"\"],\"semester\":[\"\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_last_login`
--

CREATE TABLE `gl8m_last_login` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `sessionData` varchar(2048) NOT NULL,
  `machineIp` varchar(1024) NOT NULL,
  `userAgent` varchar(128) NOT NULL,
  `agentString` varchar(1024) NOT NULL,
  `platform` varchar(128) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl8m_last_login`
--

INSERT INTO `gl8m_last_login` (`id`, `userId`, `sessionData`, `machineIp`, `userAgent`, `agentString`, `platform`, `createdDtm`) VALUES
(1, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 03:24:03'),
(2, 3, '{\"role\":\"6\",\"roleText\":\"Teacher\",\"name\":\"Rajat Mishra\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 04:09:41'),
(3, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 04:10:49'),
(4, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 04:12:36'),
(5, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 04:19:33'),
(6, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:2e18:3998:cd04:b7f2:7488:a898', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 04:20:01'),
(7, 3, '{\"role\":\"6\",\"roleText\":\"Teacher\",\"name\":\"Rajat Mishra\"}', '2401:4900:3e81:dc57::102c:504a', 'Chrome 103.0.0.0', 'Mozilla/5.0 (Linux; Android 12; SM-M315F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Mobile Safari/537.36', 'Android', '2022-09-07 04:29:44'),
(8, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2401:4900:3e81:d100:1c9d:715f:96b6:88fd', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 09:29:26'),
(9, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2401:4900:3e81:d100:1c9d:715f:96b6:88fd', 'Firefox 104.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0', 'Windows 10', '2022-09-07 10:10:21'),
(10, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\",\"email\":\"student@example.com\",\"avatar\":\"\"}', '2409:4062:2e0e:8677:1c9d:715f:96b6:88fd', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 10:11:21'),
(11, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:2e0e:8677:1c9d:715f:96b6:88fd', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 10:12:43'),
(12, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:2e0e:8677:1c9d:715f:96b6:88fd', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-07 10:18:08'),
(13, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:18:26'),
(14, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\",\"email\":\"student@example.com\",\"avatar\":\"\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:22:12'),
(15, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:22:53'),
(16, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:24:01'),
(17, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '14.140.119.210', 'Firefox 104.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0', 'Windows 10', '2022-09-08 02:28:47'),
(18, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:29:24'),
(19, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:30:19'),
(20, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:31:32'),
(21, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '14.140.119.210', 'Chrome 104.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 02:33:26'),
(22, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 10:07:48'),
(23, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 10:15:30'),
(24, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 10:40:41'),
(25, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-08 16:28:23'),
(26, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-12 09:31:06'),
(27, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 09:20:02'),
(28, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 10:11:28'),
(29, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 11:50:56'),
(30, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 16:38:04'),
(31, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 16:40:16'),
(32, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 16:56:25'),
(33, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '117.99.96.18', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 13:30:11'),
(34, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '117.99.96.18', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 13:31:33'),
(35, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '117.99.96.18', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-13 13:39:41'),
(36, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-15 11:40:07'),
(37, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '::1', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-15 14:38:38'),
(38, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2401:4900:3ea1:d0cf:7ce2:e855:5352:c4a7', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-17 15:40:20'),
(39, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\",\"email\":\"student@example.com\",\"avatar\":\"\"}', '2401:4900:3ea1:d0cf:7ce2:e855:5352:c4a7', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-17 15:45:23'),
(40, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2401:4900:3ea1:d0cf:7ce2:e855:5352:c4a7', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-17 15:47:15'),
(41, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '49.37.44.218', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-24 03:59:27'),
(42, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '49.37.44.218', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-24 04:02:24'),
(43, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '49.37.44.218', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-24 04:03:29'),
(44, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '49.37.44.218', 'Firefox 105.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:105.0) Gecko/20100101 Firefox/105.0', 'Windows 10', '2022-09-24 04:20:43'),
(45, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '49.37.44.218', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36', 'Windows 10', '2022-09-24 04:21:45'),
(46, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '119.155.4.67', 'Chrome 105.0.5195.79', 'Mozilla/5.0 (Linux; Android 11; SM-A505F Build/RP1A.200720.012; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/105.0.5195.79 Mobile Safari/537.36', 'Android', '2022-09-24 06:49:59'),
(47, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '119.155.4.67', 'Chrome 105.0.0.0', 'Mozilla/5.0 (Linux; Android 11; SM-A505F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Mobile Safari/537.36', 'Android', '2022-09-24 06:51:07'),
(48, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.163.51.6', 'Chrome 106.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', 'Windows 10', '2022-10-13 04:48:20'),
(49, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 04:24:40'),
(50, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 04:27:20'),
(51, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 04:27:52'),
(52, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 05:14:08'),
(53, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 05:15:50'),
(54, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 05:16:19'),
(55, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.177.181.192', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 05:49:05'),
(56, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:107:96fa:8198:7732:a3c0:5f7d', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 10:23:05'),
(57, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:107:96fa:8198:7732:a3c0:5f7d', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 11:15:13'),
(58, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:107:96fa:8198:7732:a3c0:5f7d', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-18 11:25:18'),
(59, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:107:96fa:8198:7732:a3c0:5f7d', 'Firefox 107.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:107.0) Gecko/20100101 Firefox/107.0', 'Windows 10', '2022-11-18 11:30:01'),
(60, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:4e86:a581:705b:e75d:da89:1745', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:16:37'),
(61, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:4e86:a581:705b:e75d:da89:1745', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:17:09'),
(62, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '2409:4062:4e86:a581:705b:e75d:da89:1745', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:33:42'),
(63, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '188.43.136.44', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:33:59'),
(64, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '188.43.136.44', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:38:55'),
(65, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:4e86:a581:705b:e75d:da89:1745', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 15:41:24'),
(66, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '2409:4062:4e86:a581:705b:e75d:da89:1745', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-19 16:41:25'),
(67, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '223.235.115.42', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 05:19:37'),
(68, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.59', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 12:11:59'),
(69, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.59', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 13:28:20'),
(70, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.34.169.138', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 16:06:45'),
(71, 3, '{\"role\":\"6\",\"roleText\":\"Teacher\",\"name\":\"Rajat Mishra\"}', '39.34.169.138', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 18:09:56'),
(72, 4, '{\"role\":\"6\",\"roleText\":\"Teacher\",\"name\":\"Kajal\"}', '39.34.169.138', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 18:24:14'),
(73, 3, '{\"role\":\"6\",\"roleText\":\"Teacher\",\"name\":\"Rajat Mishra\"}', '39.34.169.138', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-22 18:43:52'),
(74, 4, '{\"role\":\"5\",\"roleText\":\"Parent\",\"name\":\"Kajal\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 05:46:37'),
(75, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 08:18:32'),
(76, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 08:47:59'),
(77, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 08:50:23'),
(78, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 08:55:09'),
(79, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 09:31:02'),
(80, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '39.62.61.129', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-23 09:34:36'),
(81, 2, '{\"role\":\"4\",\"roleText\":\"Student\",\"name\":\"Debendra Kumar Sahoo\"}', '122.163.49.231', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-24 04:45:48'),
(82, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.163.49.231', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-24 12:15:08'),
(83, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '39.62.61.133', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-29 08:23:13'),
(84, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '39.62.61.133', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-29 13:11:34'),
(85, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '122.163.88.51', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-30 06:05:36'),
(86, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '39.62.61.133', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-11-30 06:10:02'),
(87, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '39.62.61.133', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-12-01 08:31:56'),
(88, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '39.62.61.133', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-12-01 08:36:32'),
(89, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '59.103.216.166', 'Chrome 107.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36', 'Windows 10', '2022-12-02 11:44:10'),
(90, 1, '{\"role\":\"1\",\"roleText\":\"System Administrator\",\"name\":\"admin\",\"email\":\"admin@example.com\",\"avatar\":\"\"}', '157.41.254.102', 'Chrome 108.0.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', 'Windows 10', '2022-12-02 11:45:12');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_messages`
--

CREATE TABLE `gl8m_messages` (
  `id` int(255) NOT NULL,
  `sender_id` int(255) NOT NULL,
  `recever_name` text COLLATE utf8_bin NOT NULL,
  `recever_id` int(255) NOT NULL,
  `subject` text COLLATE utf8_bin NOT NULL,
  `message` longtext COLLATE utf8_bin NOT NULL,
  `status` int(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_message_reply`
--

CREATE TABLE `gl8m_message_reply` (
  `id` int(255) NOT NULL,
  `message_id` int(255) NOT NULL,
  `sender_id` int(255) NOT NULL,
  `recever_id` int(255) NOT NULL,
  `message` longtext COLLATE utf8_bin NOT NULL,
  `status` int(255) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_notice`
--

CREATE TABLE `gl8m_notice` (
  `id` int(255) NOT NULL,
  `title` text NOT NULL,
  `noticeText` text NOT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `groupId` int(25) NOT NULL,
  `users` varchar(255) NOT NULL,
  `readNotice` text NOT NULL,
  `hit` int(255) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateDate` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `createdBy` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_parents`
--

CREATE TABLE `gl8m_parents` (
  `id` int(255) NOT NULL,
  `userid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_payments`
--

CREATE TABLE `gl8m_payments` (
  `id` int(255) NOT NULL,
  `student_id` int(255) NOT NULL,
  `student_class` int(255) NOT NULL,
  `student_department` int(255) NOT NULL,
  `student_roll` varchar(255) COLLATE utf8_bin NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_bin NOT NULL,
  `month` varchar(255) COLLATE utf8_bin NOT NULL,
  `year` varchar(255) COLLATE utf8_bin NOT NULL,
  `fees_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `paid_ammount` decimal(10,2) NOT NULL,
  `due_ammount` decimal(10,2) NOT NULL,
  `status` int(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` text COLLATE utf8_bin NOT NULL,
  `uid` int(255) NOT NULL,
  `txn_id` text COLLATE utf8_bin NOT NULL,
  `review_by` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_payment_method`
--

CREATE TABLE `gl8m_payment_method` (
  `id` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `alias` varchar(255) COLLATE utf8_bin NOT NULL,
  `published` int(255) NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_payment_method`
--

INSERT INTO `gl8m_payment_method` (`id`, `name`, `alias`, `published`, `data`) VALUES
(1, 'Offline', 'offline', 1, '{\"message\":[\"Your payment request is being processed.\"]}'),
(2, 'Paypal', 'paypal', 1, '{\"business\":[\"business-facilitator@zwebtheme.com\"],\"sandbox\":[\"on\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_paypal`
--

CREATE TABLE `gl8m_paypal` (
  `id` int(255) NOT NULL,
  `payer_email` text NOT NULL,
  `payer_id` text NOT NULL,
  `payer_status` text NOT NULL,
  `transaction_id` text NOT NULL,
  `total_paid_amt` text NOT NULL,
  `payment_status` text NOT NULL,
  `payment_type` text NOT NULL,
  `txn_type` text NOT NULL,
  `payment_date` text NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_reset_password`
--

CREATE TABLE `gl8m_reset_password` (
  `id` bigint(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` bigint(20) NOT NULL DEFAULT 1,
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_result_comments`
--

CREATE TABLE `gl8m_result_comments` (
  `id` int(255) NOT NULL,
  `roll` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `class` int(255) NOT NULL,
  `eid` int(255) NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tid` int(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_roles`
--

CREATE TABLE `gl8m_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl8m_roles`
--

INSERT INTO `gl8m_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Admin'),
(3, 'User'),
(4, 'Student'),
(5, 'Parent'),
(6, 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_sessions`
--

CREATE TABLE `gl8m_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  `user` int(255) NOT NULL,
  `role` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_sessions`
--

INSERT INTO `gl8m_sessions` (`id`, `ip_address`, `timestamp`, `data`, `user`, `role`) VALUES
('ca699e4fdc468da097c6b84f45679ac09f2ec845', '122.163.88.51', 1669788677, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393738383637373b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d32392031333a31313a3334223b69734c6f67676564496e7c623a313b, 1, 1),
('7a54c2d1bdec2e67d36763999f98078ec6f6e217', '39.62.61.133', 1669789090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393738393039303b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('58f426c71e7609e2b4d247f85014cbcf96217ec7', '122.163.88.51', 1669789834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393738393833343b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d32392031333a31313a3334223b69734c6f67676564496e7c623a313b, 1, 1),
('8bc3b4c9b50d043ba62cb9f5130e3b4877863946', '39.62.61.133', 1669789410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393738393431303b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('b53e057ef624a64e41bf01af38f41acb18485689', '39.62.61.133', 1669789916, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393738393931363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('127d089eedc4c61df7eef8a4353b0e0557ed4095', '122.163.88.51', 1669793395, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333339353b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d32392031333a31313a3334223b69734c6f67676564496e7c623a313b, 1, 1),
('203a1ca0df3c722ffb3892d70047d2512f8a4c9c', '39.62.61.133', 1669790387, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739303338373b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('10d4f238ee72c4816e94678755dfa334b4197e3b', '39.62.61.133', 1669790982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739303938323b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('63a304c7345430062d7dd82fb67d0f8f346c2c7b', '39.62.61.133', 1669791326, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739313332363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('5dc7e0d5fc2071a40f7ee5fa3555efb95cb12397', '39.62.61.133', 1669791639, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739313633393b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('19783000d9e132f8c62ffd1f29ec98122437559e', '39.62.61.133', 1669791959, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739313935393b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('1c2ef1be784fb7a8d19c5e814a77fd6af52b2ee4', '39.62.61.133', 1669792286, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739323238363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('f6c34960eb630a444e10f7cbb7cf8b46acbc224f', '39.62.61.133', 1669792622, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739323632323b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('a1cf8bcb9e478ec4f8b9415010a08a8111fae8d6', '39.62.61.133', 1669792928, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739323932383b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('0bc69cf853e42efbd73189559a9cfe97f1ed40ae', '39.62.61.133', 1669793241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333234313b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('cd13312176aecdf7f92bf4f79de3ba360c5aca01', '39.62.61.133', 1669793746, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333734363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('3432d2c39521e97cef267d91141da5e84b778336', '122.163.88.51', 1669793994, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333939343b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d32392031333a31313a3334223b69734c6f67676564496e7c623a313b, 1, 1),
('8e88ae1e93482786c5ef39e61929c983c5a45c59', '39.62.61.133', 1669793988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333734363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a30353a3336223b69734c6f67676564496e7c623a313b, 1, 1),
('b0ba6c1802ffa14f028b63d41b9bc98395214c3d', '122.163.88.51', 1669793996, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393739333939343b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d32392031333a31313a3334223b69734c6f67676564496e7c623a313b, 1, 1),
('7c06e19d94a351460ab5fa2f96176b8a0b32d7e1', '39.62.61.133', 1669879590, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393837393539303b, 0, 0),
('8692f28e7d46e1a93cd264fec3ad4ea03cabedb2', '39.62.61.133', 1669883709, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838333530363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31312d33302030363a31303a3032223b69734c6f67676564496e7c623a313b, 1, 1),
('6934c7c5ddff9ddfd8ec2605a1153c8c4938377e', '39.62.61.133', 1669884196, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838343139363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('64902b4ab4b19b0b003cfa760154fa9879ad6c00', '39.62.61.133', 1669884510, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838343531303b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('d2afe22a4b11b5f92265b80baa5e1e3186c40fae', '39.62.61.133', 1669885032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838353033323b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('019182ee7a8505b8e92d17ca8910e1b99834523e', '39.62.61.133', 1669885346, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838353334363b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('8cce9ed4832460d5c5281b9a583b6723652429bc', '39.62.61.133', 1669885723, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838353732333b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('524ab284c1e37ac706c1870237031dff76d41300', '39.62.61.133', 1669887483, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838373438333b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('422528b7386d194c88c3b872431b4c9c76242653', '39.62.61.133', 1669887808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838373830383b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('7b6ebe4b3a9f26dec93b4c1912beb4b37bfa64f4', '39.62.61.133', 1669887827, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393838373830383b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33313a3536223b69734c6f67676564496e7c623a313b, 1, 1),
('a0ab1130f2e9395664ee9b297dfd223d80a01ee0', '59.103.216.166', 1669982219, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393938323231393b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33363a3332223b69734c6f67676564496e7c623a313b, 1, 1),
('605e6362bf43283e381b4a5c4221b63853d2cc95', '52.114.32.28', 1669981481, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393938313438313b, 0, 0),
('8b231accd258e5fde67c70a00cca601d17685cb9', '157.41.254.102', 1669981529, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393938313439353b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30322031313a34343a3130223b69734c6f67676564496e7c623a313b, 1, 1),
('3826a355eee9566fd16d3dcc992df73d4f323a35', '59.103.216.166', 1669982251, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636393938323231393b7573657249647c733a313a2231223b726f6c657c733a313a2231223b726f6c65546578747c733a32303a2253797374656d2041646d696e6973747261746f72223b6e616d657c733a353a2261646d696e223b656d61696c7c733a31373a2261646d696e406578616d706c652e636f6d223b6176617461727c733a303a22223b6c6173744c6f67696e7c733a31393a22323032322d31322d30312030383a33363a3332223b69734c6f67676564496e7c623a313b, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_students`
--

CREATE TABLE `gl8m_students` (
  `id` int(11) NOT NULL,
  `userid` int(255) NOT NULL,
  `student_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `class` text COLLATE utf8_bin NOT NULL,
  `department` text COLLATE utf8_bin NOT NULL,
  `roll` int(30) NOT NULL,
  `year` text COLLATE utf8_bin NOT NULL,
  `parent` int(255) NOT NULL,
  `subjects` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_students`
--

INSERT INTO `gl8m_students` (`id`, `userid`, `student_code`, `class`, `department`, `roll`, `year`, `parent`, `subjects`) VALUES
(1, 2, '', '6', '1', 101, '1', 0, 'a:3:{s:10:\"compulsory\";a:4:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:1:\"5\";}s:8:\"optional\";a:1:{i:0;s:1:\"7\";}s:6:\"honors\";a:1:{i:0;s:1:\"6\";}}'),
(9, 12, '', '6', '1', 111, '1', 0, 'a:3:{s:10:\"compulsory\";N;s:8:\"optional\";N;s:6:\"honors\";N;}'),
(10, 13, '', '6', '1', 112, '1', 0, ''),
(11, 22, '', '6', '1', 1001, '1', 0, 'a:3:{s:10:\"compulsory\";N;s:8:\"optional\";N;s:6:\"honors\";N;}'),
(12, 24, '', '6', '1', 111, '1', 0, ''),
(13, 25, '', '6', '1', 111, '1', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_subjects`
--

CREATE TABLE `gl8m_subjects` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_subjects`
--

INSERT INTO `gl8m_subjects` (`id`, `name`, `code`, `type`) VALUES
(1, 'English', 'En', 'Compulsory'),
(2, 'Math', 'M1', 'Compulsory'),
(3, 'Physics', 'Py', 'Compulsory'),
(4, 'History', 'Hy', 'Compulsory'),
(5, 'Geography', 'Geo', 'Compulsory'),
(6, 'Hindi', 'Hn', 'Honors'),
(7, 'Botany', 'Bt', 'Optional'),
(8, 'Acoounting', 'Ac', 'Compulsory'),
(9, 'Statistics', 'St', 'Compulsory');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_teachers`
--

CREATE TABLE `gl8m_teachers` (
  `id` int(11) NOT NULL,
  `userid` int(255) NOT NULL,
  `designation` text COLLATE utf8_bin NOT NULL,
  `class` varchar(255) COLLATE utf8_bin NOT NULL,
  `subject` varchar(255) COLLATE utf8_bin NOT NULL,
  `department` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gl8m_teachers`
--

INSERT INTO `gl8m_teachers` (`id`, `userid`, `designation`, `class`, `subject`, `department`) VALUES
(1, 3, 'Professor', '1,2', '4', '1'),
(2, 4, 'Assistant professor', '1,2', '1,2,4,5', '1'),
(3, 15, '', '7', '1', '1'),
(4, 16, '', '7', '1', '1'),
(5, 17, '', '7', '1', '1'),
(6, 18, '', '7', '1', '1'),
(7, 19, '', '7', '1', '1'),
(8, 20, '', '7', '1', '1'),
(9, 21, '', '7', '1', '1'),
(10, 23, '', '7', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_update`
--

CREATE TABLE `gl8m_update` (
  `id` int(11) NOT NULL,
  `version` text NOT NULL,
  `install_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gl8m_update`
--

INSERT INTO `gl8m_update` (`id`, `version`, `install_date`) VALUES
(1, '1.1', '2022-09-07 03:19:19');

-- --------------------------------------------------------

--
-- Table structure for table `gl8m_users`
--

CREATE TABLE `gl8m_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `avatar` text NOT NULL COMMENT 'avatar',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `is_verified` int(1) NOT NULL DEFAULT 0,
  `hash` varchar(32) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `active` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gl8m_users`
--

INSERT INTO `gl8m_users` (`userId`, `email`, `password`, `name`, `avatar`, `mobile`, `roleId`, `isDeleted`, `is_verified`, `hash`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`, `active`) VALUES
(1, 'admin@example.com', '$2y$10$tFgtKnrIxsZ18e7ohwpTNOUQRuc92eP6Wnnvn1gsmHCj3AO7EDmWy', 'admin', '', NULL, 1, 0, 1, '', 0, '0000-00-00 00:00:00', NULL, NULL, 0),
(2, 'student@example.com', '$2y$10$Qbnc79NVbgi22KyvCOGC9eRq7Y59HDA5SNTbKutK3bj8Ixk509ise', 'Debendra Kumar Sahoo', 'admin1.png', '03351840056', 4, 0, 1, '', 2, '2022-11-23 08:55:36', NULL, NULL, 1),
(3, 'teacher@example.com', '$2y$10$Px8IgNdiLm2rXhBktPzgoOV9hx5Ay5vT2njbRy9qPYF9ilwCkH87e', 'Rajat Mishra', '', '1234567890', 6, 0, 1, '', 1, '2022-09-07 03:46:57', NULL, NULL, 1),
(4, 'kajal@gmail.com', '$2y$10$Px8IgNdiLm2rXhBktPzgoOV9hx5Ay5vT2njbRy9qPYF9ilwCkH87e', 'Kajal', '', '8978765864', 5, 0, 1, '', 1, '2022-09-08 12:16:48', NULL, NULL, 1),
(12, 'newstudent@gmail.com', '$2y$10$xg.Xoe1REjozHc7wzIaHqe1tNHRIsz.XAVGlDrnM9rk3U130D4.DG', 'Newstudent', '', '03351840056', 4, 0, 1, '', 1, '2022-11-24 12:15:57', NULL, NULL, 1),
(13, 'newstudent1@gmail.com', '$2y$10$Beoqq76jYv48GKMIrXi.5ev.5RCD38G3KdJt7Cb0hpTYrcXKBOvDi', 'Newstudent1', '', '03351840059', 4, 0, 0, '', 0, '2022-11-23 06:29:19', NULL, NULL, 0),
(14, 'teacher@gmail.com', '$2y$10$wX5fq7S3QrUts5pS.9E/6uRLwsJG.doFjUe8ZcETtRZVXJjNySK.2', 'Teacher', '', '03351840056', 4, 0, 0, '', 0, '2022-11-23 07:54:15', NULL, NULL, 0),
(15, 'teacher@gmail.com', '$2y$10$6TaYpCK6mNeHGPTJEbLG7uJhu6LqwMAgah.Q439CFy23fYMCWN8Si', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 07:56:51', NULL, NULL, 0),
(16, 'teacher@gmail.com', '$2y$10$niurcHn.LacKK.AnpnI1Cecn.LR8.zUvURmX8iOozgYLIJGYn41pq', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:00:58', NULL, NULL, 0),
(17, 'teacher@gmail.com', '$2y$10$eZgCCARciSH.A1M9pSj3K.UhyCDycx.RlDvXqkJkxsrGRY6x3KQru', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:02:48', NULL, NULL, 0),
(18, 'teacher@gmail.com', '$2y$10$Zx5327ol0mpz.pf.BLZl8OVcIpODWu1PeTRJlkJVLPmBxeafPz572', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:06:14', NULL, NULL, 0),
(19, 'teacher@gmail.com', '$2y$10$bymmxMVuDKmMizIBnlEi0uXiqM/siYtwF/RAD15AqjkT1wEnm4YqK', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:08:37', NULL, NULL, 0),
(20, 'teacher@gmail.com', '$2y$10$Ihaz1n3PJ1QakadnqOVxr.qhXs.7t2k0YgGfVvrfD4TuvEKgAqsHK', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:10:33', NULL, NULL, 0),
(21, 'teacher@gmail.com', '$2y$10$zDAsDSxgdnO/Uc5MjJCsp.fwyoreyzvOhTB0QOfzLIyrgiEZxc5dS', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-23 08:11:01', NULL, NULL, 0),
(22, 'sonacomplex2013@yahoo.com', '', 'Contemporary World', '', '7008124707', 4, 0, 0, '', 1, '2022-11-24 12:20:04', NULL, NULL, 0),
(23, 'teacher@gmail.com', '$2y$10$GB/u5GR0YBnPpP/KoyIy5O9cAYteUxyaBdfgDgRQY1.GYS56qQuNu', 'teacher', '', '03351840056', 6, 0, 0, '', 0, '2022-11-26 08:42:57', NULL, NULL, 0),
(24, 'student@gmail.com', '$2y$10$/NvGcelx9qUR4jTKa8nJLOxncH4dwvJ5xswbVhA6EtgH5INHcyKe6', 'Student', '', '03351840056', 4, 0, 0, '', 0, '2022-11-26 08:58:16', NULL, NULL, 0),
(25, 'demo@demo.com', '$2y$10$Gn/l4Xb4KR7RDkMihjui..t31b5oDhjiRNRbDFO5fRIRMhSA4GBEq', 'Asdas', '', '1234567890', 4, 0, 0, '', 0, '2022-11-30 05:17:02', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gl8m_academic_year`
--
ALTER TABLE `gl8m_academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_attendance`
--
ALTER TABLE `gl8m_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_attendance_info`
--
ALTER TABLE `gl8m_attendance_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_class`
--
ALTER TABLE `gl8m_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_config`
--
ALTER TABLE `gl8m_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_courses`
--
ALTER TABLE `gl8m_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_course_inquiry`
--
ALTER TABLE `gl8m_course_inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_departments`
--
ALTER TABLE `gl8m_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_exam`
--
ALTER TABLE `gl8m_exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_exam_card`
--
ALTER TABLE `gl8m_exam_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_exam_marks`
--
ALTER TABLE `gl8m_exam_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_fees`
--
ALTER TABLE `gl8m_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_fields`
--
ALTER TABLE `gl8m_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_fields_data`
--
ALTER TABLE `gl8m_fields_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_fields_section`
--
ALTER TABLE `gl8m_fields_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_fields_type`
--
ALTER TABLE `gl8m_fields_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_form_entries`
--
ALTER TABLE `gl8m_form_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_grade`
--
ALTER TABLE `gl8m_grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_grade_category`
--
ALTER TABLE `gl8m_grade_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_languages`
--
ALTER TABLE `gl8m_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_last_login`
--
ALTER TABLE `gl8m_last_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_messages`
--
ALTER TABLE `gl8m_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_message_reply`
--
ALTER TABLE `gl8m_message_reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_notice`
--
ALTER TABLE `gl8m_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_parents`
--
ALTER TABLE `gl8m_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_payments`
--
ALTER TABLE `gl8m_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_payment_method`
--
ALTER TABLE `gl8m_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_paypal`
--
ALTER TABLE `gl8m_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_reset_password`
--
ALTER TABLE `gl8m_reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_result_comments`
--
ALTER TABLE `gl8m_result_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_roles`
--
ALTER TABLE `gl8m_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `gl8m_sessions`
--
ALTER TABLE `gl8m_sessions`
  ADD KEY `8quy_ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `gl8m_students`
--
ALTER TABLE `gl8m_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_subjects`
--
ALTER TABLE `gl8m_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_teachers`
--
ALTER TABLE `gl8m_teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_update`
--
ALTER TABLE `gl8m_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gl8m_users`
--
ALTER TABLE `gl8m_users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gl8m_academic_year`
--
ALTER TABLE `gl8m_academic_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `gl8m_attendance`
--
ALTER TABLE `gl8m_attendance`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_attendance_info`
--
ALTER TABLE `gl8m_attendance_info`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_class`
--
ALTER TABLE `gl8m_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gl8m_config`
--
ALTER TABLE `gl8m_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gl8m_courses`
--
ALTER TABLE `gl8m_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gl8m_course_inquiry`
--
ALTER TABLE `gl8m_course_inquiry`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `gl8m_departments`
--
ALTER TABLE `gl8m_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gl8m_exam`
--
ALTER TABLE `gl8m_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gl8m_exam_card`
--
ALTER TABLE `gl8m_exam_card`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `gl8m_exam_marks`
--
ALTER TABLE `gl8m_exam_marks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gl8m_fees`
--
ALTER TABLE `gl8m_fees`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_fields`
--
ALTER TABLE `gl8m_fields`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `gl8m_fields_data`
--
ALTER TABLE `gl8m_fields_data`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `gl8m_fields_section`
--
ALTER TABLE `gl8m_fields_section`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gl8m_fields_type`
--
ALTER TABLE `gl8m_fields_type`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gl8m_form_entries`
--
ALTER TABLE `gl8m_form_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gl8m_grade`
--
ALTER TABLE `gl8m_grade`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gl8m_grade_category`
--
ALTER TABLE `gl8m_grade_category`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gl8m_languages`
--
ALTER TABLE `gl8m_languages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gl8m_last_login`
--
ALTER TABLE `gl8m_last_login`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `gl8m_messages`
--
ALTER TABLE `gl8m_messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_message_reply`
--
ALTER TABLE `gl8m_message_reply`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_notice`
--
ALTER TABLE `gl8m_notice`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_parents`
--
ALTER TABLE `gl8m_parents`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_payments`
--
ALTER TABLE `gl8m_payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_payment_method`
--
ALTER TABLE `gl8m_payment_method`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gl8m_paypal`
--
ALTER TABLE `gl8m_paypal`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_reset_password`
--
ALTER TABLE `gl8m_reset_password`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_result_comments`
--
ALTER TABLE `gl8m_result_comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl8m_roles`
--
ALTER TABLE `gl8m_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gl8m_students`
--
ALTER TABLE `gl8m_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gl8m_subjects`
--
ALTER TABLE `gl8m_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gl8m_teachers`
--
ALTER TABLE `gl8m_teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gl8m_update`
--
ALTER TABLE `gl8m_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gl8m_users`
--
ALTER TABLE `gl8m_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
