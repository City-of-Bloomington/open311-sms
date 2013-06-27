<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class InteractionMode2Controller extends Controller
{

	public function index()
	{
		
	}
	public function __construct(Template $template)
	{
		parent::__construct($template);
	}
	public function generateResponse($endpoint)
	{
		$incomingSMS=new IncomingSMS;
		$serviceCode=$incomingSMS->getServiceCode();
		if(!$serviceCode)
		{
			//return error
		}
		
		$xmlurlServiceList = file_get_contents($endpoint.'/services.xml');    
		$xmlServiceList = simplexml_load_string($xmlurlServiceList, null, LIBXML_NOCDATA);
		$list=ServiceList::getServiceList($xmlServiceList);
		$serviceNumber=self::findServiceNumber($serviceCode);
		
		if(!($list[$serviceNumber]))
		{	
			//return error 
		}
		$fields=array();
		$fields['service_code']=$serviceNumber;
		$fields['address_string']=$incomingSMS->getQueryText();
		$fields['phone']=$incomingSMS->getFrom();
		if(ServiceList::isMetadataPresent($xmlServiceList,$serviceNumber))
		{
			$xmlurlServiceDefinition = file_get_contents($endpoint.'/services/'.$serviceNumber.'.xml');    
			$xmlServiceDefinition = simplexml_load_string($xmlurlServiceDefinition, null, LIBXML_NOCDATA);
			$attributeList=self::getAttributeList($xmlServiceDefinition);
			$fieldString=self::constructFieldString($fields);
			QueryRecord::save(2,1,$fieldString);
			$responseSMS=self::generateMetadataResponse($attributeList,1);
		}
		else
		{	
			$serverResponse=self::postRequest($endpoint,$fields);
			if($serverResponse)
			{			
				$xmlServiceRequest = simplexml_load_string($serverResponse);
				$responseSMS['head']=SUCCESSFUL_REQUEST_SUBMISSION_TEXT;
				$responseSMS[1]=(string)$xmlServiceRequest->request->service_request_id;
			}
			else
			{
				//error
			}
			QueryRecord::save(2,1,$responseSMS[1]);
			
		}
		$this->template->smsBlocks=$responseSMS;
	}
	public function handleReplySMS($endpoint)
	{
		$incomingSMS=new IncomingSMS;
		$previousQuery=QueryRecord::getRecord($incomingSMS->getFrom());
		preg_match('/service_code=([0-9]*)/',$previousQuery['additional_info'],$matches);
		$serviceNumber=$matches[1];
		$incomingAttributeOrder=$previousQuery['previous_page']; //Order of Attribute whose response is in Incoming SMS
		$xmlurlServiceDefinition = file_get_contents($endpoint.'/services/'.$serviceNumber.'.xml');    
		$xmlServiceDefinition = simplexml_load_string($xmlurlServiceDefinition, null, LIBXML_NOCDATA);
		$attributeList=self::getAttributeList($xmlServiceDefinition);
		$attributeCode=$attributeList[$incomingAttributeOrder]['code'];

		$fieldString=$previousQuery['additional_info'];
		$fields=array();
		
		if($attributeList[$incomingAttributeOrder]['datatype']=='singlevaluelist')
		{
			$attributeValueSMSCode=$incomingSMS->getQueryText();
			if(preg_match('/^'.SINGLEVALUELIST_OPTIONS_PREFIX.'([0-9]*)$/',$attributeValueSMSCode,$matches))
				$attributeValueNumber=$matches[1];
			else
			{
				//error
			}	
			$attributeKeyChosen=self::findAttributeKeyChosen($attributeList[$incomingAttributeOrder],$attributeValueNumber);
			$fields['attribute['.$attributeCode.']']=$attributeKeyChosen;
			$fieldString=self::constructFieldString($fields,$fieldString);
		}
		else if($attributeList[$incomingAttributeOrder]['datatype']=='multivaluelist')
		{
			$attributeValueSMSCodes=$incomingSMS->getQueryText();
			if(preg_match_all('/'.MULTIVALUELIST_OPTIONS_PREFIX.'([0-9]*)/',$attributeValueSMSCodes,$matches))
			{
				$attributeValueNumbers=array();				
				$attributeValueNumbers=$matches[1];
			}
			else
			{
				//error
			}	
			foreach($attributeValueNumbers as $attributeValueNumber)
			{
				$attributeKeyChosen=self::findAttributeKeyChosen($attributeList[$incomingAttributeOrder],$attributeValueNumber);
				$fields['attribute['.$attributeCode.'][]']=$attributeKeyChosen;
				$fieldString=self::constructFieldString($fields,$fieldString);
			}
		}
		else
		{
			$fields['attribute['.$attributeCode.']']=$incomingSMS->getQueryText();
			$fieldString=self::constructFieldString($fields,$fieldString);
		}
		
		QueryRecord::save(2,($incomingAttributeOrder+1),$fieldString);	

		if(($incomingAttributeOrder+1)>count($attributeList))
		{
			//No more attributes. We should post the query
			
			$serverResponse=self::postRequest($endpoint,NULL,$fieldString);
			if($serverResponse)
			{			
				$xmlServiceRequest = simplexml_load_string($serverResponse);
				$responseSMS['head']=SUCCESSFUL_REQUEST_SUBMISSION_TEXT;
				$responseSMS[1]=(string)$xmlServiceRequest->request->service_request_id;
			}
			else
			{
				//error
			}
			
		}
		else
		{
			//Response SMS will ask for information about next Attribute
			
			$responseSMS=self::generateMetadataResponse($attributeList,($incomingAttributeOrder+1));
			
		}
		$this->template->smsBlocks=$responseSMS;
	}
	public function postRequest($endpoint,array $fields=NULL,$fieldString=NULL)
	{
		if($fields)
		{
			$fields['api_key'] = API_KEY;
			$fields['jurisdiction_id'] =defined('OPEN311_JURISDICTION_ID')?OPEN311_JURISDICTION_ID:NULL;
			$fieldString=self::constructFieldString($fields);
		}
		else if($fieldString)
		{
			if(!preg_match('/api_key/',$fieldString))
				$fieldString.='&api_key='.API_KEY;
			if(!preg_match('/jurisdiction_id/',$fieldString))
				$fieldString.='&jurisdiction_id='.OPEN311_JURISDICTION_ID;
		}
		//open connection
		$ch = curl_init();
		$url = $endpoint.'/requests.xml';
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		return $result;
	}
	private static function findServiceNumber($string)
	{
		if(preg_match('/^'.SERVICE_OPTIONS_PREFIX.'([0-9]*$)/', $string,$matches))
		{
			return $matches[1]; 
		}
		else
		{
			return 0;
		}
	}
	private static function getAttributeList($xml)
	{
		$attributeList=array();
		foreach($xml->attributes->attribute as $attribute)
		{
			if((string)$attribute->variable=='true')
			{
				$order=(string)$attribute->order;
				$attributeList[$order]=array();
				$attributeList[$order]['code']=(string)$attribute->code;
				$attributeList[$order]['required']=(string)$attribute->required;
				$attributeList[$order]['description']=(string)$attribute->description;
				$attributeList[$order]['datatype']=(string)$attribute->datatype;
				if(((string)$attribute->datatype=='singlevaluelist')||((string)$attribute->datatype=='multivaluelist'))
				{
					foreach($attribute->values->value as $value)
					{
						$key=(string)$value->key;
						$attributeList[$order]['values'][$key]=(string)$value->name;
					}
				}
			}
		}
		return $attributeList;
	}
	private static function constructFieldString(array $fields,$fieldString=NULL)
	{
		if(isset($fieldString))
			$fieldString.='&';
		else
			$fieldString='';
		foreach($fields as $key=>$value) 
		{
			$value=urlencode($value); 
			$fieldString .= $key.'='.$value.'&'; 
		}
		$fieldString=rtrim($fieldString, '&');
		return $fieldString;
	}
	private static function generateMetadataResponse($attributeList,$attributeNumber)
	{	
		$metadataResponse=array();
		$attributeProperties=$attributeList[$attributeNumber];
		$datatype=strtoupper($attributeProperties['datatype']);

		$metadataResponse['head']=constant($datatype.'_DATATYPE_RESPONSE_TEXT_1');
		$metadataResponse['head'].=$attributeProperties['description'];
		$metadataResponse['head'].=constant($datatype.'_DATATYPE_RESPONSE_TEXT_2');
		switch($attributeProperties['datatype'])
		{
			case 'singlevaluelist':
			case 'multivaluelist':
			{
				$i=1;
				foreach($attributeProperties['values'] as $key => $value)
				{
					$metadataResponse[$i]=constant($datatype.'_OPTIONS_PREFIX').$i.'-'.$value.';';
					++$i;
				}
			}
		}
		return $metadataResponse;
	}
	private static function findAttributeKeyChosen($attributeProperties,$attributeValueNumber)
	{
		$i=1;
		foreach($attributeProperties['values'] as $key => $value)
		{
			if($i==$attributeValueNumber)
			{
				$attributeKeyChosen=$key;
				break;
			}
			++$i;
		}
		return $attributeKeyChosen;		
	}
}
