<?php
/**
 * @copyright 2007-2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */

class SimulatorController extends Controller
{
	public function __construct(Template $template)
	{	
		parent::__construct($template);
	}
	public function index()
	{
		$this->template->blocks[]=new Block('textingSimulator.inc');	
	}
	public function getResponse()
	{
		$fieldString=ConfigurationList::get('SMSFromParameter').'='.$_REQUEST['From'];
		$fieldString.='&'.ConfigurationList::get('SMSBodyParameter').'='.$_REQUEST['Body'];
		$fieldString.='&format=simulator';
		if(ConfigurationList::get('APIKeyRequired')=='Yes')
		{
			$fieldString.='&'.ConfigurationList::get('SMSAPIKeyParameter').'='.ConfigurationList::get('SMSAPIKey');
		}
		//open connection
		$ch = curl_init();
		$url = BASE_URL.'/SMSinterface';
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//execute post
		$result = trim(curl_exec($ch));

		//close connection
		curl_close($ch);
				
		$this->template->blocks[]=new Block('simulatorResponse.inc',array('response'=>$result));	
	}
}
?>
