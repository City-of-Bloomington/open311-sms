<?php
/**
 * @copyright 2007-2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 * @param UserList $this->userList
 */
?>
<div class="interfaceBox">
	<h2>User Accounts</h2>
		<?php
			if (userIsAllowed('users')) {
				echo "</br><a class=\"add button\" href=\"".BASE_URL."/users/update\">Add Account</a>";
			}
		?>
	<table class="table table-hover">
		<thead>
			<tr><th></th>
				<th>Username</th>
				<th>Name</th>
				<th>Authentication</th>
				<th>Role</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($this->userList as $user) {
				$editButton = '';
				$deleteButton = '';
				if (userIsAllowed('users')) {
					$editButton = "
					<a class=\"edit button\"
						href=\"".BASE_URL."/users/update?user_id={$user->getId()}\">
						Edit Account
					</a>
					";
					$deleteButton = "
					<a class=\"delete button\"
						href=\"".BASE_URL."/users/delete?user_id={$user->getId()}\">
						Delete Account
					</a>
					";
				}

				$name = View::escape($user->getFullname());
				echo "
				<tr><td>$editButton</td>
					<td>{$user->getUsername()}</td>
					<td>$name</td>
					<td>{$user->getAuthenticationMethod()}</td>
					<td>{$user->getRole()}</td>
					<td>$deleteButton</td>
				</tr>
				";
			}
		?>
		</tbody>
	</table>
</div>
