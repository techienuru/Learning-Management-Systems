-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 02:55 PM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin@password');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` int(255) NOT NULL,
  `course_id` int(255) DEFAULT NULL,
  `lecturer_id` int(255) DEFAULT NULL,
  `due_date` date NOT NULL,
  `assignment_file` varchar(5000) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignment_id`, `course_id`, `lecturer_id`, `due_date`, `assignment_file`, `date_created`) VALUES
(1, NULL, NULL, '2024-07-27', 'assignments/cmp notes.docx', '2024-07-26 12:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(255) NOT NULL,
  `course_id` int(255) DEFAULT NULL,
  `class_date` date NOT NULL,
  `class_time` time NOT NULL,
  `online_link` varchar(5000) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `course_id`, `class_date`, `class_time`, `online_link`, `date_created`) VALUES
(1, NULL, '2024-07-26', '03:00:00', 'https://chatgpt.com/c/a69f3213-9885-41cb-87d1-4a61e80fcd58', '2024-07-26 10:59:42'),
(2, NULL, '2024-07-25', '12:10:00', 'https://getbootstrap.com/docs/5.0/components/modal/', '2024-07-26 11:11:29'),
(3, NULL, '2024-07-26', '12:15:00', 'https://www.w3schools.com/', '2024-07-26 11:16:48'),
(4, NULL, '2024-07-26', '23:17:00', 'https://chatgpt.com/c/a69f3213-9885-41cb-87d1-4a61e80fcd58', '2024-07-26 11:17:21'),
(5, NULL, '2024-07-26', '11:17:00', 'https://chatgpt.com/c/a69f3213-9885-41cb-87d1-4a61e80fcd58', '2024-07-26 11:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `course_level` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_title`, `course_level`, `date_added`) VALUES
(5, 'CMP 410', 'Artificial Intelligence', '200', '2024-09-05 09:28:17'),
(6, 'CMP111', 'Introduction to programming', '100', '2024-09-05 09:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `course_assignment`
--

CREATE TABLE `course_assignment` (
  `assignment_id` int(255) NOT NULL,
  `lecturer_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_assignment`
--

INSERT INTO `course_assignment` (`assignment_id`, `lecturer_id`, `course_id`, `date_added`) VALUES
(1, NULL, NULL, '2024-07-25 12:42:12'),
(4, NULL, NULL, '2024-07-25 12:45:20'),
(5, 5, 5, '2024-09-05 09:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `course_material`
--

CREATE TABLE `course_material` (
  `material_id` int(255) NOT NULL,
  `course_id` int(255) DEFAULT NULL,
  `material_type_1` varchar(255) DEFAULT NULL,
  `title_1` varchar(255) DEFAULT NULL,
  `file_1` varchar(5000) DEFAULT NULL,
  `material_type_2` varchar(255) DEFAULT NULL,
  `title_2` varchar(255) DEFAULT NULL,
  `file_2` varchar(5000) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_material`
--

INSERT INTO `course_material` (`material_id`, `course_id`, `material_type_1`, `title_1`, `file_1`, `material_type_2`, `title_2`, `file_2`, `date_added`) VALUES
(1, NULL, 'video', 'Introduction to OOP', './course-materials/video/african_praise_loop_130_bpm_practice_tool_x_live_use_30_minutes_6054646861073037289.mp3', 'pdf', 'Introduction to OOP', './course-materials/pdf/cmp notes 1.pdf', '2024-07-25 16:27:23'),
(2, NULL, 'video', 'Introduction to JS', 'course-materials/video/worship 1.mp3', '', '', '', '2024-07-25 16:29:00'),
(3, NULL, '', '', '', 'pdf', 'Introduction to', 'course-materials/pdf/2014_Book_ThePythonWorkbook.pdf', '2024-07-25 16:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int(255) NOT NULL,
  `ua_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `grade_score` int(255) NOT NULL,
  `date_graded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`grade_id`, `ua_id`, `course_id`, `grade_score`, `date_graded`) VALUES
(2, 1, NULL, 44, '2024-07-29 14:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `firstname`, `surname`, `email`, `faculty`, `department`, `password`) VALUES
(5, 'Prof ', 'Mathew ', 'profmathew@gmail.com', 'Engineering', 'Electrical Engineering', '1');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `othername` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `matricno` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_approved?` varchar(255) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstname`, `lastname`, `othername`, `email`, `matricno`, `password`, `is_approved?`, `date_time`) VALUES
(1, 'Nuru', 'Isah', 'shehu', 'drsidi@gmail.com', '0219047000204', '1', '1', '2024-07-24 11:33:39'),
(2, 'Mark', 'Mathew', 'Agya', 'sidi@gmail.com', '1234567890', '1', NULL, '2024-07-24 11:35:46'),
(3, 'Mark', 'Mathew', 'Agya', 'sidi@gmail.com', '1234567890', '123', '1', '2024-07-24 11:36:39'),
(5, 'Abdullahi', 'Adamu', '', 'abdullahi@gmail.com', '1234567890', '1', '1', '2024-07-24 16:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `student_course_id` int(255) NOT NULL,
  `student_id` int(255) DEFAULT NULL,
  `course_id` int(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_assignment`
--

CREATE TABLE `uploaded_assignment` (
  `ua_id` int(255) NOT NULL,
  `assignment_id` int(255) DEFAULT NULL,
  `student_id` int(255) DEFAULT NULL,
  `ua_file` varchar(5000) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploaded_assignment`
--

INSERT INTO `uploaded_assignment` (`ua_id`, `assignment_id`, `student_id`, `ua_file`, `date_submitted`) VALUES
(1, 1, 1, 'assignments/Algorithm.docx', '2024-07-29 11:21:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `join assignment & course` (`course_id`),
  ADD KEY `join assignment & lecturer` (`lecturer_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `join class & course` (`course_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_assignment`
--
ALTER TABLE `course_assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `join course_assigment & course_id` (`course_id`),
  ADD KEY `join course_assigment & lecturer_id` (`lecturer_id`);

--
-- Indexes for table `course_material`
--
ALTER TABLE `course_material`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `join course_material & course_id` (`course_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `join grade & course` (`course_id`),
  ADD KEY `join grade & ua` (`ua_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`student_course_id`),
  ADD KEY `join student_course & student` (`student_id`),
  ADD KEY `join student_course & course` (`course_id`);

--
-- Indexes for table `uploaded_assignment`
--
ALTER TABLE `uploaded_assignment`
  ADD PRIMARY KEY (`ua_id`),
  ADD KEY `join uploaded_assignment & assignment` (`assignment_id`),
  ADD KEY `join uploaded_assignment & student` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_assignment`
--
ALTER TABLE `course_assignment`
  MODIFY `assignment_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_material`
--
ALTER TABLE `course_material`
  MODIFY `material_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_course`
--
ALTER TABLE `student_course`
  MODIFY `student_course_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uploaded_assignment`
--
ALTER TABLE `uploaded_assignment`
  MODIFY `ua_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `join assignment & course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `join assignment & lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE SET NULL;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `join class & course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL;

--
-- Constraints for table `course_assignment`
--
ALTER TABLE `course_assignment`
  ADD CONSTRAINT `join course_assigment & course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `join course_assigment & lecturer_id` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`) ON DELETE SET NULL;

--
-- Constraints for table `course_material`
--
ALTER TABLE `course_material`
  ADD CONSTRAINT `join course_material & course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL;

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `join grade & course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `join grade & ua` FOREIGN KEY (`ua_id`) REFERENCES `uploaded_assignment` (`ua_id`) ON DELETE SET NULL;

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `join student_course & course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `join student_course & student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL;

--
-- Constraints for table `uploaded_assignment`
--
ALTER TABLE `uploaded_assignment`
  ADD CONSTRAINT `join uploaded_assignment & assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `join uploaded_assignment & student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
