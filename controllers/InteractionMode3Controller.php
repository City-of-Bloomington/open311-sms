<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode3Controller extends Controller
{
	public function index()
	{
		$this->template->smsBlocks['head'] = REQUEST_STATUS_RESPONSE_TEXT_1;
	}
}
