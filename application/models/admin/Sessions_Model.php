<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];
		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllSessionsByPresenter($presenter_id)
	{
		$this->db->select('sessions.*');
		$this->db->from('sessions');
		$this->db->join('session_presenters', 'session_presenters.session_id = sessions.id');
		$this->db->where('session_presenters.presenter_id', $presenter_id);
		$this->db->where('sessions.project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getById($id)
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('id', $id);
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			$sessions->result()[0]->presenters = $this->getPresentersPerSession($id);
			return $sessions->result()[0];
		}

		return new stdClass();
	}

	public function getAllTracks()
	{
		$this->db->select('*');
		$this->db->from('session_tracks');
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function add()
	{
		$session_data = $this->input->post();

		// Upload session photo if set
		$session_photo = '';
		if (isset($_FILES['sessionPhoto']) && $_FILES['sessionPhoto']['name'] != '')
		{
			$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$photo_config['file_name'] = $session_photo = rand().'_'.str_replace(' ', '_', $_FILES['sessionPhoto']['name']);
			$photo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/thumbnails/';

			$this->load->library('upload', $photo_config);
			if ( ! $this->upload->do_upload('sessionPhoto'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session photo', 'technical_data'=>$this->upload->display_errors());
		}

		$start_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['startDateTime']);
		$start_time_mysql = $start_time_object->format('Y-m-d H:i:s');

		$end_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['endDateTime']);
		$end_time_mysql = $end_time_object->format('Y-m-d H:i:s');


		$data = array(
			'project_id' => $this->project->id,
			'name' => $session_data['sessionName'],
			'other_language_name' => $session_data['sessionNameOther'],
			'description' => $session_data['sessionDescription'],
			'thumbnail' => $session_photo,
			'agenda' => $session_data['sessionAgenda'],
			'track' => $session_data['sessionTrack'],
			'millicast_stream' => $session_data['millicastStream'],
			'presenter_embed_code' => $session_data['slidesHtml'],
			'zoom_link' => $session_data['zoomLink'],
			'start_date_time' => $start_time_mysql,
			'end_date_time' => $end_time_mysql
		);

		$this->db->insert('sessions', $data);

		if ($this->db->affected_rows() > 0)
		{
			$session_id = $this->db->insert_id();

			foreach ($session_data['sessionPresenters'] as $presenter_id)
			{
				$data = array(
					'presenter_id' => $presenter_id,
					'session_id' => $session_id,
					'added_on' => date('Y-m-d H:i:s'),
					'added_by' => $this->user['user_id'],
				);

				$this->db->insert('session_presenters', $data);
			}

			return array('status' => 'success', 'session_id' => $this->db->insert_id());
		}

		return array('status' => 'failed', 'msg' => 'Error occurred', 'technical_data'=> $this->db->error());

	}

	public function update()
	{
		$session_data = $this->input->post();

		if (!isset($session_data['sessionId']) || $session_data['sessionId'] == 0)
			return array('status' => 'failed', 'msg'=>'No session(ID) selected', 'technical_data'=>'');

		// Upload session photo if set
		$session_photo = '';
		if (isset($_FILES['sessionPhoto']) && $_FILES['sessionPhoto']['name'] != '')
		{
			$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$photo_config['file_name'] = $session_photo = rand().'_'.str_replace(' ', '_', $_FILES['sessionPhoto']['name']);
			$photo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/thumbnails/';

			$this->load->library('upload', $photo_config);
			if ( ! $this->upload->do_upload('sessionPhoto'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session photo', 'technical_data'=>$this->upload->display_errors());
		}

		$start_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['startDateTime']);
		$start_time_mysql = $start_time_object->format('Y-m-d H:i:s');

		$end_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['endDateTime']);
		$end_time_mysql = $end_time_object->format('Y-m-d H:i:s');


		$data = array(
			'project_id' => $this->project->id,
			'name' => $session_data['sessionName'],
			'other_language_name' => $session_data['sessionNameOther'],
			'description' => $session_data['sessionDescription'],
			'thumbnail' => $session_photo,
			'agenda' => $session_data['sessionAgenda'],
			'track' => $session_data['sessionTrack'],
			'millicast_stream' => $session_data['millicastStream'],
			'presenter_embed_code' => $session_data['slidesHtml'],
			'zoom_link' => $session_data['zoomLink'],
			'start_date_time' => $start_time_mysql,
			'end_date_time' => $end_time_mysql
		);

		$this->db->set($data);
		$this->db->where('id', $session_data['sessionId']);
		$this->db->update('sessions');

		if ($this->db->affected_rows() > 0)
		{
			$session_id = $session_data['sessionId'];

			if (isset($session_data['sessionPresenters']))
			{
				$this->db->where('session_id', $session_id);
				$this->db->delete('session_presenters');

				foreach ($session_data['sessionPresenters'] as $presenter_id)
				{
					$data = array(
						'presenter_id' => $presenter_id,
						'session_id' => $session_id,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user['user_id'],
					);

					$this->db->insert('session_presenters', $data);
				}
			}

			$session = $this->db->get_where('sessions', array('id'=>$session_data['sessionId']))->result()[0];

			return array('status' => 'success', 'session_id' => $session_data['sessionId'], 'session' => $session);
		}

		return array('status' => 'warning', 'msg' => 'No changes made', 'technical_data'=> $this->db->error());

	}

	public function getAllPresenters()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('user_project_access', 'user_project_access.user_id = user.id');
		$this->db->where('user_project_access.project_id', $this->project->id);
		$this->db->group_by('user.id');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getPresentersPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_presenters', 'session_presenters.presenter_id = user.id');
		$this->db->where('session_presenters.session_id', $session_id);
		$this->db->group_by('user.id');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

}
