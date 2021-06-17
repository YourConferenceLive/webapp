<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

	/**
	 * @param $rows
	 * @return array|string[]
	 *
	 * Column A = Name
	 * Column B = Surname
	 * Column C = Email
	 * Column D = Credentials
	 * Column E = Disclosures
	 */
	public function importUsers($rows)
	{
		$this->db->trans_begin();

		foreach ($rows as $row_num => $row)
		{
			if (!isset($row['A']) || $row['A'] == '')
				return array('status'=>'error', 'msg'=>'Unable to import', 'error'=>"No name found in row: {$row_num} column: A");

			if (!isset($row['B']) || $row['B'] == '')
				return array('status'=>'error', 'msg'=>'Unable to import', 'error'=>"No surname found in row: {$row_num} column: B");

			if (!isset($row['C']) || $row['C'] == '')
				return array('status'=>'error', 'msg'=>'Unable to import', 'error'=>"No email found in row: {$row_num} column: C");

			$data = array(
				'name' => $row['A'],
				'surname' => $row['B'],
				'email' => $row['C'],
				'password' => password_hash('COS2021', PASSWORD_DEFAULT),
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => 17
			);

			if (isset($row['D']) && $row['D'] != '')
				$data['credentials'] = $row['D'];
			if (isset($row['E']) && $row['E'] != '')
				$data['disclosures'] = $row['E'];

			$this->db->insert('user', $data);

			if ($this->db->affected_rows() > 0) {

				$user_id = $this->db->insert_id();
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'presenter'));
				$this->logger->add($this->project->id, $user_id, 'Registered', 'As an attendee');

			} else {
				return array('status'=>'error', 'msg'=>'Unable to register', 'error'=>$this->db->error());
			}
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return array('status'=>'error', 'msg'=>'Unable to register', 'error'=>$this->db->error());
		}
		else
		{
			$this->db->trans_commit();
			return array('status'=>'success', 'msg'=>'Import successful');
		}
	}

	public function resetPasswordsOfAll($access_level)
	{

		$user_ids = $this->db
			->select('user_id')
			->where('project_id', $this->project->id)
			->where('level', $access_level)
			->group_by('user_id')
			->get_compiled_select('user_project_access', true);

		$this->db->set('password', password_hash('COS2021', PASSWORD_DEFAULT));
		$this->db->where('id IN ('.$user_ids.')');
		$this->db->update("user");

	}
}
