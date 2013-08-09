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

CREATE TABLE `language_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blockName` varchar(255) NOT NULL,
  `blockValue` text,
  `blockType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blockName` (`blockName`)
);

INSERT INTO `language_en` VALUES 
(1,'SUB_KEYWORD_GET_SERVICE_CODES','get_service_codes','SubKeyword'),
(2,'SUB_KEYWORD_SUBMIT_REQUEST','submit_request','SubKeyword'),
(3,'SUB_KEYWORD_CHECK_REQUEST_STATUS','check_request_status','SubKeyword'),
(4,'SUB_KEYWORD_HELP','help','SubKeyword'),
(5,'SUB_KEYWORD_MORE','more','SubKeyword'),
(6,'SUB_KEYWORD_SKIP','skip','SubKeyword'),
(7,'GROUP_OPTIONS_PREFIX','g','GetServiceCodeInteractionMode'),
(8,'SERVICE_OPTIONS_PREFIX','s','GetServiceCodeInteractionMode'),
(9,'GROUP_LIST_INFO_TEXT_1','Reply "group code" to get list of services in that group;Groups:','GetServiceCodeInteractionMode'),
(10,'GROUP_LIST_INFO_TEXT_2','Reply "more" to get more groups','GetServiceCodeInteractionMode'),
(11,'GROUP_LIST_INFO_TEXT_3','Groups:','GetServiceCodeInteractionMode'),
(12,'SERVICE_LIST_INFO_TEXT_1','Services:','GetServiceCodeInteractionMode'),
(13,'SERVICE_LIST_INFO_TEXT_2','Reply "more" to get more services','GetServiceCodeInteractionMode'),
(14,'SUCCESSFUL_REQUEST_SUBMISSION_TEXT','Your request has been successfully registered. Your service request id is:','SubmitRequestInteractionMode'),
(15,'UNSUCCESSFUL_REQUEST_SUBMISSION_TEXT','Your request was not registered. Please Retry','SubmitRequestInteractionMode'),
(16,'STRING_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(17,'STRING_DATATYPE_RESPONSE_TEXT_2',';Reply with your answer','SubmitRequestInteractionMode'),
(18,'NUMBER_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(19,'NUMBER_DATATYPE_RESPONSE_TEXT_2',';Reply with your answer','SubmitRequestInteractionMode'),
(20,'DATETIME_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(21,'DATETIME_DATATYPE_RESPONSE_TEXT_2',';Reply with your answer','SubmitRequestInteractionMode'),
(22,'TEXT_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(23,'TEXT_DATATYPE_RESPONSE_TEXT_2',';Reply with your answer','SubmitRequestInteractionMode'),
(24,'SINGLEVALUELIST_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(25,'SINGLEVALUELIST_DATATYPE_RESPONSE_TEXT_2',';Reply with your answer','SubmitRequestInteractionMode'),
(26,'SINGLEVALUELIST_OPTIONS_PREFIX','i','SubmitRequestInteractionMode'),
(27,'MULTIVALUELIST_DATATYPE_RESPONSE_TEXT_1','Additional info required:','SubmitRequestInteractionMode'),
(28,'MULTIVALUELIST_DATATYPE_RESPONSE_TEXT_2',';Reply with the option code;Options:','SubmitRequestInteractionMode'),
(29,'MULTIVALUELIST_OPTIONS_PREFIX','m','SubmitRequestInteractionMode'),
(30,'REPLY_WITH_DESCRIPTION','Reply with description of issue','SubmitRequestInteractionMode'),
(31,'REPLY_TO_SKIP','Reply "skip" to skip','SubmitRequestInteractionMode'),
(32,'REQUEST_STATUS','Request Status:','RequestStatusInteractionMode'),
(33,'REQUEST_STATUS_INFO','Info:','RequestStatusInteractionMode'),
(34,'REQUEST_STATUS_SERVICE_NOTICE','Service Notice:','RequestStatusInteractionMode'),
(35,'MORE_OPTIONS_TEXT','Reply "more" to get more options','RequestStatusInteractionMode'),
(36,'OPTIONS_TEXT','Options:','RequestStatusInteractionMode'),
(37,'HELP_INTRO_PAGE','Reply "1" for help on getting service codes;"2" for help on submitting service request;"3" for help onchecking service request status','HelpInteractionMode'),
(38,'HELP_GET_SERVICE_CODES_GROUPS_PAGE_1','Reply "get_service_codes";You will get list of groups and their group codes.Examples of some group codes:g2,g3','HelpInteractionMode'),
(39,'HELP_GET_SERVICE_CODES_SERVICES_PAGE_1','Reply "get_service_codes";You will get list of services and their service codes.Examples of some service codes:s23,s37','HelpInteractionMode'),
(40,'HELP_SUBMIT_REQUEST_PAGE_1','Reply "submit_request<space>service code<space>location of service issue" to submit service request','HelpInteractionMode'),
(41,'HELP_CHECK_REQUEST_STATUS_PAGE_1','Reply "check_request_status<space>service request id" to check request status','HelpInteractionMode'),
(42,'SMS_ERROR_INCORRECT_RESPONSE','You have sent an incorrect response.Reply "help" to get help on sending SMS','Error'),
(43,'SMS_ERROR_INCORRECT_QUERY','You have sent an incorrect query.Reply "help" to get help on sending SMS','Error'),
(44,'SMS_ERROR_SERVER_PROBLEM','Our servers encountered a problem. Please try again later.','Error'),
(45,'SMS_ERROR_INCORRECT_SERVICE_CODE','You have submitted an incorrect Service Code.Reply "get_service_codes" to get a list of service codes.','Error'),
(46,'SMS_ERROR_SERVICE_CODE_NOT_PRESENT','No Service Code was present in your request.Reply "help"to get help on sumitting Service Requests.','Error'),
(47,'SMS_ERROR_INCORRECT_OPTION_CHOSEN','You have chosen an incorrect option.','Error'),
(48,'SMS_ERROR_INVALID_SERVICE_REQUEST_ID','You have sent an incorrect Service Request Id','Error'),
(49,'SMS_ERROR_NO_SERVICE_REQUEST_ID_PRESENT','No Service Request Id was present in your request.Reply"help"to get help on checking request status.','Error');
(50,'SMS_ERROR_CANNOT_SKIP_REQUIRED_FIELD','This is a required field.You cannot skip this.Please reply with the answer','Error');

CREATE TABLE `query_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(20) NOT NULL,
  `interaction_mode` int(2) NOT NULL,
  `previous_page` varchar(255) NOT NULL,
  `additional_info` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
);
