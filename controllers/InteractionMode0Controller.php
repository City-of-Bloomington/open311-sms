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
		if(($incomingSMS->getSubKeyword()==SUB_KEYWORD_MORE)&&$previousQuery)
		{
			if($previousQuery['interaction_mode']==1)
			{
				$page=$previousQuery['previous_page']+1;
				$type=$previousQuery['additional_info'];	
				$controller=new InteractionMode1Controller($this->template);
				$controller->generateResponse($endpoint,$page,$type);
			}
			else
			{
				//error
			}
		}
		else
		{
			//error
		}
		
	}
}
