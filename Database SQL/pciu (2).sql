-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 01:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pciu`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `courseCode`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(194, 'hi', 'cse222_a', 'parves_erfan', 'parves_erfan', '2024-04-23 16:49:16', 'no', 709);

-- --------------------------------------------------------

--
-- Table structure for table `createclass`
--

CREATE TABLE `createclass` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `className` varchar(50) NOT NULL,
  `section` varchar(25) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `student_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `createclass`
--

INSERT INTO `createclass` (`id`, `username`, `className`, `section`, `subject`, `courseCode`, `date`, `student_array`) VALUES
(125, 'parves_erfan', 'cse222', 'a', 'map', 'cse222_a', '2024-04-23', 'sadman_raafi ,');

-- --------------------------------------------------------

--
-- Table structure for table `joinclass`
--

CREATE TABLE `joinclass` (
  `user_id_fk` int(11) NOT NULL,
  `class_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `joinclass`
--

INSERT INTO `joinclass` (`user_id_fk`, `class_id_fk`) VALUES
(386, 0),
(386, 124),
(387, 122),
(387, 124),
(389, 124),
(389, 125);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `files` varchar(500) DEFAULT NULL,
  `fileDestination` varchar(500) NOT NULL,
  `marks` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `courseCode`, `user_to`, `date_added`, `files`, `fileDestination`, `marks`) VALUES
(709, 'Hello Guys!', 'parves_erfan', 'cse222_a', 'none', '2024-04-23 16:28:55', 'none', 'none', NULL),
(710, '', 'parves_erfan', 'cse222_a', 'none', '2024-04-23 16:29:08', 'parves_erfan_66278d749a99b_cse222_a.pdf', 'Uploaded byparves_erfan_66278d749a99b_cse222_a.pdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `phoneNumber` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `profilePic`, `signup_date`, `phoneNumber`) VALUES
(386, 'Parves', 'Erfan', 'parves_erfan', 'mdperrfan@gmail.com', 'a01610228fe998f515a72dd730294d87', '', '2024-04-05', 0),
(387, 'Syed', 'Hasin', 'syed_hasin', 'hasin@gmail.com', 'b59c67bf196a4758191e42f76670ceba', '', '2024-04-05', 0),
(388, 'Tosif', 'Reza', 'tosif_reza', 'reza@gmail.com', 'b59c67bf196a4758191e42f76670ceba', '', '2024-04-05', 0),
(389, 'Sadman', 'Raafi', 'sadman_raafi', 'raafi@mail.com', 'a01610228fe998f515a72dd730294d87', '', '2024-04-05', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `createclass`
--
ALTER TABLE `createclass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joinclass`
--
ALTER TABLE `joinclass`
  ADD PRIMARY KEY (`user_id_fk`,`class_id_fk`),
  ADD KEY `user_id_fk` (`user_id_fk`),
  ADD KEY `class_id_fk` (`class_id_fk`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `createclass`
--
ALTER TABLE `createclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=711;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
