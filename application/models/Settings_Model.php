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
//		print_r($_FILES['poll_music']['name']);exit;
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
			'mail_menu'=>(isset($post['mail_menu']) && $post['mail_menu']== 'on')?1:0,
			'profile_menu'=>(isset($post['profile_menu']) && $post['profile_menu']== 'on')?1:0,
			'profile'=>(isset($post['profile']) && $post['profile']== 'on')?1:0,
			'session_background_image'=>(isset($post['session_background_image']) && $post['session_background_image']== 'on')?1:0,
			'session_background_color'=>(isset($post['session_background_color']) && $post['session_background_color'] ? trim($post['session_background_color']):''),
			'stickyIcon_color'=>(isset($post['stickIcon_color']) && $post['stickIcon_color'] ? trim($post['stickIcon_color']):''),
			'homepage_redirect'=>(isset($post['homepage_redirect']) && !empty($post['homepage_redirect']))?$post['homepage_redirect']:'lobby',
			'live_support_color'=>(isset($post['live_support_color']) && !empty($post['live_support_color']))? trim($post['live_support_color']):'#6D8FA7',
		);

		$settings = $this->db->select('*')
			->from('attendee_view_settings')
			->where('project_id', $project_id)
			->get();
		$poll_music= '';
		if(isset($_FILES['poll_music']) && !empty($_FILES['poll_music'])){
			$poll_music_config['allowed_types'] = 'mp3';
			$poll_music_config['file_name'] = $poll_music = rand().'_'.str_replace(' ', '_', $_FILES['poll_music']['name']);
			$poll_music_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/music/';

			$this->load->library('upload', $poll_music_config);
			if ( ! $this->upload->do_upload('poll_music'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session photo', 'technical_data'=>$this->upload->display_errors());
			else
				$fieldset['poll_music']=(isset($poll_music_config['file_name']) && !empty($poll_music_config['file_name']))? trim($poll_music_config['file_name']):NULL;
		}
		if($settings->num_rows()>0){
			$this->db->where('project_id', $project_id);
			$result = $this->db->update('attendee_view_settings', $fieldset);
			return (array('status'=>'success', 'msg'=>'Settings Updated Successfully'));
		}else{
			$this->db->where('project_id', $project_id);
			$result = $this->db->insert('attendee_view_settings', $fieldset);
			return (array('status'=>'success', 'msg'=>'Settings Saved Successfully'));
		}

	}

}
