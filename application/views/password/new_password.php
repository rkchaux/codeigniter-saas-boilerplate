<div class='container'>
	<legend>New Password for Resetting Password</legend>

	<!-- Show Error -->
	<?php if(validation_errors()) { ?>
		<div class='alert alert-error alert-block'>
			<?php echo validation_errors(); ?>
		</div>
	<?php } ?>

	<?php echo form_open("password/doNewPassword", array(
			"class" => "form-horizontal",
			"method" => "post"
		));

	?>
		<input type='hidden' name='code' value='<?php echo $code; ?>'/> 
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="text" name='password' value='<?php echo set_value('password');?>' id="inputPassword" placeholder="Enter your password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputConfirmPassword">Confirm Password</label>
			<div class="controls">
				<input type="text" name='confirmPassword' value='<?php echo set_value('confirmPassword');?>' id="inputConfirmPassword" placeholder="Enter your password">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Reset Password</button>
			</div>
		</div>
	</form>

</div>