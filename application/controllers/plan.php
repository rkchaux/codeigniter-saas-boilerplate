<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model("plan_model", "model");
	}

	public function select() {

		authorizedContent();

		$data = array(
			"scripts"=> array("company.js", "plans.js")
		);

		$email = $this->session->userdata("email");
		$company = $this->session->userdata("company");

		$planData = array(
			"plans" => $this->model->get(),
			"selectedPlan" => $this->model->getSelectedPlan($email, $company)
		);

		$this->load->view("common/header", $data);
		$this->load->view("common/private_navbar");
		$this->load->view("plan/select", $planData);
		$this->load->view("common/footer");
	}

	public function doSelect() {

		authorizedContent(true);

		$email = $this->session->userdata("email");
		$company = $this->session->userdata("company");
		$planId = intval($this->input->post("planId"));

		if($planId) {

			$this->model->selectPlan($email, $company, $planId);
			$this->sendJson(array("success" => true));

		} else {

			$this->sendJson(array("error" => "No PlanId Provided"));
		}

	}

	private function sendJson($obj) {
		
		header("Content-Type: application/json");
		echo json_encode($obj);
	}
}