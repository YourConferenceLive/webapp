<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lounge extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Users_Model', 'users');
		$this->load->model('Lounge_Model', 'lounge');
	}

	public function index()
	{
		$this->logger->log_visit("Lounge");

		$data['project'] = $this->project;
		$menu['user'] = $_SESSION['project_sessions']["project_{$this->project->id}"];
		$data['lounge_user'] = $this->users->getById($_SESSION['project_sessions']["project_{$this->project->id}"]['user_id']);
		$data['allUsers'] = $this->users->getAll();
		$data['allGroupChats'] = $this->lounge->getAllGroupChats();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $menu)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/lounge", $data)
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function sendGroupChat()
	{
		if ($this->lounge->sendGroupChat())
			echo 1;
		else
			echo 0;
	}

	public function getDirectChatsWith($user_id)
	{
		echo json_encode($this->lounge->getDirectChatsWith($user_id));
	}

	public function sendDirectChat()
	{
		if ($this->lounge->sendDirectChat())
			echo 1;
		else
			echo 0;
	}
}
