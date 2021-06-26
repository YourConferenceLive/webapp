<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Sessions_Model', 'sessions');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$create_modal['tracks'] = $this->sessions->getAllTracks();
		$create_modal['types'] = $this->sessions->getAllTypes();
		$create_modal['presenters'] = $this->sessions->getAllPresenters();
		$create_modal['moderators'] = $this->sessions->getAllModerators();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/list")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/add-session-modal", $create_modal)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function view($id)
	{

		$sidebar_data['user'] = $this->user;

		$session = $this->sessions->getById($id);

		$data["error_text"] = "No Slide Found";
		if (!isset($session->id))
			$data["error_text"] = "Session Not Found";


		$data["session"] = $session;
		$data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllJson()
	{
		echo json_encode($this->sessions->getAll());
	}

	public function getByIdJson($session_id)
	{
		echo json_encode($this->sessions->getById($session_id));
	}

	public function add()
	{
		echo json_encode($this->sessions->add());
	}

	public function update()
	{
		echo json_encode($this->sessions->update());
	}

	public function remove($session_id)
	{
		echo json_encode($this->sessions->removeSession($session_id));
	}

	public function getHostChatsJson($session_id)
	{
		echo json_encode($this->sessions->getHostChat($session_id));
	}

	public function sendHostChat()
	{
		echo json_encode($this->sessions->sendHostChat($this->input->post()));
	}

	public function polls($session_id)
	{
		$sidebar_data['user'] = $this->user;
		$session = $this->sessions->getById($session_id);

		$data['session'] = $session;
		$data['polls'] = $this->sessions->getAllPolls($session_id);


		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/polls", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/add-poll-modal.php")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllPollsJson($session_id)
	{
		echo json_encode($this->sessions->getAllPolls($session_id));
	}

	public function getPollByIdJson($id)
	{
		echo json_encode($this->sessions->getPollById($id));
	}

	public function addPollJson($session_id)
	{
		echo json_encode($this->sessions->addPoll($session_id));
	}
}
