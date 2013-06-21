<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class IncomingSMS
{
	protected $smsFrom;
	protected $smsBody;
	protected $smsAPIKey;
	protected $smsBodyPieces;

	public function __construct()
	{
		$this->smsFrom  = trim(self::fetchValuefromKey(SMS_FROM));
		$this->smsBody  = trim(self::fetchValuefromKey(SMS_BODY));
		$this->smsAPIKey= trim(self::fetchValuefromKey(SMS_API_KEY_PARAM));
		$this->smsBodyPieces=explode(" ",$this->smsBody,3);
	}
	
	public function isAPIKeyValid()
	{
		if(isset($this->smsAPIKey))
		{
			if(($this->smsAPIKey)==SMS_API_KEY)
				return TRUE;
			else
			{	
				throw new Exception('Invalid Key');
			}
		}
		
	}
	
	public function isKeywordMatched()
	{
		$keyword=$this->smsBodyPieces[0];
		if(defined('SMS_KEYWORD'))
		{
			if($keyword==SMS_KEYWORD)	
			{
				return TRUE;
			}
			else
			{
				throw new Exception('Keyword Mismatch');
			}
		}
		return TRUE;
	}

	public function getSubKeyword()
	{
		$SubKeywordIndex=1;
		
		if (!defined('SMS_KEYWORD'))
		{
			--$SubKeywordIndex;
		}

		if (SUB_KEYWORD_GET_SERVICE_CODES==$this->smsBodyPieces[$SubKeywordIndex]) 
		{
			$subKeyword=SUB_KEYWORD_GET_SERVICE_CODES; 
		}	
		else if (SUB_KEYWORD_SUBMIT_REQUEST==$this->smsBodyPieces[$SubKeywordIndex]) 
		{ 
			$subKeyword=SUB_KEYWORD_SUBMIT_REQUEST; 
		}	
		else if (SUB_KEYWORD_CHECK_REQUEST_STATUS==$this->smsBodyPieces[$SubKeywordIndex])
		{ 
			$subKeyword=SUB_KEYWORD_CHECK_REQUEST_STATUS; 
		}	
		else if (SUB_KEYWORD_HELP==$this->smsBodyPieces[$SubKeywordIndex]) 
		{ 
			$subKeyword=SUB_KEYWORD_HELP; 
		}	
		else 
		{ 
			$subKeyword=NULL;	
		}
		return $subKeyword;
	}

	public function getQueryText()
	{
		$potentialQueryTextIndex=2;
		if(!defined('SMS_KEYWORD')) {-- $potentialQueryTextIndex; }
		if(is_null(self::getSubKeyword())) {-- $potentialQueryTextIndex; }
		
		/* 
		 *All the pieces after Keyword and subKeyword are QueryText
		 */	
		$QueryTextIndex=$potentialQueryTextIndex;
		$QueryText=$this->smsBodyPieces[$QueryTextIndex];
		for($i=$QueryTextIndex+1;$i<=2;$i++)
		{
			$QueryText=$QueryText." ".$this->smsBodyPieces[$i];
		}
		
		return $QueryText;
	}
	
	private static function fetchValuefromKey($key)
	{
		$value=array_key_exists($key, $_REQUEST)?$_REQUEST[$key]:NULL;
		return $value;
	}
}
