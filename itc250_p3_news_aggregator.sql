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

INSERT INTO `Category` (`CategoryID`, `CategoryTitle`, `CategoryDescription`) VALUES
(1,	'Wildlife',	'Wildlife conservation is the practice of protecting wild plant and animal species and their habitats. The goal of wildlife conservation is to ensure that nature will be around for future generations to enjoy and also to recognize the importance of wildlife and wilderness for humans and other species alike. - Wikipedia'),
(2,	'Public Lands',	'Public lands have a wide variety of purposes, from contributing to the economy to being an important part of our heritage. '),
(3,	'Ocean',	'The diversity and productivity of the world’s oceans is a vital interest for humankind.  Our security, our economy, our very survival all require healthy oceans. - Marine Conservation Institute');

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

INSERT INTO `Subcategory` (`SubcategoryID`, `CategoryID`, `SubcategoryTitle`, `SubcategoryDescription`) VALUES
(1,	1,	'North America',	'Our vision: Diverse wildlife populations in North America are secure and thriving, sustained by a network of healthy lands and waters. - Defenders of Wildlife'),
(2,	1,	'Africa',	'Critical to protecting Africa’s wildlife are the local people. Sharing the land, often alongside each other, can lead to struggles for resources and deforestation. If people and wildlife learn to live together—inside and outside of protected areas—the future for all will thrive. - African Wildlife Foundation'),
(3,	1,	'Asia',	'Wildlife in Asia is reaching a crisis point. Due to habitat loss and poaching many species have their backs against the wall. - Wildlife Asia'),
(4,	2,	'Pacific Northwest United States',	'The Pacific Northwest Region (Region 6) of the US Forest Service contains 17 National Forests, two National Scenic Areas, a National Grassland, and two National Volcanic Monuments, all within the States of Oregon and Washington. These national forests provide timber for people, forage for cattle and wildlife, habitat for fish, plants, and animals, and some of the finest recreation lands in the country. - USDA'),
(5,	2,	'Midwest United States',	'Protect Midwest land for public enjoyment and habitat preservation.'),
(6,	2,	'Southwest United States',	'America’s national forests, wildlife refuges, parks, and public lands are part of our national identity.  Our public lands were created so all Americans, regardless of wealth or social status, would be able to enjoy access to the outdoors in perpetuity.  That our public lands should be open to everyone to experience is one of our nation’s proudest and most sacred traditions. - The Wilderness Society'),
(7,	3,	'Pacific',	'The Pacific Ocean is the largest of the Earth\'s oceanic divisions. It extends from the Arctic Ocean in the north to the Southern Ocean (or, depending on definition, to Antarctica) in the south and is bounded by Asia and Australia in the west and the Americas in the east. - Wikipedia'),
(8,	3,	'Atlantic',	'The Atlantic Ocean is the second largest of the world\'s oceanic divisions, following the Pacific Ocean. With a total area of about 106,400,000 square kilometres (41,100,000 sq mi),[1] it covers approximately 20 percent of the Earth\'s surface and about 29 percent of its water surface area. - Wikipedia'),
(9,	3,	'Indian',	'The Indian Ocean is the third largest of the world\'s oceanic divisions, covering approximately 20% of the water on the Earth\'s surface.[1] It is bounded by Asia on the north, on the west by Africa, on the east by Australia, and on the south by the Southern Ocean or, depending on definition, by Antarctica. - Wikipedia');

-- 2016-02-22 08:32:18
