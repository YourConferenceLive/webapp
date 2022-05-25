<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if
		(
			isset($_SESSION['project_sessions']["project_{$this->project->id}"]) &&
			(
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] == 1 ||
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_moderator'] == 1
			)
		)redirect(base_url().$this->project->main_route."/presenter/dashboard"); // Already logged-in
	}

	public function index()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/login")
			->view("{$this->themes_dir}/{$this->project->theme}/common/forgot_password_modal")
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function test()
	{
		echo 'yes';
	}
}
