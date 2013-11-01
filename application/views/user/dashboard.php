<div class='container'>
	<h1>Projects</h1>	
	<label>Filter By Company</label>
		<select id='companyList'>
		</select>

	<div id='projectList'>
		
		<div id='addProject' class='project well'>
			<div class='name'>Add New Project</div>
			<img style='width: 150px; height: 150px;' src="<?php echo base_url(); ?>images/add.png" />
		</div>	
		<?php foreach($projects as $project) { ?>

			<div class='project well'>
				<div class='name'><?php echo $project['name']?></div>
				<img src="http://placehold.it/150x150" />
			</div>	

		<?php } ?>
	</div>
	<div style='clear:both;'></div>
</div>