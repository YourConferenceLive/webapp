<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
//		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_sponsor_admin'] != 1)
//			redirect(base_url() . $this->project->main_route . "/login"); // Not logged-in

//		$this->load->model('Logger_Model', 'logger');
		$this->load->helper('string');
		$this->load->model('sponsor/Sponsor_Model', 'm_sponsor');
//		$this->session->set_userdata(array('sponsor_id'=>17,'booth_id'=>19));
		$this->session->set_userdata(array('sponsor_id'=>14,'booth_id'=>14));
	}

	public function index()
	{

		$data['project'] = $this->project;
		$data['sponsor_data']= $this->m_sponsor->get_sponsor_data();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sponsor/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/sponsor_admin", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data);

	}

	public function logout()
	{
		$this->session->unset_userdata('sponsors_id');
		$this->session->unset_userdata('booth_id');
		$this->session->unset_userdata(array('email', 'userType'));
		redirect('sponsor-admin/login');
	}


	public function save_booth_details()
	{
		echo  $this->m_sponsor->save_booth_details();
		return;
	}

	public function upload_cover(){
		echo $this->m_sponsor->upload_cover();
		return;
	}

	public function upload_logo(){
		echo $this->m_sponsor->upload_logo();
		return;
	}

	public function update_sponsor_name(){
		echo $this->m_sponsor->update_sponsor_name();
		return;
	}

	public function update_about_us(){
		echo $this->m_sponsor->update_about_us();
		return;
	}

	public function update_twitter(){
		echo $this->m_sponsor->update_twitter();
		return;
	}
	public function update_facebook(){
		echo $this->m_sponsor->update_facebook();
		return;
	}
	public function update_linkedin(){
		echo $this->m_sponsor->update_linkedin();
		return;
	}
	public function update_website(){
		echo $this->m_sponsor->update_website();
		return;
	}

	public function save_sponsor_group_chat(){
		echo $this->m_sponsor->save_sponsor_group_chat();
		return;
	}

	public function get_sponsor_group_chat(){
		$result= $this->m_sponsor->get_sponsor_group_chat();
		echo $result;
	}

	public function get_sponsor_attendee_lists(){
		$result= $this->m_sponsor->get_sponsor_attendee_lists();
		echo $result;
	}

	public function get_sponsor_attendee_chat(){

		$result= $this->m_sponsor->get_sponsor_attendee_chat();
		echo $result;
	}

	public function get_attendee_info(){
		$result= $this->m_sponsor->get_attendee_info();
		echo $result;
	}

	public function save_sponsor_attendee_chat(){
		$result= $this->m_sponsor->save_sponsor_attendee_chat();
		echo $result;
	}

	public function upload_resource_file(){
		$result= $this->m_sponsor->upload_resource_file();
		echo $result;
	}

	public function get_resource_files(){
		$result= $this->m_sponsor->get_resource_files();
		echo $result;
	}

	public function delete_resource_file(){
		$result= $this->m_sponsor->delete_resource_file();
		echo $result;
	}

	public function download_resource_file(){
		$result= $this->m_sponsor->download_resource_file();
		echo $result;
	}

	public function add_availability_date_time(){
		$result= $this->m_sponsor->add_availability_date_time();
		echo $result;
	}

	public function get_availability_list(){
		$result= $this->m_sponsor->get_availability_list();
		echo $result;
	}

	public function delete_availability(){
		$result= $this->m_sponsor->delete_availability();
		echo $result;
	}

	public function get_calendar_events(){
		$result= $this->m_sponsor->get_calendar_events();
		echo $result;
	}
}
