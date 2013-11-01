<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {

	public function create($companyId, $name) {

		log_message("INFO", "creating project: $name for company: $companyId");
		
		$this->db->where("name", $name);
		$this->db->where("company", $companyId);
		$companies = $this->db->get("project")->result_array();

		if(count($companies) == 0) {

			$this->db->insert("project", array(
				"name" => $name,
				"company" => $companyId,
				"createdAt" => time()
			));
			return TRUE;
		} else {

			log_message("INFO", "Project exists: $name by company: $companyId");
			return FALSE;
		}
	}

	public function get($companyId) {

		log_message("INFO", "getiing all companies for user: $companyId");
		
		$this->db->where("company", $companyId);
		$companies = $this->db->get("project")->result_array();

		return $companies;
	}

	// public function delete($email, $name) {

	// 	$this->db->where("email", $email);
	// 	$this->db->where("name", $name);

	// 	$this->db->delete("company");
	// 	return TRUE;
	// }

	// public function isOwner($email, $company) {


	// 	log_message("INFO", "checking company: $company owned to user: $email");
	// 	$this->db->where("email", $email);
	// 	$this->db->where("name", $company);
	// 	$companies = $this->db->get("company");

	// 	if(count($companies) == 1) {
	// 		return TRUE;
	// 	} else {
	// 		return FALSE;
	// 	}
	// }
}