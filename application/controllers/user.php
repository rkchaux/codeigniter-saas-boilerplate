<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function register() {

		$this->load->helper("form");
		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("user/register");
		$this->load->view("common/footer");
	}

	public function doRegister() {

		$this->load->model("user_model", "model");

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 
			'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');

		if($this->form_validation->run() == FALSE) {
			
			//validation failed
			$this->register();
		} else {

			$email = $this->input->post("email");
			$password = $this->input->post("password");
			$nickname = $this->input->post("nickname");

			$this->model->register($email, $password, $nickname);
			redirect(site_url('user/dashboard'));
		}
	}

	public function login() {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("common/footer");
	}
}