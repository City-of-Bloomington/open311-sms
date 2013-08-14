<form class="form-horizontal" method="post" action="<?php echo BASE_URL; ?>/login/login" >
	<input name="return_url" type="hidden" value="<?php echo View::escape($this->return_url); ?>" />
	<div class='form-group'>
			<label for="username" class="col-lg-1 control-label">Username:</label>
			<div class='col-lg-3'>
			<input name="username" class="form-control" id="username"); ?>
			</div>
      	</div>
	<div class='form-group'>
			<label for="password" class="col-lg-1 control-label">Password:</label>
			<div class='col-lg-3'>
			<input type="password" name="password" class="form-control" id="password"); ?>
			</div>
      	</div>

<button id="Login" class="btn btn-primary">Login</button>
</form>
