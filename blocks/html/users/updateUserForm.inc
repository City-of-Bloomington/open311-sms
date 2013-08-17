<?php
/**
 * @copyright 2006-2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @authors Cliff Ingham <inghamn@bloomington.in.gov>, Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 * @param User $this->user
 */
$title = $this->user->getId() ? "Edit {$this->user->getUsername()}" : "Create User Account";
?>
<div class="updateUserForm">
	<h2><?php echo $title; ?></h2>
	<form method="post" action="<?php echo BASE_URL; ?>/users/update" class='form-horizontal'>
		<fieldset><legend>Personal Info</legend>
			<?php
				$this->person = $this->user;
				include APPLICATION_HOME.'/blocks/html/people/personFields.inc';
			?>
		</fieldset>
		<fieldset><legend>User Account</legend>
			<input name="user_id" type="hidden" value="<?php echo $this->user->getId(); ?>" />
			<div class='form-group'>
				<label for="authenticationMethod" class="col-lg-2 control-label">Authentication</label>
				<div class='col-lg-10'>
				<select name="authenticationMethod" id="authenticationMethod" class="form-control">
						<?php
							foreach (Person::getAuthenticationMethods() as $method) {
								$selected = $this->user->getAuthenticationMethod()==$method
									? 'selected="selected"'
									: '';
								echo "<option $selected>$method</option>";
							}
						?>
				</select>
				</div>
      			</div>
			<div class='form-group'>
				<label for="username" class="col-lg-2 control-label">Username</label>
				<div class='col-lg-10'>
				<input name="username" class="form-control" id="username" value="<?php echo View::escape($this->user->getUsername()); ?>" />
				</div>
			</div>	
			<div class='form-group'>
				<label for="password" class="col-lg-2 control-label">Password</label>
				<div class='col-lg-10'>
				<input name="password" class="form-control" id="password" type="password"/>
				</div>
			</div>	
			<div class='form-group'>
				<label for="role" class="col-lg-2 control-label">Role</label>
				<div class='col-lg-10'>
				<select name="role" id="role" class="form-control"><option></option>
						<?php
							global $ZEND_ACL;
							foreach (array_reverse($ZEND_ACL->getRoles()) as $role) {
								$selected = $this->user->getRole()==$role
									? 'selected="selected"'
									: '';
								echo "<option $selected>$role</option>";
							}
						?>
				</select>
				</div>
			</div>			
			<button type="submit" class="btn btn-primary">Submit</button>
			<button type="button" class="btn btn-default"
				onclick="document.location.href='<?php echo BASE_URL; ?>/users';">
				Cancel
			</button>
		</fieldset>
	</form>
<p></p>
</div>
