<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication_Model extends CI_Model
{
	function __construct() {
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function verifyLogin($project_id, $username, $password)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->where('user.email', $username);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0)
		{
			if (password_verify($password, $result->row()->password))
			{
				$user = $result->row();
				$user->access_levels = array();
				$this->db->select('level');
				$this->db->from('user_project_access');
				$this->db->where('user_id', $user->id);
				$this->db->where('project_id', $project_id);
				$result = $this->db->get();
				if ($result->num_rows() > 0)
				{
					foreach($result->result() as $row)
					{
						if ($row->level == 'moderator')
							$user->access_levels[] = 'presenter';
						else
							$user->access_levels[] = $row->level;

					}

					$result = $this->db->select('homepage_redirect')
						->from('attendee_view_settings')
						->where('project_id',$project_id)
						->get();
					if($result->num_rows()>0){
						$homepage_redirect = $result->result()[0];
					}else {
						$homepage_redirect = 'lobby';
					}

					return array('status'=>true, 'msg'=>"Login successful", 'user'=>$user, 'homepage'=>$homepage_redirect);

				}else{
					$this->logger->add($project_id, $user->id, 'Access denied', "No access to the project");
					return array('status'=>false, 'msg'=>"You are not authorized to access this project");
				}
			}else{
				return array('status'=>false, 'msg'=>"Incorrect username or password");
			}
		}

		return array('status'=>false, 'msg'=>"{$username} is not registered with us");
	}

	public function getBoothByUser($user_id)
	{
		$this->db->select('booth_id');
		$this->db->from('sponsor_booth_admin');
		$this->db->where('sponsor_booth_admin.user_id', $user_id);
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result()[0]->booth_id;
		return null;
	}

	public function update_user_token($user_id) {
		$token = $this->generateRandomString();
		$this->db->update("user", array("token" => $token), array("id" =>$user_id));
		return $token;
	}

	function generateRandomString($length = 8) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	function cco_auth_project_access($user_id){
		$project_access = $this->db->select('*')
			->from('user_project_access')
			->where('user_id', $user_id)
			->where('project_id', $this->project->id)
			->get();
		if($project_access->num_rows()>0){
			return $project_access->result()[0]->id;
		}
		$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'attendee'));
		return $this->db->insert_id();
	}
}
