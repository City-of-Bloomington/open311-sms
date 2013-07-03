<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @authors Cliff Ingham <inghamn@bloomington.in.gov>,Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
include '../configuration.inc';
include '../language files/default_'.LANGUAGE.'.inc';


// Check for routes
if (preg_match('|'.BASE_URI.'(/([a-zA-Z0-9]+))?(/([a-zA-Z0-9]+))?|',$_SERVER['REQUEST_URI'],$matches)) {
	$resource = isset($matches[2]) ? $matches[2] : 'index';
	$action   = isset($matches[4]) ? $matches[4] : 'index';
}

$sms_mode=FALSE;

// Check for SMS mode
if(($resource=='index')&&($action=='index')&&isset($_REQUEST))
{
	$sms_mode=TRUE;
	$template = new Template('SMS',SMS_RESPONSE_FORMAT);
	$incomingSMS=new IncomingSMS;
	unset($_SESSION['SMSErrorMessage']);

	// Check if incoming SMS is valid
	$incomingSMS->isAPIKeyValid();
	$incomingSMS->isKeywordMatched();
	
	/**
	 * Sub-Keywords and corresponding Interaction Modes:
	 * SUB_KEYWORD_GET_SERVICE_CODES   :$interactionMode=1
	 * SUB_KEYWORD_SUBMIT_REQUEST      :$interactionMode=2	
	 * SUB_KEYWORD_CHECK_REQUEST_STATUS:$interactionMode=3
 	 * SUB_KEYWORD_HELP                :$interactionMode=4
	 */
	$interactionMode = $incomingSMS->getInteractionMode();
	if(!isset($interactionMode))
	{	
		//No interaction mode present. Checking whether incoming SMS is a reply SMS.
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());
		if(!isset($previousQuery))
		{
			$_SESSION['SMSErrorMessage'][] = SMS_ERROR_INCORRECT_RESPONSE;
		}
		$interactionMode=$previousQuery['interaction_mode'];
		$action='handleReplySMS';		
	}
	else
	{
		$action='generateFirstPageResponse';
	}
	if(isset($interactionMode))
		$resource='InteractionMode'.$interactionMode;
	
	$xmlurlServiceDiscovery = file_get_contents(SERVICE_DISCOVERY_URL);    
	$xmlServiceDiscovery = simplexml_load_string($xmlurlServiceDiscovery, null, LIBXML_NOCDATA);
	if(!$xmlurlServiceDiscovery)
		$_SESSION['SMSErrorMessage'][] = SMS_ERROR_SERVER_PROBLEM;

	//Find the valid and active endpoint from Service Discovery
	foreach ($xmlServiceDiscovery->endpoints->endpoint as $endpoint) 
	{
   		$endpointURL=(string)$endpoint->url;
		if((string)$endpoint->type=='production')
		{
			$xmlurlServiceList = file_get_contents($endpointURL."/services.xml");    
			$xmlServiceList = simplexml_load_string($xmlurlServiceList, null, LIBXML_NOCDATA);
			if (isset($xmlServiceList->service[0]->service_code))
				break;
		}
	}
}
else
{
	$template = !empty($_REQUEST['format'])? new Template('default',$_REQUEST['format']) : new Template('default');
}
// Execute the Controller::action()
if (isset($resource) && isset($action) && $ZEND_ACL->has($resource)) {
	$USER_ROLE = isset($_SESSION['USER']) ? $_SESSION['USER']->getRole() : 'Anonymous';
	if ($ZEND_ACL->isAllowed($USER_ROLE, $resource, $action)) {
		$controller = ucfirst($resource).'Controller';		
		$c = new $controller($template);
		$c->$action();
	}
	else {
		header('HTTP/1.1 403 Forbidden', true, 403);
		$_SESSION['errorMessages'][] = new Exception('noAccessAllowed');
	}
}
// ACL not required if in SMS mode
else if ($sms_mode)
{
	
	$controller = ucfirst($resource).'Controller';
	$c = new $controller($template,$endpointURL,$xmlServiceList);
	$c->$action();
}
else {
	header('HTTP/1.1 404 Not Found', true, 404);
	$template->blocks[] = new Block('404.inc');
}

echo $template->render();
