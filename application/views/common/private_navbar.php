<?php
	$links = array();

	array_push($links, array("caption" => "Dashboard", "href" => "user/dashboard"));
	
	$comapanyInfo = $this->session->userdata("company");
	if($comapanyInfo) {
		array_push($links, array("caption" => "Archive", "href" => "project/archive"));
		array_push($links, array("caption" => "Plans", "href" => "plan/select"));
	}

	array_push($links, array("caption" => "Profile", "href" => "profile"));
	array_push($links, array("caption" => "Logout", "href" => "user/doLogout"));

?>
<div style='height: 50px'></div>
<div class="navbar navbar-inverse navbar-fixed-top navbar-shadow">
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