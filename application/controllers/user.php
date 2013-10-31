<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper("form");
	}

	public function register() {

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
			$this->model->login($email);
			redirect(site_url('user/dashboard'));
		}
	}

	public function login($errors =  "") {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("user/login", array("errors" => $errors));
		$this->load->view("common/footer");
	}

	public function doLogin() {

		$this->load->model("user_model", "model");

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE) {
			
			//validation failed
			$this->login();
		} else {

			$email = $this->input->post("email");
			$password = $this->input->post("password");

			if($this->model->check_login($email, $password)) {
				
				if($this->model->login($email)) {
					redirect(site_url("user/dashboard"));
				} else {
					$this->login("Internal Error! Please try again");
				}
			} else {
				$this->login("Login Failed! Please try again");
			}
		}
	}

	function dashboard() {

		
		echo "Welcome! " . $this->session->userdata("email");
	}
}