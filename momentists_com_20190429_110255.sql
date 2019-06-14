-- MySQL dump 10.13  Distrib 5.5.54, for Win64 (AMD64)
--
-- Host: localhost    Database: momentists_com
-- ------------------------------------------------------
-- Server version	5.5.54-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `association`
--

DROP TABLE IF EXISTS `association`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `association` (
  `association_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `association_name` tinytext NOT NULL,
  `memberNum` smallint(5) unsigned NOT NULL,
  `association_description` text,
  `association_contact` varchar(20) DEFAULT NULL,
  `association_address` varchar(255) DEFAULT NULL,
  `class` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`association_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association`
--

LOCK TABLES `association` WRITE;
/*!40000 ALTER TABLE `association` DISABLE KEYS */;
INSERT INTO `association` VALUES (160,'Dancing Clubing',2,'123456','7576620431234566','Liverpool','Academic'),(162,'Drawing club',2,'hello','745674567456','Liverpool','Art'),(163,'Moments Club',1,'We are moments!','momentistscom@gmial.','Liverpool','Academic'),(164,'society43436',1,'','','','Academic'),(165,'Boxing',3,'Boxing','888888888888','Liverpool','Sports'),(166,'Bowling',1,'996','996','Liverpool','Sports'),(167,'Programming club',2,'996 happly','9987654521','Liverpool','Academic'),(168,'Math',2,'Love math!','100%','everywhere','Academic'),(169,'society69422',1,'','','','Academic'),(170,'outdoor',1,'123','123','Liverpool','Outdoor'),(171,'Naruto',1,'hahh','233@gmail.com','wulawala xingqiu','Culture'),(172,'Computing',1,'The School of Computing Society host regular social events letting you blow off steam from your studies with nights out, gaming, bowling and more. They plan hackathons, coding challenges, gaming nights, programming & technology talks. They welcome students from the School of Computing as well as anybody with an interest in any aspect of computer engineering, programming, development, technology, VR/AR.','computingsociety@liv','University of Liverpool, Liverpool L69 3BX, United Kingdom','Academic'),(173,'society60077',1,'','','','Academic'),(174,'GERMAN SOCIETY',3,'Our society is formed to bring together all students, that have an interest in the German culture and language. We are open to students of the German language, Germans and everyone else that wants to participate.','GermanSociety@liverp','University of Liverpool, Liverpool L69 3BX, United Kingdom','Academic'),(175,'ELLIPSIS MAGAZINE',2,'Ellipsis is the University of Liverpool’s only print arts and culture magazine. We print twice a year and run a website all year round, featuring articles by students, for students! If you’re interested in music, culture, politics, literature or anything in between, or even want to get involved in design, marketing or copy editing, then Ellipsis is the society for you! With socials, workshops and events all year round, including Ellipsis’ famous annual ‘Raise The Roof’ charity gig in collaboration with Help The Homeless Society, we are more than just a magazine!','ELLIPSIS MAGAZINE@li','University of Liverpool, Liverpool L69 3BX, United Kingdom','Media'),(176,'AAAAAAAA',1,'AAAAAAAA','AAAAAAA','AAAAAAAAAAA','Academic'),(177,'society40894',1,'','','','Academic'),(178,'society15220',1,'','','','Academic');
/*!40000 ALTER TABLE `association` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `association_touser`
--

DROP TABLE IF EXISTS `association_touser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `association_touser` (
  `touser_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `chatroom_ID` smallint(5) unsigned NOT NULL,
  `user_ID` smallint(5) unsigned NOT NULL,
  `user_displayname` varchar(30) NOT NULL,
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `user_sendlasttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`touser_ID`),
  KEY `touser_chat` (`chatroom_ID`),
  KEY `touser_userID` (`user_ID`),
  CONSTRAINT `touser_chat` FOREIGN KEY (`chatroom_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE,
  CONSTRAINT `touser_userID` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `association_touser`
--

LOCK TABLES `association_touser` WRITE;
/*!40000 ALTER TABLE `association_touser` DISABLE KEYS */;
INSERT INTO `association_touser` VALUES (193,160,28,'swt',2,'0000-00-00 00:00:00'),(195,160,29,'szy',1,'0000-00-00 00:00:00'),(196,162,35,'Username',2,'0000-00-00 00:00:00'),(197,163,36,'Aditor',2,'0000-00-00 00:00:00'),(198,164,37,'Superman',2,'0000-00-00 00:00:00'),(199,165,29,'szy',2,'0000-00-00 00:00:00'),(200,165,28,'swt',1,'0000-00-00 00:00:00'),(201,166,30,'lc',2,'0000-00-00 00:00:00'),(202,167,30,'lc',2,'0000-00-00 00:00:00'),(203,168,38,'shuxue',2,'0000-00-00 00:00:00'),(204,167,28,'swt',1,'0000-00-00 00:00:00'),(205,169,38,'shuxue',2,'0000-00-00 00:00:00'),(206,170,32,'rwx',2,'0000-00-00 00:00:00'),(207,162,38,'shuxue',1,'0000-00-00 00:00:00'),(208,171,39,'qisiwole',2,'0000-00-00 00:00:00'),(209,172,40,'Jone',2,'0000-00-00 00:00:00'),(210,173,40,'Jone',2,'0000-00-00 00:00:00'),(211,174,40,'Jone',2,'0000-00-00 00:00:00'),(212,175,41,'chenchenchen',2,'0000-00-00 00:00:00'),(213,176,43,'WenxiRan16',2,'0000-00-00 00:00:00'),(214,174,42,'lily',1,'0000-00-00 00:00:00'),(215,175,42,'lily',1,'0000-00-00 00:00:00'),(216,165,41,'chenchenchen',1,'0000-00-00 00:00:00'),(217,174,41,'chenchenchen',1,'0000-00-00 00:00:00'),(218,168,41,'chenchenchen',1,'0000-00-00 00:00:00'),(219,177,41,'chenchenchen',2,'0000-00-00 00:00:00'),(220,178,41,'chenchenchen',2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `association_touser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `comment_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_asso_ID` smallint(5) unsigned NOT NULL,
  `comment_event_ID` mediumint(8) unsigned NOT NULL,
  `comment_display_name` varchar(30) NOT NULL,
  `comment_author_IP` varchar(100) DEFAULT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text,
  `comment_agent` varchar(255) DEFAULT NULL,
  `comment_user_ID` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`comment_ID`),
  KEY `comment_asso_ID` (`comment_asso_ID`),
  KEY `comment_event_ID` (`comment_event_ID`),
  KEY `comment_user_ID` (`comment_user_ID`),
  CONSTRAINT `comment_asso_ID` FOREIGN KEY (`comment_asso_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_event_ID` FOREIGN KEY (`comment_event_ID`) REFERENCES `event` (`event_ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `comment_user_ID` FOREIGN KEY (`comment_user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` text NOT NULL,
  `event_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `event_location` varchar(255) DEFAULT 'Unknown',
  `event_description` text,
  `event_member` smallint(5) unsigned NOT NULL DEFAULT '0',
  `asso_ID` smallint(5) unsigned NOT NULL,
  `limitation` tinyint(4) NOT NULL DEFAULT '0',
  `pictureNum` tinyint(3) unsigned DEFAULT '0',
  `click_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_ID`),
  KEY `event_association_ID` (`asso_ID`),
  CONSTRAINT `event_association_ID` FOREIGN KEY (`asso_ID`) REFERENCES `association` (`association_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (33,'123456','2020-01-29 00:00:00','Unknown','123456',2,160,1,1,10),(34,'hello','2019-11-30 14:00:00','liverpool','hello',1,160,2,1,13),(35,'Moments demo','2019-05-01 01:00:00','Liverpool','Demo',1,163,1,1,18),(36,'Hellp','2019-11-30 14:00:00','Unknown','Hello welcome',1,162,3,1,2),(37,'1*1=1','1999-11-30 00:00:00','Unknown','1*1=1',3,162,3,1,5),(38,'Boxing','2001-11-30 16:00:00','Unknown','hiking\r\n',2,165,1,1,19),(39,'Boxing2','2019-12-30 03:33:00','Unknown','Boxing2',1,165,1,1,3),(40,'Hello','0000-00-00 00:00:00','Unknown','1111',1,167,1,1,4),(41,'Math club','1999-11-30 00:00:00','Unknown','everywhere',1,168,1,2,11),(42,'event92417','0000-00-00 00:00:00','Unknown','',1,172,1,0,6),(43,'event1261','0000-00-00 00:00:00','Unknown','',1,176,1,0,2),(44,'event52857','0000-00-00 00:00:00','Unknown','',1,176,1,0,2),(45,'event75919','0000-00-00 00:00:00','Unknown','',1,176,1,0,2),(46,'event23270','0000-00-00 00:00:00','Unknown','',1,176,1,0,4);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupmsg`
--

DROP TABLE IF EXISTS `groupmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupmsg` (
  `msg_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chatroom_ID` smallint(5) unsigned NOT NULL,
  `msg_senderID` smallint(5) unsigned NOT NULL,
  `msg_sendername` varchar(30) NOT NULL,
  `msg_senderIP` varchar(100) DEFAULT NULL,
  `msg_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `msg_content` text NOT NULL,
  `msg_agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`msg_ID`),
  KEY `groupmsg_senderID` (`msg_senderID`),
  CONSTRAINT `groupmsg_senderID` FOREIGN KEY (`msg_senderID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2642 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupmsg`
--

LOCK TABLES `groupmsg` WRITE;
/*!40000 ALTER TABLE `groupmsg` DISABLE KEYS */;
INSERT INTO `groupmsg` VALUES (2638,163,36,'Aditor','194.66.243.2','2019-04-28 19:51:46','?','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36'),(2639,162,38,'shuxue','194.66.243.2','2019-04-28 20:36:55','?','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36'),(2640,171,39,'qisiwole','5.151.0.120','2019-04-28 21:42:43','something','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.108 Safari/537.36'),(2641,174,40,'Jone','194.66.243.2','2019-04-28 22:01:46','?','Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36');
/*!40000 ALTER TABLE `groupmsg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moments`
--

DROP TABLE IF EXISTS `moments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moments` (
  `moments_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moments_senderID` smallint(5) unsigned NOT NULL,
  `moments_title` varchar(255) DEFAULT NULL,
  `moments_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `moments_description` text NOT NULL,
  `moments_pictureNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`moments_ID`),
  KEY `moments_send` (`moments_senderID`),
  CONSTRAINT `moments_send` FOREIGN KEY (`moments_senderID`) REFERENCES `users` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moments`
--

LOCK TABLES `moments` WRITE;
/*!40000 ALTER TABLE `moments` DISABLE KEYS */;
INSERT INTO `moments` VALUES (48,28,NULL,'2019-04-28 19:46:44',' hello',0),(49,36,NULL,'2019-04-28 19:53:49',' Moments Demo',0),(50,35,NULL,'2019-04-28 20:00:48',' ',0),(51,29,NULL,'2019-04-28 20:11:34',' ',0),(52,30,NULL,'2019-04-28 20:22:38',' ',0),(53,40,NULL,'2019-04-28 21:38:19',' Hello!  I want to know the university lab open time. Anybody can tell me??? Thx!!!',0),(54,42,NULL,'2019-04-28 22:10:29',' Really hate the raining days...',0),(55,43,NULL,'2019-04-28 22:35:33',' How are you today?',0);
/*!40000 ALTER TABLE `moments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usermeta`
--

DROP TABLE IF EXISTS `usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usermeta` (
  `umeta_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` smallint(5) unsigned NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`umeta_id`),
  KEY `usermeta_user_id` (`user_id`),
  CONSTRAINT `usermeta_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usermeta`
--

LOCK TABLES `usermeta` WRITE;
/*!40000 ALTER TABLE `usermeta` DISABLE KEYS */;
INSERT INTO `usermeta` VALUES (232,28,'subscribe_association','160'),(234,28,'event','33'),(235,29,'subscribe_association','160'),(236,28,'event','34'),(237,35,'subscribe_association','162'),(238,36,'subscribe_association','163'),(239,36,'event','35'),(240,35,'event','36'),(241,35,'event','37'),(242,37,'subscribe_association','164'),(243,29,'subscribe_association','165'),(244,28,'subscribe_association','165'),(245,29,'event','38'),(246,29,'event','39'),(247,29,'event','33'),(248,30,'subscribe_association','166'),(249,30,'subscribe_association','167'),(250,38,'subscribe_association','168'),(251,28,'subscribe_association','167'),(252,30,'event','40'),(253,38,'event','41'),(254,38,'event','37'),(255,38,'subscribe_association','169'),(256,32,'subscribe_association','170'),(257,38,'subscribe_association','162'),(258,39,'subscribe_association','171'),(259,40,'subscribe_association','172'),(260,40,'event','42'),(261,40,'subscribe_association','173'),(262,40,'subscribe_association','174'),(263,41,'subscribe_association','175'),(264,43,'subscribe_association','176'),(265,42,'subscribe_association','174'),(266,43,'event','43'),(267,43,'event','44'),(268,42,'subscribe_association','175'),(269,43,'event','45'),(270,43,'event','46'),(271,41,'subscribe_association','165'),(272,41,'event','38'),(273,41,'event','37'),(274,41,'subscribe_association','174'),(275,41,'subscribe_association','168'),(276,41,'subscribe_association','177'),(277,41,'subscribe_association','178');
/*!40000 ALTER TABLE `usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(100) DEFAULT '',
  `user_login` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_pass` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `signature` varchar(140) NOT NULL DEFAULT '',
  `user_registered` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (28,'','swt','123456','null','','2019-04-28 19:24:49'),(29,'','szy','123456','null','','2019-04-28 19:24:59'),(30,'','lc','123456','null','','2019-04-28 19:25:16'),(31,'','sc','123456',NULL,'','2019-04-28 19:25:27'),(32,'','rwx','123456',NULL,'','2019-04-28 19:25:38'),(33,'','xyf','123456',NULL,'','2019-04-28 19:25:47'),(35,'','Username','Password','null','','2019-04-28 19:35:24'),(36,'','Aditor','123456','null','','2019-04-28 19:47:46'),(37,'','Superman','123456','null','','2019-04-28 19:54:42'),(38,'','shuxue','123456','null','','2019-04-28 20:17:00'),(39,'','qisiwole','qisiwole',NULL,'','2019-04-28 21:27:27'),(40,'Arrad House, Liverpool','Jone','sc12345','sundoris@hotmail.com','New to here! Want to make more friends!','2019-04-28 21:34:48'),(41,'Liverpool','chenchenchen','123','sgamy@student.liverpool.ac.uk','Be confident! Be active!','2019-04-28 22:02:47'),(42,'Liverpool','lily','sc12345','lily@student.liverpool.ac.uk',';)','2019-04-28 22:07:31'),(43,'','WenxiRan16','12345',NULL,'','2019-04-28 22:09:10'),(44,'','Tinana','Tinana',NULL,'','2019-04-29 00:10:48');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'momentists_com'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-29 11:02:56
