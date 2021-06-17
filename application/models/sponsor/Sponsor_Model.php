<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  project
 */
class Sponsor_model extends CI_Model
{

	private $booth_id;
	private $sponsor_id;


	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	function getBoothData($booth_id)
	{

		$this->db->select('*');
		$this->db->from('sponsor_booth');
		$this->db->where('id', $booth_id);
		$booth = $this->db->get();
		if ($booth->num_rows() > 0)
			return $booth->result()[0];
	}

	function save_booth_details()
	{
		$post = $this->input->post();
		$field_array = array(
			'project_id'=>$this->project->id,
			'facebook_link' => $post['facebook'],
			'twitter_link' => $post['twitter'],
			'linkedin_link' => $post['linkedin'],
			'custom_link' => $post['custom'],
			'about_us' => $post['about_us'],
			'video_description' => $post['video_description'],
			'name' => $post['name'],
		);


		$this->db->select('user_id');
		$this->db->from('booth_data');
		$this->db->where(array('id' => $this->booth_id, 'user_id' => $this->sponsor_id,'project_id'=>$this->project_id));
		$res = $this->db->get();
		if ($res->num_rows() > 0) {
			$result = $this->db->update('booth_data', $field_array);
			return $result;
		} else {
			$result = $this->db->insert('booth_data', $field_array);
			$insert_id = $this->db->insert_id();
			if (!empty($result)) {
				$this->db->select('*');
				$this->db->where('id', $insert_id);
				$this->db->where('project_id',$this->project->id);
				$this->db->from('booth_data');
				$dbget = $this->db->get();
				return $dbget->result();
			} else {
				return '';
			}
		}
	}

	function upload_booth_photos()
	{
		$project_id=$this->input->post('project_id');
		$current_booth_id=$this->input->post('current_booth_id');
		$photo_type=$this->input->post('type');

		if ($_FILES['file']) {
			$fileExt = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			$file_name="{$project_id}.{$current_booth_id}.{$photo_type}.{$fileExt}";
			if (move_uploaded_file($_FILES["file"]["tmp_name"], FCPATH . "/theme_assets/booth_uploads/{$file_name}")) {
				$this->db->update('sponsor_booth', array($photo_type => $file_name), array('id' => $current_booth_id));
				return true;
			} else {
				return false;
			}

		}
	}

	function change_booth_url()
	{
		$current_booth_id=$this->input->post('current_booth_id');
		$tv_url=$this->input->post('tv_url');
		$this->db->update('sponsor_booth', array('main_video_url' => $tv_url), array('id' => $current_booth_id));
	}


	function upload_cover()
	{
		$post = $this->input->post();
		if ($_FILES['cover']) {
			$fileExt = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
			if (file_exists("cover_photo{$this->booth_id}.{$fileExt}")) {
				chmod("cover_photo{$this->booth_id}.{$fileExt}", 0755); //Change the file permissions if allowed
				unlink("cover_photo{$this->booth_id}.{$fileExt}"); //remove the file
			}
			if (move_uploaded_file($_FILES["cover"]["tmp_name"], FCPATH . "cms_uploads/projects/".$this->project->id."/sponsor_assets/uploads/cover_photo/cover_photo{$this->booth_id}.{$fileExt}")) {
				$this->db->update('sponsor_booth', array('cover_photo' => "cover_photo{$this->booth_id}.{$fileExt}"), array('id' => $this->booth_id));
				return "cover_photo{$this->booth_id}.{$fileExt}";
			} else {
				return false;
			}
		}
	}

	function upload_logo()
	{
		$post = $this->input->post();
		$id = $this->booth_id;
		if ($_FILES['logo']) {
			$fileExt = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
			if (file_exists("logo{$id}.{$fileExt}")) {
				chmod("logo{$id}.{$fileExt}", 0755); //Change the file permissions if allowed
				unlink("logo{$id}.{$fileExt}"); //remove the file
			}
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], FCPATH . "cms_uploads/projects/".$this->project->id."/sponsor_assets/uploads/logo/logo{$id}.{$fileExt}")) {
				$this->db->update('sponsor_booth', array('logo' => "logo{$id}.{$fileExt}"), array('id' => $id));
				return "logo{$id}.{$fileExt}";
			} else {
				return false;
			}
		}
	}

	function update_sponsor_name()
	{
		$post = $this->input->post();
		if (isset($post['name'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('name' => $post['name']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function update_about_us()
	{
		$post = $this->input->post();
		if (isset($post['about_us'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('about_us' => $post['about_us']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function update_website()
	{
		$post = $this->input->post();
		if (isset($post['website'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('website_link' => $post['website']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function update_twitter()
	{
		$post = $this->input->post();
		if (isset($post['twitter'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('twitter_link' => $post['twitter']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function update_facebook()
	{
		$post = $this->input->post();
		if (isset($post['facebook'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('facebook_link' => $post['facebook']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function update_linkedin()
	{
		$post = $this->input->post();
		if (isset($post['linkedin'])) {
			$this->db->where('id', $this->booth_id);
			$this->db->update('sponsor_booth', array('linkedin_link' => $post['linkedin']));
			return 'success';
		} else {
			return 'error';
		}
	}

	function save_sponsor_group_chat()
	{
		$post = $this->input->post();
		$fields = array(
			'project_id'=> $this->project->id,
			'booth_id' => $this->booth_id,
			'chat_from' => $this->sponsor_id,
			'chat_text' => $post['chat_text'],
			'date_time' => date('Y-m-d H:i:s'),
		);
		$result = $this->db->insert('sponsor_group_chat', $fields);
		$insert_id = $this->db->insert_id();

		if (!empty($result)) {
			return 'success';
		} else {
			return 'error';
		}

	}

	function get_sponsor_group_chat()
	{
		$post = $this->input->post();
		$this->db->select('*')
				->from('sponsor_group_chat sc')
				->join('user u', 'sc.chat_from = u.id', 'left')
				->where('cleared', 0)
				->where('project_id', $this->project->id)
				->where('booth_id', $this->booth_id)
				->order_by('sc.date_time', 'asc');

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}

	function get_sponsor_attendee_lists()
	{

		$this->db->select('*')
			->from('user u')
			->join('user_project_access upa','upa.user_id = u.id','right')
			->where('u.id!=',$this->sponsor_id)
			->where('upa.project_id',$this->project->id)
			->order_by('u.name');

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'error', json_last_error());
		}
		return json_encode($json_array);
	}

	function get_sponsor_attendee_chat()
	{
		$post = $this->input->post();
//		print_r($post);
		$this->db->select('*')
			->from('sponsor_attendee_chat sac')
			->join('user u','sac.from_id = u.id','left')
			->where('booth_id', $this->booth_id)
			->group_start()
			->where('sac.to_id', $post['chat_from_id'])
			->or_where('sac.from_id', $post['chat_from_id'])
			->group_end()
//			->where('sac.to_id = '.$post['chat_from_id'].' OR sac.from_id = '.$post['chat_from_id'].'' )
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

	function get_attendee_info()
	{
		$post = $this->input->post();
		$this->db->select('*')
				->from('user u')
				->join('user_project_access upa', 'upa.user_id = u.id')
				->order_by('u.name', 'desc')
				->where('u.id', $post['attendee_id'])
				->where('upa.project_id',$this->project->id);

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
		$fields = array(
			'project_id'=>$this->project->id,
			'booth_id' => $this->booth_id,
			'chat_from' => 'sponsor',
			'to_id' => $post['chat_to_id'],
			'from_id' => $this->sponsor_id,
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

	function upload_resource_file()
	{
		$post = $this->input->post();
		$random_string = md5(uniqid(rand(), true));
		$resource_name = $post['resource_name'];
		$screen_name = ($_FILES["resource_file"]["name"]);
		if ($_FILES['resource_file']) {
			$fileExt = pathinfo($_FILES["resource_file"]["name"], PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["resource_file"]["tmp_name"], FCPATH . "cms_uploads/projects/".$this->project->id."/sponsor_assets/uploads/resource_management_files/resource_{$this->booth_id}_{$random_string}.{$fileExt}")) {
				$data = array(
					'project_id'=>$this->project->id,
					'booth_id' => $this->booth_id,
					'resource_name' => $resource_name,
					'screen_name' => $screen_name,
					'file_name' => "resource_{$this->booth_id}_{$random_string}.{$fileExt}"
				);
				$this->db->insert('sponsor_resource_management', $data);
				$ret = $this->db->insert_id();
			} else {
				$ret = false;
			}
		}
		return $ret;
	}

	function get_resource_files(){
		$this->db->select('*')
				->from('sponsor_resource_management')
				->where('project_id',$this->project->id)
				->where('booth_id',$this->booth_id)
				->order_by('date_time','desc');
		$result = $this->db->get();
		if($result->num_rows() > 0){
			$json_array = array('status'=>'success','result'=>$result->result());
		}else{
			$json_array = array('status'=>'error');
		}
		return json_encode($json_array);
	}

	function delete_resource_file(){
		$post = $this->input->post();
		 $this->db->delete('sponsor_resource_management', array('id' => $post['resource_id']));
		return 'success';
	}

	function download_resource_file(){
		$post = $this->input->post();
		$result = $this->db->select('*')->from('sponsor_resource_management')->where('id',$post['file_id'])->where('project_id',$this->project->id)->get();
		if($result->num_rows()>0){
			$file = FCPATH.$result->row()->file_path;
			$new_filename = $result->row()->name;

			header("Content-Type: {$result->row()->format}");
			header("Content-Length: " . filesize($file));
			header('Content-Disposition: attachment; filename="' . $new_filename . '"');
			readfile($file);

		}else{

		}
		return;
	}

	function add_availability_date_time(){

		$overLapCheck = $this->check_availability_overlap();
		if ($overLapCheck == false){
			return 'error';
			die;
		}

		$post = $this->input->post();
		$field_set = array(
			'project_id'=>$this->project->id,
			'booth_id'=>$this->booth_id,
			'sponsor_admin_id'=>$this->sponsor_id,
			'available_from'=>$post['available_from'],
			'available_to'=>$post['available_to'],
		);
		$result= $this->db->insert('sponsor_meeting_availability', $field_set);
		if (!empty($result)) {
			return 'success';
		} else {
			return 'error';
		}
	}

	function check_availability_overlap(){
		$post = $this->input->post();
		$from = $post['available_from'];
		$to = $post['available_to'];

		$this->db->select('*')
			->from('sponsor_meeting_availability')
			->where(array('project_id'=>$this->project->id, 'booth_id'=>$this->booth_id, 'sponsor_admin_id'=>$this->sponsor_id, ))
			->where("('".$from."' between available_from AND available_to) OR ('".$to."' between available_from AND available_to)")
			;
		$qstr = $this->db->get();
		if($qstr->num_rows() > 0 ){
			return false;
		}else{
			return true;
		}
	}

	function get_availability_list(){
		$this->db->select('*')
			->from('sponsor_meeting_availability')
			->where('project_id',$this->project->id)
			->where('booth_id',$this->booth_id)
			->where('sponsor_admin_id',$this->sponsor_id);
			$result = $this->db->get();
			if($result->num_rows()>0 ){
				$json_array = array('status'=>'success','result'=>$result->result());
			}else{
				$json_array = array('status'=>'error');
			}
			return json_encode($json_array);
	}

	function delete_availability(){
		$post = $this->input->post();
		return $this->db->delete('sponsor_meeting_availability',array('id'=>$post['availability_id']));
	}

	function get_calendar_events(){
		$this->db->select('smb.day_time_start as start, smb.day_time_end as end, u.name as title, u.id as attendee_id')
			->from('sponsor_meeting_booking smb')
			->join('user u','smb.user_id = u.id')

			->where('sponsor_admin_id', $this->sponsor_id)
			->where('booth_id',$this->booth_id)
			->where('project_id', $this->project->id)
;
		$result = $this->db->get();
		if($result->num_rows() > 0){

			$json_array = array('status'=>'success', 'result'=> $result->result());
		}else{
			$json_array = array('status'=>'error' );
		}
		return json_encode($json_array);
	}

	function clear_group_chat(){
			$data = array(
				'booth_id'=>$this->booth_id,
				'project_id'=>$this->project->id
			);
			$this->db->where($data);
			$this->db->update('sponsor_group_chat',array('cleared'=>1));

		if (!$this->db->affected_rows()) {
			$result = 'Group chat already empty';
		} else {
			$result = 'success';
		}
		return $result;
	}

	function copy_from_group_chat(){
		$post = $this->input->post();
			$this->db->select('*')
				->from('sponsor_group_chat')
				->where('cleared',0)
				;
			$result = $this->db->get();
//			return $result->result();
			if($result->num_rows() > 0 ){
				$data_array = array();
				foreach ($result->result() as $data){
					$this->db->select('*')
						->from('saved_group_chat')
						->where('sponsor_group_chat_id ', $data->id);
					$duplicate = $this->db->get();

					if($duplicate->num_rows() < 1){

						$insert = $this->db->insert('saved_group_chat',
							array(
								'sponsor_group_chat_id'=>$data->id,
								'project_id'=>$data->project_id,
								'booth_id'=>$data->booth_id,
								'sponsor_admin_id'=>$this->sponsor_id,
								'name'=>$post['backup_name'],
								'chat_from'=>$data->chat_from,
								'chat_text'=>$data->chat_text,
								'date_time'=>$data->date_time,
								'save_date_time'=>date('Y-m-d H:i:s')
							));
					}else{
						return array('status'=> 'no_update', 'message'=>'Chats already saved');
					}
				}
				if($insert){
					return array('status'=> 'success', 'message'=>'Chat saved successfully');
				}else{
					return array('status'=> 'error', 'message'=> 'Chat is empty');
				}

			}else{
				return array('status'=> 'error', 'message'=> 'Chat is empty');
			}
	}

	function get_saved_group_chats()
	{
		$post = $this->input->post();
		$this->db->select('*')
			->from('saved_group_chat sgc')
			->join('user u', 'sgc.chat_from = u.id', 'left')
			->where('sgc.project_id', $this->project->id)
			->where('sgc.booth_id', $this->booth_id)
			->where('sgc.sponsor_admin_id', $this->sponsor_id)
			->order_by('sgc.id', 'asc');

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			$json_array = array('status' => 'success', 'result' => $result->result());
		} else {
			$json_array = array('status' => 'empty');
		}
		return json_encode($json_array);
	}

	function delete_saved_chats(){
		return $this->db->delete('saved_group_chat',array('sponsor_admin_id'=>$this->sponsor_id, 'booth_id'=>$this->booth_id, 'project_id'=>$this->project->id));
	}
}
