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
	$template = new Template('SMS');
	$incomingSMS=new IncomingSMS;

	// Check if incoming SMS is valid
	$incomingSMS->isAPIKeyValid();
	$incomingSMS->isKeywordMatched();

	$interactionMode = $incomingSMS->getInteractionMode();
	$resource='InteractionMode'.$interactionMode;	
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
	$c = new $controller($template);
	$c->$action();
}
else {
	header('HTTP/1.1 404 Not Found', true, 404);
	$template->blocks[] = new Block('404.inc');
}

echo $template->render();
