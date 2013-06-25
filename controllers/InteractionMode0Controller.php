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
