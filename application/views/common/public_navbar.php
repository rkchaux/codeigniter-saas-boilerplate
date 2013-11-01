<?php
	$links = array(
		array("caption" => "Home", "href" => ""),
		array("caption" => "Login", "href" => "user/login"),
		array("caption" => "Register", "href" => "user/register")
	);
?>
<div style='height: 50px'></div>
<div class="navbar navbar-inverse navbar-fixed-top navbar-shadow">
	<div class="navbar-inner navbar-inverse">
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