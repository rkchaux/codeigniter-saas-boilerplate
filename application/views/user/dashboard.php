<div class='container'>
	<h1>Dashboard</h1>	
	<div id='companyBar'>
		<label>Select Your Company</label>
		<select id='companyList'>
		</select><br>
		<a id='createCompany' class='btn btn-primary'>Create New Company</a> 
		<a  id='deleteCompany' class='btn btn-danger'>Delete Selected Company</a>
	</div>
	<h2>Projects</h2>
	<button id='addProject' class='btn btn-primary'>Add New</button>
	<div id='projectList'>
		
		<?php foreach($projects as $project) { ?>

			<div class='project well'>
				<div class='name'><?php echo $project['name']?></div>
				<img src="http://placehold.it/150x150" />
			</div>	

		<?php } ?>
	</div>
	<div style='clear:both;'></div>
</div>