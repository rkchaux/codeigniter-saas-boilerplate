<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

	public function __construct() {

		$this->config->load("email", TRUE);
		$smtpInfo = $this->config->item("smtp", "email");

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => $smtpInfo['host'],
			'smtp_port' => $smtpInfo['port'],
			'smtp_user' => $smtpInfo['user'],
			'smtp_pass' => $smtpInfo['password'],
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$smtp = $this->config->item("smtp", "email");
	}

	public function passwordReset($email, $code) {

		log_message("INFO", "sending password reset code: $code to email: $email");

		$link = site_url("password/newPassword/$code");
		$message = 
			"Click following link to reset your password<br><br>".
			"<a href='$link'>$link</a>";

		$this->sendEmail($email, "Password Reset Request", $message);

	}

	public function validateUser($email, $code) {

		$link = site_url("user/validate/$code");
		$message =
			"Please click following link to validate your account.<br><br>".
			"<a href='$link'>$link</a>";

		$this->sendEmail($email, "Validate your account at SAAS", $message);

		log_message("INFO", "validating acount with: $email with code: $code");
	}

	public function inviteUser($email, $code) {

		$link = site_url("invitation/register/$code");
		$message =
			"Please click following link to create your account.<br><br>".
			"<a href='$link'>$link</a>";

		$this->sendEmail($email, "You are invited to SAAS", $message);

		log_message("INFO", "inviting user: $email with code: $code");
	}

	private function sendEmail($to, $subject, $message) {

		$enable = $this->config->item("enable", "email");

		if($enable) {

			$sender = $this->config->item("sender", "email");

			$this->email->from($sender['email'], $sender['name']);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);

			if(!$this->email->send()) {

				log_message("ERROR", "email sending failed to: $to with subject: $subject");
				log_message("ERROR", $this->email->print_debugger());
			} 
		}
	}
}