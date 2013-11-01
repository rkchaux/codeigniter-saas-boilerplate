<?php
	$links = array(
		array("caption" => "Dashboard", "href" => "user/dashboard"),
		array("caption" => "Archive", "href" => "project/archive"),
		array("caption" => "Plans", "href" => "plan/select"),
		array("caption" => "Profile", "href" => "profile"),
		array("caption" => "Logout", "href" => "user/doLogout")
	);
?>
<div class="navbar">
	<div class="navbar-inner">
	<div class='container'>
		<a class="brand" href="#">SAAS Boilerplate</a>
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