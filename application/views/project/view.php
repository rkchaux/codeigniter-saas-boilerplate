<?php
	$companyInfo = $this->session->userdata("company");
	$allowManage = $project['company'] == $companyInfo['id'];
?>
<div class='container'>
	<h1>Project: <?php echo $project['name']?></h1>
	<a href='<?php echo site_url("user/dashboard/{$project['company']}");?>' class='btn btn-primary'>Back</a>

	<div class='miniContent well'>

	<?php if($allowManage) { ?>
		<h3>Collaboraters</h3>
		<div id='userList'>
			<div data-id= '<?php echo $project['id']; ?>' id='addUser' class='projectUser' style='cursor: pointer;'>
				<img src='<?php echo base_url() . "images/addUser.png"; ?>' rel="tooltip" title="Add new collaborater"/>
			</div>
			<?php foreach($users as $user) { ?>
				<div class='projectUser'>
					<img src='http://placehold.it/40x40' rel="tooltip" title="<?php echo $user['email']; ?>" />
				</div>
			<?php } ?>
			<div style='clear:both;'></div>
		</div>
		<button data-id='<?php echo $project['id']; ?>' class='btn btn-primary' id='manageUsers'>Manage</button>
	<?php } ?>
	</div>
</div>

<?php if($allowManage) { ?>
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
				<td><img src='http://placehold.it/40x40' /></td>
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