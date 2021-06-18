<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (isset($_SESSION['project_sessions']["project_{$this->project->id}"]) && $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] == 1)
			redirect(base_url().$this->project->main_route."/lobby"); // Already logged-in

		if ($this->project->main_route == 'COS')
			redirect(base_url().$this->project->main_route); // COS does not allow registration in the app (use COS API)
	}

	public function index()
	{
		$data['project'] = $this->project;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/register", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}
}
