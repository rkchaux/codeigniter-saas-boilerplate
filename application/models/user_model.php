<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function register($email, $password, $nickname) {

		$salt = md5(rand());
		$password = hash_hmac('md5', $password, $salt);

		$data = array(
			'email' => $email,
			'nickname' => $nickname, 
			'password' => $password, 
			'salt' => $salt,
			'createdAt' => time()
		);

		$this->db->insert("user", $data);
	}
}