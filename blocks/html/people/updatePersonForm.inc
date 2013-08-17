<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 * @param Person $this->person
 */
$title = $this->person->getId() ? View::escape('Edit '.$this->person->getFirstname()) : 'Add Someone';
?>
<div class="updatePersonForm">
	<h2><?php echo $title; ?></h2>
	<form method="post" action="<?php echo BASE_URL; ?>/people/update" class="form-horizontal">
		<fieldset><legend>Person Info</legend>
			<input name="person_id" type="hidden" value="<?php echo $this->person->getId(); ?>" />

			<?php include APPLICATION_HOME.'/blocks/html/people/personFields.inc'; ?>

			<button type="submit" class="btn btn-primary">Submit</button>
			<button type="button" class="btn btn-default"
				onclick="document.location.href='<?php echo BASE_URL; ?>/people';">
				Cancel
			</button>
		</fieldset>
	</form>
</div>
