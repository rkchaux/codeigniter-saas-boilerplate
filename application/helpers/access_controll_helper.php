<?php

/*
	Allowed only access logged in users
*/
function authorizedContent($jsonUser = false) {
	
	$CI =& get_instance();
	$email = $CI->session->userdata("email");

	if(!$email) {

		if($jsonUser) {

			header("Content-Type: application/json");
			echo json_encode(array("error"=> "Unauthorized access"));
			die();
		} else {
			
			redirect(site_url("user/login"));
		}
	}
}