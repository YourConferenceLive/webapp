<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mobile/Mobile_Sessions_Model', 'msessions');
	}

	public function index($session_id){


	}

	public function id($session_id){
		$project_id = $this->project->id;
//		print_r( $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee']);exit;

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;
		$this->session->set_userdata($current_project_sessions);

		$data['sess_data'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);

//		print_r($data['sess_data']);exit;
		$data['session_id'] = $session_id;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/login", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function logout(){
		session_destroy();
	}

}
