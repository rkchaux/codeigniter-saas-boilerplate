<h1>Project: <?php echo $project['name']?> > Item: <?php echo $item['name']; ?></h1>
<br>
<div>
	<?php

		$links = array();

		array_push($links, array("caption" => "Back to Project", "href" => "project/view/{$project['id']}"));
		array_push($links, array("caption" => "Info", "href" => "item/view/{$project['id']}/{$item['id']}"));
		array_push($links, array("caption" => "Settings", "href" => "item/edit/{$project['id']}/{$item['id']}"));

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