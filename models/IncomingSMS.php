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
		$this->smsAPIKey= defined('SMS_API_KEY_PARAM')?trim(self::fetchValuefromKey(SMS_API_KEY_PARAM)):NULL;
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
		return TRUE;
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

	public function getInteractionMode()
	{
		$SubKeywordIndex=1;
		
		if (!defined('SMS_KEYWORD'))
		{
			--$SubKeywordIndex;
		}

		switch($this->smsBodyPieces[$SubKeywordIndex])
		{
			case SUB_KEYWORD_GET_SERVICE_CODES   :{$interactionMode=1;break;}
			case SUB_KEYWORD_SUBMIT_REQUEST      :{$interactionMode=2;break;}	
			case SUB_KEYWORD_CHECK_REQUEST_STATUS:{$interactionMode=3;break;}	
			case SUB_KEYWORD_HELP                :{$interactionMode=4;break;}	
			default :{$interactionMode=0;}	
		}
		return $interactionMode;
	}

	public function getSubKeyword()
	{
		$SubKeywordIndex=1;		
		if (!defined('SMS_KEYWORD'))
		{
			--$SubKeywordIndex;
		}

		switch($this->smsBodyPieces[$SubKeywordIndex])
		{
			case SUB_KEYWORD_GET_SERVICE_CODES   :{return SUB_KEYWORD_GET_SERVICE_CODES;}
			case SUB_KEYWORD_SUBMIT_REQUEST      :{return SUB_KEYWORD_SUBMIT_REQUEST;}	
			case SUB_KEYWORD_CHECK_REQUEST_STATUS:{return SUB_KEYWORD_CHECK_REQUEST_STATUS;}	
			case SUB_KEYWORD_HELP                :{return SUB_KEYWORD_HELP;}
			case SUB_KEYWORD_MORE                :{return SUB_KEYWORD_MORE;}
			default 			     :{return NULL;}	
		}
	}

	public function getQueryText()	
	{
		$potentialQueryTextIndex=2;
		if(!defined('SMS_KEYWORD')) {-- $potentialQueryTextIndex; }
		if(is_null(self::getSubkeyword())) {-- $potentialQueryTextIndex; }
		
		/* 
		 *All the pieces after Keyword and subKeyword are QueryText
		 */	
		$QueryTextIndex=$potentialQueryTextIndex;
		$QueryText=isset($this->smsBodyPieces[$QueryTextIndex])?$this->smsBodyPieces[$QueryTextIndex]:NULL;
		foreach($this->smsBodyPieces as $key => $value)
		{
			if($key>$QueryTextIndex)
				$QueryText=$QueryText." ".$value;
		}	
		return $QueryText;
	}
	
	private static function fetchValuefromKey($key)
	{
		$value=array_key_exists($key, $_REQUEST)?$_REQUEST[$key]:NULL;
		return $value;
	}

	public function getFrom() 
        { 
		return $this->smsFrom;           
	}
	
}
