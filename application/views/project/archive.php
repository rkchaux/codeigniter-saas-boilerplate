<div class='container'>
	<h1>Project Archive</h1>
	<span class='label label-info'><?php echo $company['name']; ?></span>

	<div class='miniContent'>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Project Name</th>
					<th>Unarchive</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($projects as $project) { ?>
				<tr>
					<td><?php echo $project['name']; ?></td>
					<td><button class='projectUnarchive btn btn-info btn-small' data-id='<?php echo $project['id'];?>'>Unarchive</button></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>