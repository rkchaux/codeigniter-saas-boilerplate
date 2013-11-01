<div class='container'>
	<legend>User Registration</legend>

	<!-- Show Error -->
	<?php if(validation_errors()) { ?>
		<div class='alert alert-error alert-block'>
			<?php echo validation_errors(); ?>
		</div>
	<?php } ?>

	<?php echo form_open("user/doRegister", array(
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
			<label class="control-label" for="inputNickname">Nickname</label>
			<div class="controls">
				<input type="text" name='nickname' value='<?php echo set_value('nickname');?>' id="inputNickname" placeholder="Enter your nickname">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputCompany">Company</label>
			<div class="controls">
				<input type="text" name='company' value='<?php echo set_value('company');?>' id="inputCompany" placeholder="Enter your company name">
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