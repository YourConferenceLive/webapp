<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$user_ids = $this->db
			->select('user_id')
			->where('project_id', $this->project->id)
			->group_by('user_id')
			->get_compiled_select('user_project_access', true);

		$this->db->select('id, name, surname, email, active');
		$this->db->from('user');
		$this->db->where('id IN ('.$user_ids.')');
		$this->db->order_by("id", "desc");
		$users = $this->db->get();
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $user)
				$user->accesses = $this->getProjectAccesses($user->id);

			return $users->result();
		}

		return new stdClass();
	}

	public function getById($id)
	{
		$this->db->select('id, name, surname, email, active, bio, disclosures, photo');
		$this->db->from('user');
		$this->db->where('id', $id);
		$user = $this->db->get();
		if ($user->num_rows() > 0)
		{
			$user->result()[0]->accesses = $this->getProjectAccesses($user->result()[0]->id);
			return $user->result()[0];
		}

		return new stdClass();
	}

	public function create()
	{
		$post = $this->input->post();
		$user_photo_name = '';
		// Upload files if set
		if (isset($_FILES['user-photo']) && $_FILES['user-photo']['name'] != '')
		{
			$upload_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$upload_config['file_name'] = $user_photo_name = rand().'_'.str_replace(' ', '_', $_FILES['user-photo']['name']);
			$upload_config['upload_path'] = FCPATH.'cms_uploads/user_photo/profile_pictures/';

			$this->load->library('upload', $upload_config);
			if ( ! $this->upload->do_upload('user-photo'))
				return false;
			//print_r($this->upload->display_errors());
		}

		$data = array(
			'name' => $post['first_name'],
			'surname' => $post['surname'],
			'email' => $post['email'],
			'password' => password_hash($post['password'], PASSWORD_DEFAULT),
			'bio' => $post['bio'],
			'disclosures' => $post['disclosure'],
			'photo' => $user_photo_name,
			'created_on' => date('Y-m-d H:i:s'),
			'created_by' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],

		);
		$this->db->insert('user', $data);

		if ($this->db->affected_rows() > 0)
		{
			$user_id =$this->db->insert_id();

			if (isset($post['attendee_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'attendee'));
			if (isset($post['presenter_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'presenter'));
			if (isset($post['moderator_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'moderator'));
			if (isset($post['admin_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'admin'));
			if (isset($post['exhibitor_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'exhibitor'));

			return true;
		}

		return false;
	}

	public function update()
	{
		$post = $this->input->post();
		$user_photo_name = '';

		if (!isset($post['userId']) || $post['userId'] == 0)
			return array('status' => 'failed', 'msg'=>'No User(ID) selected', 'technical_data'=>'');

		// Upload files if set
		if (isset($_FILES['user-photo']) && $_FILES['user-photo']['name'] != '')
		{
			$upload_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$upload_config['file_name'] = $user_photo_name = rand().'_'.str_replace(' ', '_', $_FILES['user-photo']['name']);
			$upload_config['upload_path'] = FCPATH.'cms_uploads/user_photo/profile_pictures/';

			$this->load->library('upload', $upload_config);
			if ( ! $this->upload->do_upload('user-photo'))
				return false;
			//print_r($this->upload->display_errors());
		}


		$data = array(
			'email' => $post['email'],
			'name' => $post['first_name'],
			'surname' => $post['surname'],
			'bio' => $post['bio'],
			'disclosures' => $post['disclosure'],
			'photo' => $user_photo_name,
			'updated_on' => date('Y-m-d H:i:s'),
			'updated_by' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id']

		);
		$this->db->set($data);
		$this->db->where('id', $post['userId']);
		$this->db->update('user');

		if ($this->db->affected_rows() > 0)
		{
			$user_id = $post['userId'];

			$this->db->where('project_id', $this->project->id);
			$this->db->where('user_id', $user_id);
			$this->db->delete('user_project_access');

			if (isset($post['attendee_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'attendee'));
			if (isset($post['presenter_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'presenter'));
			if (isset($post['moderator_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'moderator'));
			if (isset($post['admin_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'admin'));
			if (isset($post['exhibitor_access']))
				$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'exhibitor'));

			return true;
		}

		return false;
	}

	public function delete($id)
	{
		$this->db->delete('sponsor_group_chat', array('booth_id' => $id));
		$this->db->delete('sponsor_attendee_chat', array('booth_id' => $id));
		$this->db->delete('sponsor_resource_management', array('booth_id' => $id));
		$this->db->delete('sponsor_bag', array('booth_id' => $id));
		$this->db->delete('sponsor_fishbowl', array('booth_id' => $id));
		$this->db->delete('sponsor_meeting_availability', array('booth_id' => $id));
		$this->db->delete('sponsor_meeting_booking', array('booth_id' => $id));
		$this->db->delete('sponsor_booth_admin', array('booth_id' => $id));

		$this->db->delete('sponsor_booth', array('id' => $id));

		return true;
	}

	public function getProjectAccesses($user_id)
	{
		return $this->db
			->select('level')
			->where(array('user_id' => $user_id, 'project_id' => $this->project->id))
			->from('user_project_access')
			->get()
			->result();
	}

	/**
	 * Returns true if email exists, otherwise false
	 *
	 * @param $email
	 * @return bool
	 */
	public function emailExists($email)
	{
		return
			($this->db
			->select('id')
			->where('email', $email)
			->from('user')
			->get()
			->num_rows()
			) > 0;
	}

	public function getAllAttendees()
	{
		$user_ids = $this->db
			->select('user_id')
			->where('level', 'attendee')
			->where('project_id', $this->project->id)
			->group_by('user_id')
			->get_compiled_select('user_project_access', true);

		$this->db->select('id, name, surname, email, active');
		$this->db->from('user');
		$this->db->where('id IN ('.$user_ids.')');
		$this->db->order_by("id", "desc");
		$users = $this->db->get();
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $user)
				$user->accesses = $this->getProjectAccesses($user->id);

			return $users->result();
		}

		return new stdClass();
	}

	public function getAllExhibitors()
	{
		$user_ids = $this->db
			->select('user_id')
			->where('level', 'exhibitor')
			->where('project_id', $this->project->id)
			->group_by('user_id')
			->get_compiled_select('user_project_access', true);

		$this->db->select('id, name, surname, email, active');
		$this->db->from('user');
		$this->db->where('id IN ('.$user_ids.')');
		$this->db->order_by('name', 'asc');
		$users = $this->db->get();
		if ($users->num_rows() > 0)
			return $users->result();

		return new stdClass();
	}

	public function getExhibitorsByBoothId($booth_id)
	{
		$user_ids = $this->db
			->select('user_id')
			->where('booth_id', $booth_id)
			->group_by('user_id')
			->get_compiled_select('sponsor_booth_admin', true);

		$this->db->select('id, name, surname, email, active');
		$this->db->from('user');
		$this->db->where('id IN ('.$user_ids.')');
		$this->db->order_by("id", "desc");
		$users = $this->db->get();
		if ($users->num_rows() > 0)
			return $users->result();

		return new stdClass();
	}

	public function getMyAgenda()
	{
		$user_id = $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'];

		$this->db
			->select('sessions.*')
			->from('user_agenda')
			->where('user_agenda.user_id', $user_id)
			->where('user_agenda.project_id', $this->project->id)
			->join('sessions', 'sessions.id = user_agenda.session_id')
			->order_by('start_date_time', 'ASC');

		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			$this->load->model('Sessions_Model', 'session_m');
			foreach ($sessions->result() as $session)
			{
				$session->presenters = $this->session_m->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->session_m->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->session_m->getModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}



}
