<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_Notification_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->user = (object)($_SESSION['project_sessions']["project_{$this->project->id}"]);
		$this->load->model('Logger_Model', 'logger');
	}

	public function savePushNotification()
	{
		$post = $this->input->post();
		$session_id = ($post['session_id'] == "NULL")? null: $post['session_id'];
		$presenter = ($post['presenter'] == 'on')? '1':0;
		$attendee = ($post['attendee'] == 'on')? 1:0;
		$message = $post['message'];

		if($attendee == 1 && $presenter == 0){
			$notify_to = 'Attendee';
		}
		elseif($attendee == 0 && $presenter == 1){
			$notify_to = 'Presenter';
		}else{
			$notify_to = 'All';
		}

		$field_set = array(
			'session_id'=>$session_id,
			'project_id'=>$this->project->id,
			'notify_to'=>$notify_to,
			'message'=>$message,
			'date_time'=>date('Y-m-d H:i:s')
		);
		$this->db->insert('push_notification', $field_set);
		if($this->db->insert_id()){
			return array('status'=>'success', 'msg'=>'Notification saved');
		}
		return array('status'=>'error', 'msg'=>'Something went wrong');
	}

	function getAllPushNotification(){
		$result = $this->db->select('pn.*, s.name as session_name')
			->from('push_notification pn')
			->join('sessions s', 'pn.session_id = s.id', 'left')
			->where('pn.project_id', $this->project->id)
			->get();

			if($result->num_rows() > 0){
				return array('status'=>'success', 'data'=>$result->result());
			}else{
				return array('status'=>'error', 'data'=>$result->result());
			}
	}

	function getPushNotification(){
		$this->db->select('*');
		$this->db->from('push_notification');
		$this->db->where('project_id', $this->project->id);
		$this->db->where(array('status' => 1));
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return array('status' => 'success', 'data'=>$result->row());
		else
			return array('status' => 'error');
	}

	function send_notification($pid) {
		$this->db->update('push_notification', array('status' => 0, 'project_id'=>$this->project->id));
		$this->db->update('push_notification', array('status' => 1), array('id' => $pid, 'project_id'=>$this->project->id));
		if($this->db->affected_rows() > 0)
			return array('status'=>'success');
		else
			return array('status'=>'error');

	}
}

