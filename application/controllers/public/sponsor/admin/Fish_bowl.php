<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fish_bowl extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
//		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_sponsor_admin'] != 1)
//			redirect(base_url() . $this->project->main_route . "/login"); // Not logged-in

//		$this->load->model('Logger_Model', 'logger');
		$this->load->helper('string');
		$this->load->model('sponsor/Fish_bowl_model', 'm_fishbowl');
//		$this->session->set_userdata(array('sponsor_id'=>17,'booth_id'=>19));
		$this->session->set_userdata(array('sponsor_id' => 14, 'booth_id' => 14));
	}

	public function index(){

		$data['fish_bowl_data']= $this->m_fishbowl->get_fish_bowl_data();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/fish_bowl", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data);
	}

}
