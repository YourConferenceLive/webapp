<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eposters extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('admin/Eposters_Model', 'eposters');
	}

	public function index()
	{
		$sidebar_data['user'] 		= $this->user;
		$create_modal['tracks'] 	= $this->eposters->getAllTracks();
		$create_modal['prizes'] 	= $this->eposters->getAllPrizes();
		$create_modal['types'] 		= $this->eposters->getAllTypes();
		$create_modal['authors'] 	= $this->eposters->getAllAuthors();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/eposters/list")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/eposters/add-modal", $create_modal)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function view($id)
	{
		$sidebar_data['user'] 	= $this->user;
		$eposter 				= $this->eposters->getById($id);

		$data["error_text"] 	= "No Slide Found";
		if (!isset($eposter->id))
			$data["error_text"] = "ePoster Not Found";

		$data["eposter"] 		= $eposter;
		$data['user'] 			= $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/eposters/view", $data)
		;
	}

	public function getAllJson()
	{
		echo json_encode($this->eposters->getAll());
	}

	public function getByIdJson($eposter_id)
	{
		echo json_encode($this->eposters->getById($eposter_id));
	}

	public function add()
	{
		echo json_encode($this->eposters->add());
	}

	public function update()
	{
		echo json_encode($this->eposters->update());
	}

	public function remove($eposter_id)
	{
		echo json_encode($this->eposters->removeEposter($eposter_id));
	}

	public function getHostChatsJson($eposter_id)
	{
		echo json_encode($this->eposters->getHostChat($eposter_id));
	}

	public function sendHostChat()
	{
		echo json_encode($this->eposters->sendHostChat($this->input->post()));
	}

	public function downloadAllImages(){
		$this->eposters->downloadAllImages();
	}
}
