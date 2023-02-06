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

	public function getAttendeeSettings( $project_id, $session_id = null)
	{
		$result = $this->db->select('*')
			->from('sessions')
			->where('id', $session_id)
			->get();

		$settingsId = 0;
		if($result->num_rows() > 0){
			$settingsId = $result->result()[0]->attendee_settings_id;

		}

		 $this->db->select('*');
		$this->db->from('attendee_view_settings');
		$this->db->where('project_id', $project_id);
		if($settingsId != 0){
			$this->db->where('id', $settingsId);
		}

		$settings = $this->db->get();
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
			'header_logo_width'=>(isset($post['header_logo_width']) && !empty($post['header_logo_width']))? trim($post['header_logo_width']):NULL,
			'header_logo_height'=>(isset($post['header_logo_height']) && !empty($post['header_logo_height']))? trim($post['header_logo_height']):NULL,
		);

		$settings = $this->db->select('*')
			->from('attendee_view_settings')
			->where('project_id', $project_id)
			->get();
		$poll_music= '';
		if(isset($_FILES['poll_music']) && !empty($_FILES['poll_music']) && $_FILES['poll_music']['size']!==0){
			$poll_music_config['allowed_types'] = 'mp3';
			$poll_music_config['file_name'] = $poll_music = rand().'_'.str_replace(' ', '_', $_FILES['poll_music']['name']);
			$poll_music_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/music/';

			$this->load->library('upload', $poll_music_config);
			if ( ! $this->upload->do_upload('poll_music'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the poll music', 'technical_data'=>$this->upload->display_errors());
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

	function presenterSettings($project_id){
		//		print_r($project_id);exit;
		$settings = $this->db->select('*')
			->from('presenter_view_settings')
			->where('project_id', $project_id)
			->get();
		if($settings->num_rows()>0){
			return $settings->result();
		}

		return '';
	}

	function savePresenterViewSetting($project_id){
		$post = $this->input->post();
		$fieldset = array(
			'project_id'=>$project_id,
			'time_zone' =>(isset($post['presenter_timezone']) && $post['presenter_timezone'] ? trim($post['presenter_timezone']):'')
		);

		$settings = $this->db->select('*')
			->from('presenter_view_settings')
			->where('project_id', $project_id)
			->get();

		if($settings->num_rows() > 0){
			$this->db->where('project_id', $project_id);
			$this->db->update('presenter_view_settings', $fieldset);
			return (array('status'=>'success', 'msg'=>'Settings Updated Successfully'));
		}else{
			$this->db->insert('presenter_view_settings', $fieldset);
			if($this->db->insert_id()) {
				return (array('status' => 'success', 'msg' => 'Settings Saved Successfully'));
			}else{
				return (array('status' => 'error', 'msg' => 'Save failed!'));
			}
		}

	}

	function getColorPresets(){
		$result = $this->db->select('*')
			->from('attendee_view_settings')
			->where('name !=', '')
			->get();

		if($result->num_rows() > 0){
			return json_encode(array('status'=>'success', 'data'=>$result->result()));
		}
		return '';
	}
}
