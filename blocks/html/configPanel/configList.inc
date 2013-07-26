<?php
/**
 * @copyright 2007-2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
$configList= new ConfigurationList;

/*
$fields = array('serviceDiscoveryURL','open311APIKey','open311JurisdictionId','getServiceListResponse','SMSCharacterLimit','useSMSKeyword',
	'SMSKeyword','SMSResponseFormat','SMSBodyParameter','SMSFromParameter','SMSAPIKeyParameter','SMSAPIKey');

foreach ($fields as $field) {
	$get = 'get'.ucfirst($field);
	$$field = View::escape();
}
$title = $this->person->getId() ? View::escape('Edit '.$this->person->getFirstname()) : 'Add Someone';
$title = $this->title ? View::escape($this->title) : $title;
/*
?>

<!--
<div class="updatePersonForm">
	<h2><?php echo $title; ?></h2>
	<form method="post" action="<?php echo $_SERVER['REDIRECT_URL']; ?>">
		<fieldset><legend>Person Info</legend>
			<input name="person_id" type="hidden" value="<?php echo $this->person->getId(); ?>" />
			<?php
				// Preserve any extra parameters passed in
				foreach ($_REQUEST as $key=>$value) {
					if (!in_array($key,$fields)) {
						$key = View::escape($key);
						$value = View::escape($value);
						echo "<input type=\"hidden\" name=\"$key\" value=\"$value\" />\n";
					}
				}
			?>
			<table>
				<tr><td><label for="firstname" class="required">Firstname</label></td>
					<td><input name="firstname" id="firstname" value="<?php echo $firstname; ?>" /></td>
				</tr>

				<tr><td><label for="middlename">Middlename</label></td>
					<td><input name="middlename" id="middlename" value="<?php echo $middlename; ?>" /></td>
				</tr>

				<tr><td><label for="lastname" class="required">Lastname</label></td>
					<td><input name="lastname" id="lastname" value="<?php echo $lastname; ?>" /></td>
				</tr>

				<tr><td><label for="email">Email</label></td>
					<td><input name="email" id="email" value="<?php echo $email; ?>" /></td>
				</tr>

				<tr><td><label for="phoneNumber">Phone</label></td>
					<td><input name="phoneNumber" id="phoneNumber" value="<?php echo $phoneNumber; ?>" /></td>
				</tr>

				<tr><td><label for="organization">Organization</label></td>
					<td><input name="organization" id="organization" value="<?php echo $organization; ?>" /></td>
				</tr>
			</table>
		</fieldset>

		<fieldset><legend>Address</legend>
			<table>
				<tr><td><label for="address">Address</label></td>
					<td><input name="address" id="address" value="<?php echo $address; ?>" /></td>
				</tr>

				<tr><td><label for="city">City</label></td>
					<td><input name="city" id="city" value="<?php echo $city; ?>" /></td>
				</tr>

				<tr><td><label for="state">State</label></td>
					<td><input name="state" id="state" size="2" maxlength="2" value="<?php echo $state; ?>" />
					</td>
				</tr>

				<tr><td><label for="zip">Zip</label></td>
					<td><input name="zip" id="zip" size="5" maxlength="5" value="<?php echo $zip; ?>" />
					</td>
				</tr>
			</table>
		</fieldset>
-->
