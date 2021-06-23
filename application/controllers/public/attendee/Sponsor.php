<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor extends CI_Controller
{

	private $user_id;
	/**
	 * @var mixed
	 */
	private $user;

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->user_id = ($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']);
		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];
		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Sponsor_Model', 'm_sponsor');
		$this->load->model('sponsor/Scavenger_Hunt_Items_Model', 'hunt_items');

	}

	public function index()
	{

		$data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sponsor/exhibition_hall", $data)
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function booth($booth_id){

		if ($this->user['is_exhibitor'])
			redirect(base_url().$this->project->main_route."/lobby"); //Exhibitors can't see booths as an attendee

		$this->logger->log_visit("Booth", $booth_id);

		$data['project'] = $this->project;
		$data['sponsor_data'] = $this->m_sponsor->get_booth_data($booth_id);
		$data['admins'] = $this->m_sponsor->getBoothAdmins($booth_id);
		$data['user'] = $this->user;

		$this->load->model('sponsor/Scavenger_Hunt_Items_Model', 'hunt_items');
		$hunt_item = $this->hunt_items->get_hunt_item($data["sponsor_data"][0]->id);
		$hunt_item = $hunt_item->num_rows() > 0 ? false : true;
		$data['hunt_item'] = $hunt_item;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sponsor/booth", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/common/sponsor-video-chat-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function logout(){

		$this->session->sess_destroy();
		redirect(base_url().$this->project->main_route."/login"); // Not logged-in
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

	public function getTimeSlotByDateOf(){
		$post = $this->input->post();
		$date = $this->input->post()['date'];
		$booth_id= $post['booth_id'];
		$sponsor_id = $post['sponsor_id'];

		$dates = $this->m_sponsor->getTimeSlotByDateOf();

		if ($dates == false){
			echo json_encode(array());
			return;
		}

		$timeSlots = array();
		$meetingDuration  = 30 * 60; //15 minutes


		foreach ($dates as $times)
		{
			$start_time = strtotime(substr($dates[0]['start'], strrpos($dates[0]['start'], ' ') + 1));
			$end_time = strtotime(substr($dates[0]['end'], strrpos($dates[0]['end'], ' ') + 1));
			while ($start_time <= $end_time)
			{
				$timeSlots[] = date ("H:i", $start_time);
				$start_time += $meetingDuration;
			}
		}

		$existingBookings = $this->m_sponsor->getExistingBookings($booth_id, $sponsor_id, $date);
		$existingTimeSlots = array();

		if ($existingBookings != false){
			foreach ($existingBookings as $existingTimes)
			{
				$existingStart_time = strtotime($existingTimes['day_time_start']);
				$existingTimeSlots[] = date ("H:i", $existingStart_time);
			}
		}

		array_pop($timeSlots);

		$finalAvailableTimes = array_diff($timeSlots, $existingTimeSlots);

		echo json_encode(array_values($finalAvailableTimes));
		return;
	}

	public function getAvailableDatesOf()
	{
		$dates = $this->m_sponsor->get_sponsor_date_slot();

		if ($dates == false){
			echo json_encode(array());
			return;
		}

		$dateSlots = array();

		foreach ($dates as $dateSlotsData)
		{
			$period = new DatePeriod(
				new DateTime($dateSlotsData['start'].' 00:00:01'),
				new DateInterval('P1D'),
				new DateTime($dateSlotsData['end'].' 23:59:59')
			);

			foreach ($period as $key => $value) {
				$dateSlots[] = $value->format('Y-m-d');
			}
		}

		$dates = array_unique($dateSlots);
		echo json_encode($dates);
		return;
	}

	public function makeBooking()
	{
		$status = $this->m_sponsor->makeBooking();

		if ($status == true){
			echo json_encode(array('status'=>'success', 'message'=>'Your meeting has been scheduled.'));
			return;
		}elseif ($status == false)
		{
			echo json_encode(array('status'=>'error', 'message'=>'Someone else booked that time slot while you were planning!'));
			return;
		}

		echo json_encode(array('status'=>'failed', 'message'=>'Unable to schedule the meeting.'));
		return;

	}

	public function get_resource_by_id(){
		$result = $this->m_sponsor->get_resource_by_id();
		echo json_encode($result);
	}

	public function save_fishbowl_card(){
		$result = $this->m_sponsor->save_fishbowl_card();
		echo json_encode($result);
	}

	public function item_found(){
		echo  $this->hunt_items->item_found();
	}
}
