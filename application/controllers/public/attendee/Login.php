<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//if (ycl_env == "testing")
			//redirect('https://yourconference.live/COS/');

		if (isset($_SESSION['project_sessions']["project_{$this->project->id}"]) && $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] == 1)
			redirect(base_url().$this->project->main_route."/lobby"); // Already logged-in
	}

	public function index()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/login")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function staff()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/staff_login")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}
}
