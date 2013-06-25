<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
class ServiceList
{	
	public static function getServiceList($xml,$group='All')
	{
		foreach ($xml->service as $service) 
		{
			if(((string)$service->group==$group)||($group=='All'))
			{	
				$serviceCode=(int)$service->service_code;
	   			$serviceList[$serviceCode]=(string)$service->service_name;
			}
		}
		uasort($serviceList, 'self::cmp');
		return $serviceList;
	}
	public static function getGroupList($xml)
	{
		$i=1;
		$groupList=array();
		foreach ($xml->service as $service) 
		{
			$groupName=(string)$service->group;
			if(!in_array($groupName,$groupList))
			{	
				$groupList[$i]=$groupName;
				$i++;
			}	
		}
		uasort($groupList, 'self::cmp');
		return $groupList;
	}
	private static function cmp($a,$b)
	{
		if (strlen($a) == strlen($b))
		{
		       	return 0;
    		}
    		return (strlen($a) < strlen($b)) ? -1 : 1;
	}
		
}



?>
