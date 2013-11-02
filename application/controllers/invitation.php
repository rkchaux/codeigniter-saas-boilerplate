<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitation extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper("form");

		$this->load->model("invitation_model", "model");
	}

	public function register($secret) {

		$invitedUser = $this->model->getInvitedUser($secret);

		$this->load->view("common/header");
		$this->load->view("common/public_navbar");

		if($invitedUser) {

			$data = array(
				"secret" => $secret,
				"user" => $invitedUser
			);
			$this->load->view("invitation/register", $data);
		} else {

			$this->load->view("invitation/expired");
		}

		$this->load->view("common/footer");
	}

	public function doRegister() {

		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');

		$secret = $this->input->post("secret");

		if($this->form_validation->run() == FALSE) {
			
			//validation failed
			$this->register($secret);
		} else {

			$password = $this->input->post("password");
			$nickname = $this->input->post("nickname");

			$invitedUser = $this->model->getInvitedUser($secret);

			if($invitedUser) {

				$this->load->model("user_model");

				//change password
				$this->user_model->changePasswordWithoutCheck($invitedUser['email'], $password);

				//update user
				$this->user_model->update($invitedUser['email'], array("nickname" => $nickname));

				//remove invitation
				$this->model->clearInvitation($secret);;

				//do login
				$this->user_model->login($email);

				redirect(site_url('user/dashboard'));

				echo "Done";
			} else {

				$this->register($secret);
			}

		}
	}
}