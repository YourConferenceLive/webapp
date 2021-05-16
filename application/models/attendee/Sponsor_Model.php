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
			->from('sponsor_booth ')
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

	function get_sponsor_date_slot(){
		$post = $this->input->post();
		$this->db->select('available_from as start, available_to as end')
			->from('sponsor_meeting_availability')
			->where('project_id', $this->project->id)
			->where('booth_id', $post['booth_id'])
			->where('sponsor_admin_id', $post['sponsor_id'])
			;
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}
}
