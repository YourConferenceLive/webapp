<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_Sessions_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}

	public function getAll()
	{
		$this->db->select('s.*, st.name as session_track');
		$this->db->from('sessions s');
		$this->db->join('session_tracks st', 's.track = st.id', 'left');
		$this->db->where('s.is_deleted', 0);
		$this->db->where('s.project_id', $this->project->id);
		$this->db->order_by('s.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
				$session->invisible_moderators = $this->getInvisibleModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}


	public function getUserBriefcasePerSession($session_id)
	{
		$this->db->select('*');
		$this->db->from('user_agenda');
		$this->db->where('project_id', $this->project->id);
		$this->db->where('session_id', $session_id);
		$this->db->where('user_id', $this->user->user_id);
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
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}


	public function getKeynoteSpeakersPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_keynote_speakers', 'session_keynote_speakers.speaker_id = user.id');
		$this->db->where('session_keynote_speakers.session_id', $session_id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getModeratorsPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_moderators', 'session_moderators.moderator_id = user.id');
		$this->db->where('session_moderators.session_id', $session_id);
		$this->db->where('session_moderators.is_invisible', 0);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getInvisibleModeratorsPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_moderators', 'session_moderators.moderator_id = user.id');
		$this->db->where('session_moderators.session_id', $session_id);
		$this->db->where('session_moderators.is_invisible', 1);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getResources($session_id)
	{
		$this->db->select("*");
		$this->db->from('session_resources');
		$this->db->where('session_id', $session_id);
		$this->db->where('is_active', 1);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}


	public function getById($id)
	{
//		print_r($id);
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('id', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			$sessions->result()[0]->briefcase = $this->getUserBriefcasePerSession($id);
			$sessions->result()[0]->presenters = $this->getPresentersPerSession($id);
			$sessions->result()[0]->keynote_speakers = $this->getKeynoteSpeakersPerSession($id);
			$sessions->result()[0]->moderators = $this->getModeratorsPerSession($id);
			$sessions->result()[0]->invisible_moderators = $this->getInvisibleModeratorsPerSession($id);
			$sessions->result()[0]->resources = $this->getResources($id);

			return $sessions->result()[0];
		}

		return new stdClass();
	}

	public function getSessionDetailsById($id)
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('id', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			$sessions->result()[0]->presenters = $this->getPresentersPerSession($id);
			$sessions->result()[0]->keynote_speakers = $this->getKeynoteSpeakersPerSession($id);
			$sessions->result()[0]->moderators = $this->getModeratorsPerSession($id);
			$sessions->result()[0]->invisible_moderators = $this->getInvisibleModeratorsPerSession($id);

			return $sessions->result()[0];
		}

		return new stdClass();
	}

	function get_session_resource($session_id) {
		$this->db->select('*');
		$this->db->from('session_resources');
		$this->db->where('session_id', $session_id);
//		$this->db->where('project_id', $this->project->id);
		$session_resource = $this->db->get();
		if ($session_resource->num_rows() > 0) {
			return $session_resource->result();
		} else {
			return '';
		}
	}
}
