<?php
/**
 * @copyright 2009-2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class LanguageBlockList
{
	private $languageBlockList;
	public function __construct()
	{	
		$zend_db = Database::getConnection();
		$result=$zend_db->query('SELECT blockName, blockValue FROM language_'.ConfigurationList::get('language'));
		$result=$result->fetchAll();
		foreach($result as $config)
		{
			$this->languageBlockList[$config['blockName']]=$config['blockValue'];
		}		
	}
	public static function get($languageBlockName)
	{
		$list=new LanguageBlockList;
		return $list->languageBlockList[$languageBlockName];
	}
	public function getArray()
	{
		$list=new LanguageBlockList;
		return $list->languageBlockList;
	}
	public function set($blockName,$blockValue)
	{
		$zend_db = Database::getConnection();
		$data = array('blockValue'=> $blockValue);
		$blockName=$zend_db->quoteInto('blockName =?',$blockName);
		$zend_db->update('language_'.ConfigurationList::get('language'), $data, $blockName);
	}
	public function handleUpdate($post)
	{
		
		$fields = array_keys(self::getArray());
		foreach ($fields as $field) {
			if (isset($post[$field])) {
				self::set($field,$post[$field]);
			}
		}
	}
	
}
?>
