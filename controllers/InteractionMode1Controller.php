<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode1Controller extends Controller
{
	public function index()
	{
		
		
	}
	public function __construct(Template $template)
	{
		parent::__construct($template);
	}
	
	public function generateResponse($endpoint,$type=GET_SERVICE_LIST_RESPONSE,$page=1)
	{	
		$list=array();	
		$xmlurl = file_get_contents($endpoint.'/services.xml');    
		$xml = simplexml_load_string($xmlurl, null, LIBXML_NOCDATA);	
		
		if($type=='GROUPS')
		{
			$list=ServiceList::getGroupList($xml);	
			$listType='GROUPS';		
		}
		else if($type=='SERVICES')
		{
			$list=ServiceList::getServiceList($xml);
			$listType='SERVICES';			
		}
		else		
		{
			$groupList=ServiceList::getGroupList($xml);
			$groupNumber=self::findGroupNumber($type);
			$groupName=$groupList[$groupNumber];
			$list=ServiceList::getServiceList($xml,$groupName);
			$listType='SERVICES';
		}
		
		$pages=SMSPages::constructServiceListPages($list,$listType);
		if($page<=count($pages))
		{	
			QueryRecord::save(1,$page,$type);
			$this->template->smsBlocks=$pages['page'.$page];		
		}
		else
		{
			//error
		}
	}
	public function handleReplySMS($endpoint)
	{
		$incomingSMS=new IncomingSMS;
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());

		if(  ($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&
				   ( ($previousQuery['additional_info']=='GROUPS')||
					($previousQuery['additional_info']=='SERVICES') ) )
			{
				$page=$previousQuery['previous_page']+1;
				$type=$previousQuery['additional_info'];	
				$this->generateResponse($endpoint,$type,$page);
			}
				
		else 
		{
			$validQuery=FALSE;
			if(self::findGroupNumber($incomingSMS->getQueryText()))
			{
				$groupCode=$incomingSMS->getQueryText();
				$page=1;
				$validQuery=TRUE;
			}
			else if (($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&(self::findGroupNumber($previousQuery['additional_info'])))
			{
				$groupCode=$previousQuery['additional_info'];
				$page=$previousQuery['previous_page']+1;
				$validQuery=TRUE;
			}
			if($validQuery)
			{	
				$this->generateResponse($endpoint,$groupCode,$page);					
			}		
			else
			{
				//error
			}
		}
			
	}	
	private static function findGroupNumber($string)
	{
		if(preg_match('/^'.GROUP_OPTIONS_PREFIX.'([0-9]*$)/', $string,$matches))
		{
			return $matches[1]; 
		}
		else
		{
			return 0;
		}
	}
}
