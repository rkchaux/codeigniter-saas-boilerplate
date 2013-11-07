<?php

class Project extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model("project_model", "model");
	}

	public function doCreate() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$name = $this->input->post("name");

		if(!$companyInfo) {

			$this->sendJson(array("error" => "No Company Selected"));
		} else if($name) {

			$projectId = $this->model->create($companyInfo['id'], $name);
			
			if($projectId) {

				//assign the logged_in user to the project
				$userId = $this->session->userdata("id");
				$this->model->assignUser($userId, $projectId, "OWNER");

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
		if($id) {

			$this->model->delete($companyInfo['id'], $id);
			$this->sendJson(array("success" => true));

		} else {
			$this->sendJson(array("error" => "No Id Provided"));
		}
	}

	public function doArchive() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$id = $this->input->post("id");
		if($id) {

			$this->model->archive($companyInfo['id'], $id);
			$this->sendJson(array("success" => true));
		
		} else {
			$this->sendJson(array("error" => "No Id Provided"));
		}
	}

	public function doUnarchive() {

		authorizedContent(true);

		$companyInfo = $this->session->userdata("company");
		$id = $this->input->post("id");
		if($id) {

			$this->model->unarchive($companyInfo['id'], $id);
			$this->sendJson(array("success" => true));
		
		} else {
			$this->sendJson(array("error" => "No Id Provided"));
		}
	}

	public function archive() {

		authorizedContent();

		$data = array(
			"scripts"=> array("project.js")
		);

		$companyInfo = $this->session->userdata("company");

		$archiveData = array(
			"projects" => $this->model->getArchived($companyInfo['id']),
			"company" => $companyInfo
		);

		$this->load->view("common/header", $data);
		$this->load->view("common/private_navbar");
		$this->load->view("project/archive", $archiveData);
		$this->load->view("common/footer");
	}

	public function archivedItems($projectId) {

		authorizedContent();

		$userId = $this->session->userdata("id");
		$role = $this->model->getUserRole($userId, $projectId);

		if($this->model->checkPermission("EDITOR", $role)) {

			$data = array(
				"scripts"=> array("item.js")
			);

			$project = $this->model->getOne($projectId);

			$this->load->model("item_model");

			$archiveData = array(
				"items" => $this->item_model->getArchived($projectId),
				"project" => $project,
				"role" => $role
			);

			$this->load->view("common/header", $data);
			$this->load->view("common/private_navbar");
			$this->load->view("project/archived_items", $archiveData);
			$this->load->view("common/footer");

		} else {

			
		}

	}

	public function edit($id) {

		authorizedContent();

		$userId = $this->session->userdata("id");
		$role = $this->model->getUserRole($userId, $id);

		$this->load->helper("form");

		$data = array( "project" => NULL );

		$this->load->view("common/header");
		$this->load->view("common/private_navbar");
		if($this->model->checkPermission("ADMIN", $role)) {
			
			$project = $this->model->getOne($id);
			$data['project'] = $project;
			$data['role'] = $role;
		}

		$this->load->view("project/edit", $data);
		$this->load->view("common/footer");

	}

	public function doEdit($id) {

		authorizedContent();
		
		$this->load->library("form_validation");

		$this->form_validation->set_rules("name", "Name", "required");

		if($this->form_validation->run() == TRUE) {
			
			$companyInfo = $this->session->userdata('company');
			$project = array(
				"name" => $this->input->post("name")
			);

			$this->model->update($companyInfo['id'], $id, $project);
			redirect(site_url('user/dashboard?projectEdited=true'));
		} else {

			$this->edit($id);
		}
	}

	public function info($id) {

		$shareInfo = authorizedContentWithSharing($id);
		$role = $shareInfo['role'];
		$project = $shareInfo['project'];

		$data = array(
			"project" => $this->model->getOne($id),
			"role" => $role
		);

		$this->load->view("common/header");
		$this->load->view("common/private_navbar");
		$this->load->view("project/info", $data);
		$this->load->view("common/footer");
	}

	public function view($projectId) {

		$shareInfo = authorizedContentWithSharing($projectId);
		$role = $shareInfo['role'];
		$project = $shareInfo['project'];

		$this->load->helper("form");

		$this->load->view("common/header", array(
			"scripts" => array("projectView.js", "item.js")
		));
		$this->load->view("common/private_navbar");

		if($this->model->checkPermission("VIEWER", $role)) {

			$this->load->model("item_model");
			$data = array(
				"project" => $project,
				"users" => $this->model->getUsers($projectId),
				"items" => $this->item_model->getByProject($projectId),
				"role" => $role,
				"shareCode" => $this->model->getShareCode($projectId)
			);

			$this->load->view("project/view", $data);
		} else {
			$this->load->view("project/restricted");
		}

		$this->load->view("common/footer");

	}

	public function share($code) {


		$project = $this->model->getProjectByShareCode($code);
		
		if($project) {

			$this->session->set_userdata("SHARE_PROJECT", $project['id']);
			$this->view($project['id']);

		} else {

			$this->load->view("common/header", array(
				"scripts" => array("projectView.js", "item.js")
			));
			$this->load->view("common/public_navbar");
			$this->load->view("project/invalid_share_code");
		}


	}

	public function doAssignUser($projectId) {

		authorizedContent(true);

		$userId = $this->session->userdata("id");
		$role = $this->model->getUserRole($userId, $projectId);

		if($this->model->checkPermission("ADMIN", $role)) {

			$email = $this->input->post("email");
			$role = $this->input->post("role");

			if($email && $role) {

				$this->model->assignUserByEmail($email, $projectId, $role);
				$this->sendJson(array("success" => true));
			} else {

				$this->sendJson(array("success" => false, "error" => "Email and Role required"));
			}
		} else {
			
			$this->sendJson(array("success" => false, "error" => "Not Allowed"));
		}
		
	}

	public function doRemoveUser($projectId) {

		authorizedContent(true);

		$userId = $this->session->userdata("id");
		$role = $this->model->getUserRole($userId, $projectId);

		if($this->model->checkPermission("ADMIN", $role)) {

			$userId = $this->input->post("user");
			$this->model->removeUser($userId, $projectId);

			$this->sendJson(array("success" => true));
		} else {
			
			$this->sendJson(array("success" => false, "error" => "Not Allowed"));
		}
		
	}

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}
}