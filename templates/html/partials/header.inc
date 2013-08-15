<head>
	<meta charset="utf-8" />
	
 	<link rel="stylesheet" href="<?php echo BOOTSTRAP;?>/css/bootstrap.min.css">

	<script src="<?php echo JQUERY;?>/jquery.min.js">
</script>
 	<script src="<?php echo BOOTSTRAP;?>/js/bootstrap.min.js"></script>
	
	<script>
		var BaseURI="<?php echo BASE_URI;?>";
		var SMSCharacterLimit=<?php echo ConfigurationList::get('SMSCharacterLimit');?>;
	</script>

	<script src="<?php echo BASE_URI;?>/js/textingSimulator.js"></script>

	<title><?php echo $this->title ? View::escape($this->title) : APPLICATION_NAME; ?></title>
</head>
