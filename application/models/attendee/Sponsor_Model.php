<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  project
 */
class Sponsor_Model extends CI_Model
{

	private $user_id;

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Sponsor_Model', 'm_sponsor');

		$this->user_id=($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']);
	}


	function get_booth_data($booth_id){

		$this->db->select('*')
			->from('sponsor_booth sb')
			->where('id', $booth_id)
			->where('project_id', $this->project->id);

		$result= $this->db->get();

		if($result){
			return $result->result();
		}else{
			return  '';
		}
	}

	function save_sponsor_group_chat(){
		$post = $this->input->post();
		$field_set = array(
			'project_id'=>$this->project->id,
			'booth_id'=>$post['booth_id'],
			'chat_from'=>$this->user_id,
			'chat_text'=>$post['chat_text'],
			'date_time'=>date('Y-m-d H:i:s')
		);
		$result = $this->db->insert('sponsor_group_chat',$field_set);
		if(!empty($result) ){
			return 'success';
		}else{
			return '';
		}
	}

	function get_sponsor_group_chat()
	{
		$post = $this->input->post();
		$this->db->select('*')
			->from('sponsor_group_chat sc')

			->join('user u', 'sc.chat_from = u.id', 'left')
			->where('project_id',$this->project->id)
			->where('booth_id',$post['booth_id'])
			->where('cleared', 0)
			->order_by('sc.id', 'asc');

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}

	function get_sponsor_attendee_chat(){
		$post = $this->input->post();
//		print_r($post);exit;
		$this->db->select('*, CONCAT(u.name," ",u.surname) as full_name')
			->from('sponsor_attendee_chat sac')
			->join('user u', 'sac.from_id = u.id','left')
			->where('sac.booth_id', $post['booth_id'])
			->where('sac.project_id', $this->project->id)
			->group_start()
			->where('from_id', $this->user_id)
			->or_where('to_id', $this->user_id)
			->group_end()
			->order_by('sac.id', 'asc')
			;
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}

	function save_sponsor_attendee_chat()
	{
		$post = $this->input->post();
//		print_r($post);exit;
		$fields = array(
			'project_id'=>$this->project->id,
			'booth_id' => $post['booth_id'],
			'chat_from'=> "attendee",
			'from_id' => $this->user_id,
			'to_id'=>"sponsor",
			'chat_text' => $post['chat_text'],
			'date_time' => date('Y-m-d H:i:s'),
		);
		$result = $this->db->insert('sponsor_attendee_chat', $fields);
		$insert_id = $this->db->insert_id();

		if (!empty($result)) {
			return 'success';
		} else {
			return 'error';
		}
	}

	function get_resource_files(){
		$post = $this->input->post();
//		print_r($post);exit;
		$this->db->select('*')
			->from('sponsor_resource_management')
			->where('booth_id', $post['booth_id']);

		$result = $this->db->get();
//		print_r($result);exit;
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);

	}

	function get_sponsor_list(){
		$post = $this->input->post();

		$this->db->select('CONCAT(u.name," ",u.surname) as sponsor_name, u.id as sponsor_id, sba.id as id')
			->from('sponsor_booth_admin sba')
			->join('user u','sba.user_id=u.id')
			->where('booth_id', $post['booth_id'])
			->where('project_id', $this->project->id)
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}


//	GET DATE LIST OF DATETIME PICKER ###############################

	function get_sponsor_date_slot(){
		$post = $this->input->post();
		$this->db->select('DATE(available_from) as start, DATE(available_to) as end')
			->from('sponsor_meeting_availability')
			->where('project_id', $this->project->id)
			->where('booth_id', $post['booth_id'])
			->where('sponsor_admin_id', $post['sponsor_id'])
			;
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return ($result->result_array());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
//		return json_encode($json_array);
	}


	function getTimeSlotByDateOf()
	{
		$post = $this->input->post();
		$date = $this->input->post()['date'];
//		print_r($date);exit;
		$this->db->select('available_from as start, available_to as end')
			->from('sponsor_meeting_availability')
			->where('project_id', $this->project->id)
			->where('booth_id', $post['booth_id'])
			->where('sponsor_admin_id', $post['sponsor_id'])
			->group_start()
			->where('DATE(available_from)', $date)
			->or_where('DATE(available_to)', $date)
			->group_end()
		;
		$result = $this->db->get();
		if($result->num_rows() != 0)
		{

			return $result->result_array();
		}
		else
		{
			return false;
		}
	}

	function getExistingBookings($booth_id, $sponsor_id, $date){
		$this->db->select('day_time_start')
			->from('sponsor_meeting_booking')
			->where('project_id', $this->project->id)
			->where('booth_id', $booth_id)
			->where('sponsor_admin_id', $sponsor_id)
			->where('DATE(day_time_start)', $date)

		;
		$query = $this->db->get();
		if($query->num_rows() != 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	function makeBooking()
	{
		$post = $this->input->post();
		$sponsor_id = $post['sponsor_id'];
		$booth_id = $post['booth_id'];
		$meetFrom = $post['meet_from'];
		$meetTo = $post['meet_to'];

		$data = array(
			'sponsor_admin_id' => $sponsor_id,
			'project_id'=>$this->project->id,
			'booth_id ' => $booth_id,
			'user_id ' => $this->user_id,
			'day_time_start' => $meetFrom,
			'day_time_end' => $meetTo
		);

		if ($this->existingBookingCheck() != true)
		{
			$this->db->insert('sponsor_meeting_booking', $data);
			return true;
		}else{
			return false;
		}
	}

	function existingBookingCheck()
	{

		$sponsor_id = $this->input->post()['sponsor_id'];
		$booth_id = $this->input->post()['booth_id'];
		$meetFrom = $this->input->post()['meet_from'];
		$meetTo = $this->input->post()['meet_to'];

		$data = array(
			'sponsor_admin_id' => $sponsor_id,
			'project_id'=>$this->project->id,
			'booth_id ' => $booth_id,
			'day_time_start' => $meetFrom,
			'day_time_end' => $meetTo
		);

		$this->db->select('*');
		$this->db->from('sponsor_meeting_booking');
		$this->db->where($data);
		$query = $this->db->get();
		if($query->num_rows() != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_resource_by_id() {
		$resource_id = $this->input->post('resource_id');
		$note = $this->input->post('note');
		$this->db->select('*')
			->from('sponsor_resource_management')
			->where('id',$resource_id)
;
		$result = $this->db->get();

		if($result->num_rows() > 0 ) {
			$data = $result->result()[0];

			$check_duplicate = $this->check_bag_item_duplicate($data->file_name);

			if ($check_duplicate) {
				return array('status'=>'exist','message'=>'file already in the bag');
			} else {

			$data_field=array(
				'project_id'=>$data->project_id,
				'booth_id'=>$data->booth_id,
				'file_name'=> $data->file_name,
				'resource_name'=>$data->resource_name,
				'screen_name'=>$data->screen_name,
				'note'=>$note,
				'user_id'=>$this->user_id,
				'item_type'=>'sponsor_resource',
				'date_time'=>date('Y-m-d H:i:s')
			);

			$this->db->insert('sponsor_bag', $data_field);
				return array('status'=>'success','message'=>'file added to bag');
			}
		}
		return '';
	}

	function check_bag_item_duplicate($file_name){
		$this->db->select('*')
			->from('sponsor_bag')
			->where('file_name', $file_name);

			$result = $this->db->get();
			if($result->num_rows() > 0){
				return true;
			}else{
				return false;
			}

	}

	function save_fishbowl_card(){
		$field_set = array(
			'project_id'=>$this->project->id,
			'booth_id'=>$this->input->post('booth_id'),
			'user_id'=>$this->user_id,
			'date_time'=>date('Y-m-d H:i:s')
		);
		$result = $this->db->insert('sponsor_fishbowl',$field_set);
		if(!empty($result)){
			return array('status'=>'success');
		}else{
			return array('status'=>'error');
		}
	}
}
