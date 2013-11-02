<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {

	public function create($companyId, $name) {

		log_message("INFO", "creating project: $name for company: $companyId");
		
		$this->db->where("name", $name);
		$this->db->where("company", $companyId);
		$companies = $this->db->get("project")->result_array();

		if(count($companies) == 0) {

			$createdAt = time();
			$this->db->insert("project", array(
				"name" => $name,
				"company" => $companyId,
				"createdAt" => $createdAt
			));

			$sql = "SELECT id FROM project where name=? AND company =? AND createdAt =? LIMIT 1";

			$projects =  $this->db->query($sql, array($name, $companyId, $createdAt))->result_array();
			return $projects[0]['id'];
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

	public function assignUser($userId, $projectId) {

		log_message("INFO", "assigning user: $userId to the project: $projectId");

		$sql = "INSERT INTO user_project (user, project) VALUES (?, ?) ON DUPLICATE KEY UPDATE project = ?";
		$this->db->query($sql, array($userId, $projectId, $projectId));
	}

	public function assignUserByEmail($email, $projectId) {

		log_message("INFO", "assigning user by email: $email to the project: $projectId");

		$users = $this->db->get_where("user", array("email" => $email))->result_array();
		if(count($users) == 1) {
			//user exists and asign him
			$this->assignUser($users[0]['id'], $projectId);
		} else {
			//invite user
			log_message("INFO", "inviting email: $email to the project: $projectId");

			//register user with a random password
			$this->load->model("user_model");
			$password = md5(rand());
			$userId = $this->user_model->register($email, $password, "");

			//assign user
			$this->assignUser($userId, $projectId);

			//inviter user
			$this->load->model("invitation_model");
			$inviteKey = $this->invitation_model->inviteUser($email);

			log_message("INFO", "invited email: $email with key: $inviteKey");
		}
	}

	public function getUsers($projectId) {

		$sql = "SELECT u.*, i.secret FROM user_project up, user u LEFT JOIN invitation i ON i.email = u.email WHERE up.user = u.id AND up.project = ?";
		return $this->db->query($sql, array($projectId))->result_array();
	}

}