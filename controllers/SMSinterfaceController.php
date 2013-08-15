<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class SMSinterfaceController extends Controller
{
	public function __construct(Template $template)
	{
		parent::__construct($template);
	}
	public function index()
	{
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
		
		$xmlurlServiceDiscovery = @file_get_contents(ConfigurationList::get('serviceDiscoveryURL'));  
		if(!$xmlurlServiceDiscovery)
		{
			$_SESSION['SMSErrorMessage'][] = SMS_ERROR_SERVER_PROBLEM;  
			return;
		}		
		$xmlServiceDiscovery = simplexml_load_string($xmlurlServiceDiscovery, null, LIBXML_NOCDATA);
		

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
		//Execute the Controller::Action
		$controller = ucfirst($resource).'Controller';
		$c = new $controller($this->template,$endpointURL,$xmlServiceList);
		$c->$action();
	}
}	

?>
