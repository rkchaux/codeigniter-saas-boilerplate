<?php

class Password_model extends CI_Model {

	public function getResetCode($userId) {

		log_message("INFO", "resetting password for user: $userId");

		$code = md5(rand());
		$time = time();
		$sql = 
			"INSERT INTO password_reset (user, code, createdAt) VALUES (?, ?, ?) ".
			"ON DUPLICATE KEY UPDATE code = ?, createdAt = ?";
		$this->db->query($sql, array($userId, $code, $time, $code, $time));

		return $code;
	}

	public function getUserId($code) {

		log_message("INFO", "getting userId by code: $code");

		$codes = $this->db->get_where("password_reset", array("code" => $code))->result_array();

		if(count($codes) == 1) {
			return $codes[0]["user"];
		} else {
			return NULL;
		}
	}

	public function deleteResetCode($code) {

		log_message("INFO", "deleting reset code: $code");

		$this->db->where("code", $code);
		$this->db->delete("password_reset");
	}
}