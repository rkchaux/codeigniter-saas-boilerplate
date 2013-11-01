<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index() {

		authorizedContent();

		$data = array(
			"nickname" => $this->session->userdata("nickname"),
			"email" => $this->session->userdata("email")
		);

		if(!$data['nickname']) {
			$data['nickname'] = $data['email'];
		}

		$this->load->view("common/header");
		$this->load->view("common/private_navbar");
		$this->load->view("profile/index", $data);
		$this->load->view("common/footer");
	}

	public function edit($errors = array()) {

		authorizedContent();

		$data = array(
			"nickname" => $this->session->userdata("nickname"),
			"email" => $this->session->userdata("email"),
			"errors" => $errors
		);

		$this->load->helper("form");
		$this->load->view("common/header");
		$this->load->view("common/private_navbar");
		$this->load->view("profile/edit", $data);
		$this->load->view("common/footer");

	}

	public function doEdit() {

		authorizedContent();

		$email = $this->session->userdata("email");
		$data = array(
			"email" => $this->input->post("email"),
			"nickname" => $this->input->post("nickname")
		);

		$this->load->model("user_model");
		$this->user_model->update($email, $data);
		redirect(site_url("profile/edit?updated=true"));
	}

	public function doPasswordChange() {

		authorizedContent();


		$this->load->helper("form");
		$this->load->library('form_validation');

		$this->form_validation->set_rules('currPassword', 'Current Password', 'required');
		$this->form_validation->set_rules('newPassword', 'New Password', 'required');
		$this->form_validation->set_rules('confirmNewPassword', 'Confirm New Password', 'required');
		$this->form_validation->set_rules('confirmNewPassword', 'Confirm New Password', 'matches[newPassword]');

		if($this->form_validation->run() == FALSE) {
			
			//validation failed
			$this->edit();
		} else {

			$email = $this->session->userdata("email");
			$password = $this->input->post("currPassword");
			$newPassword = $this->input->post("newPassword");
			$this->load->model("user_model");
			if($this->user_model->changePassword($email, $password, $newPassword)) {

				redirect(site_url("profile/edit?passwordChanged=true"));
			} else {

				$errors = array(
					"changePassword" => "Your current password is not correct"
				);
				$this->edit($errors);
			}
		}
	}
}