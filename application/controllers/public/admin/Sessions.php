<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load->model('admin/Sessions_Model', 'sessions');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data["sessions"] = $this->sessions->getAll();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/list", $data)
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

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}
}
