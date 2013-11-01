<div class='container'>
	<h1>Edit Profile</h1>
	<a href='<?php echo site_url("profile"); ?>' class='btn btn-primary'>Back</a><br><br>
	
	<div id='basicInfo' class='well'>

		<h3>Basic Info</h3>

		<?php if($this->input->get("updated")) { ?>

			<div class='alert alert-success'>
				<strong>Basic Info Successfully Updated!</strong>
			</div>

		<?php } ?>

		<?php echo form_open("profile/doEdit", array(
				"class" => "form-horizontal",
				"method" => "post"
			));

		?>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email</label>
				<div class="controls">
					<input type="text" name='email' value='<?php echo $email; ?>' id="inputEmail" placeholder="Enter your email">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputNickname">Nickname</label>
				<div class="controls">
					<input type="text" name='nickname' value='<?php echo $nickname;?>' id="inputNickname" placeholder="Enter your nickname">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</div>
		</form>
	
	</div>

	<div id='passwordEdit' class='well'>

		<h3>Change Password</h3>

		<!-- Show Validation Error -->
		<?php if(validation_errors()) { ?>
			<div class='alert alert-error alert-block'>
				<?php echo validation_errors(); ?>
			</div>
		<?php } ?>

		<!-- Show ChangePassword Errors -->
		<?php if(isset($errors["changePassword"])) { ?>
			<div class='alert alert-error alert-block'>
				<?php echo $errors['changePassword']; ?>
			</div>
		<?php } ?>

		<!-- Show Success -->
		<?php if($this->input->get("passwordChanged")) { ?>

			<div class='alert alert-success'>
				<strong>Password Changed Successfully!</strong>
			</div>

		<?php } ?>

		<?php echo form_open("profile/doPasswordChange", array(
				"class" => "form-horizontal",
				"method" => "post"
			));

		?>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Current Password</label>
				<div class="controls">
					<input type="password" name='currPassword' value='<?php echo ""; ?>' id="inputEmail" placeholder="Enter your current password">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputNickname">New Password</label>
				<div class="controls">
					<input type="password" name='newPassword' value='<?php echo "";?>' id="inputNickname" placeholder="Enter your new password">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputNickname">Confirm New Password</label>
				<div class="controls">
					<input type="password" name='confirmNewPassword' value='<?php echo "";?>' id="inputNickname" placeholder="Enter your new password again">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</div>
		</form>
	
	</div>


</div>
</div>