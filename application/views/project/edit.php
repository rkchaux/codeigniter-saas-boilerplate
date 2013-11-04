<div class='container'>

	<?php
		$this->load->view("project/menubar", array(
			"project" => $project,
			"role" => $role
		));
	?>

	<div class='miniContent'>

		<?php if($this->model->checkPermission("ADMIN", $role)) { ?>
			<?php if(validation_errors()) { ?>
				<div class='alert alert-error alert-block'>
					<?php echo validation_errors(); ?>
				</div>
			<?php } ?>

			<?php echo form_open("project/doEdit/". $project['id'], array(
					"class" => "form-horizontal",
					"method" => "post"
				));

			?>
				<div class="control-group">
					<label class="control-label" for="inputName">Name</label>
					<div class="controls">
						<input type="text" name='name' value='<?php echo $project['name'];?>' id="inputName" placeholder="Enter new project name">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="submit" class="btn">Update</button>
					</div>
				</div>
			</form>
		<?php } else { ?>
			<div class='alert alert-error alert-block'>
				<strong>There is no such project</strong>
			</div>
		<?php } ?>
	</div>
</div>