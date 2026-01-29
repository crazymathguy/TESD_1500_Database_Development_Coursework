-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 22, 2026 at 06:36 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `summer_camp`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergy_information`
--

CREATE TABLE `allergy_information` (
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `allergy` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `allergy_information`
--

INSERT INTO `allergy_information` (`applicant_id`, `allergy`) VALUES
(1, 'dairy'),
(2, 'gluten'),
(4, 'hay fever'),
(4, 'peanuts'),
(5, 'sugar'),
(10, 'cats'),
(10, 'dairy'),
(10, 'dogs'),
(10, 'gluten');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `first_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `age` tinyint(3) UNSIGNED NOT NULL,
  `gender` char(6) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_address` varchar(256) NOT NULL,
  `shirt_size` char(2) NOT NULL,
  `status` char(9) NOT NULL DEFAULT 'Submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`applicant_id`, `first_name`, `last_name`, `age`, `gender`, `phone_number`, `email_address`, `shirt_size`, `status`) VALUES
(1, 'Sean', 'Briggs', 17, 'Male', '+10123456789', 'sean@example.com', 'M', 'In Review'),
(2, 'Thomas', 'Briggs', 14, 'Male', '+10001112222', 'thomas@example.com', 'S', 'In Review'),
(3, 'Charlotte', 'Briggs', 12, 'Female', '+14729572901', 'charlotte@example.com', 'XS', 'Submitted'),
(4, 'Someone', 'Else', 32, 'Other', '+19876543210', 'someone@example.com', 'XL', 'Rejected'),
(5, 'Random', 'Person', 42, 'Female', '+12749551630', 'random@example.com', 'L', 'Accepted'),
(6, 'Random', 'Different Person', 20, 'Male', '+13453453456', 'random2@example.com', 'XL', 'Rejected'),
(10, 'John', 'Doe', 20, 'Other', '+11111111111', 'jdoe@example.com', 'S', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `review_id` int(10) UNSIGNED NOT NULL,
  `applicant_id` int(10) UNSIGNED NOT NULL,
  `feedback` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`review_id`, `applicant_id`, `feedback`) VALUES
(1, 1, 'It was fun.'),
(2, 2, 'I loved it so much!\nIt could be better if you had more dances.'),
(3, 3, 'It was scary at first, but I did enjoy myself by the end.'),
(4, 5, 'I am coming next year!'),
(5, 4, 'I had a bad experience'),
(7, 1, 'Oh, yeah!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergy_information`
--
ALTER TABLE `allergy_information`
  ADD PRIMARY KEY (`applicant_id`,`allergy`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`applicant_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `applicant_id` (`applicant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `applicant_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allergy_information`
--
ALTER TABLE `allergy_information`
  ADD CONSTRAINT `allergy_information_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`applicant_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`applicant_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
