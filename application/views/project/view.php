<?php
	$companyInfo = $this->session->userdata("company");
	$allowManage = $project['company'] == $companyInfo['id'];

	$sampleItem = array(
		"name" => "The Item",
		"id" => 100
	);

	if(!isset($shareCode)) {
		$shareCode = "";
	}
?>
<div class='container'>
	
	<?php
		$this->load->view("project/menubar", array(
			"project" => $project,
			"role" => $role
		));
	?>

	<?php if($this->model->checkPermission("EDITOR", $role)) { ?>
	<button id='startReorder' class='btn btn-success'>Reorder Items</button>
	<button id='endReorder' class='btn btn-danger hide'>Save New Order</button>
	<?php } ?>
	<p></p>
	<div id='alertReorder' class='alert hide'>
		<strong></strong>
	</div>
	<div class='miniContent'>


		<div id='itemList'>

		<?php if($this->model->checkPermission("ADMIN", $role)) { ?>
			<div class='item well' id='userList'>
				<h3>Collaboraters</h3>
				<div data-id= '<?php echo $project['id']; ?>' id='addUser' class='projectUser' style='cursor: pointer;'>
					<img src='<?php echo base_url() . "images/addUser.png"; ?>' rel="tooltip" title="Add new collaborater"/>
				</div>
				<?php foreach($users as $user) { ?>
					<div class='projectUser'>
						<img src='http://dummyimage.com/40x40' rel="tooltip" title="<?php echo $user['email']; ?>" />
					</div>
				<?php } ?>
				<div style='clear:both;'></div><p></p>
				<button data-id='<?php echo $project['id']; ?>' class='btn btn-primary' id='manageUsers'>Manage</button>
				<a href='#shareModal' role='button' data-toggle="modal" class='btn btn-success' id='shareProject'>Share</a>
			</div>
		<?php } ?>
			
		<?php if($this->model->checkPermission("EDITOR", $role)) { ?>
			<div data-project='<?php echo $project['id']; ?>' id='addItem' class='item well'>
				<div class='name'>Add New Item</div>
				<img style='width: 150px; height: 150px;' src="<?php echo base_url(); ?>images/add.png" />
			</div>	
		<?php } ?>
			
			<div id='itemSortList'>
			<?php foreach($items as $item) { ?>

				<div data-project='<?php echo $project['id']; ?>' data-id='<?php echo $item['id']; ?>' class='item well'>
					<div class='name'><?php echo $item['name']?></div>
					<a href='<?php echo site_url("item/view/{$project['id']}/{$item['id']}");?>'><img src="http://dummyimage.com/150x127" /></a>
				
				<?php if($this->model->checkPermission("EDITOR", $role)) { ?>
					<a href='<?php echo site_url("item/edit/{$project['id']}/{$item['id']}"); ?>' class='itemEdit btn btn-info btn-mini'>Edit</a>
					<button data-project='<?php echo $project['id']; ?>' data-id='<?php echo $item['id']; ?>' class='itemArchive btn btn-inverse btn-mini'>Archive</button>
					<button data-project='<?php echo $project['id']; ?>' data-id='<?php echo $item['id']; ?>' class='itemDelete btn btn-danger btn-mini'>Delete</button>
				<?php } ?>
				</div>	

			<?php } ?>
			</div>
		</div>




	</div>
</div>

<?php if($this->model->checkPermission("ADMIN", $role)) { ?>
<div class="modal hide" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="usersLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="usersLabel">Manage Collaboraters</h3>
  </div>
  <div class="modal-body">

  	<div id='userSuccess' class='alert alert-success hide'>
  		<strong>Invitation has been sent!</strong>
  	</div>
    <div class="control-group">
		<label class="control-label" for="inputName">Add Collaborater </label>
		<div class="controls">
			<input type="text" id='addEmail'  placeholder="Enter email">
			<select id='role'>
				<option>Select a Role</option>
				<option name='VIEWER'>Viewer</option>
				<option name='EDITOR'>Editor</option>
				<option name='ADMIN'>Admin</option>
			</select>
			<br>
			<button id='assignUser' class="btn btn-primary btn-snall" aria-hidden="true">Add</button>
		</div>
		<hr>
		<table>
			<thead>
				<th width='55px'></th>
				<th></th>
				<th></th>
			</thead>
			<?php foreach($users as $user) { 
					if($user['role'] == 'OWNER') continue;
			?>	
			<tr>
				<td><img src='http://dummyimage.com/40x40' /></td>
				<td>
				<?php 
					echo "{$user['email']} (<b>{$user['role']})</b>"; 
					if($user['secret']) {
						echo " - <small><b>Invited</b></small>";
					}
				?>
				</td>
				<td><button data-project='<?php echo $project['id'];?>' data-user='<?php echo $user['id'];?>' class='btn btn-danger btn-mini projectUserRemove'>X</button></td>
			</tr>
			<?php } ?>
		</table>
	</div>
  </div>
  <div class="modal-footer">
    <button class="btn" onclick='' data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<?php } ?>


<div id='shareModal' class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Share Project</h3>
  </div>
  <div class="modal-body">
    <div class="control-group">
		<label class="control-label" for="shareUrl">
			Use following link to share project with anyone (does not require login)
		</label>
		<div class="controls">
			<input type="text" style='width: 450px;' id='shareUrl' value='<?php echo site_url("/project/share/$shareCode"); ?>'>
		</div>
	</div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
  </div>
</div>