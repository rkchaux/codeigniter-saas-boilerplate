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

	public function update($companyId, $id, $project) {

		log_message("INFO", "updating project: $id of company: $companyId");

		$this->db->where("company", $companyId);
		$this->db->where("id", $id);

		$this->db->update("project", $project);
		return TRUE;
	}

	public function delete($companyId, $id) {

		log_message("INFO", "deleting project: $id of company: $companyId");

		$this->db->where("company", $companyId);
		$this->db->where("id", $id);

		$this->db->delete("project");
		return TRUE;
	}

	public function archive($companyId, $id) {

		log_message("INFO", "archiving project: $id of company: $companyId");

		$this->db->where("company", $companyId);
		$this->db->where("id", $id);

		$this->db->update("project", array(
			"archived" => 1
		));
		return TRUE;
	}

	public function unarchive($companyId, $id) {

		log_message("INFO", "unarchiving project: $id of company: $companyId");

		$this->db->where("company", $companyId);
		$this->db->where("id", $id);

		$this->db->update("project", array(
			"archived" => 0
		));
		return TRUE;
	}

	public function get($companyId) {

		log_message("INFO", "getiing all projects for company: $companyId");
		
		$this->db->where("archived", 0);
		$this->db->where("company", $companyId);
		$companies = $this->db->get("project")->result_array();

		return $companies;
	}

	public function getOne($companyId, $projectId) {

		log_message("INFO", "getting project: $projectId for company: $companyId");

		$this->db->where("company", $companyId);
		$this->db->where("id", $projectId);

		$companies = $this->db->get("project")->result_array();

		if(count($companies) == 1) {
			return $companies[0];
		} else {

			log_message("ERROR", "no such project: $projectId for company: $companyId");
			return FALSE;
		}
	}

	public function getArchived($companyId) {

		log_message("INFO", "getiing all archived projects for company: $companyId");

		$this->db->where("archived", 1);
		$this->db->where("company", $companyId);
		$companies = $this->db->get("project")->result_array();

		return $companies;
	}

}