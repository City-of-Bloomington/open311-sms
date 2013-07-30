<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class ConfigurationController extends Controller
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
		if (isset($_POST['serviceDiscoveryURL'])) 
		{
			ConfigurationList::handleUpdate($_POST);
			try {
				$_SESSION['USER']->save();
				header('Location: '.BASE_URL.'/configuration');
				exit();
			}
			catch (Exception $e) {
				$_SESSION['errorMessages'][] = $e;
			}
		}
		$configurationList= new ConfigurationList;
		$configurationList=$configurationList->getArray();
		$this->template->blocks[]=new Block('configPanel/configList.inc',array('configurationList'=>$configurationList));
	}
}
?>
