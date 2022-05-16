<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Evaluation_Model', 'eval_model');
		$this->load->model('Settings_Model', 'settings');
	}

	public function index($id=1)
	{

		$this->logger->log_visit("Evaluation");

		// ToDo: If already submitted, then show Thank you message (confirm with Shannon)

		$data['project'] 	= $this->project;
		$data['user'] 		= $_SESSION['project_sessions']["project_{$this->project->id}"];
		$data['evaluation'] = $this->eval_model->get_evaluation($id);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/evaluation", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function save_evaluation(){
		echo $this->eval_model->save_evaluation();
	}

}
