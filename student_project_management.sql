-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 07:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_project_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `project_title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `technology` varchar(150) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `submitted_at` datetime DEFAULT current_timestamp(),
  `project_year` int(11) DEFAULT year(curdate()),
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `student_id`, `project_title`, `description`, `technology`, `file_name`, `status`, `created_at`, `submitted_at`, `project_year`, `feedback`) VALUES
(44, 22, 'qwer', NULL, 'qwer', '1773554295_SPMS.pdf', 'Approved', '2026-03-15 05:58:15', '2026-03-15 11:28:15', 2025, NULL),
(52, 20, 'mano', 'asd', 'php', '1773614406_ilovepdf_merged (3).pdf', 'Rejected', '2026-03-15 22:40:06', '2026-03-16 04:10:06', 2026, NULL),
(54, 77, 'sheik', NULL, 'html', '1773640946_ilovepdf_merged.pdf', 'Approved', '2026-03-16 06:02:26', '2026-03-16 11:32:26', 2024, NULL),
(60, 33, 'sss', NULL, 'html', '1773720456_eg2.pdf', 'Approved', '2026-03-17 04:07:36', '2026-03-17 09:37:36', 2025, NULL),
(61, 14, 'sss', '', 'html', 'eg1.pdf', 'Approved', '2026-03-17 06:55:03', '2026-03-17 12:25:03', 2026, ' good\r\n'),
(62, 14, 'asdfg', '', 'asdfg', '1773790259_student.pdf', 'Approved', '2026-03-17 23:30:59', '2026-03-18 05:00:59', 2026, 'asdd'),
(66, 122, 'awe', NULL, 'html', '1773791763_eg2.pdf', 'Approved', '2026-03-17 23:56:03', '2026-03-18 05:26:03', 2026, NULL),
(67, 3456, '3456', NULL, 'html', '1773792602_student.pdf', 'Approved', '2026-03-18 00:10:02', '2026-03-18 05:40:02', 2024, NULL),
(69, 14, 'student', 'bxf', 'html', '1775459120_turf doc.pdf', 'Approved', '2026-04-06 07:05:20', '2026-04-06 12:35:20', 2026, 'dgf');

-- --------------------------------------------------------

--
-- Table structure for table `project_years`
--

CREATE TABLE `project_years` (
  `id` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_years`
--

INSERT INTO `project_years` (`id`, `year`) VALUES
(4, 2024),
(1, 2025),
(2, 2026);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `register_no` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','faculty','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `register_no`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'ADMIN001', 'admin@gmail.com', '$2y$10$f69OrlhBDPdDrSvQ1PK20ezq75Jj8eRLeDfCp0aSqLC3cN/WwDCiK', 'admin', '2026-01-18 08:05:33'),
(13, 'abc', '1', 'abc@gmail.com', '$2y$10$YUxwRAtTbR/2w3Xv0h6HQOZDwc52H5bibqgB9PoB2CHuG4FuPEjhS', 'faculty', '2026-01-18 07:50:00'),
(14, '123', '123', '123@gmail.com', '$2y$10$QuVa.jQj.IHsEZSQ0Y87ueU1qwzFF2DqS0lchAL.W9UXy6iIueTdC', 'student', '2026-01-18 07:55:03'),
(20, 'mano', '131', 'mano@gmail.com', '$2y$10$GpxISOsn4B9c6GOyrO9m5uLeTxl3nENl3z.nn3x39CYR42u79GNKW', 'student', '2026-03-15 22:39:33'),
(21, 'roopesh', '456', 'roopesh@gmail.com', '$2y$10$50OtcIRbXJy2xDoC7C9uEOHWm3BSibvUpDjqQEJZv7r.xRce4lK1.', 'student', '2026-03-16 22:54:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_years`
--
ALTER TABLE `project_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year` (`year`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `project_years`
--
ALTER TABLE `project_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
