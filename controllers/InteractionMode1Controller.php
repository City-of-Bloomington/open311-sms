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
		
		$pages=self::constructPages($list,$listType);
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
	public static function constructPages(array $list,$type)
	{
		$prefix=($type=='SERVICES')?SERVICE_OPTIONS_PREFIX:GROUP_OPTIONS_PREFIX;
		$pages=array();
		$pages['page1']=array();
		$pages['page1']['head'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_1:GROUP_LIST_INFO_TEXT_1;
		$pages['page1']['tail'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_2:GROUP_LIST_INFO_TEXT_2;
		$characterCount=strlen(html_entity_decode($pages['page1']['head']))+
					strlen(html_entity_decode($pages['page1']['tail']));
		$i=1;
		$pageNumber=1;	
		foreach($list as $key=>$value)
		{
			$smsBlock=$prefix.$key.'-'.$value.';';
			$characterCount=$characterCount+strlen(html_entity_decode($smsBlock));
			
			if($characterCount>=(int)SMS_CHARACTER_LIMIT)
			{
				$pageNumber++;
				$pages['page'.$pageNumber]=array();
				$pages['page'.$pageNumber]['head'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_1:GROUP_LIST_INFO_TEXT_3;
				$pages['page'.$pageNumber]['tail'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_2:GROUP_LIST_INFO_TEXT_2;
				$characterCount=strlen(html_entity_decode($pages['page'.$pageNumber]['head']))
							+strlen(html_entity_decode($pages['page'.$pageNumber]['tail']));
				$characterCount=$characterCount+strlen(html_entity_decode($smsBlock));
				$i=1;	
			}
			
			$pages['page'.$pageNumber][$i++] = $smsBlock;  
		}
		$pages['page'.$pageNumber]['tail']='';	
		return $pages;
	}
	private static function findLastPage($pages)
	{
		$i=0;
		
		foreach($pages as $page)
		{			
			$i++;
		}
		return $i;
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
