<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $booth_id;

	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_exhibitor'] != 1)
			redirect(base_url($this->project->main_route)."/sponsor/admin/login"); // Not logged-in

		$this->booth_id = $_SESSION['project_sessions']["project_{$this->project->id}"]['exhibitor_booth_id'];
		$this->user_id = ($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']);

		if ($this->booth_id == null) // No booth has been assigned to this account
			redirect(base_url($this->project->main_route)."/sponsor/admin/login");

		$this->load->model('Logger_Model', 'logger');
		$this->load->helper('string');
		$this->load->model('sponsor/Sponsor_Model', 'sponsor');

		$this->load->model('Users_Model', 'users');
	}

	public function index()
	{
		$menu_data['user'] = (Object) $_SESSION['project_sessions']["project_{$this->project->id}"];

		$data['booth'] = $this->sponsor->getBoothData($this->booth_id);
		$data['attendees'] = $this->users->getAllAttendees();
		$data['user'] = (Object) $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/menu-bar", $menu_data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/sponsor_admin", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/common/sponsor-video-chat-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/footer")
		;

	}


	public function upload_booth_photos(){
		echo  $this->sponsor->upload_booth_photos();
	}

	public function change_booth_url(){
		echo  $this->sponsor->change_booth_url();
	}

	public function save_booth_details()
	{
		echo  $this->sponsor->save_booth_details();
		return;
	}

	public function upload_cover(){
		echo $this->sponsor->upload_cover();
		return;
	}

	public function upload_logo(){
		echo $this->sponsor->upload_logo();
		return;
	}

	public function update_sponsor_name(){
		echo $this->sponsor->update_sponsor_name();
		return;
	}

	public function update_about_us(){
		echo $this->sponsor->update_about_us();
		return;
	}

	public function update_twitter(){
		echo $this->sponsor->update_twitter();
		return;
	}
	public function update_facebook(){
		echo $this->sponsor->update_facebook();
		return;
	}
	public function update_linkedin(){
		echo $this->sponsor->update_linkedin();
		return;
	}
	public function update_website(){
		echo $this->sponsor->update_website();
		return;
	}

	public function save_sponsor_group_chat(){
		echo $this->sponsor->save_sponsor_group_chat($this->booth_id, $this->user_id);
		return;
	}

	public function get_sponsor_group_chat(){
		$result= $this->sponsor->get_sponsor_group_chat($this->booth_id);
		echo $result;
	}

	public function get_sponsor_attendee_lists(){
		$result= $this->sponsor->get_sponsor_attendee_lists();
		echo $result;
	}

	public function get_sponsor_attendee_chat(){

		$result= $this->sponsor->get_sponsor_attendee_chat($this->booth_id);
		echo $result;
	}

	public function get_attendee_info(){
		$result= $this->sponsor->get_attendee_info();
		echo $result;
	}

	public function save_sponsor_attendee_chat(){
		$result= $this->sponsor->save_sponsor_attendee_chat($this->booth_id, $this->user_id);
		echo $result;
	}

	public function upload_resource_file(){
		$result= $this->sponsor->upload_resource_file($this->booth_id);
		echo $result;
	}

	public function get_resource_files(){
		$result= $this->sponsor->get_resource_files($this->booth_id);
		echo $result;
	}

	public function delete_resource_file(){
		$result= $this->sponsor->delete_resource_file();
		echo $result;
	}

	public function download_resource_file(){
		$result= $this->sponsor->download_resource_file();
		echo $result;
	}

	public function add_availability_date_time(){
		$result= $this->sponsor->add_availability_date_time();
		echo $result;
	}

	public function get_availability_list(){
		$result= $this->sponsor->get_availability_list();
		echo $result;
	}

	public function delete_availability(){
		$result= $this->sponsor->delete_availability();
		echo $result;
	}

	public function get_calendar_events(){
		$result= $this->sponsor->get_calendar_events();
		echo $result;
	}

	public function clear_group_chat(){
		$result = $this->sponsor->clear_group_chat();
		echo $result;
	}

	public function copy_from_group_chat(){
		$result = $this->sponsor->copy_from_group_chat();
		echo json_encode($result);
	}

	public function get_saved_group_chats(){
		$result = $this->sponsor->get_saved_group_chats();
		echo $result;
	}

	public function delete_saved_chats(){
		$result = $this->sponsor->delete_saved_chats();
		echo $result;
	}
}
