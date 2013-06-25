<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode0Controller extends Controller
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
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());
		
		if(!($previousQuery))
		{
			//return error;
		}
		if($previousQuery['interaction_mode']==1)
		{
			if(  ($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&
				   ( ($previousQuery['additional_info']=='GROUPS')||
					($previousQuery['additional_info']=='SERVICES') ) )
			{
				$page=$previousQuery['previous_page']+1;
				$type=$previousQuery['additional_info'];	
				$controller=new InteractionMode1Controller($this->template);
				$controller->generateResponse($endpoint,$type,$page);
			}
				
			else 
			{
				$validQuery=FALSE;
				if(self::findGroupNumber($incomingSMS->getQueryText()))
				{
					$groupNumber=self::findGroupNumber($incomingSMS->getQueryText());
					$page=1;
					$validQuery=TRUE;
				}
				else if (($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&(self::findGroupNumber($previousQuery['additional_info'])))
				{
					$groupNumber=self::findGroupNumber($previousQuery['additional_info']);
					$page=$previousQuery['previous_page']+1;
					$validQuery=TRUE;
				}
				if($validQuery)
				{
					$xmlurl = file_get_contents($endpoint.'/services.xml');    
					$xml = simplexml_load_string($xmlurl, null, LIBXML_NOCDATA);	
					$groupList=ServiceList::getGroupList($xml);
					$group=$groupList[$groupNumber];					
					$serviceList=ServiceList::getServiceList($xml,$group);
					$pages=InteractionMode1Controller::constructPages($serviceList,'SERVICES');
					QueryRecord::save(1,$page,GROUP_OPTIONS_PREFIX.$groupNumber);
					$this->template->smsBlocks=$pages['page'.$page];		
				}		
				else
				{
					//error
				}
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
