-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 06:53 PM
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
-- Database: `student_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_code` varchar(50) DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `units` int(11) DEFAULT 0,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `day_id`, `subject_name`, `subject_code`, `instructor`, `units`, `start_time`, `end_time`, `room`, `created_at`) VALUES
(8, 2, 'Information Technology 101', 'IT101', 'Prof. Jino Estillore', 19, '08:00:00', '08:50:00', 'IT ROOM 1', '2026-05-18 12:55:43'),
(9, 1, 'Web Development', 'IT101', 'Prof. Dela Cruz', 3, '08:00:00', '10:00:00', 'Room 204', '2026-05-18 12:57:00'),
(10, 1, 'Database Systems', 'CS102', 'Ms. Santos', 3, '10:30:00', '12:00:00', 'Lab 301', '2026-05-18 12:57:00'),
(11, 2, 'Discrete Mathematics', 'MATH201', 'Dr. Reyes', 4, '09:00:00', '11:00:00', 'Room 105', '2026-05-18 12:57:00'),
(12, 3, 'Computer Programming', 'CS105', 'Mr. Garcia', 3, '01:00:00', '03:00:00', 'Lab 202', '2026-05-18 12:57:00'),
(13, 4, 'Human Computer Interaction', 'IT205', 'Prof. Villanueva', 3, '07:30:00', '09:00:00', 'Room 410', '2026-05-18 12:57:00'),
(14, 1, 'Networking Fundamentals', 'NET201', 'Mr. Ramirez', 3, '01:00:00', '03:00:00', 'Lab 101', '2026-05-18 16:49:44'),
(15, 1, 'Software Engineering', 'SE301', 'Engr. Bautista', 3, '03:00:00', '05:00:00', 'Room 205', '2026-05-18 16:49:44'),
(16, 2, 'Mobile Application Development', 'MAD202', 'Ms. Fernandez', 3, '10:00:00', '12:00:00', 'IT ROOM 2', '2026-05-18 16:49:44'),
(17, 2, 'Operating Systems', 'CS210', 'Dr. Mendoza', 4, '01:00:00', '03:00:00', 'Lab 303', '2026-05-18 16:49:44'),
(18, 3, 'Data Structures and Algorithms', 'CS220', 'Prof. Navarro', 4, '08:00:00', '10:00:00', 'Lab 201', '2026-05-18 16:49:44'),
(19, 3, 'Cybersecurity Basics', 'CYB101', 'Mr. Aquino', 3, '10:30:00', '12:00:00', 'Room 402', '2026-05-18 16:49:44'),
(20, 4, 'Artificial Intelligence', 'AI401', 'Dr. Lim', 3, '09:00:00', '11:00:00', 'AI Lab', '2026-05-18 16:49:44'),
(21, 4, 'Cloud Computing', 'CC305', 'Ms. Torres', 3, '01:00:00', '03:00:00', 'Room 501', '2026-05-18 16:49:44'),
(22, 5, 'Capstone Project', 'CAP401', 'Prof. Evangelista', 6, '08:00:00', '11:00:00', 'Research Room', '2026-05-18 16:49:44'),
(23, 5, 'System Analysis and Design', 'SAD203', 'Mr. Cruz', 3, '01:00:00', '03:00:00', 'Room 208', '2026-05-18 16:49:44'),
(24, 9, 'Sample Subject Name', 'Sample Subject', 'Sample Instructor', 21, '13:00:00', '14:59:00', 'Sample Room 101', '2026-05-18 16:52:50'),
(25, 10, 'Web Development 001', 'WD001', 'Prof. Jino Estillore', 21, '08:00:00', '09:00:00', 'IT ROOM 3', '2026-05-19 14:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_days`
--

CREATE TABLE `schedule_days` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_days`
--

INSERT INTO `schedule_days` (`id`, `user_id`, `day_name`) VALUES
(1, 1, 'Monday'),
(2, 1, 'Tuesday'),
(3, 1, 'Wednesday'),
(4, 1, 'Thursday'),
(5, 1, 'Friday'),
(6, 1, 'Saturday'),
(7, 1, 'Sunday'),
(8, 3, 'Monday'),
(9, 5, 'Monday'),
(10, 15, 'Monday'),
(11, 15, 'Tuesday'),
(12, 15, 'Wednesday');

-- --------------------------------------------------------

--
-- Table structure for table `subject_notes`
--

CREATE TABLE `subject_notes` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_notes`
--

INSERT INTO `subject_notes` (`id`, `schedule_id`, `title`, `content`, `created_at`) VALUES
(1, 8, 'Sample Title', 'This is just a sample content of my notes', '2026-05-18 15:32:34'),
(4, 8, 'Sample Title 2', 'This is just a sample content of my sample title 2.', '2026-05-18 15:41:08'),
(5, 8, 'Sample Title 3', 'This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3. This is just a sample content of my sample title 3.', '2026-05-18 16:07:02'),
(6, 8, 'For Keeps', 'This is the first paragraph.\r\n\r\nNow this is the second.\r\n\r\nAnd this is the thirdAnd this is the thirdAnd this is the thirdAnd this is the thirdAnd this is the third', '2026-05-18 16:17:04'),
(12, 8, 'asddddddddddddddddddddddddddddddddddddddasdas', 'dasdasd', '2026-05-18 17:54:14'),
(13, 8, 'asdddddddddddddddddddddasdasdasdass', 'asdasd', '2026-05-18 17:59:58'),
(16, 25, 'Sample Note', 'Smaple Contents', '2026-05-19 14:43:19'),
(17, 25, 'sfs', 'fsdf', '2026-05-19 14:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `subject_tasks`
--

CREATE TABLE `subject_tasks` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_tasks`
--

INSERT INTO `subject_tasks` (`id`, `schedule_id`, `title`, `description`, `due_date`, `status`, `created_at`) VALUES
(1, 8, 'Sample Task', 'This is a sample description of the Sample Task.\r\n\r\nThis is a sample description of the Sample Task.This is a sample description of the Sample Task.This is a sample description of the Sample Task.', '2026-05-20', 'Pending', '2026-05-18 17:22:03'),
(3, 8, 'asdasd', 'asdasdas', '2026-05-21', 'Pending', '2026-05-18 18:15:19'),
(4, 8, 'asdasd', 'adasdasdasd', '2026-05-18', 'Completed', '2026-05-18 18:15:26'),
(5, 8, 'asdasd', 'asdasdasd', '2026-05-29', 'Pending', '2026-05-18 18:15:32'),
(6, 8, 'sd', 'adsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwwwadsaaaaaaaaaaaaaaadassssssssssssdawwwwwwwwwwwwwwwwwwwwwwwwwww', '2026-05-18', 'Pending', '2026-05-18 18:35:56'),
(8, 21, 'Sample Task', 'Sample description of this task', '2026-05-20', 'Pending', '2026-05-18 19:46:42'),
(9, 8, 'asd12adsadasdasdasdawdawrqwqwewqeqwedasdsafsfsdgdgdgdfgdfawd', 'asdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadadaasdasdasdadsadada', '2026-05-22', 'Pending', '2026-05-19 08:27:08'),
(11, 25, 'Test', 'testss', '2026-05-21', 'Pending', '2026-05-19 14:51:23'),
(12, 25, 'asdasd', 'asd', '2026-05-22', 'Pending', '2026-05-19 14:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `subject_topics`
--

CREATE TABLE `subject_topics` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `status` enum('Upcoming','Ongoing','Completed') DEFAULT 'Upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `mastery_level` enum('Not Started','Studying','Mastered') DEFAULT 'Not Started'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_topics`
--

INSERT INTO `subject_topics` (`id`, `schedule_id`, `topic_name`, `status`, `created_at`, `description`, `mastery_level`) VALUES
(1, 21, 'HTML Designs', 'Upcoming', '2026-05-18 19:34:19', 'Just a designing for HTML', 'Not Started'),
(2, 21, 'HTML Basics', 'Upcoming', '2026-05-18 19:42:30', 'A foundation and fundamentals of HTML', 'Studying'),
(3, 21, 'OOP', 'Upcoming', '2026-05-18 19:45:40', 'A programming paradigm fundamental to many programming languages, including Java and C++. In this article, we\'ll provide an overview of the basic concepts of OOP.', 'Mastered'),
(4, 8, 'Web Designs', 'Upcoming', '2026-05-19 07:59:57', 'HTML Web Design Structure for UI', 'Not Started'),
(5, 8, 'OOP 101', 'Upcoming', '2026-05-19 08:43:54', 'Object Oriented Programming fundamentals for that organizes software design around \"objects\" (data and behavior) rather than logic', 'Studying'),
(6, 8, 'Sample Topic', 'Upcoming', '2026-05-19 08:50:43', 'A sample topic description for testing purposes only', 'Mastered'),
(9, 10, 'MYSQL', 'Upcoming', '2026-05-19 10:15:04', 'A widely used relational database management system (RDBMS). MySQL is free and open-source.', 'Not Started'),
(11, 25, 'HTML Designs', 'Upcoming', '2026-05-19 14:15:39', 'A sample description of this topic HTML Designs', 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `topic_files`
--

CREATE TABLE `topic_files` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic_files`
--

INSERT INTO `topic_files` (`id`, `topic_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(1, 4, 'jino-estillore-ai-certificate.pdf', 'uploads/topic_files/topic_6a0c329571a683.58047276.pdf', '2026-05-19 09:51:17'),
(2, 4, 'Chapter_1.docx', 'uploads/topic_files/topic_6a0c32ce776707.00768803.docx', '2026-05-19 09:52:14'),
(4, 4, 'af9583b0-4516-404e-9178-8bfc995a93a9.jfif', 'uploads/topic_files/topic_6a0c332877f069.51239182.jfif', '2026-05-19 09:53:44'),
(5, 4, 'Narrative-Report-Jino.docx', 'uploads/topic_files/topic_6a0c34e2987000.35851395.docx', '2026-05-19 10:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `topic_highlights`
--

CREATE TABLE `topic_highlights` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic_highlights`
--

INSERT INTO `topic_highlights` (`id`, `topic_id`, `content`, `created_at`) VALUES
(1, 4, '1. This is a sample content to highlights.\r\n2. This is the second sample.\r\n3. This is the third highlight of the topic', '2026-05-19 08:24:42'),
(2, 4, '1. An example of a highlight\r\n  1.1. Second type of a highlight\r\n  1.2. A type of highlight\r\n2. Second Example of an important highlight.\r\n3. The third highlight is about the highlights.', '2026-05-19 08:57:27'),
(4, 4, 'Part I.\r\n\r\n1. An example of a highlight\r\n1.1. Second type of a highlight\r\n1.2. A type of highlight\r\n2. Second Example of an important highlight.\r\n3. The third highlight is about the highlights.\r\n\r\nPart II.\r\n\r\n1. This is a sample content to highlights.\r\n2. This is the second sample.\r\n3. This is the third highlight of the topic', '2026-05-19 09:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `topic_questions`
--

CREATE TABLE `topic_questions` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic_questions`
--

INSERT INTO `topic_questions` (`id`, `topic_id`, `question`, `answer`, `created_at`) VALUES
(1, 4, 'What is the 3rd planet of our Solar System?', 'Earth', '2026-05-19 15:28:37'),
(2, 4, 'What is encapsulation in OOP?', 'Encapsulation is the bundling of data and methods into a single unit (class).', '2026-05-19 15:40:48'),
(3, 4, 'What is a database index?', 'A database index improves the speed of data retrieval operations on a table.', '2026-05-19 15:40:48'),
(4, 4, 'What is HTML?', 'HTML is a markup language for creating web pages.', '2026-05-19 15:42:26'),
(5, 4, 'What is CSS?', 'CSS is used to style HTML elements.', '2026-05-19 15:42:26'),
(6, 4, 'What is JavaScript?', 'JavaScript adds interactivity to web pages.', '2026-05-19 15:42:26'),
(7, 4, 'What is a database?', 'A database is used to store and manage data.', '2026-05-19 15:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `created_at`) VALUES
(1, 'Jino Estillore', 'jinoestillore@email.com', '$2y$10$bNBnaCOZXLvr7Wsjdj6jx.qfUoJpRHgbicCEnctTugpZvSWV7p4/2', '2026-05-06 16:39:09'),
(2, 'Jino Student', 'jinostudent@email.com', '$2y$10$7cyArqkdZOa7/4wVt0nOwOhY2Ih4kdiDuznKdWZHY0.QFMQan9hg.', '2026-05-06 17:48:38'),
(3, 'Student One', 'jino1@email.com', '$2y$10$hqNG90caB/0J9NiMK80WM.Gtq5cNO1FaH43bgjOCXlaBOX0.z0kMe', '2026-05-09 16:35:27'),
(5, 'Jin Estillore', 'jinoes@email.com', '$2y$10$54QHpBbrMj2COBodBD/aA.KUkLquR16o.6WnGdwH11W1WFPhCQEji', '2026-05-18 13:56:06'),
(6, 'Student Two', 'studenttwo@email.com', '$2y$10$ZRIqfvudakjNzxEjW7eWd.CWx.nCKjmJef6f2.y/WpzAa02A8vDOC', '2026-05-19 13:42:42'),
(8, 'John Cena', 'jino2@email.com', '$2y$10$XQtH1MdT.3WEQXagkkrBBu2sNJVw8XDzfKe6aOOdTW.4nhrRXgxmi', '2026-05-19 13:47:46'),
(15, 'Jin Mori', 'jin@email.com', '$2y$10$.vCHXqYcZPNgddKF190VKe/CmYOonxtdPbOhHm9NpLLG4AQ.lyPry', '2026-05-19 14:03:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_days`
--
ALTER TABLE `schedule_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_notes`
--
ALTER TABLE `subject_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `subject_tasks`
--
ALTER TABLE `subject_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `subject_topics`
--
ALTER TABLE `subject_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `topic_files`
--
ALTER TABLE `topic_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topic_highlights`
--
ALTER TABLE `topic_highlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topic_questions`
--
ALTER TABLE `topic_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `schedule_days`
--
ALTER TABLE `schedule_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subject_notes`
--
ALTER TABLE `subject_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `subject_tasks`
--
ALTER TABLE `subject_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subject_topics`
--
ALTER TABLE `subject_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `topic_files`
--
ALTER TABLE `topic_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `topic_highlights`
--
ALTER TABLE `topic_highlights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `topic_questions`
--
ALTER TABLE `topic_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subject_notes`
--
ALTER TABLE `subject_notes`
  ADD CONSTRAINT `subject_notes_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_tasks`
--
ALTER TABLE `subject_tasks`
  ADD CONSTRAINT `subject_tasks_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_topics`
--
ALTER TABLE `subject_topics`
  ADD CONSTRAINT `subject_topics_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_files`
--
ALTER TABLE `topic_files`
  ADD CONSTRAINT `topic_files_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `subject_topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_highlights`
--
ALTER TABLE `topic_highlights`
  ADD CONSTRAINT `topic_highlights_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `subject_topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topic_questions`
--
ALTER TABLE `topic_questions`
  ADD CONSTRAINT `topic_questions_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `subject_topics` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
