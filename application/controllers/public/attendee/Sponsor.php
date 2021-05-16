<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor extends CI_Controller
{

	private $user_id;
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->user_id = ($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']);
		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Sponsor_Model', 'm_sponsor');
	}

	public function index(){

	}

	public function booth($booth_id){

		$this->logger->log_visit("Booth", $booth_id);
		$data['project']=$this->project;
		$data['sponsor_data']= $this->m_sponsor->get_booth_data($booth_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sponsor/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sponsor/booth", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('booth');
	}
	public function save_sponsor_group_chat(){
		$result = $this->m_sponsor->save_sponsor_group_chat();
		echo $result;
	}

	public function get_sponsor_group_chat(){
		$result = $this->m_sponsor->get_sponsor_group_chat();
		echo $result;
	}

	public function get_sponsor_attendee_chat(){
		$result = $this->m_sponsor->get_sponsor_attendee_chat();
		echo $result;
	}

	public function save_sponsor_attendee_chat(){
		$result= $this->m_sponsor->save_sponsor_attendee_chat();
		echo $result;
	}

	public function get_resource_files(){
		$result= $this->m_sponsor->get_resource_files();
		echo $result;
	}

	public function get_sponsor_list(){
		$result= $this->m_sponsor->get_sponsor_list();
		echo $result;
	}

	public function get_sponsor_date_slot(){
		$result= $this->m_sponsor->get_sponsor_date_slot();
		echo $result;
	}
}
