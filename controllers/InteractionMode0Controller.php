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
		$this->template->smsBlocks['head'] = GROUP_LIST_INFO_TEXT;
	}
}
