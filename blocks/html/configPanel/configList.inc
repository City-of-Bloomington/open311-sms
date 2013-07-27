<?php
/**
 * @copyright 2007-2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */

$configurationList= new ConfigurationList;

?>


<div class="configurationPanel">
	<h2>Configuration Panel</h2>
	<form method="post" action="<?php echo $_SERVER['REDIRECT_URL']; ?>">
		<fieldset><legend>Configuration</legend>
			<table>
				<tr><td><label for="serviceDiscoveryURL" class="required">Service Discovery URL</label></td>
					<td><input name="serviceDiscoveryURL" id="serviceDiscoveryURL" value="<?php echo View::escape($configurationList->get('serviceDiscoveryURL')); ?>" /></td>
				</tr>

				<tr><td><label for="open311APIKey" class="required">Open311 APIKey</label></td>
					<td><input name="open311APIKey" id="open311APIKey" value="<?php echo View::escape($configurationList->get('open311APIKey')); ?>" /></td>
				</tr>

				<tr><td><label for="open311JurisdictionId" class="required">Open311 Jurisdiction Id</label></td>
					<td><input name="open311JurisdictionId" id="open311JurisdictionId" value="<?php echo View::escape($configurationList->get('open311JurisdictionId'));  ?>" /></td>
				</tr>

				<tr><td><label for="getServiceListResponse" class="required">Response to Get Service List Interaction Mode</label></td>
					<td><input name="getServiceListResponse" id="getServiceListResponse" value="<?php echo View::escape($configurationList->get('getServiceListResponse')); ?>" /></td>
				</tr>

				<tr><td><label for="SMSCharacterLimit" class="required">SMS Character Limit</label></td>
					<td><input name="SMSCharacterLimit" id="SMSCharacterLimit" value="<?php echo View::escape($configurationList->get('SMSCharacterLimit')); ?>" /></td>
				</tr>

				<tr><td><label for="useSMSKeyword" class="required">Use SMS Keyword?</label></td>
					<td><input name="useSMSKeyword" id="useSMSKeyword" value="<?php echo View::escape($configurationList->get('useSMSKeyword')); ?>" /></td>
				</tr>
		
				<tr><td><label for="SMSKeyword">SMS Keyword</label></td>
					<td><input name="SMSKeyword" id="SMSKeyword" value="<?php echo View::escape($configurationList->get('SMSKeyword')) ?>" /></td>
				</tr>

				<tr><td><label for="SMSResponseFormat" class="required">SMSResponseFormat</label></td>
					<td><input name="SMSResponseFormat" id="SMSResponseFormat" value="<?php echo View::escape($configurationList->get('SMSResponseFormat')); ?>" /></td>
				</tr>

				<tr><td><label for="SMSBodyParameter" class="required">SMS Body Parameter</label></td>
					<td><input name="SMSBodyParameter" id="SMSBodyParameter" value="<?php echo View::escape($configurationList->get('SMSBodyParameter')); ?>" />
					</td>
				</tr>

				<tr><td><label for="SMSFromParameter" class="required">SMS From Parameter</label></td>
					<td><input name="SMSFromParameter" id="SMSFromParameter"  value="<?php echo View::escape($configurationList->get('SMSFromParameter')); ?>" />
					</td>
				</tr>

				<tr><td><label for="APIKeyRequired">Is API Key Required?</label></td>
					<td><input name="APIKeyRequired" id="APIKeyRequired" value="<?php echo View::escape($configurationList->get('APIKeyRequired')); ?>" />
					</td>
				</tr>

				<tr><td><label for="SMSAPIKeyParameter">SMSAPIKeyParameter</label></td>
					<td><input name="SMSAPIKeyParameter" id="SMSAPIKeyParameter" value="<?php echo View::escape($configurationList->get('SMSAPIKeyParameter')); ?>" />
					</td>
				</tr>

				<tr><td><label for="SMSAPIKey">SMSAPIKey</label></td>
					<td><input name="SMSAPIKey" id="SMSAPIKey" value="<?php echo View::escape($configurationList->get('SMSAPIKey')); ?>" />
					</td>
				</tr>
				<tr><td><label for="language">Language</label></td>
					<td><input name="language" id="language" value="<?php echo View::escape($configurationList->get('language')); ?>" />
					</td>
				</tr>
			</table>
		</fieldset>
<fieldset><legend>Submit</legend>
			<button type="submit" class="submit">Submit</button>
			<?php
				if (isset($_REQUEST['return_url'])) {
					$return_url = urlencode($_REQUEST['return_url']);
				}
				
				else {
					$return_url = BASE_URL.'/configuration/update';
				}

				$onclick = isset($_REQUEST['callback'])	? 'onclick="self.close();"': '';
				echo "<a class=\"cancel\" href=\"$return_url\" $onclick>Cancel</a>";
			?>
		</fieldset>
	</form>
</div>
