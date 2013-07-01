<?php
define('SUB_KEYWORD_GET_SERVICE_CODES','get_service_codes');
define('SUB_KEYWORD_SUBMIT_REQUEST','submit_request');
define('SUB_KEYWORD_CHECK_REQUEST_STATUS','check_request_status');
define('SUB_KEYWORD_HELP','help');
define('SUB_KEYWORD_MORE','more');
define('GROUP_OPTIONS_PREFIX','g');
define('SERVICE_OPTIONS_PREFIX','s');
define('GROUP_LIST_INFO_TEXT_1','Reply \''.SMS_KEYWORD.'&lt;space&gt;group code\' to get list of services in that group;Groups:');
define('GROUP_LIST_INFO_TEXT_2','Reply \''.SMS_KEYWORD.' '.SUB_KEYWORD_MORE.'\' to get more groups');
define('GROUP_LIST_INFO_TEXT_3','Groups:');
define('SERVICE_LIST_INFO_TEXT_1','Services:');
define('SERVICE_LIST_INFO_TEXT_2','Reply \''.SMS_KEYWORD.' '.SUB_KEYWORD_MORE.'\' to get more services');
define('SUCCESSFUL_REQUEST_SUBMISSION_TEXT','Your request has been successfully registered. Your service request id is:');
define('UNSUCCESSFUL_REQUEST_SUBMISSION_TEXT','Your request was not registered. Please Retry');
define('STRING_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('STRING_DATATYPE_RESPONSE_TEXT_2',';Reply \''.SMS_KEYWORD.'&lt;space&gt;(your answer)\'');
define('NUMBER_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('NUMBER_DATATYPE_RESPONSE_TEXT_2',';Reply \''.SMS_KEYWORD.'&lt;space&gt;(your answer)\'');
define('DATETIME_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('DATETIME_DATATYPE_RESPONSE_TEXT_2',';Reply \''.SMS_KEYWORD.'&lt;space&gt;(your answer)\'');
define('TEXT_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('TEXT_DATATYPE_RESPONSE_TEXT_2',':Reply \''.SMS_KEYWORD.'&lt;space&gt;(your answer)\'');
define('SINGLEVALUELIST_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('SINGLEVALUELIST_DATATYPE_RESPONSE_TEXT_2',';Reply \''.SMS_KEYWORD.'&lt;space&gt;option code\';Options:');
define('SINGLEVALUELIST_OPTIONS_PREFIX','i');
define('MULTIVALUELIST_DATATYPE_RESPONSE_TEXT_1','Additional info required:');
define('MULTIVALUELIST_DATATYPE_RESPONSE_TEXT_2',';Reply \''.SMS_KEYWORD.'&lt;space&gt;option code\';Options:');
define('MULTIVALUELIST_OPTIONS_PREFIX','m');
define('REQUEST_STATUS','Request Status:');
define('REQUEST_STATUS_INFO','Info:');
define('REQUEST_STATUS_SERVICE_NOTICE','Service Notice:');
define('MORE_OPTIONS_TEXT','Reply \''.SMS_KEYWORD.' '.SUB_KEYWORD_MORE.'\' to get more options');
define('OPTIONS_TEXT','Options:');

/**
 * Help Pages:
 * To add pages, change the page number of the constants and define the content of the page as the value of the constants
 */
//Intro Page
define('HELP_INTRO_PAGE','Reply:\''.SMS_KEYWORD.' 1\' for help on getting service codes;\''.SMS_KEYWORD.' 2\' for help on submitting service request;\''.SMS_KEYWORD.' 3\' for help on checking service request status');
//Get Service Code Help
define('HELP_GET_SERVICE_CODES_GROUPS_PAGE_1','Reply \''.SMS_KEYWORD.' '. SUB_KEYWORD_GET_SERVICE_CODES.'\';You will get list of groups and their group codes.Examples of some group codes:g2,g3');

define('HELP_GET_SERVICE_CODES_SERVICES_PAGE_1','Reply \''.SMS_KEYWORD.' '. SUB_KEYWORD_GET_SERVICE_CODES.'\';You will get list of services and their service codes.Examples of some service codes:s23,s37');
//Submit Service Request Help
define('HELP_SUBMIT_REQUEST_PAGE_1','Reply \''.SMS_KEYWORD.' '. SUB_KEYWORD_SUBMIT_REQUEST.'&lt;space&gt;service code&lt;space&gt;location of service issue\' to submit service request');
//Check Request Status Help
define('HELP_CHECK_REQUEST_STATUS_PAGE_1','Reply \''.SMS_KEYWORD.' '. SUB_KEYWORD_CHECK_REQUEST_STATUS.'&lt;space&gt;service request id\' to check request status');
?>
