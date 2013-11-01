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

	public function edit() {

		authorizedContent();

		$data = array(
			"nickname" => $this->session->userdata("nickname"),
			"email" => $this->session->userdata("email")
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
		$user = array(
			"email" => $this->input->post("email"),
			"nickname" => $this->input->post("nickname")
		);

		$this->load->model("user_model");
		$this->user_model->update($email, $user);
		redirect(site_url("profile/edit?updated=true"));
	}
}