<?php

class Item extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model("item_model", "model");
	}

	public function doCreate() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$name = $this->input->post("name");
		$projectId = $this->input->post("project");
		$userId = $this->session->userdata("id");

		if(!$projectId) {

			$this->sendJson(array("error" => "No Project Selected"));
		} else if($name) {

			$itemId = $this->model->create($userId, $projectId, $name);
			
			if($itemId) {

				$this->sendJson(array("success" => true));
			} else {

				$this->sendJson(array("success" => false));
			}
			

		} else {

			$this->sendJson(array("error" => "No Name Provided"));
		}
	}

	public function doDelete() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$id = $this->input->post("id");
		$projectId = $this->input->post("project");

		if($id && $projectId) {

			$this->model->delete($projectId, $id);
			$this->sendJson(array("success" => true));

		} else {
			$this->sendJson(array("error" => "No Id and Project Provided"));
		}
	}

	public function doArchive() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$id = $this->input->post("id");
		$projectId = $this->input->post("project");

		if($id && $projectId) {

			$this->model->archive($projectId, $id);
			$this->sendJson(array("success" => true));
		
		} else {
			$this->sendJson(array("error" => "No Id and Project Provided"));
		}
	}

	public function doUnarchive() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$id = $this->input->post("id");
		$projectId = $this->input->post("project");

		if($id && $projectId) {

			$this->model->archive($projectId, $id);
			$this->sendJson(array("success" => true));
		
		} else {
			$this->sendJson(array("error" => "No Id and Project Provided"));
		}
	}

	public function view($projectId, $id) {

		$this->load->model("project_model");
		$project = $this->project_model->getOne($projectId);

		$item = $this->model->getOne($id);

		$data = array(
			"project" => $project, 
			"item" => $item
		);
		
		$this->load->view("common/header");
		$this->load->view("common/private_navbar");
		$this->load->view("item/view", $data);
		$this->load->view("common/footer");
	}

	// public function archive() {

	// 	authorizedContent();

	// 	$data = array(
	// 		"scripts"=> array("project.js")
	// 	);

	// 	$companyInfo = $this->session->userdata("company");

	// 	$archiveData = array(
	// 		"projects" => $this->model->getArchived($companyInfo['id']),
	// 		"company" => $companyInfo
	// 	);

	// 	$this->load->view("common/header", $data);
	// 	$this->load->view("common/private_navbar");
	// 	$this->load->view("project/archive", $archiveData);
	// 	$this->load->view("common/footer");
	// }

	// public function edit($id) {

	// 	authorizedContent();

	// 	$userId = $this->session->userdata("id");
	// 	$role = $this->model->getUserRole($userId, $id);

	// 	$this->load->helper("form");

	// 	$data = array( "project" => NULL );

	// 	$this->load->view("common/header");
	// 	$this->load->view("common/private_navbar");
	// 	if($this->model->checkPermission("ADMIN", $role)) {
			
	// 		$project = $this->model->getOne($id);
	// 		$data['project'] = $project;
	// 		$data['role'] = $role;
	// 	}

	// 	$this->load->view("project/edit", $data);
	// 	$this->load->view("common/footer");

	// }

	// public function doEdit($id) {

	// 	authorizedContent();
		
	// 	$this->load->library("form_validation");

	// 	$this->form_validation->set_rules("name", "Name", "required");

	// 	if($this->form_validation->run() == TRUE) {
			
	// 		$companyInfo = $this->session->userdata('company');
	// 		$project = array(
	// 			"name" => $this->input->post("name")
	// 		);

	// 		$this->model->update($companyInfo['id'], $id, $project);
	// 		redirect(site_url('user/dashboard?projectEdited=true'));
	// 	} else {

	// 		$this->edit($id);
	// 	}
	// }

	// public function info($id) {

	// 	$userId = $this->session->userdata("id");

	// 	$role = $this->model->getUserRole($userId, $id);

	// 	$data = array(
	// 		"project" => $this->model->getOne($id),
	// 		"role" => $role
	// 	);

	// 	$this->load->view("common/header");
	// 	$this->load->view("common/private_navbar");
	// 	$this->load->view("project/info", $data);
	// 	$this->load->view("common/footer");
	// }

	// public function view($projectId) {

	// 	authorizedContent();

	// 	$this->load->helper("form");

	// 	$userId = $this->session->userdata("id");

	// 	$role = $this->model->getUserRole($userId, $projectId);

	// 	$this->load->view("common/header", array(
	// 		"scripts" => array("projectView.js", "item.js")
	// 	));
	// 	$this->load->view("common/private_navbar");

	// 	if($this->model->checkPermission("VIEWER", $role)) {

	// 		$data = array(
	// 			"project" => $this->model->getAssignedProject($userId, $projectId),
	// 			"users" => $this->model->getUsers($projectId),
	// 			"role" => $role
	// 		);

	// 		$this->load->view("project/view", $data);
	// 	} else {
	// 		$this->load->view("project/restricted");
	// 	}

	// 	$this->load->view("common/footer");

	// }

	// public function doAssignUser($projectId) {

	// 	authorizedContent(true);

	// 	$userId = $this->session->userdata("id");
	// 	$role = $this->model->getUserRole($userId, $projectId);

	// 	if($this->model->checkPermission("ADMIN", $role)) {

	// 		$email = $this->input->post("email");
	// 		$role = $this->input->post("role");

	// 		if($email && $role) {

	// 			$this->model->assignUserByEmail($email, $projectId, $role);
	// 			$this->sendJson(array("success" => true));
	// 		} else {

	// 			$this->sendJson(array("success" => false, "error" => "Email and Role required"));
	// 		}
	// 	} else {
			
	// 		$this->sendJson(array("success" => false, "error" => "Not Allowed"));
	// 	}
		
	// }

	// public function doRemoveUser($projectId) {

	// 	authorizedContent(true);

	// 	$userId = $this->session->userdata("id");
	// 	$role = $this->model->getUserRole($userId, $projectId);

	// 	if($this->model->checkPermission("ADMIN", $role)) {

	// 		$userId = $this->input->post("user");
	// 		$this->model->removeUser($userId, $projectId);

	// 		$this->sendJson(array("success" => true));
	// 	} else {
			
	// 		$this->sendJson(array("success" => false, "error" => "Not Allowed"));
	// 	}
		
	// }

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}
}