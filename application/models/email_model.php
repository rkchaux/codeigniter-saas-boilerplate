<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	public function passwordReset($email, $code) {

		log_message("INFO", "sending password reset code: $code to email: $email");
	}
}