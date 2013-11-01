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

		if($name) {

			if($this->model->create($companyInfo['id'], $name)) {

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

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}
}