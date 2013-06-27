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
			$controller= new InteractionMode1Controller($this->template);
			$controller->handleReplySMS($endpoint);
		}
		if($previousQuery['interaction_mode']==2)
		{
			$controller= new InteractionMode2Controller($this->template);
			$controller->handleReplySMS($endpoint);
		}
		
	}
}
