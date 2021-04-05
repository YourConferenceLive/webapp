<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  project
 */
class Account_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function register()
	{
		try
		{
			$post = $this->input->post();

			if (!isset($post['name']) || $post['name'] == '')
				throw new Exception("Missing or empty name");
			if (!isset($post['surname']) || $post['surname'] == '')
				throw new Exception("Missing or empty surname");
			if (!isset($post['email']) || $post['email'] == '')
				throw new Exception("Missing or empty email");
			if (!isset($post['password']) || $post['password'] == '')
				throw new Exception("Missing or empty password");

			$project_id = $this->project->id;
			$name = $post['name'];
			$surname = $post['surname'];
			$email = $post['email'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);


		}
		catch(Exception $error)
		{
			return array('status'=>'error', 'msg'=>'Missing required parameters', 'error'=>$error->getMessage());
		}

		$this->db->trans_begin();

		$data = array(
			'name' => $name,
			'surname' => $surname,
			'email' => $email,
			'password' => $password,
			'created_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('user', $data);

		if ($this->db->affected_rows() > 0) {

			$user_id = $this->db->insert_id();
			$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$project_id, 'level'=>'attendee'));

			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();

				return array('status'=>'error', 'msg'=>'Unable to register', 'error'=>$this->db->error());
			}
			else
			{
				$this->db->trans_commit();
				$this->logger->add($project_id, $user_id, 'Registered', 'As an attendee');
				return array('status'=>'success', 'msg'=>'Account created');
			}
		} else {
			return array('status'=>'error', 'msg'=>'Unable to register', 'error'=>$this->db->error());
		}
	}
}
