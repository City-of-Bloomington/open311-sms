-- @copyright 2006-2013 City of Bloomington, Indiana
-- @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
-- @authors Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>, Cliff Ingham <inghamn@bloomington.in.gov>

CREATE TABLE `query_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `interaction_mode` int(2) NOT NULL,
  `previous_page` varchar(255) NOT NULL,
  `additional_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
) 
create table people (
	id                   int          unsigned not null primary key auto_increment,
	firstname            varchar(128),
	middlename           varchar(128),
	lastname             varchar(128),
	email                varchar(255),
	organization         varchar(128),
	address              varchar(128),
	city                 varchar(128),
	state                varchar(128),
	zip                  varchar(20),
	department_id        int          unsigned,
	username             varchar(40)  unique,
	password             varchar(40),
	authenticationMethod varchar(40),
	role varchar
);
