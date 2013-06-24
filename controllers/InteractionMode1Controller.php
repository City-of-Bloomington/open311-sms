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
	public function generateResponse($endpoint)
	{	
		$list=array();	
		$xmlurl = file_get_contents($endpoint.'/services.xml');    
		$xml = simplexml_load_string($xmlurl, null, LIBXML_NOCDATA);	
		if(GET_SERVICE_LIST_RESPONSE=='GROUP')
		{
			$list=ServiceList::getGroupList($xml);
			$prefix=GROUP_OPTIONS_PREFIX;
		}
		else
		{
			$list=ServiceList::getServiceList($xml);
			$prefix=SERVICE_OPTIONS_PREFIX;	
		}

		$this->template->smsBlocks['head'] = GROUP_LIST_INFO_TEXT_1;
		$this->template->smsBlocks['tail'] = GROUP_LIST_INFO_TEXT_2;
		$characterCount=strlen($this->template->smsBlocks['head'])+strlen($this->template->smsBlocks['tail']);
		$i=1;	
		foreach($list as $key=>$value)
		{
			$smsBlock=$prefix.$key.'-'.$value.';';
			$characterCount=$characterCount+strlen($smsBlock);
			if($characterCount<=(int)SMS_CHARACTER_LIMIT)
				$this->template->smsBlocks[$i++] = $smsBlock;
			else
				break;
		}
		
		
	}
}
