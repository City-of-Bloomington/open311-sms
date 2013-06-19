-- @copyright 2006-2012 City of Bloomington, Indiana
-- @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
-- @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
CREATE TABLE `query_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `previous_sms_body` varchar(160),
  `previous_sms_time` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
);
