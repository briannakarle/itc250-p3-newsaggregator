-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `Article`;
CREATE TABLE `Article` (
  `ArticleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SubcategoryID` int(10) unsigned NOT NULL,
  `ArticleTitle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ArticleAuthor` varchar(50) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL,
  `ArticleDatePublished` date NOT NULL,
  `ArticleSource` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ArticleURL` text COLLATE utf8_unicode_ci NOT NULL,
  `ArticleDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `ArticleDateAdded` timestamp NOT NULL,
  PRIMARY KEY (`ArticleID`),
  KEY `SubcategoryID` (`SubcategoryID`),
  CONSTRAINT `Article_ibfk_1` FOREIGN KEY (`SubcategoryID`) REFERENCES `Subcategory` (`SubcategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
  `CategoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryTitle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CategoryDescription` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `Subcategory`;
CREATE TABLE `Subcategory` (
  `SubcategoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryID` int(10) unsigned NOT NULL,
  `SubcategoryTitle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `SubcategoryDescription` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`SubcategoryID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `Subcategory_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `Category` (`CategoryID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-02-21 19:15:51
