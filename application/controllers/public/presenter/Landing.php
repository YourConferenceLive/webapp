<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['project'] = $this->project;

		if
		(
			!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) ||
			(
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] != 1 &&
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_moderator'] != 1
			)
		)redirect(base_url().$this->project->main_route."/presenter/login"); // Not logged-in

		$this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header", $data);
		$this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/landing", $data);
		$this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer", $data);
	}
}
