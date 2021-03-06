<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {

	public function create($email, $name) {

		$this->db->where("email", $email);
		$this->db->where("name", $name);

		log_message("INFO", "creating company: $name for user: $email");

		$companies = $this->db->get("company")->result_array();
		if(count($companies) == 0) {

			$this->db->insert("company", array(
				"name" => $name,
				"email" => $email,
				"createdAt" => time()
			));
			return TRUE;
		} else {

			log_message("INFO", "Company exists: $name by user: $email");
			return FALSE;
		}
	}

	public function get($email) {

		log_message("INFO", "getiing all companies for user: $email");
		
		$this->db->where("email", $email);
		$companies = $this->db->get("company")->result_array();

		return $companies;
	}

	public function getOne($email, $name) {

		log_message("INFO", "getiing company: $name for user: $email");
		
		$this->db->where("name", $name);
		$this->db->where("email", $email);
		$companies = $this->db->get("company")->result_array();

		if(count($companies) == 1) {

			return $companies[0];
		} else {

			log_message("INFO", "no such company: $company for user: #email");
			return NULL;
		}
	}

	public function delete($email, $name) {

		$this->db->where("email", $email);
		$this->db->where("name", $name);

		$this->db->delete("company");
		return TRUE;
	}

}