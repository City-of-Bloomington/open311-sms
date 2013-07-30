<?php
/**
 * @copyright 2009-2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class ConfigurationList
{
	private $configurationList;
	public function __construct()
	{	
		$zend_db = Database::getConnection();
		$result=$zend_db->query('SELECT configName,configValue FROM configuration');
		$result=$result->fetchAll();
		foreach($result as $config)
		{
			$this->configurationList[$config['configName']]=$config['configValue'];
		}		
	}
	public static function get($configName)
	{
		$config=new ConfigurationList;
		return $config->configurationList[$configName];
	}
	public function set($configName,$configValue)
	{
		$zend_db = Database::getConnection();
		$data = array('configValue'=> $configValue);
		$configName=$zend_db->quoteInto('configName =?',$configName);
		$zend_db->update('configuration', $data, $configName);
	}
	public static function handleUpdate($post)
	{
		$fields = array('serviceDiscoveryURL', 'open311APIKey', 'open311JurisdictionId', 'getServiceListResponse', 'SMSCharacterLimit','useSMSKeyword', 'SMSKeyword','SMSResponseFormat', 'SMSBodyParameter', 'SMSFromParameter', 'SMSAPIKeyParameter','SMSAPIKey','language','APIKeyRequired');
		foreach ($fields as $field) {
			if (isset($post[$field])) {
				self::set($field,$post[$field]);
			}
		}
	}
	
}
?>
