-- @copyright 2006-2013 City of Bloomington, Indiana
-- @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
-- @authors Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>, Cliff Ingham <inghamn@bloomington.in.gov>

CREATE TABLE `configuration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `configName` varchar(255) NOT NULL,
  `configValue` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configName` (`configName`)
);

INSERT INTO `configuration` VALUES 
(1,'serviceDiscoveryURL','https://api.city.gov/discovery.xml'),
(2,'open311APIKey','open311_api_key'),
(3,'open311JurisdictionId','api.city.gov'),
(4,'getServiceListResponse','GROUPS'),
(5,'SMSCharacterLimit','160'),
(6,'useSMSKeyword','No'),
(7,'SMSKeyword','keyword'),
(8,'SMSResponseFormat','html'),
(9,'SMSBodyParameter','Body'),
(10,'SMSFromParameter','From'),
(11,'APIKeyRequired','Yes'),
(12,'SMSAPIKeyParameter','api_key_param'),
(13,'SMSAPIKey','api_key'),
(14,'language','en');



CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `authenticationMethod` varchar(40) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ;

CREATE TABLE `query_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `interaction_mode` int(2) NOT NULL,
  `previous_page` varchar(255) NOT NULL,
  `additional_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
);
