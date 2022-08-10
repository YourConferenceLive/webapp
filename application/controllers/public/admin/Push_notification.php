<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_notification extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url() . $this->project->main_route . "/admin/login"); // Not logged-in

		$this->user = (object)($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Sessions_Model', 'sessions');
		$this->load->model('Push_Notification_Model', 'm_push_notification');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/push_notification")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllSession(){
		echo json_encode($this->sessions->getAll());
	}

	public function savePushNotification(){
		echo json_encode($this->m_push_notification->savePushNotification());
	}

	public function getAllPushNotification(){
		echo json_encode($this->m_push_notification->getAllPushNotification());
	}

	public function send_notification($pid){
		echo json_encode($this->m_push_notification->send_notification($pid));
	}

	public function close_notification($pid){
		echo json_encode($this->m_push_notification->close_notification($pid));
	}
}
