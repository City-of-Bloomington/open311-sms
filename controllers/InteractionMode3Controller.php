<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode3Controller extends SMSController
{
	public function index()
	{
		
	}
	public function __construct(Template $template,$endpoint,$xmlServiceList)
	{
		parent::__construct($template,$endpoint,$xmlServiceList);
	}
	public function generateFirstPageResponse()
	{
		$incomingSMS=new IncomingSMS;
		$serviceRequestId=$incomingSMS->getQueryText();
		$xmlurlServiceRequest = file_get_contents($this->endpoint.'/requests/'.$serviceRequestId.'.xml');    
		$xmlServiceRequest = simplexml_load_string($xmlurlServiceRequest, null, LIBXML_NOCDATA);
		$request=$xmlServiceRequest->request;
		if(!isset($request))
		{
			if(is_numeric($serviceRequestId))		
				$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INVALID_SERVICE_REQUEST_ID;
			else 
				$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_QUERY;
		}
		$responseSMS['head']=REQUEST_STATUS;
		$responseSMS['head'].=$request->status;
		if(isset($request->status_notes))
		{
			$responseSMS['head'].=';'.REQUEST_STATUS_INFO;
			$responseSMS['head'].=$request->status_notes;
		}
		if(isset($request->service_notice))
		{
			$responseSMS['head'].=';'.REQUEST_STATUS_SERVICE_NOTICE;
			$responseSMS['head'].=$request->service_notice;
		}
		QueryRecord::save(3,1);
		$this->template->smsBlocks=$responseSMS;
	}
	public function handleReplySMS()
	{
		//This mode does not handle Reply SMS. Therefore, any reply SMS should be considered an Incorrect Response
		$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_QUERY;
	}
}
