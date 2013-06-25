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
	
	public function generateResponse($endpoint,$page=1,$type=GET_SERVICE_LIST_RESPONSE)
	{	
		$list=array();	
		$xmlurl = file_get_contents($endpoint.'/services.xml');    
		$xml = simplexml_load_string($xmlurl, null, LIBXML_NOCDATA);	
		if($type=='GROUPS')
		{
			$list=ServiceList::getGroupList($xml);
			$pages=self::constructPages($list,'GROUPS');
		}
		else
		{
			$list=ServiceList::getServiceList($xml);
			$pages=self::constructPages($list,'SERVICES');
		}
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
	private static function constructPages(array $list,$type)
	{
		$prefix=($type=='SERVICES')?SERVICE_OPTIONS_PREFIX:GROUP_OPTIONS_PREFIX;
		$pages=array();
		$pages['page1']=array();
		$pages['page1']['head'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_1:GROUP_LIST_INFO_TEXT_1;
		$pages['page1']['tail'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_2:GROUP_LIST_INFO_TEXT_2;
		$characterCount=strlen($pages['page1']['head'])+strlen($pages['page1']['tail']);
		$i=1;
		$pageNumber=1;	
		foreach($list as $key=>$value)
		{
			$smsBlock=$prefix.$key.'-'.$value.';';
			$characterCount=$characterCount+strlen($smsBlock);
			if($characterCount>(int)SMS_CHARACTER_LIMIT)
			{
				$pageNumber++;
				$pages['page'.$pageNumber]=array();
				$pages['page'.$pageNumber]['head'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_1:GROUP_LIST_INFO_TEXT_3;
				$pages['page'.$pageNumber]['tail'] = ($type=='SERVICES')?SERVICE_LIST_INFO_TEXT_2:GROUP_LIST_INFO_TEXT_2;
				$characterCount=strlen($pages['page'.$pageNumber]['head'])+strlen($pages['page'.$pageNumber]['tail']);
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
}
