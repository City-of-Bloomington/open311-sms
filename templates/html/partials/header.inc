<head>
	<meta charset="utf-8" />
	
 	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
 	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
	<?php
		if ($this->layout) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".BASE_URI."/skins/local/layouts/{$this->layout}.css\" />";
		}
	?>
	<script type="text/javascript">
		var CRM = {
			BASE_URL: '<?php echo BASE_URL; ?>'
		};
	</script>
	<title><?php echo $this->title ? View::escape($this->title) : APPLICATION_NAME; ?></title>
</head>
