<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	function attendeeSettings($project_id){
//		print_r($project_id);exit;
		$settings = $this->db->select('*')
			->from('attendee_view_settings')
			->where('project_id', $project_id)
			->get();
		if($settings->num_rows()>0){
			return $settings->result();
		}

		return '';
	}

	public function getAttendeeSettings($project_id)
	{
		$settings = $this->db->select('*')
			->from('attendee_view_settings')
			->where('project_id', $project_id)
			->get();
		if($settings->num_rows()>0){
			return $settings->result();
		}

		return '';
	}

	function saveAttendeeViewSetting($project_id){
		$post = $this->input->post();
		$fieldset = array(
			'lobby'=>(isset($post['lobby']) && $post['lobby']== 'on')?1:0,
			'project_id'=>$project_id,
			'agenda'=>(isset($post['agenda']) && $post['agenda']== 'on')?1:0,
			'eposter'=>(isset($post['eposter']) && $post['eposter']== 'on')?1:0,
			'lounge'=>(isset($post['lounge']) && $post['lounge']== 'on')?1:0,
			'exhibition_hall'=>(isset($post['exhibitionHall']) && $post['exhibitionHall']== 'on')?1:0,
			'scavenger_hunt'=>(isset($post['scavengerHunt']) && $post['scavengerHunt']== 'on')?1:0,
			'relaxation_zone'=>(isset($post['relaxation']) && $post['relaxation']== 'on')?1:0,
			'evaluation'=>(isset($post['evaluation']) && $post['evaluation']== 'on')?1:0,
			'briefcase'=>(isset($post['briefcase']) && $post['briefcase']== 'on')?1:0,
			'homepage_redirect'=>(isset($post['homepage_redirect']) && !empty($post['homepage_redirect']))?$post['homepage_redirect']:'lobby',
		);

		$settings = $this->db->select('*')
			->from('attendee_view_settings')
			->where('project_id', $project_id)
			->get();

		if($settings->num_rows()>0){
			$this->db->where('project_id', $project_id);
			$result = $this->db->update('attendee_view_settings', $fieldset);
		}else{
			$this->db->where('project_id', $project_id);
			$result = $this->db->insert('attendee_view_settings', $fieldset);
		}

	}
}
