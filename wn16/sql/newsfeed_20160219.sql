/*
  //newsFeed_20160219.sql - first version of news app application
  
*/


SET foreign_key_checks = 0; #turn off constraints temporarily

#since constraints cause problems, drop tables first, working backward
DROP TABLE IF EXISTS wn16_news_categories;
  
#all tables must be of type InnoDB to do transactions, foreign key constraints
CREATE TABLE wn16_news_categories(
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT,
Category VARCHAR(255) DEFAULT '',
Description TEXT DEFAULT '',
GoogleNewsQuery TEXT Default '',
PRIMARY KEY (CategoryID)
)ENGINE=INNODB; 

#assigning first survey to AdminID == 1
INSERT INTO wn16_news_categories VALUES (NULL,'North America','Description of Feed', 'North America Wildlife'); 
INSERT INTO wn16_news_categories VALUES (NULL,'Africa','Description of Feed', 'Africa Wildlife'); 
INSERT INTO wn16_news_categories VALUES (NULL,'Asia','Description of Feed', 'Asia Wildlife'); 


/*
Add additional tables here


*/
SET foreign_key_checks = 1; #turn foreign key check back on