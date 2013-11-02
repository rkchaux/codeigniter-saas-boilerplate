<div class='container'>
	<h1>Projects</h1>	
	<div class='miniContent'>
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
					<a href='<?php echo site_url('project/view/' . $project['id']);?>'><img src="http://placehold.it/150x127" /></a>
					<a href='<?php echo site_url('project/edit/' . $project['id']); ?>' class='projectEdit btn btn-info btn-mini'>Edit</a>
					<button data-id='<?php echo $project['id']; ?>' class='projectArchive btn btn-inverse btn-mini'>Archive</button>
					<button data-id='<?php echo $project['id']; ?>' class='projectDelete btn btn-danger btn-mini'>Delete</button>
				</div>	

			<?php } ?>
		</div>
		<div style='clear:both;'></div>
	</div>
</div>