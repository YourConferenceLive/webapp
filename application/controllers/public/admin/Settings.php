<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url() . $this->project->main_route . "/admin/login"); // Not logged-in

		$this->user = (object)($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('admin/Sponsors_Model', 'sponsors');
		$this->load->model('Users_Model', 'users');
		$this->load->model('Settings_Model', 'settings');
	}

	public function index(){
		$sidebar_data['user'] = $this->user;
		$data['settings'] = $this->settings->attendeeSettings($this->project->id);
		$data['presenter_settings'] = $this->settings->presenterSettings($this->project->id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/settings",$data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function saveAttendeeViewSetting(){
		echo json_encode($this->settings->saveAttendeeViewSetting($this->project->id));
	}

	public function savePresenterViewSetting(){
		echo json_encode($this->settings->savePresenterViewSetting($this->project->id));
	}

	public function getColorPresets(){
		echo  $this->settings->getColorPresets();
	}
}
