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
		$this->form_validation->set_rules('company', 'Company', 'required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');

		if($this->form_validation->run() == FALSE) {
			
			//validation failed
			$this->register();
		} else {

			$email = $this->input->post("email");
			$password = $this->input->post("password");
			$nickname = $this->input->post("nickname");
			$company = $this->input->post("company");

			//register user
			$userId = $this->model->register($email, $password, $nickname);

			//register company
			$this->load->model("company_model");
			$this->company_model->create($email, $company);

			//start validating
			$validateCode = $this->model->startUserValidation($userId);
			$this->load->model("email_model");
			$this->email_model->validateUser($email, $validateCode);

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

	public function doLogout() {

		authorizedContent();

		$this->session->sess_destroy();
		redirect(site_url("user/login"));
	}

	public function passwordReset() {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		$this->load->view("user/passwordReset");
		$this->load->view("common/footer");
	}

	public function doPasswordReset() {

		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "required|valid_email");

		if($this->form_validation->run()) {

			echo "Success";
		} else {

			$this->passwordReset();
		}
	}

	public function dashboard($companyId = NULL) {

		authorizedContent();

		$companies = $this->_getCompanies();

		if(!$companyId) {
			log_message("INFO", "calling again dashboard with the first company");
			return $this->dashboard($companies[0]['id']);
		}

		$companyInfo = $this->session->userdata('company');
		$userId = $this->session->userdata("id");
		
		$this->load->model("project_model");

		if($companyInfo && $companyId == $companyInfo['id']) {
			//getting company's project
			$projects = $this->project_model->get($companyInfo['id']);
			
		} else {
			//getting assigned projects
			$projects = $this->project_model->getAssignedProjects($userId, $companyId);
		}

		$this->load->model("project_model");

		$data = array(
			"scripts"=> array("company.js", "project.js")
		);

		$dashboardData = array(
			"projects" => $projects,
			"companies" => $companies,
			"selectedCompany" => $companyId
		);

		$this->load->view("common/header", $data);
		$this->load->view("common/private_navbar");
		$this->load->view("user/dashboard", $dashboardData);
		$this->load->view("common/footer");
	}

	public function validate($code) {

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");
		
		$this->load->model("user_model");
		$user = $this->user_model->completeUserValidation($code);
		if($user) {

			$this->user_model->login($user['email']);
			$this->load->view("user/validated", array("user" => $user));
		} else {
			$this->load->view("user/validation_failed");
		}
		$this->load->view("common/footer");

	}

	private function _getCompanies() {
		
		$email = $this->session->userdata("email");
		$userId = $this->session->userdata("id");

		$this->load->model("company_model");
		$companies = $this->company_model->get($email);

		$this->load->model("project_model");
		$projectCompanies = $this->project_model->getCompanies($userId);

		return array_merge($companies, $projectCompanies);
	}

}