-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 01:40 AM
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
-- Database: `easeblog`
--

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
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `imageID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
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
  `postImage` varchar(255) NOT NULL,
  `postImage2` varchar(255) NOT NULL,
  `postImage3` text NOT NULL,
  `postImage4` text NOT NULL,
  `postImage5` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `title`, `content`, `studID`, `created_at`, `postImage`, `postImage2`, `postImage3`, `postImage4`, `postImage5`) VALUES
(64, 'as', 'as', '22-UR-0776', '2024-03-28 06:53:52', 'images/menu-btn.png', '', '', '', ''),
(65, 'as', 'as', '22-UR-0776', '2024-03-28 06:54:07', 'images/menu-btn.png', '', '', '', ''),
(66, 'sds', 'asa', '22-UR-0776', '2024-03-28 06:57:46', '', '', '', '', ''),
(67, 'Michelle Apartelle', 'asas', '22-UR-0776', '2024-03-28 06:59:36', '', '', '', '', ''),
(68, 'sds', 'ASD', '22-UR-0776', '2024-03-28 07:00:15', '', '', '', '', ''),
(69, 'Michelle Apartelle', 'ASA', '22-UR-0776', '2024-03-28 07:03:40', 'images/menu-btn.png', '', '', '', ''),
(70, 'urdaner', 'asas', '22-UR-0776', '2024-03-28 07:07:56', 'images/menu-btn (2).png', '', '', '', ''),
(71, 'asasasa', 'SAD', '22-UR-0776', '2024-03-28 07:13:21', 'images/menu-btn.png', '', '', '', ''),
(72, 'AS', 'SA', '22-UR-0776', '2024-03-28 07:13:55', 'images/menu-btn (2).png', '', '', '', ''),
(73, 'Michelle Apartelle', 'DD', '22-UR-0776', '2024-03-28 07:15:42', 'images/menu-btn.png', '', '', '', ''),
(74, 'Michelle Apartelle', 'sd', '22-UR-0776', '2024-03-28 07:18:47', 'images/menu-btn.png', '', '', '', ''),
(75, 'asasas', 'sadssasa', '22-UR-0776', '2024-03-28 07:22:53', 'images/menu-btn (2).png', '', '', '', ''),
(78, '12322', '123444', '22-UR-0776', '2024-03-28 07:34:10', 'images/menu-btn (2).png', 'images/menu-btn.png', '', '', ''),
(83, 'Michelle Apartelle', '12345', '22-UR-0776', '2024-03-28 11:21:10', 'images/menu-btn (2).png', 'images/menu-btn.png', 'images/menu-btn (2).png', 'images/menu-btn.png', 'images/menu-btn (2).png'),
(92, 'joanna boarding', 'are we falling like.....like snow on the beach', '21-UR-0123', '2024-03-29 00:40:18', 'images/house.png', '', '', '', '');

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
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`studID`, `firstname`, `lastname`, `username`, `password`) VALUES
('21-UR-0123', 'Joanna Marie', 'Areniego', 'joanna03', '12345678'),
('22-UR-0776', 'janelka', 'a5rw', 'JTamayo', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `postID` (`postID`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`imageID`),
  ADD KEY `postID` (`postID`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `shared_posts`
--
ALTER TABLE `shared_posts`
  MODIFY `shareID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`studID`) REFERENCES `users` (`studID`);

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
