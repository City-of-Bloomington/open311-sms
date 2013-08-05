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
		$this->smsFrom  = trim(self::fetchValuefromKey(ConfigurationList::get('SMSFromParameter')));
		$this->smsBody  = trim(self::fetchValuefromKey(ConfigurationList::get('SMSBodyParameter')));
		$this->smsAPIKey= (ConfigurationList::get('APIKeyRequired')=='Yes')?trim(self::fetchValuefromKey(ConfigurationList::get('SMSAPIKeyParameter'))):NULL;
		$this->smsBodyPieces=explode(" ",$this->smsBody,4);
	}
	
	public function isAPIKeyValid()
	{
		
		if(isset($this->smsAPIKey))
		{
			
			if(($this->smsAPIKey)==ConfigurationList::get('SMSAPIKey'))
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
		if(ConfigurationList::get('useSMSKeyword')=='Yes')
		{
			if($keyword==ConfigurationList::get('SMSKeyword'))	
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
		$subKeywordIndex=1;
		
		if (ConfigurationList::get('useSMSKeyword')=='No')
		{
			--$subKeywordIndex;
		}
		switch($this->smsBodyPieces[$subKeywordIndex])
		{
			case SUB_KEYWORD_GET_SERVICE_CODES   :{$interactionMode=1;break;}
			case SUB_KEYWORD_SUBMIT_REQUEST      :{$interactionMode=2;break;}	
			case SUB_KEYWORD_CHECK_REQUEST_STATUS:{$interactionMode=3;break;}	
			case SUB_KEYWORD_HELP                :{$interactionMode=4;break;}	
			default :{$interactionMode=NULL;}	
		}
		return $interactionMode;
	}

	public function getSubKeyword()
	{
		$SubKeywordIndex=1;		
		if (ConfigurationList::get('useSMSKeyword')=='No')
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
	
	public function getServiceCode()	
	{
		$serviceCodeIndex=2;
		if(ConfigurationList::get('useSMSKeyword')=='No') {-- $serviceCodeIndex; }
		if(is_null(self::getSubkeyword())) {-- $serviceCodeIndex; }
		if((isset($this->smsBodyPieces[$serviceCodeIndex]))&&(preg_match('/^'.SERVICE_OPTIONS_PREFIX.'[0-9]*$/i',$this->smsBodyPieces[$serviceCodeIndex],$matches)))
		{
			return $this->smsBodyPieces[$serviceCodeIndex];
		}
		else	
		{
			return NULL;
		}
	}
	public function getQueryText()	
	{
		$queryTextIndex=3;
		if(ConfigurationList::get('useSMSKeyword')=='No') {-- $queryTextIndex; }
		if(is_null(self::getSubkeyword())) {-- $queryTextIndex; }
		if(is_null(self::getServiceCode())) {-- $queryTextIndex; }		
		/* 
		 *All the pieces after Keyword and subKeyword are QueryText
		 */	
		$queryText=isset($this->smsBodyPieces[$queryTextIndex])?$this->smsBodyPieces[$queryTextIndex]:NULL;
		foreach($this->smsBodyPieces as $key => $value)
		{
			if($key>$queryTextIndex)
				$queryText=$queryText." ".$value;
		}	
		return $queryText;
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
