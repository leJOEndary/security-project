-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2019 at 09:01 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tweety`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `comment` varchar(140) NOT NULL,
  `commentOn` int(11) NOT NULL,
  `commentBy` int(11) NOT NULL,
  `commentAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `comment`, `commentOn`, `commentBy`, `commentAt`) VALUES
(13, 'comment', 149, 1, '2019-04-20 19:21:35'),
(14, 'gamed', 166, 1, '2019-04-20 23:18:43'),
(27, 'babaaa', 171, 1, '2019-04-21 14:12:01'),
(29, 'enta asad', 192, 1, '2019-04-21 17:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `followID` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `followOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`followID`, `sender`, `receiver`, `followOn`) VALUES
(53, 21, 1, '0000-00-00 00:00:00'),
(54, 21, 7, '0000-00-00 00:00:00'),
(55, 21, 5, '0000-00-00 00:00:00'),
(56, 21, 19, '0000-00-00 00:00:00'),
(61, 1, 6, '0000-00-00 00:00:00'),
(62, 1, 21, '0000-00-00 00:00:00'),
(63, 1, 19, '0000-00-00 00:00:00'),
(64, 1, 22, '0000-00-00 00:00:00'),
(65, 1, 7, '0000-00-00 00:00:00'),
(66, 1, 18, '0000-00-00 00:00:00'),
(67, 1, 23, '0000-00-00 00:00:00'),
(68, 1, 5, '0000-00-00 00:00:00'),
(69, 21, 18, '0000-00-00 00:00:00'),
(70, 21, 23, '0000-00-00 00:00:00'),
(71, 21, 6, '0000-00-00 00:00:00'),
(72, 21, 22, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `likeBy` int(11) NOT NULL,
  `likeOn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likeID`, `likeBy`, `likeOn`) VALUES
(236, 1, 174),
(237, 1, 209),
(238, 1, 174),
(239, 1, 192),
(240, 22, 174),
(241, 21, 217),
(242, 21, 192),
(243, 21, 192),
(244, 1, 170),
(245, 1, 170),
(246, 1, 170),
(247, 1, 170),
(248, 1, 170),
(249, 1, 170),
(250, 1, 170),
(251, 1, 170),
(252, 21, 212),
(253, 21, 212),
(254, 21, 212),
(255, 21, 216),
(256, 1, 220),
(257, 1, 223),
(258, 1, 232),
(259, 1, 218);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `message` text NOT NULL,
  `messageTo` int(11) NOT NULL,
  `messageFrom` int(11) NOT NULL,
  `messageOn` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `message`, `messageTo`, `messageFrom`, `messageOn`, `status`) VALUES
(1, 'hi', 21, 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `trendID` int(11) NOT NULL,
  `hashtag` varchar(140) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`trendID`, `hashtag`, `createdOn`) VALUES
(1, 'php', '0000-00-00 00:00:00'),
(2, '#awlhashtag #tanyhashtag', '2019-04-18 01:01:12'),
(4, 'awlhashtag', '2019-04-18 01:04:48'),
(5, 'tanyhashtag', '2019-04-18 01:04:48'),
(6, 'woho', '2019-04-18 13:52:54'),
(7, 'graduation', '2019-04-18 15:46:47'),
(8, 'photoshoot', '2019-04-18 15:46:47'),
(9, 'socialmediaslaves', '2019-04-18 15:46:47'),
(10, 'fun', '2019-04-18 15:46:47'),
(11, 'hashtags', '2019-04-18 15:46:47'),
(12, 'HeavyWeights', '2019-04-18 15:48:00'),
(13, 't5ate5', '2019-04-18 15:48:00'),
(14, 'to5an', '2019-04-18 20:36:07'),
(17, 'kimo', '2019-04-18 22:40:51'),
(18, 'FIRST_TWEET', '2019-04-20 21:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweetID` int(11) NOT NULL,
  `status` varchar(140) NOT NULL,
  `tweetBy` int(11) NOT NULL,
  `retweetID` int(11) NOT NULL,
  `retweetBy` int(11) NOT NULL,
  `tweetImage` varchar(255) NOT NULL,
  `likesCount` int(11) NOT NULL,
  `retweetCount` int(11) NOT NULL,
  `postedOn` datetime NOT NULL,
  `retweetMsg` varchar(140) NOT NULL,
  `privateTweet` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tweetID`, `status`, `tweetBy`, `retweetID`, `retweetBy`, `tweetImage`, `likesCount`, `retweetCount`, `postedOn`, `retweetMsg`, `privateTweet`) VALUES
(212, '@hatem1', 1, 0, 0, '', 1, 0, '2019-04-22 11:16:56', '', 0),
(216, '@hatem1', 1, 0, 0, '', 1, 0, '2019-04-22 13:40:39', '', 0),
(218, '&lt;script&gt;alert(\'XSS\');&lt;/script&gt;', 22, 0, 0, '', 1, 0, '2019-04-23 11:47:04', '', 0),
(220, '&lt;script&gt;alert(\'XSS\');&lt;/script&gt;', 22, 0, 0, '', 1, 0, '2019-04-23 11:48:15', '', 0),
(222, 'Very private', 21, 0, 0, '', 0, 0, '2019-04-24 00:51:28', '', 1),
(223, 'hhaahha bazt', 21, 0, 0, '', 1, 0, '2019-04-24 01:00:53', '', 0),
(225, 'private', 1, 0, 0, '', 0, 0, '2019-04-24 11:33:03', '', 1),
(227, 'private', 1, 0, 0, '', 0, 0, '2019-04-24 12:04:24', '', 1),
(229, 'so private', 21, 0, 0, '', 0, 0, '2019-04-24 21:19:29', '', 1),
(230, 'besm ellah mashalla', 21, 0, 0, '', 0, 0, '2019-04-24 21:27:40', '', 1),
(232, 'a5r test', 21, 0, 0, '', 1, 0, '2019-04-24 21:57:01', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `screenName` varchar(40) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `following` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `bio` varchar(140) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `salt` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `screenName`, `profileImage`, `profileCover`, `following`, `followers`, `bio`, `country`, `website`, `private`, `salt`) VALUES
(1, 'AmrHatem', 'amr@hotmail.com', '9b248d820a0535afce2cfa7d8287bff3', 'Amr Hatem', 'users/51402248_2239384566337117_5860640990318034944_n.jpg', 'users/pexels-photo-248797.jpeg', 8, 1, '', '', '', 1, '5cbc5dfb1ba37c'),
(5, 'atef', 'asdas@asf.comsdg', '7ace0319f202215e282e38272b2e30ad', '3atef', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, ''),
(6, 'baha', 'XBEX@HOG.COM', 'b780ec5b573746d42fd7147eeb53b716', 'bahaa', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, ''),
(7, 'alaa', 'asdas@asf.comsdgS', '7124faded03c2181c2aa7489b6942aca', 'alaa', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, ''),
(18, 'kareem', 'kareem@kareem.com', '35ae3d69bdd2d3fdcc497ab7690eb168', 'kareem', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, '5cbb77696e016'),
(19, 'youssef', 'youssef@youssef.com', '4e17920b657496182525972c49f22a81', 'youssef', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 1, '5cbb7c7b82e72'),
(21, 'hatem1', 'hatem@hatem.com', '40a400dbc0663d652d697dee797ec9ad', 'Hatem Tharwat', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 8, 1, '', '', '', 1, '5cbc5dfb1ba37'),
(22, 'kareem1', 'kareem@labib.com', 'e22b5335e9148b567489670538c81be0', 'kareem', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, '5cbede7494641'),
(23, 'newnew', 'new@new.com', 'c38dbb8e397d414302a1d2f476806e9c', 'new', 'assets/images/defaultProfileImage.png', 'assets/images/defaultCoverImage.png', 0, 2, '', '', '', 0, '5cc4ab28e4b8a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`followID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`trendID`),
  ADD UNIQUE KEY `hashtag` (`hashtag`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweetID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `trendID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
