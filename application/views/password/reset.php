<div class='container'>
	<legend>Password Reset</legend>

	<!-- Show Error -->
	<?php if(validation_errors()) { ?>
		<div class='alert alert-error alert-block'>
			<?php echo validation_errors(); ?>
		</div>
	<?php } ?>

	<?php echo form_open("password/doReset", array(
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
			<div class="controls">
				<button type="submit" class="btn btn-primary">Reset Password</button>
			</div>
		</div>
	</form>

</div>