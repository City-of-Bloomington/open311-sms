<?php
/**
 * @copyright 2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
abstract class SMSController extends Controller
{
	protected $template;
	protected $endpoint;
	protected $xmlServiceList;

	abstract public function generateFirstPageResponse();
	abstract public function handleReplySMS();

	public function __construct(Template $template,$endpoint,$xmlServiceList)
	{
		parent::__construct($template);
		$this->endpoint=$endpoint;    
		$this->xmlServiceList = $xmlServiceList;
	}
}
