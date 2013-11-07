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

function authorizedContentWithSharing($projectId) {

	$CI =& get_instance();
	$userId = $CI->session->userdata("id");
	$CI->load->model("project_model");

	if($userId) {

		$role = $CI->project_model->getUserRole($userId, $projectId);

		if($role) {
			$project = $CI->project_model->getAssignedProject($userId, $projectId);
		} else if($CI->session->userdata("SHARE_PROJECT") == $projectId) {

			$role = "VIEWER";
			$project = $CI->project_model->getOne($projectId);
		} else {
			authorizedContent();
		}
		
	} else if($CI->session->userdata("SHARE_PROJECT") == $projectId) {

		$role = "VIEWER";
		$project = $CI->project_model->getOne($projectId);
	} else {
		authorizedContent();
	}

	return array(
		'role' => $role,
		'project' => $project
	);
} 
