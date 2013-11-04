<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends CI_Model {

	public function create($userId, $projectId, $name) {

		log_message("INFO", "creating item: $name for project: $projectId by user: $userId");
		
		$this->db->where("name", $name);
		$this->db->where("project", $projectId);
		$this->db->where("user", $userId);
		$companies = $this->db->get("item")->result_array();

		if(count($companies) == 0) {

			$createdAt = time();
			$this->db->insert("item", array(
				"name" => $name,
				"project" => $projectId,
				"user" => $userId,
				"createdAt" => $createdAt
			));

			$sql = "SELECT id FROM item where name=? AND project =? AND user=? AND createdAt =? LIMIT 1";

			$items =  $this->db->query($sql, array($name, $projectId, $userId, $createdAt))->result_array();
			return $items[0]['id'];
		} else {

			log_message("INFO", "Item exists: $name for project: $projectId by user: $userId");
			return FALSE;
		}
	}

	public function getByProject($projectId) {

		$query = array(
			"project" => $projectId,
			"archived" => 0
		);
		return $this->db->get_where("item", $query)->result_array();
	}

	public function getOne($id) {

		$items = $this->db->get_where("item", array("id" => $id))->result_array();
		if(count($items) == 1) {
			return $items[0];
		} else {
			return FALSE;
		}
	}

	public function update($projectId, $id, $item) {

		log_message("INFO", "updating item: $id of project: $projectId");

		$this->db->where("project", $projectId);
		$this->db->where("id", $id);

		$this->db->update("item", $item);
		return TRUE;
	}

	public function delete($projectId, $id) {

		log_message("INFO", "deleting item: $id of project: $projectId");

		$this->db->where("project", $projectId);
		$this->db->where("id", $id);

		$this->db->delete("item");
		return TRUE;
	}

	public function archive($projectId, $id) {

		log_message("INFO", "archiving item: $id of project: $projectId");

		$this->db->where("project", $projectId);
		$this->db->where("id", $id);

		$this->db->update("item", array(
			"archived" => 1
		));
		return TRUE;
	}

	public function unarchive($projectId, $id) {

		log_message("INFO", "archiving item: $id of project: $projectId");

		$this->db->where("project", $projectId);
		$this->db->where("id", $id);

		$this->db->update("item", array(
			"archived" => 0
		));
		return TRUE;
	}

	public function getArchived($projectId) {

		log_message("INFO", "getiing all archived items for project: $projectId");

		$this->db->where("archived", 1);
		$this->db->where("project", $projectId);
		$items = $this->db->get("item")->result_array();

		return $items;
	}

	// public function get($companyId) {

	// 	log_message("INFO", "getiing all projects for company: $companyId");
		
	// 	$this->db->where("archived", 0);
	// 	$this->db->where("company", $companyId);
	// 	$companies = $this->db->get("project")->result_array();

	// 	return $companies;
	// }

	// public function getOne($projectId) {

	// 	log_message("INFO", "getting project: $projectId");

	// 	$this->db->where("id", $projectId);

	// 	$projects = $this->db->get("project")->result_array();

	// 	if(count($projects) == 1) {
	// 		return $projects[0];
	// 	} else {

	// 		log_message("ERROR", "no such project: $projectId");
	// 		return FALSE;
	// 	}
	// }


	// public function assignUser($userId, $projectId, $role) {

	// 	log_message("INFO", "assigning user: $userId to the project: $projectId");

	// 	$sql = "INSERT INTO user_project (user, project, role) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE role = ?";
	// 	$this->db->query($sql, array($userId, $projectId, $role, $role));
	// }

	// public function removeUser($userId, $projectId) {

	// 	log_message("INFO", "removing user: $userId from the project: $projectId");

	// 	$this->db->where("user", $userId);
	// 	$this->db->where("project", $projectId);

	// 	$this->db->delete("user_project");
	// }

	// public function assignUserByEmail($email, $projectId, $role) {

	// 	log_message("INFO", "assigning user by email: $email to the project: $projectId with role: $role");

	// 	$users = $this->db->get_where("user", array("email" => $email))->result_array();
	// 	if(count($users) == 1) {
	// 		//user exists and asign him
	// 		$this->assignUser($users[0]['id'], $projectId, $role);
	// 	} else {
	// 		//invite user
	// 		log_message("INFO", "inviting email: $email to the project: $projectId");

	// 		//register user with a random password
	// 		$this->load->model("user_model");
	// 		$password = md5(rand());
	// 		$userId = $this->user_model->register($email, $password, "");

	// 		//assign user
	// 		$this->assignUser($userId, $projectId, $role);

	// 		//inviter user
	// 		$this->load->model("invitation_model");
	// 		$inviteKey = $this->invitation_model->inviteUser($email);

	// 		$this->load->model("email_model");
	// 		$this->email_model->inviteUser($email, $inviteKey);
	// 	}
	// }

	// public function getUsers($projectId) {

	// 	$sql = "SELECT u.*, i.secret, up.role FROM user_project up, user u LEFT JOIN invitation i ON i.email = u.email WHERE up.user = u.id AND up.project = ?";
	// 	return $this->db->query($sql, array($projectId))->result_array();
	// }

	// public function getCompanies($userId) {

	// 	log_message("INFO", "get companies of assigned projects for user: $userId");
	// 	$sql = 
	// 		"SELECT DISTINCT c.* FROM user_project up, project p, company c " .
	// 		"WHERE up.project = p.id AND p.company = c.id AND up.user = ? AND up.role != 'OWNER' ";

	// 	return $this->db->query($sql, array($userId))->result_array();
	// }

	// public function getAssignedProjects($userId, $companyId) {

	// 	log_message("INFO", "getting assigned projects of user: $userId under company: $companyId");

	// 	$sql = 
	// 		"SELECT DISTINCT p.* FROM user_project up, project p " .
	// 		"WHERE up.project = p.id AND up.user = ? AND p.company = ? AND p.archived = 0";

	// 	return $this->db->query($sql, array($userId, $companyId))->result_array();
	// }

	// public function getAssignedProject($userId, $projectId) {

	// 	log_message("INFO", "getting the assigned project: $projectId of user: $userId");

	// 	$sql = 
	// 		"SELECT DISTINCT p.* FROM user_project up, project p " .
	// 		"WHERE up.project = p.id AND up.user = ? AND up.project = ?";

	// 	$projects =  $this->db->query($sql, array($userId, $projectId))->result_array();
	// 	if(count($projects) == 1) {
	// 		return $projects[0];
	// 	} else {
	// 		return FALSE;
	// 	}
	// }

	// public function getUserRole($userId, $projectId) {

	// 	log_message("INFO", "getting role of user: $userId under project: $projectId");

	// 	$this->db->select("role");
	// 	$users = $this->db->get_where("user_project", array(
	// 		"user" => $userId, 
	// 		"project" => $projectId
	// 	))->result_array();

	// 	if(count($users) == 1) {

	// 		return $users[0]["role"];
	// 	} else {
	// 		return FALSE;
	// 	}
	// }

	// public function checkPermission($minumumRole, $userRole) {

	// 	$roles = array(
	// 		"OWNER" => 4,
	// 		"ADMIN" => 3,
	// 		"EDITOR" => 2,
	// 		"VIEWER" => 1
	// 	);

	// 	return $roles[$minumumRole] <= $roles[$userRole];
	// }

}