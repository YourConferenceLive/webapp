<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Users_Model', 'users');
		$this->load->model('Settings_Model', 'settings');
		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];
	}

	public function index($id=1)
	{

		$this->logger->log_visit("Profile");

		$data['project'] = $this->project;
		$data['user'] = $_SESSION['project_sessions']["project_{$this->project->id}"];
		$data['profile_data'] = $this->users->getById($this->user['user_id']);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/profile", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function update_profile_data(){
		if ($this->users->update_profile_attendee())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

}
