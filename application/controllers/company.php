<?php

class Company extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model("company_model", "model");
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

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}
}