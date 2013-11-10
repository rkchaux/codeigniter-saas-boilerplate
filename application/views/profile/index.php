<div class='container'>
	<h1>Profile</h1>
	<a href='<?php echo site_url("profile/edit"); ?>' class='btn btn-primary'>Edit Profile</a><br><br>
	<div class='well'>
		<h3><?php echo $nickname; ?></h3>
	    <img src="http://dummyimage.com/150x200" alt="">
	    <p>
	    <address>
	    	<strong>Email: </strong><?php echo $email; ?>
	    </address>
	</div>


</div>