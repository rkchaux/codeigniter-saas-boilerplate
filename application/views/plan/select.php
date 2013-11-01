<div class='container'>
	<h1>Available Plans</h1>
	<div id='companyBar'>
		<label>Select Your Company</label>
		<select id='companyList'>
		</select><br>
		<a id='createCompany' class='btn btn-primary'>Create New Company</a> 
		<a  id='deleteCompany' class='btn btn-danger'>Delete Selected Company</a>
	</div>
	<div class=''>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Plan Name</th>
					<th>Description</th>
					<th>Select</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($plans as $plan) { ?>
				<tr>
					<td><?php echo $plan['name']; ?></td>
					<td><?php echo $plan['description']; ?></td>

					<td>
					<?php if($plan['id'] == $selectedPlan) {?>
						<button class='btn btn-danger disabled'>Selected</button>
					<?php } else { ?>
						<button class='planSelect btn btn-primary' data-plan='<?php echo $plan['id'];?>'>Select</button>
					<?php } ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>