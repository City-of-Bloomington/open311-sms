<?php
/**
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 * @param Person $this->person
 */
$fields = array('firstname','lastname','email');
foreach ($fields as $field) {
	$get = 'get'.ucfirst($field);
	$$field = View::escape($this->person->$get());
}
?>
<div class='form-group'>
			<label for="firstname" class="required col-lg-2 control-label">Firstname</label>
			<div class='col-lg-10'>
			<input name="firstname" class="form-control" id="firstname" value="<?php echo $firstname; ?>" />
			</div>
</div>
<div class='form-group'>
			<label for="lastname" class="required col-lg-2 control-label">Lastname</label>
			<div class='col-lg-10'>
			<input name="lastname" class="form-control" id="lastname" value="<?php echo $lastname; ?>" />
			</div>
</div>
<div class='form-group'>
			<label for="email" class="required col-lg-2 control-label">Email</label>
			<div class='col-lg-10'>
			<input name="email" class="form-control" id="email" value="<?php echo $email; ?>" />
			</div>
</div>
