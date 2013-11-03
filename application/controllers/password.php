<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper("form");
		$this->load->model("password_model", "model");
	}

	public function reset() {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("password/reset");
		$this->load->view("common/footer");
	}

	public function doReset() {

		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "required|valid_email");

		if($this->form_validation->run()) {

			$email = $this->input->post("email");

			$this->load->model("user_model");
			$user = $this->user_model->getByEmail($email);

			if($user) {

				$code = $this->model->getResetCode($user['id']);

				$this->load->model("email_model");
				$this->email_model->passwordReset($email, $code);

			} else {
				log_message("INFO", "password reset try for email: $email, but not registered");
			}

			$this->load->view("common/header");
			$this->load->view("common/public_navbar");
			$this->load->view("password/reset_confirm");
			$this->load->view("common/footer");

		} else {

			$this->reset();
		}
	}

	/*
		Used to get the new password for completing password resetting process
	*/
	public function newPassword($code) {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("password/new_password", array( "code" => $code ));
		$this->load->view("common/footer");
	}

	public function doNewPassword() {

		$this->load->library("form_validation");
		$this->form_validation->set_rules("password", "Password", "required");
		$this->form_validation->set_rules("confirmPassword", "Confirm Password", "required|matches[password]");

		$password = $this->input->post("password");
		$code = $this->input->post("code");

		if($this->form_validation->run()) {

			$this->load->model("password_model");
			$this->load->model("user_model");

			$userId = $this->password_model->getUserId($code);

			if($userId) {

				$user = $this->user_model->getById($userId);
				$this->user_model->changePasswordWithoutCheck($user['email'], $password);
				$this->user_model->login($user['email']);

				$this->password_model->deleteResetCode($code);
				
				redirect(site_url("user/dashboard"));
			} else {
				
				$this->load->view("common/header");
				$this->load->view("common/public_navbar");
				$this->load->view("password/invalid_code");
				$this->load->view("common/footer");
			}


		} else {

			$this->newPassword($code);
		}
	}



}