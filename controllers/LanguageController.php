<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class LanguageController extends Controller
{
	public function __construct(Template $template)
	{
		parent::__construct($template);
	}
	public function index()
	{	
		
	}
	public function update()
	{
		$languageBlockList= new LanguageBlockList;
		if (isset($_POST['SMS_KEYWORD'])) 
		{
			$languageBlockList->handleUpdate($_POST);
			try {
				$_SESSION['USER']->save();
				header('Location: '.BASE_URL.'/configuration');
				exit();
			}
			catch (Exception $e) {
				$_SESSION['errorMessages'][] = $e;
			}
		}
		$languageBlockList= new LanguageBlockList;
		$languageBlockList=$languageBlockList->getArray();
		$this->template->blocks[]=new Block('languageBlocks.inc',array('languageBlockList'=>$languageBlockList));
	}
}
?>
