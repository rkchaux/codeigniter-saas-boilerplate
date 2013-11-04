<div class='container'>

	<?php
		$this->load->view("project/menubar", array(
			"project" => $project,
			"role" => $role
		));
	?>

	<div class='miniContent'>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Item Name</th>
					<th>Unarchive</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($items as $item) { ?>
				<tr>
					<td><?php echo $item['name']; ?></td>
					<td><button data-project='<?php echo $project['id']; ?>' class='itemUnarchive btn btn-info btn-small' data-id='<?php echo $item['id'];?>'>Unarchive</button></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	</div>
</div>