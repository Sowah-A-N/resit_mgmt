-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 01:44 PM
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
-- Database: `resitportaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `approval_id` int(11) NOT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `approved_by` enum('HOD','registrar') NOT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('approved','rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `department_id`) VALUES
(4, 'BCME 102', 'Programming With C++', 1),
(5, 'BCME 106', 'Digital Circuit Design', 1),
(6, 'BINT 102', 'Leadership and Ethical Issues in IT', 1),
(7, 'BINT 104', 'Introduction to Web Design and Internet Technologies', 1),
(8, 'BINT 106', 'Basic Digital Electronics', 1),
(9, 'DITE 101', 'Introduction to Computing', 1),
(10, 'DITE 103', 'Principles of Programming and Problem Solving', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `status` enum('Pending','Approved') DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `archived`) VALUES
(1, 'ICT', 0),
(2, 'MARINE', 0),
(3, 'NAUTICAL', 0),
(4, 'ELECTRICAL', 0),
(5, 'TRANSPORT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` int(11) DEFAULT NULL,
  `regulation` varchar(50) DEFAULT NULL,
  `category` varchar(25) DEFAULT '`UPGRADE`',
  `program_code` varchar(20) DEFAULT NULL,
  `index_code` varchar(5) DEFAULT NULL,
  `faculty` varchar(100) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `dur_format` varchar(50) DEFAULT NULL,
  `num_of_semesters` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `department`, `regulation`, `category`, `program_code`, `index_code`, `faculty`, `duration`, `dur_format`, `num_of_semesters`, `updated_at`) VALUES
(2, 'M.Sc. BIO-PROCESS ENGINEERING', NULL, '1', 'MASTERS', 'MSC', 'MBE', 'ENGINEERING AND APPLIED SCIENCES', '3', 'semester', 3, '2022-12-14 12:16:28'),
(3, 'M.Sc. ENVIRONMENTAL ENGINEERING', NULL, '1', 'MASTERS', 'MSC', 'MEE', 'ENGINEERING AND APPLIED SCIENCES', '3', 'semester', 3, '2022-12-14 12:16:28'),
(4, 'M.A. PORTS AND SHIPPING ADMINISTRATION', NULL, '1', 'MASTERS', 'MA', 'MPS', 'MARITIME STUDIES', '1', 'year', 2, '2022-12-14 12:16:28'),
(5, 'B.Sc. NAUTICAL SCIENCE', 3, '1', 'DEGREE', 'BSC', 'BNS', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(6, 'B.Sc. MARINE ENGINEERING', 2, '1', 'DEGREE', 'BSC', 'BME', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(7, 'B.Sc. MECHANICAL ENGINEERING', NULL, '1', 'DEGREE', 'BSC', 'BMT', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(8, 'B.Sc. COMPUTER ENGINEERING', 1, '1', 'DEGREE', 'BSC', 'BCE', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(9, 'B.Sc. COMPUTER SCIENCE', 1, '1', 'DEGREE', 'BSC', 'BCS', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(10, 'B.Sc. ELECTRICAL/ELECTRONIC ENGINEERING', 4, '1', 'DEGREE', 'BSC', 'BEE', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(11, 'B.Sc. ACCOUNTING', 5, '1', 'DEGREE', 'BSC', 'BAC', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(12, 'B.Sc. INFORMATION TECHNOLOGY', 1, '1', 'DEGREE', 'BSC', 'BIT', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(13, 'B.Sc. PORT AND SHIPPING ADMINISTRATION', 5, '1', 'DEGREE', 'BSC', 'BPS', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(14, 'B.Sc. LOGISTICS MANAGEMENT', 5, '1', 'DEGREE', 'BSC', 'BLG', NULL, '4', 'year', 8, '2022-12-14 12:16:28'),
(15, 'Diploma IN BANKING TECHNOLOGY AND ACCOUNTING', 5, '1', 'DIPLOMA', 'DIPLOMA', 'BTA', NULL, '2', NULL, 4, '2022-12-14 12:16:28'),
(16, 'Diploma IN ACCOUNTING WITH INFORMATION TECHNOLOGY', 5, '1', 'DIPLOMA', 'DIPLOMA', 'AIT', NULL, '2', NULL, 4, '2022-12-14 12:16:28'),
(17, 'Diploma IN INFORMATION TECHNOLOGY', 1, '1', 'DIPLOMA', 'DIPLOMA', 'DIT', NULL, '2', NULL, 4, '2022-12-14 12:16:28'),
(19, 'MARINE ENGINE MECHANICS', NULL, '1', 'SHORT', 'MEM', 'MEM', NULL, NULL, NULL, NULL, '2023-06-05 14:32:23'),
(20, 'CILT, DILT AND ADILT', NULL, '1', 'SHORT', 'CDA', 'CDA', NULL, NULL, NULL, NULL, '2023-06-05 20:22:07'),
(21, 'B.Sc. PROCUREMENT AND OPERATIONS MANAGEMENT', 5, '1', 'DEGREE', 'BSC', 'BPO', NULL, '4', 'year', 8, '2023-06-05 20:24:09'),
(22, 'Diploma IN NAUTICAL SCIENCE', 3, '1', 'DIPLOMA', 'DIPLOMA', 'DNS', NULL, '2', 'year', 4, '2023-06-13 15:01:25'),
(23, 'Diploma IN MARINE ENGINEERING', 2, '1', 'DIPLOMA', 'DIPLOMA', 'DME', NULL, '2', 'year', 4, '2023-06-13 15:02:21'),
(24, 'Diploma ELECTRICAL/ELECTRONIC ENGINNERING', 4, '1', 'DIPLOMA', 'DIPLOMA', 'DEE', NULL, '2', 'year', 4, '2023-06-13 15:03:40'),
(25, 'M.Sc. INTERNATIONAL SHIPPING AND LOGISTICS', NULL, '1', 'MASTERS', 'MSC', 'MIS', 'MARITIME STUDIES', '3', 'semester', 3, '2023-06-14 20:31:45'),
(26, 'M.Sc. SUBSEA ENGINEERING', NULL, '1', 'MASTERS', 'MSC', 'MSA', 'ENGINEERING AND APPLIED SCIENCES', '3', 'semester', 3, '2023-06-14 20:32:46'),
(28, 'B.Sc. NAVAL ARCHITECTURE, SMALL CRAFT AND OCEAN ENGINEERING', 3, '1', 'DEGREE', 'BSC', 'BNA', NULL, '4', 'year', 8, '2023-06-14 20:44:27'),
(29, 'DIPLOMA IN PORTS AND SHIPPING MANAGEMENT', 5, '1', 'DIPLOMA', 'DIPLOMA', 'DPS', NULL, '2', 'year', 4, '2023-06-14 20:46:17'),
(30, 'MASTER (UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:10:31'),
(31, 'MASTER (NEAR COASTAL, UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:10:51'),
(32, 'MASTER (LESS THAN 3000 GT)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:11:23'),
(33, 'MASTER (NEAR COASTAL, LESS THAN 500)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:12:05'),
(34, 'CHIEF MATE (UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:12:25'),
(35, 'CHIEF MATE (NEAR COASTAL, UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:12:39'),
(36, 'CHIEF MATE (LESS THAN 3000 GT)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:13:23'),
(37, 'OOW(DECK)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:13:38'),
(38, 'OOW (DECK, NEAR COASTAL, LESS THAN 500) ', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:13:57'),
(39, 'CHIEF ENGINEER (UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:14:25'),
(40, 'CHIEF ENGINEER (LESS THAN 3000KW)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:14:40'),
(41, 'CHIEF ENGINEER (UNLIMITED, NEAR COASTAL)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:14:57'),
(42, 'CHIEF ENGINEER (LESS THAN 3000 KW, NEAR COASTAL)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:15:13'),
(43, 'SECOND ENGINEER (UNLIMITED)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:15:32'),
(44, 'SECOND ENGINEER (UNLIMITED, NEAR COASTAL)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:15:48'),
(45, 'SECOND ENGINEER (LESS THAN 300KW)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:16:07'),
(46, 'SECOND ENGINEER (LESS THAN 3000,  NEAR COASTAL)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:17:19'),
(47, 'OOW (ENGINE)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:17:34'),
(48, 'OOW ENGINE (NEAR COASTAL)', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:17:51'),
(49, 'ELECTRO-TECHNICAL OFFICER', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:18:07'),
(50, 'GMDSS', NULL, '1', 'UPGRADE', 'UPGRADE', NULL, NULL, NULL, NULL, NULL, '2023-06-30 13:18:21'),
(51, 'M.Sc. RENEWABLE ENERGY ENGINEERING', NULL, '1', 'MASTERS', 'MSC', 'MRE', NULL, '3', 'semester', 3, '2024-01-11 23:04:18'),
(52, 'M.Sc. RENEWABLE ENERGY ENGINEERING', NULL, '1', 'MASTERS', 'MSC', 'MRE', NULL, '3', 'semester', 3, '2024-01-11 23:04:18'),
(1115, '455', 1, '111', '`UPGRADE`', '111', '111', '111', '11', '11', 11, '2024-02-29 11:54:53'),
(1116, '4545', 545, '45', '555', '45454', '4545', '4', '4545', '55', 5, '2024-02-29 12:24:04');

-- --------------------------------------------------------

--
-- Table structure for table `resit_registrations`
--

CREATE TABLE `resit_registrations` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `student_id` int(11) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `index_number` varchar(10) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`student_id`, `full_name`, `email`, `index_number`, `department`, `program`, `role`, `password`) VALUES
(1, 'Abeka Bernard Kwaku', 'bernard.abeka@st.rmu.edu.gh', 'BCE0000224', '1', 'B.Sc. COMPUTER ENGINEERING', 'student', '$2y$10$JmqaDALyfHnjc81vjKiCfe2tZhpT.1p9.SWjZJpii/jijq7fhf67K'),
(2, 'Eben Appiah', 'bernardabeka7@gmail.com', 'BCE0000125', '1', 'B.Sc. COMPUTER ENGINEERING', 'student', '$2y$10$MYMk0wZtvxwB//HLgK7SHuVvCnP/M0vcgErbhFuhvX0SKJT8elmMS'),
(3, 'Saho Yusuf', 'boyblaq09@gmail.com', 'BCE0001025', '1', 'B.Sc. COMPUTER ENGINEERING', 'student', '$2y$10$WkLFrSs8qjYkzJQ1PkV1uuKsHV1k/A3yGO1RPUS0tuN5r6eazFi5C');

-- --------------------------------------------------------

--
-- Table structure for table `student_payment_info`
--

CREATE TABLE `student_payment_info` (
  `id` int(11) NOT NULL,
  `index_number` varchar(10) DEFAULT NULL,
  `receipt_num` varchar(10) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `number_of_courses` tinyint(1) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_payment_info`
--

INSERT INTO `student_payment_info` (`id`, `index_number`, `receipt_num`, `amount`, `number_of_courses`, `submission_date`) VALUES
(1, 'BCE0000224', 'rpt0001', '300.00', 3, '2025-02-10 12:41:56'),
(2, 'BCE0001025', 'rpt0005', '400.00', 4, '2025-02-17 12:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','cashier','HOD','registrar','student','exam_unit') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin123', 'admin', '2024-11-14 10:03:31'),
(2, 'cashier1', 'cashier123', 'cashier', '2024-11-14 10:03:31'),
(3, 'hod1', 'hod12345', 'HOD', '2024-11-14 10:03:31'),
(4, 'registrar1', 'reg12345', 'registrar', '2024-11-14 10:03:31'),
(5, 'exam_unit1', 'exam1234', 'exam_unit', '2024-11-14 10:03:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`approval_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `resit_registrations`
--
ALTER TABLE `resit_registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD UNIQUE KEY `student_id_2` (`student_id`),
  ADD UNIQUE KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`) USING BTREE;

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_payment_info`
--
ALTER TABLE `student_payment_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_num` (`receipt_num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_payment_info`
--
ALTER TABLE `student_payment_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `resit_registrations` (`registration_id`) ON DELETE CASCADE;

--
-- Constraints for table `resit_registrations`
--
ALTER TABLE `resit_registrations`
  ADD CONSTRAINT `resit_registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resit_registrations_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
