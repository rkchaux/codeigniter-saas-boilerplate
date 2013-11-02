<div class='container'>
	<legend>User Registration (via Inivitation)</legend>

	<!-- Show Error -->
	<?php if(validation_errors()) { ?>
		<div class='alert alert-error alert-block'>
			<?php echo validation_errors(); ?>
		</div>
	<?php } ?>

	<?php echo form_open("invitation/doRegister", array(
			"class" => "form-horizontal",
			"method" => "post"
		));

	?>
		<input type='hidden' name='secret' value='<?php echo $secret; ?>'/>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
				<input disabled='disabled' type="text" value='<?php echo $user['email']; ?>' id="inputEmail" placeholder="Enter your email">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputNickname">Nickname</label>
			<div class="controls">
				<input type="text" name='nickname' value='<?php echo set_value('nickname');?>' id="inputNickname" placeholder="Enter your nickname">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" name='password' id="inputPassword" placeholder="Enter your password">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
				<input type="password" name='confirmPassword' id="inputPassword" placeholder="Enter your password again">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Register</button>
			</div>
		</div>
	</form>

</div>