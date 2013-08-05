<head>
	<meta charset="utf-8" />
	
 	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
 	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
	
	<script>
		var BaseURI="<?php echo BASE_URI;?>";
		var SMSCharacterLimit=<?php echo ConfigurationList::get('SMSCharacterLimit');?>;
	</script>

	<script src="<?php echo BASE_URI;?>/js/textingSimulator.js"></script>

	<title><?php echo $this->title ? View::escape($this->title) : APPLICATION_NAME; ?></title>
</head>
