-- Adminer 4.8.1 MySQL 8.1.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `SnapEase_Thols_SnapEase`;
CREATE DATABASE `SnapEase_Thols_SnapEase` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `SnapEase_Thols_SnapEase`;

DROP TABLE IF EXISTS `_auth`;
CREATE TABLE `_auth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  `blocked` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `_posts`;
CREATE TABLE `_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `multi_img` int NOT NULL,
  `post_text` varchar(160) NOT NULL,
  `image_uri` varchar(1080) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `like` int NOT NULL DEFAULT '0',
  `uploaded_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `_posts_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `_auth` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `_session`;
CREATE TABLE `_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `token` varchar(32) NOT NULL,
  `login_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(32) NOT NULL,
  `user_agent` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `fingerprint` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `_session_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `_auth` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `_users`;
CREATE TABLE `_users` (
  `id` int NOT NULL,
  `bio` longtext NOT NULL,
  `avatar` varchar(1024) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `dob` date NOT NULL,
  `instagram` varchar(1024) DEFAULT NULL,
  `twitter` varchar(1024) DEFAULT NULL,
  `facebook` varchar(1024) DEFAULT NULL,
  KEY `id` (`id`),
  CONSTRAINT `_users_ibfk_1` FOREIGN KEY (`id`) REFERENCES `_auth` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` varchar(32) NOT NULL,
  `uid` int NOT NULL,
  `post_id` int NOT NULL,
  `time` timestamp NOT NULL,
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `multi_image`;
CREATE TABLE `multi_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `image_uri` varchar(1080) NOT NULL,
  `uploaded_time` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `multi_image_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `_posts` (`uid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-01-24 02:28:36
