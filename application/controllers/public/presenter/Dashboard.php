<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if
		(
			!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) ||
			(
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] != 1 ||
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_moderator'] != 1
			)
		)redirect(base_url().$this->project->main_route."/presenter/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/dashboard")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}
}
