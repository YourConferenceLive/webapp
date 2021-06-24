<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
//		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_sponsor_admin'] != 1)
//			redirect(base_url() . $this->project->main_route . "/login"); // Not logged-in


	}

	public function index()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/header")
			//->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/login")
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;

	}

}
