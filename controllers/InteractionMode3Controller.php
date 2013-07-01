<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode3Controller extends Controller
{
	public function index()
	{
		
	}
	public function __construct(Template $template)
	{
		parent::__construct($template);
	}
	public function generateResponse($endpoint)
	{
		$incomingSMS=new IncomingSMS;
		$serviceRequestId=$incomingSMS->getQueryText();
		$xmlurlServiceList = file_get_contents($endpoint.'/requests/'.$serviceRequestId.'.xml');    
		$xmlServiceList = simplexml_load_string($xmlurlServiceList, null, LIBXML_NOCDATA);
		$request=$xmlServiceList->request;
		if(!isset($request))
		{
			//return error
		}
		$responseSMS['head']=REQUEST_STATUS;
		$responseSMS['head'].=$xmlServiceList->request->status;
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
}
