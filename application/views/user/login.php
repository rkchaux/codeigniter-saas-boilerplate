<div class='container'>
	<legend>User Login</legend>

	<!-- Show Error -->
	<?php if(validation_errors() || $errors) { ?>
		<div class='alert alert-error alert-block'>
			<?php echo validation_errors(); ?>
			<?php echo $errors; ?>
		</div>
	<?php } ?>

	<?php echo form_open("user/doLogin", array(
			"class" => "form-horizontal",
			"method" => "post"
		));

	?>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input type="text" name='email' value='<?php echo set_value('email');?>' id="inputEmail" placeholder="Enter your email">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" name='password' id="inputPassword" placeholder="Enter your password">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn">Login</button>
			</div>
		</div>
	</form>

</div>