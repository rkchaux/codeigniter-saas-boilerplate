<?php

class Company extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model("company_model", "model");
	}

	public function create() {

		authorizedContent(true);

		$email = $this->session->userdata("email");
		$name = $this->input->post("name");

		if($name) {

			if($this->model->create($email, $name)) {

				$this->addCompanyToSession($name);
				$this->sendJson(array("success" => true));
			} else {

				$this->sendJson(array("success" => false));
			}
			

		} else {

			$this->sendJson(array("error" => "No Name Provided"));
		}
	}

	public function get() {

		authorizedContent(true);

		$email = $this->session->userdata("email");
		
		$companies = $this->model->get($email);

		$companyInfo = $this->session->userdata("company");
		$data = array(
			"selected" => $companyInfo['name'],
			"companies" => $companies
		);
		$this->sendJson($data);
	}

	public function select() {

		authorizedContent(true);

		$email = $this->session->userdata("email");
		$name = $this->input->post("name");


		if($name) {
			
			if($this->addCompanyToSession($name)) {

				$this->sendJson(array("success" => true));
			} else {

				$this->sendJson(array("error" => "No Such Company"));
			}

		} else {

			$this->sendJson(array("error" => "No Name Provided"));
		}
	}

	public function delete() {

		authorizedContent(true);

		$email = $this->session->userdata("email");
		$name = $this->input->post("name");

		if($name) {

			$this->model->delete($email, $name);
			$this->session->set_userdata("company", NULL);
			$this->sendJson(array("success" => true));
		} else {

			$this->sendJson(array("error" => "No Name Provided"));
		}
	}

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}

	private function addCompanyToSession($name) {

		$email = $this->session->userdata("email");
		$company = $this->model->getOne($email, $name);

		if($company) {

			$companyInfo = array(
				"name" => $company['name'],
				"isOwner" => true,
				"id" => $company['id']
			);
			$this->session->set_userdata("company", $companyInfo);
			
			return TRUE;
		} else {

			return FALSE;
		}	
	}
}