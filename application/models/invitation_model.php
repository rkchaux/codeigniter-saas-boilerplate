<?php

class Invitation_model extends CI_Model {

	/*
		Invite user and return the invitation key
	*/
	public function inviteUser($email) {

		log_message("INFO", "inviting a user via email: $email");
		$key = md5(rand());
		$sql = "INSERT INTO invitation (email, secret) VALUES (?, ?) ON DUPLICATE KEY UPDATE secret = ?";
		$this->db->query($sql, array($email, $key, $key));

		return $key;
	}

	public function getInvitedUser($secret) {

		log_message("INFO", "getting user from invitation secret: $secret");

		$sql = "SELECT u.* from user u, invitation i WHERE u.email = i.email AND i.secret = ?";
		$users = $this->db->query($sql, array($secret))->result_array();

		if(count($users) == 1) {
			return $users[0];	
		} else {

			log_message("ERROR", "not a valid invitation secret: $secret");
			return FALSE;
		}
	}

	public function clearInvitation($secret) {

		log_message("INFO", "clearing invitation for secret: $secret");

		$this->db->where("secret", $secret);
		$this->db->delete("invitation");
	}
}