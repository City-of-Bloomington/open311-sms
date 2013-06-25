-- @copyright 2006-2013 City of Bloomington, Indiana
-- @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
-- @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>

CREATE TABLE `query_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `interaction_mode` int(2) NOT NULL,
  `previous_page` int(2) NOT NULL,
  `additional_info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
);

