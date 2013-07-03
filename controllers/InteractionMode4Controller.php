<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode4Controller extends SMSController
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
		$responseSMS['head']=HELP_INTRO_PAGE;
		QueryRecord::save(4,1);
		$this->template->smsBlocks=$responseSMS;
	}
	public function handleReplySMS()
	{
		
		$incomingSMS=new IncomingSMS;
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());
		if($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)
		{
			if(preg_match('/^([0-9]),([0-9])$/',$previousQuery['additional_info'],$matches))
			{
				$responseSMS['head']=SMSPages::returnHelpPages($matches[1],$matches[2]+1);
				$pageInfo=$matches[1].','.($matches[2]+1);
			}				
			if(!isset($responseSMS['head']))
				$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_RESPONSE;		
		}
		else
		{
			switch($incomingSMS->getQueryText())
			{
				case '1':
				case '2':
				case '3':
				{
					$responseSMS['head']=SMSPages::returnHelpPages($incomingSMS->getQueryText(),1);
					$pageInfo=$incomingSMS->getQueryText().',1';
					break;
				}
				default:
				{
					$_SESSION['SMSErrorMessage'][]=SMS_ERROR_INCORRECT_RESPONSE;
				}
			}
		}
		
		QueryRecord::save($previousQuery['interaction_mode'],($previousQuery['previous_page']+1),$pageInfo);
		$this->template->smsBlocks=$responseSMS;
	}
	
}
