<?php

class Invitation_model extends CI_Model {

	/*
		Invite user and return the invitation key
	*/
	public function inviteUser($email) {

		$key = md5(rand());
		$sql = "INSERT INTO invitation (email, secret) VALUES (?, ?) ON DUPLICATE KEY UPDATE secret = ?";
		$this->db->query($sql, array($email, $key, $key));

		//TODO: send the email
		return $key;
	}
}