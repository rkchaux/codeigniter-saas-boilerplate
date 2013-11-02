<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function register($email, $password, $nickname) {

		log_message("INFO", "registering user: $email");

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

		//getting user id
		$users = $this->db->get_where("user", array("email" => $email))->result_array();
		return $users[0]['id'];
	}


	public function check_login($email, $password) {

		$this->db->where("email", $email);
		$users = $this->db->get("user")->result_array();

		log_message("INFO", "check login for user: $email");

		if(count($users) == 1) {

			$user = $users[0];
			if(hash_hmac("md5", $password, $user['salt']) == $user['password']) {
				return TRUE;
			} else {
				log_message("INFO", "password failed to login for user: $email");
				return FALSE;
			}

		} else {

			log_message("ERROR", "user does not exists for check login: $email");
			return FALSE;
		}
	}

	public function login($email) {

		$this->db->where("email", $email);
		$users = $this->db->get("user")->result_array();

		if(count($users) == 1) {
			log_message("INFO", "creating session for user: $email");

			$user = $users[0];
			$this->session->set_userdata(array(
				"email" => $user['email'],
				"nickname" => $user['nickname'],
				"id" => $user['id']
			));

			//select the first Company for this user
			$sql = "SELECT id, name FROM company WHERE email = ? ORDER BY createdAt ASC LIMIT 1";
			$companies = $this->db->query($sql, array($email))->result_array();
			if(count($companies) == 1) {
				//has company
				$company = $companies[0]['name'];
				$companyInfo = array(
					"name" => $company,
					"id" => $companies[0]['id']
				);
				$this->session->set_userdata("company", $companyInfo);
				log_message("INFO", "company: $company selected at login for user: $email");
			} else {
				log_message("INFO", "No such company to select for user: $email at login");
			}

			return TRUE;

		} else {

			log_message("ERROR", "user does not exists for check login: $email");
			return FALSE;
		}
	}

	public function update($email, $user) {

		log_message("INFO", "updating user: $email");

		$this->db->where("email", $email);
		$this->db->update("user", $user);

		$this->login($email);
		return TRUE;
	}

	public function changePassword($email, $oldPassword, $newPassword) {

		if($this->check_login($email, $oldPassword)) {

			$salt = md5(rand());
			$newPassword = hash_hmac('md5', $newPassword, $salt);

			$user = array(
				"salt" => $salt, 
				"password" => $newPassword
			);

			$this->update($email, $user);
			return TRUE;

		} else {

			log_message("INFO", "password not correct when changing password - user: $email");
			return FALSE;
		}
	}
}