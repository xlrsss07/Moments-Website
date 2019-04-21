-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-04-03 22:11:44
-- 服务器版本： 5.7.19-log
-- PHP Version: 7.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_website`
--

-- --------------------------------------------------------

--
-- 替换视图以便查看 `abc`
-- (See below for the actual view)
--
CREATE TABLE `abc` (
);

-- --------------------------------------------------------

--
-- 表的结构 `association`
--

CREATE TABLE `association` (
  `association_ID` smallint(5) UNSIGNED NOT NULL,
  `association_name` tinytext NOT NULL,
  `memberNum` smallint(5) UNSIGNED NOT NULL,
  `association_description` text,
  `association_contact` varchar(20) DEFAULT NULL,
  `association_address` varchar(255) DEFAULT NULL,
  `is_department` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `association`
--

INSERT INTO `association` (`association_ID`, `association_name`, `memberNum`, `association_description`, `association_contact`, `association_address`, `is_department`) VALUES
(1, 'assocaition_test1', 5, 'We are based in the heart of Liverpool at St Philip Neri Church in Catharine Street and are open to all university students in Liverpool. It is a place where everyone is welcome and supported, whether they are already Catholic or are just interested!', '(+44) 757662043123', 'St. Philip Neri Church, 30 Catharine Street, L8 7NL 1234567890123', 0);

-- --------------------------------------------------------

--
-- 表的结构 `association_touser`
--

CREATE TABLE `association_touser` (
  `touser_ID` smallint(5) UNSIGNED NOT NULL,
  `chatroom_ID` smallint(5) UNSIGNED NOT NULL,
  `user_ID` smallint(5) UNSIGNED NOT NULL,
  `user_displayname` varchar(30) NOT NULL,
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `user_sendlasttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `association_touser`
--

INSERT INTO `association_touser` (`touser_ID`, `chatroom_ID`, `user_ID`, `user_displayname`, `user_level`, `user_sendlasttime`) VALUES
(1, 1, 1, 'fuck', 1, '2019-03-23 23:14:00'),
(2, 1, 2, 'fuck1', 1, '2019-03-23 23:14:00'),
(3, 1, 3, 'fuck2', 1, '2019-03-23 23:14:00');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `comment_ID` int(10) UNSIGNED NOT NULL,
  `comment_asso_ID` smallint(5) UNSIGNED NOT NULL,
  `comment_event_ID` mediumint(8) UNSIGNED NOT NULL,
  `comment_display_name` varchar(30) NOT NULL,
  `comment_author_IP` varchar(100) DEFAULT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text,
  `comment_agent` varchar(255) DEFAULT NULL,
  `comment_user_ID` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`comment_ID`, `comment_asso_ID`, `comment_event_ID`, `comment_display_name`, `comment_author_IP`, `comment_date`, `comment_content`, `comment_agent`, `comment_user_ID`) VALUES
(1, 1, 1, 'NaMgAlSiP', '127.0.0.1', '2019-04-03 13:29:00', 'I really enjoy this activity. It is so fun.I really enjoy this activity. It is so fun.I really enjoy this activity. It is so fun.I really enjoy this activity. It is so fun. (One information for 0.5 RMB)', '', 6),
(2, 1, 1, 'fuck4', '127.0.0.1', '2019-04-03 13:39:00', 'I really hate this activity.', '', 5);

-- --------------------------------------------------------

--
-- 表的结构 `event`
--

CREATE TABLE `event` (
  `event_ID` mediumint(8) UNSIGNED NOT NULL,
  `event_name` text NOT NULL,
  `event_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_location` varchar(255) DEFAULT 'Unknown',
  `event_description` text,
  `event_member` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `asso_ID` smallint(5) UNSIGNED NOT NULL,
  `association_name` text NOT NULL,
  `event_status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `event`
--

INSERT INTO `event` (`event_ID`, `event_name`, `event_date`, `event_location`, `event_description`, `event_member`, `asso_ID`, `association_name`, `event_status`) VALUES
(1, 'thisisevent1', '2019-03-25 22:41:00', 'this is event1 location\r\nTEST\r\ntest', 'this is event1 description', 0, 1, 'assocaition_test1', 0),
(2, 'thisisevent2', '2019-03-25 22:41:00', 'this is event2 location', 'this is event2 description', 0, 1, 'assocaition_test1', 0),
(3, 'thisisevent3', '2019-03-25 22:41:00', 'this is event3 location', 'this is event3 description', 0, 1, 'assocaition_test1', 0),
(4, 'thisisevent4', '2019-03-25 22:41:00', 'this is event1 location', 'this is event4 description', 0, 1, 'assocaition_test1', 0),
(5, 'thisisevent5', '2019-03-25 22:41:00', 'this is event5 location', 'this is event5 description', 0, 1, 'assocaition_test1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `groupmsg`
--

CREATE TABLE `groupmsg` (
  `msg_ID` int(10) UNSIGNED NOT NULL,
  `chatroom_ID` smallint(5) UNSIGNED NOT NULL,
  `msg_senderID` smallint(5) UNSIGNED NOT NULL,
  `msg_sendername` varchar(30) NOT NULL,
  `msg_senderIP` varchar(100) DEFAULT NULL,
  `msg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `msg_content` text NOT NULL,
  `msg_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `groupmsg`
--

INSERT INTO `groupmsg` (`msg_ID`, `chatroom_ID`, `msg_senderID`, `msg_sendername`, `msg_senderIP`, `msg_date`, `msg_content`, `msg_agent`) VALUES
(1, 1, 1, 'fucking', '127.0.0.1', '2019-03-25 23:31:00', 'Say hello to every one!', NULL),
(2, 1, 2, 'fucking1', '127.0.0.1', '2019-03-25 23:33:00', 'OK~~', NULL),
(3, 1, 2, 'fucking1', '127.0.0.1', '2019-03-25 23:35:00', 'testing our website.', NULL),
(4, 1, 3, 'fucking2', '127.0.0.1', '2019-03-25 23:37:00', 'FUCK,FUCK,FUCK', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `usermeta`
--

CREATE TABLE `usermeta` (
  `umeta_id` smallint(5) UNSIGNED NOT NULL,
  `user_id` smallint(5) UNSIGNED NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `usermeta`
--

INSERT INTO `usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'subscribe_association', '1'),
(2, 2, 'subscribe_association', '1'),
(3, 3, 'subscribe_association', '1'),
(4, 4, 'subscribe_association', '1'),
(5, 5, 'subscribe_association', '1');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `ID` smallint(5) UNSIGNED NOT NULL,
  `user_login` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_pass` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `user_registered` datetime DEFAULT '0000-00-00 00:00:00',
  `display_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `profile_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`ID`, `user_login`, `user_pass`, `user_email`, `user_registered`, `display_name`, `profile_name`) VALUES
(1, 'test', '123456', 'test@qq.com', '2019-03-23 23:14:00', 'fuck', NULL),
(2, 'test1', '123456', NULL, '2019-03-25 20:38:31', 'fuck1', NULL),
(3, 'test2', '123456', NULL, '2019-03-25 20:38:57', 'fuck2', NULL),
(4, 'test3', '123456', NULL, '2019-03-25 20:39:03', 'fuck3', NULL),
(5, 'test4', '123456', NULL, '2019-03-25 20:39:08', 'fuck4', NULL),
(6, 'test5', '123456', NULL, '2019-03-25 20:39:15', 'NaMgAlSiP', NULL);

-- --------------------------------------------------------

--
-- 视图结构 `abc`
--
DROP TABLE IF EXISTS `abc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `abc`  AS  select `user`.`username` AS `username`,`user`.`password` AS `pass` from `user` WITH CASCADED CHECK OPTION ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`association_ID`);

--
-- Indexes for table `association_touser`
--
ALTER TABLE `association_touser`
  ADD PRIMARY KEY (`touser_ID`),
  ADD KEY `touser_chat` (`chatroom_ID`),
  ADD KEY `touser_userID` (`user_ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_asso_ID` (`comment_asso_ID`),
  ADD KEY `comment_event_ID` (`comment_event_ID`),
  ADD KEY `comment_user_ID` (`comment_user_ID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_ID`),
  ADD KEY `event_association_ID` (`asso_ID`);

--
-- Indexes for table `groupmsg`
--
ALTER TABLE `groupmsg`
  ADD PRIMARY KEY (`msg_ID`),
  ADD KEY `groupmsg_senderID` (`msg_senderID`);

--
-- Indexes for table `usermeta`
--
ALTER TABLE `usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `usermeta_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `association`
--
ALTER TABLE `association`
  MODIFY `association_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `association_touser`
--
ALTER TABLE `association_touser`
  MODIFY `touser_ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `event`
--
ALTER TABLE `event`
  MODIFY `event_ID` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `groupmsg`
--
ALTER TABLE `groupmsg`
  MODIFY `msg_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `umeta_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `ID` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 限制导出的表
--

--
-- 限制表 `association_touser`
--
ALTER TABLE `association_touser`
  ADD CONSTRAINT `touser_chat` FOREIGN KEY (`chatroom_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `touser_userID` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- 限制表 `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_asso_ID` FOREIGN KEY (`comment_asso_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_event_ID` FOREIGN KEY (`comment_event_ID`) REFERENCES `event` (`event_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user_ID` FOREIGN KEY (`comment_user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_association_ID` FOREIGN KEY (`asso_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE;

--
-- 限制表 `groupmsg`
--
ALTER TABLE `groupmsg`
  ADD CONSTRAINT `groupmsg_senderID` FOREIGN KEY (`msg_senderID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- 限制表 `usermeta`
--
ALTER TABLE `usermeta`
  ADD CONSTRAINT `usermeta_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
