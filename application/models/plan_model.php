<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan_model extends CI_Model {

	public function get() {

		log_message("INFO", "getiing all plans");
		
		$plans = $this->db->get("plan")->result_array();

		return $plans;
	}

	public function selectPlan($email, $company, $planId) {

		log_message("INFO", "select plan: $planId for company: $company under user: $email");

		$this->db->where("email", $email);
		$this->db->where("name", $company);

		$data = array(
			"plan" => $planId
		);
		$this->db->update("company", $data);
		return TRUE;
	}

	public function getSelectedPlan($email, $company) {

		if($company) {

			log_message("INFO", "getting selectd plan for company: $company under user: $email");

			$this->db->where("email", $email);
			$this->db->where("name", $company);

			$companies = $this->db->get("company")->result_array();
			return $companies[0]['plan'];
		} else {
			return 0;
		}
	}
}