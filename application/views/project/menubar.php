<h1>Project: <?php echo $project['name']?></h1>
<br>
<div>
	<?php

		$links = array();

		array_push($links, array("caption" => "Back to Dashboard", "href" => "user/dashboard/{$project['company']}"));
		array_push($links, array("caption" => "Items", "href" => "project/view/{$project['id']}"));
		array_push($links, array("caption" => "Info", "href" => "project/info/{$project['id']}"));
	
		if($this->model->checkPermission("ADMIN", $role)) {

			array_push($links, array("caption" => "Archived Items", "href" => "project/archivedItems/{$project['id']}"));
			array_push($links, array("caption" => "Settings", "href" => "project/edit/{$project['id']}"));
		}

	?>
	<div class="navbar">
		<div class='navbar-inner'>
			<ul class="nav">

				<?php foreach ($links as $link) {
					$url = site_url($link['href']);
					$class = ($url == current_url())? " class='active' " : "";
					echo "<li $class><a href='$url'>{$link['caption']}</a></li>";
				}?>
			</ul>
		</div>
	</div>
</div>