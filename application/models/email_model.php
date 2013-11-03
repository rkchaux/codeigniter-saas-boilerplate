<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	public function passwordReset($email, $code) {

		log_message("INFO", "sending password reset code: $code to email: $email");
	}

	public function validateUser($email, $code) {

		log_message("INFO", "validating acount with: $email with code: $code");
	}

	public function inviteUser($email, $code) {

		log_message("INFO", "inviting user: $email with code: $code");
	}
}