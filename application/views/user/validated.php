<div class='container'>
	<div class='alert alert-success miniContent'>
		<h4>User Account Validated!</h4>
		You will be redirected to dashboard withing 5 seconds. Or click
		<a href='<?php echo site_url('/user/dashboard'); ?>'>here</a>

		<script type="text/javascript">
			setTimeout(function() {

				location.href = '<?php echo site_url('user/dashboard');?>';
			}, 5000);
		</script>
	</div>
</div>