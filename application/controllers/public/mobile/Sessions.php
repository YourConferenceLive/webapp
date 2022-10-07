<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();

		$this->load->model('mobile/Mobile_Sessions_Model', 'msessions');
		$this->load->model('Logger_Model', 'logger');
		$this->load->helper('string');
		$this->load->model('Settings_Model', 'settings');
		$this->load->model('Users_Model', 'users');
	}


	public function index(){
		print_r('welcome');
	}
	public function id($session_id) {
		$project_id = $this->project->id;

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee'] !== 1) {
			redirect(base_url() . $this->project->main_route . "/mobile/login/id/$session_id"); // Not logged-in
			return;
		}

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;
		$this->session->set_userdata($current_project_sessions);

		$data['sess_data'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/index", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session_modals", $data);


	}

	public function view($session_id)
	{

		$project_id = $this->project->id;
		if (isset($_SESSION['project_sessions']["project_{$this->project->id}"]) && $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee'] !== 1) {
			redirect(base_url() . $this->project->main_route . "/mobile/login/id/$session_id"); // Not logged-in
		}

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;

		$this->session->set_userdata($current_project_sessions);
//		print_r($_SESSION["project_$project_id"]['mobile_session_id']);exit;

//		$data['notes'] 		= $this->note->getAll('session', $data['session_id'], $this->user['user_id']);
		$data['sess_data'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$data['session_id'] = $session_id;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/templates/menu-bar")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session_modals", $data);
//			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer");
//		print_r('');

	}
}
