<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SAAS Boilerplate</title>
	<link type="text/css" rel='stylesheet' href='<?php echo base_url();?>css/bootstrap.min.css'></link>
	<link type="text/css" rel='stylesheet' href='<?php echo base_url();?>css/style.css'></link>
	<script type="text/javascript" src='<?php echo base_url();?>js/jquery.min.js'></script>
	<script type="text/javascript" src='<?php echo base_url();?>js/bootstrap.min.js'></script>
	<script type="text/javascript">

		var BASE_URL = '<?php echo base_url() . "index.php/"; ?>';
	</script>

	<?php 
	if(isset($scripts)) {
		foreach($scripts as $script) { ?>
			<script type="text/javascript" src='<?php echo base_url() . "js/". ($script);?>'></script>
	<?php }} ?>
</head>
<body>