<div class='container'>
	<h1>Project: <?php echo $project['name']?></h1>

	<div class='miniContent well'>

		<h3>Collaborators</h3>
		<button data-id='<?php echo $project['id']; ?>' class='btn btn-primary btn-small'id='assignUser'>Add</button>
		<div id='userList'>
			<?php foreach($users as $user) { ?>
				<div>
					<?php echo $user['email']; ?>
					<?php if ($user['secret']) { ?> - invited. <?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>