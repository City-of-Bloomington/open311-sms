<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode1Controller extends SMSController
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
		$page='1';
		$list=self::getList(GET_SERVICE_LIST_RESPONSE);
		$pages=SMSPages::constructServiceListPages($list,GET_SERVICE_LIST_RESPONSE);
		QueryRecord::save(1,$page,GET_SERVICE_LIST_RESPONSE);
		$this->template->smsBlocks=$pages['page'.$page];		
	}
	public function handleReplySMS()
	{
		$list=array();
		$incomingSMS=new IncomingSMS;
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());

		if(  ($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&
				   ( ($previousQuery['additional_info']=='GROUPS')||
					($previousQuery['additional_info']=='SERVICES') ) )
		{
			$page=$previousQuery['previous_page']+1;
			$type=$previousQuery['additional_info'];	
		}				
		else 
		{
			if(self::findGroupNumber($incomingSMS->getQueryText()))
			{
				$groupCode=$incomingSMS->getQueryText();
				$page=1;
				$type=$groupCode;			
			}
			else if (($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&(self::findGroupNumber($previousQuery['additional_info'])))
			{
				$groupCode=$previousQuery['additional_info'];
				$page=$previousQuery['previous_page']+1;
				$type=$groupCode;
			}
			else
			{
				$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_RESPONSE;
			}
			
		}
		$list=self::getList($type);
		$listType=self::getListType($type);
		$pages=SMSPages::constructServiceListPages($list,$listType);
		if($page<=count($pages))
		{	
			QueryRecord::save(1,$page,$type);
			$this->template->smsBlocks=$pages['page'.$page];	
		}
		else
		{
			$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_RESPONSE;
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
	private function getList($type)
	{
		$list=array();
		if($type=='GROUPS')
		{
			//Get list of Groups
			$list=ServiceList::getGroupList($this->xmlServiceList);	
		}
		else if($type=='SERVICES')
		{
			//Get list of all Services
			$list=ServiceList::getServiceList($this->xmlServiceList);
		}
		else		
		{
			//$type contains Group Code. Get list of services under that Group.
			$groupList=ServiceList::getGroupList($this->xmlServiceList);
			$groupNumber=self::findGroupNumber($type);
			$groupName=$groupList[$groupNumber];
			$list=ServiceList::getServiceList($this->xmlServiceList,$groupName);
		}	
		return $list;	
	}
	private function getListType($type)
	{
		if(($type=='GROUPS')||($type=='SERVICES'))
		{
			$listType=$type;
		}
		else
		{
			$listType='SERVICES';
		}
		return $listType;
	}
}
