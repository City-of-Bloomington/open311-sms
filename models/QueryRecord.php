<?php
/**
 * @copyright 2009-2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class QueryRecord
{
	protected $tablename = 'query_record';
	protected $data=array();
	public static function save($interaction_mode,$previous_page,$additional_info=NULL)
	{
		$incomingSMS=new IncomingSMS;
		$from=$incomingSMS->getFrom();
		$zend_db = Database::getConnection();
		$data = array(
		    'phone_number'    => $from,
		    'interaction_mode'=> $interaction_mode,
		    'previous_page'   => $previous_page,
		    'additional_info' => $additional_info	
		);
		$sql = 'select * from query_record where phone_number=?';
		$result = $zend_db->fetchRow($sql, $from);
		if(!isset($_SESSION['SMSErrorMessage']))
		{
			if($result)
			{
				$phone_number=$zend_db->quoteInto('phone_number =?',$from);
				$zend_db->update('query_record', $data, $phone_number);
			}
			else
			{		
				$zend_db->insert('query_record', $data);
			}
		}	
	}
	public static function getRecord($phone_number)
	{
		$zend_db = Database::getConnection();
		$sql = 'select * from query_record where phone_number=?';
		$result = $zend_db->fetchRow($sql, $phone_number);
		if($result)
		{
			return $result;
		}
		else
		{		
			return NULL;
		}	
	}
}

?>
