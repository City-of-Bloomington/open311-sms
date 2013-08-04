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
		$result=$zend_db->query('SELECT blockName, blockValue, blockType FROM language_'.ConfigurationList::get('language'));
		$result=$result->fetchAll();
		foreach($result as $row)
		{
			$this->languageBlockList[$row['blockName']]=array('blockValue'=>$row['blockValue'],'blockType'=>$row['blockType']);
		}		
	}
	public static function get($languageBlockName)
	{
		$list=new LanguageBlockList;
		return $list->languageBlockList[$languageBlockName];
	}
	public function getArray()
	{
		return $this->languageBlockList;
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
		foreach ($fields as $field) 
		{
			if (isset($post[$field])) 
			{
				self::set($field,$post[$field]);
			}
		}
	}
	public static function initializeConstants()
	{
		$list=new LanguageBlockList;
		$list=$list->getArray();
		define('SMS_KEYWORD',ConfigurationList::get('SMSKeyword'));
		foreach($list as $blockName=>$blockParam)
		{
			define($blockName,$blockParam['blockValue']);
		}
	}
	public static function getTypeList($listArray)
	{
		$blockTypeList=array();
		foreach ($listArray as $block)
		{
			if (!in_array($block['blockType'],$blockTypeList))
			{	
				$blockTypeList[]=$block['blockType'];
			}
		}
		return $blockTypeList;
	}	
}
?>
