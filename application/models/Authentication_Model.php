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

					return array('status'=>true, 'msg'=>"Login successful", 'user'=>$user);

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
}
