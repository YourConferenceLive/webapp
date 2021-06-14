<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] != 1)
			redirect(base_url().$this->project->main_route."/presenter/login"); // Not logged-in

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load->model('admin/Sessions_Model', 'sessions');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data["sessions"] = $this->sessions->getAllSessionsByPresenter($this->user['user_id']);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/list", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
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

		//$menu_data['host_chat_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_host_chat", '', true);
		//$menu_data['questions_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_questions.php", '', true);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_modal", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_result_modal", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}
}
