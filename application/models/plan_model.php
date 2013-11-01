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

	public function updateMetric($email, $company, $metricName, $qty) {


		$plan = $this->getSelectedPlan($email, $company);
		if($plan) {

			//get metricId
			$this->db->where("plan", $plan);
			$this->db->where("name", $metricName);
			$plan_metrics = $this->db->get("plan_metric")->result_array();
			if(count($plan_metrics) == 1) {

				log_message("INFO", "update metric: '$metricName' for the current plan: $plan for company: $company under user: $email");
				//has a plan metric
				$plan_metric = intval($plan_metrics[0]['id']);
				$sql = "INSERT INTO company_plan_metric (email, company, plan_metric, qty) VALUES (?, ?, ?,?) ";
				$sql .= "ON DUPLICATE KEY UPDATE qty = qty + ?; ";
				$this->db->query($sql, array($email, $company, $plan_metric, $qty, $qty));
				return TRUE;
			} else {
				//no such plan metric for the current plan
				log_message("ERROR", "no such plan metric: '$metricName' for the current plan: $plan for company: $company under user: $email");
				return FALSE;
			}
		} else {

			log_message("ERROR", "cannot determine the plan for company: $company under user: $user");
			return FALSE;
		}
	}
}