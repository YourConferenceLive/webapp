<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lobby extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Users_Model', 'user');
	}

	public function index()
	{
		$this->logger->log_visit("Lobby");

		$first_load 				= $this->input->get('first_load');
		$data['project'] 			= $this->project;
		$data['user'] 				= $_SESSION['project_sessions']["project_{$this->project->id}"];
		$data['lobby_menu'] 		= $this->load->view("{$this->themes_dir}/{$this->project->theme}/attendee/lobby/menu", NULL, TRUE);
		$data['default_password']   = ((!is_null($first_load)) ? $this->user->defaultPasswordCheck() : false );

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/lobby/index", $data)
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function testing()
	{
		$this->logger->log_visit("Lobby");

		$data['project'] = $this->project;
		$data['user'] = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$data['lobby_menu'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/attendee/lobby/menu", NULL, TRUE);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/lobby/index2", $data)
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}
}
