-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 07:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easeblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `accept_reports`
--

CREATE TABLE `accept_reports` (
  `acceptID` int(11) NOT NULL,
  `reportID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `reporterID` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `report_created_at` int(11) NOT NULL,
  `status` enum('approved') NOT NULL DEFAULT 'approved',
  `accepted_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `studID` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `commentCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faqID` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faqID`, `question`, `answer`) VALUES
(1, 'What is PSUnian Space?', 'PSUnian Space is a platform for sharing and discovering blog posts on various topics that can be used to enhace student engagements.'),
(2, 'How do I create a new post?', 'To create a new post, go to the \"Create Post\" page, fill in the required details such as title, content and insert images, and then click the submit button. Take note that posts should still be appropriate.'),
(3, 'Can I edit my posts after publishing?', 'Yes, you can edit your posts after publishing. Open the profile page where you can see your posts, simply navigate to the post you want to edit and click on the edit button.');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favID` int(11) NOT NULL,
  `studID` varchar(20) NOT NULL,
  `postID` int(11) NOT NULL,
  `fav_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE `groupmembers` (
  `gmID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `studID` varchar(20) NOT NULL,
  `is_moderator` enum('0','1') NOT NULL DEFAULT '0',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupID` int(11) NOT NULL,
  `groupname` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `group_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_comments`
--

CREATE TABLE `group_comments` (
  `gcommentID` int(11) NOT NULL,
  `gpostID` int(11) DEFAULT NULL,
  `studID` varchar(20) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `commentCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_likes`
--

CREATE TABLE `group_likes` (
  `glikeID` int(11) NOT NULL,
  `gpostID` int(11) DEFAULT NULL,
  `studID` varchar(20) DEFAULT NULL,
  `likeCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_posts`
--

CREATE TABLE `group_posts` (
  `gpostID` int(11) NOT NULL,
  `groupID` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `studID` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `studID` varchar(20) NOT NULL,
  `likeCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `studID` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` text NOT NULL,
  `report` enum('undefined','rejected','approved') DEFAULT 'undefined'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rejectedreports`
--

CREATE TABLE `rejectedreports` (
  `rejectID` int(11) NOT NULL,
  `reportID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `reporterID` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `report_created_at` varchar(255) NOT NULL,
  `status` enum('reject') NOT NULL DEFAULT 'reject',
  `rejected_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `reporterID` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `report_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shared_posts`
--

CREATE TABLE `shared_posts` (
  `shareID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `shared_by_studID` varchar(50) NOT NULL,
  `shared_from_studID` varchar(50) NOT NULL,
  `shared_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `studID` varchar(20) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_registered` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `course` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`studID`, `firstname`, `lastname`, `username`, `password`, `date_registered`, `email`, `bio`, `course`) VALUES
('21-UR-0123', 'Joanna Marie', 'Areniego', 'joanna', '12345', '2024-04-12', 'jareniego_21ur0123@psu.edu.ph', 'EME', 'Bachelor of Science in Information Technology'),
('admin', '', '', 'admin', 'admin123', '2024-04-07', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accept_reports`
--
ALTER TABLE `accept_reports`
  ADD PRIMARY KEY (`acceptID`),
  ADD KEY `ForeignKeyy1` (`reporterID`),
  ADD KEY `ForeignKeyy2` (`postID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faqID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favID`),
  ADD KEY `favorites_ibfk_1` (`postID`),
  ADD KEY `favorites_ibfk_2` (`studID`);

--
-- Indexes for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD PRIMARY KEY (`gmID`),
  ADD UNIQUE KEY `unique_group_member` (`groupID`,`studID`),
  ADD KEY `groupmembers_ibfk_2` (`studID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupID`),
  ADD KEY `groups_ibfk_1` (`created_by`);

--
-- Indexes for table `group_comments`
--
ALTER TABLE `group_comments`
  ADD PRIMARY KEY (`gcommentID`),
  ADD KEY `group_comments_ibfk_1` (`gpostID`),
  ADD KEY `group_comments_ibfk_2` (`studID`);

--
-- Indexes for table `group_likes`
--
ALTER TABLE `group_likes`
  ADD PRIMARY KEY (`glikeID`),
  ADD KEY `group_likes_ibfk_1` (`gpostID`),
  ADD KEY `group_likes_ibfk_2` (`studID`);

--
-- Indexes for table `group_posts`
--
ALTER TABLE `group_posts`
  ADD PRIMARY KEY (`gpostID`),
  ADD KEY `group_posts_ibfk_1` (`groupID`),
  ADD KEY `group_posts_ibfk_2` (`studID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `rejectedreports`
--
ALTER TABLE `rejectedreports`
  ADD PRIMARY KEY (`rejectID`),
  ADD KEY `ForeignKey` (`postID`),
  ADD KEY `ForeignKey1` (`reporterID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `reporterID` (`reporterID`);

--
-- Indexes for table `shared_posts`
--
ALTER TABLE `shared_posts`
  ADD PRIMARY KEY (`shareID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `shared_by_studID` (`shared_by_studID`),
  ADD KEY `shared_from_studID` (`shared_from_studID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`studID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accept_reports`
--
ALTER TABLE `accept_reports`
  MODIFY `acceptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `groupmembers`
--
ALTER TABLE `groupmembers`
  MODIFY `gmID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `group_comments`
--
ALTER TABLE `group_comments`
  MODIFY `gcommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_likes`
--
ALTER TABLE `group_likes`
  MODIFY `glikeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `group_posts`
--
ALTER TABLE `group_posts`
  MODIFY `gpostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `rejectedreports`
--
ALTER TABLE `rejectedreports`
  MODIFY `rejectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `shared_posts`
--
ALTER TABLE `shared_posts`
  MODIFY `shareID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accept_reports`
--
ALTER TABLE `accept_reports`
  ADD CONSTRAINT `ForeignKeyy1` FOREIGN KEY (`reporterID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ForeignKeyy2` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD CONSTRAINT `groupmembers_ibfk_1` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groupmembers_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_comments`
--
ALTER TABLE `group_comments`
  ADD CONSTRAINT `group_comments_ibfk_1` FOREIGN KEY (`gpostID`) REFERENCES `group_posts` (`gpostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_comments_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_likes`
--
ALTER TABLE `group_likes`
  ADD CONSTRAINT `group_likes_ibfk_1` FOREIGN KEY (`gpostID`) REFERENCES `group_posts` (`gpostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_likes_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_posts`
--
ALTER TABLE `group_posts`
  ADD CONSTRAINT `group_posts_ibfk_1` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_posts_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`) ON DELETE CASCADE;

--
-- Constraints for table `rejectedreports`
--
ALTER TABLE `rejectedreports`
  ADD CONSTRAINT `ForeignKey` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ForeignKey1` FOREIGN KEY (`reporterID`) REFERENCES `users` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reporterID`) REFERENCES `users` (`studID`);

--
-- Constraints for table `shared_posts`
--
ALTER TABLE `shared_posts`
  ADD CONSTRAINT `shared_posts_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`),
  ADD CONSTRAINT `shared_posts_ibfk_2` FOREIGN KEY (`shared_by_studID`) REFERENCES `users` (`studID`),
  ADD CONSTRAINT `shared_posts_ibfk_3` FOREIGN KEY (`shared_from_studID`) REFERENCES `users` (`studID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
