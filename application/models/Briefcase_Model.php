<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Briefcase_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Sessions_Model');
	}

	public function add($session_id)
	{
		$data = array('project_id' 		=> $this->project->id,
					  'user_id' 		=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
					  'session_id' 		=> strip_tags($session_id),
					  'added_datetime' 	=> date('Y-m-d H:i:s'));

		if ($this->db->insert('user_agenda', $data)) {
			return true;
		} else {
			return false;
		}
	}

	function getItinerariesCount()
	{
		$this->db->join('sessions', 'sessions.id = user_agenda.session_id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('user_agenda.user_id', $this->user->user_id);
		$this->db->where('user_agenda.project_id', $this->project->id);
		if ($keyword)
		{
			$this->db->like('user_agenda.id', $keyword);
			$this->db->or_like('sessions.name', $keyword);
			$this->db->or_like('user_agenda.added_datetime', $keyword);
		}
		return $this->db->count_all_results('user_agenda');
	}

	function getAgenda()
	{
		$this->db->select('user_agenda.id as agenda_id, sessions.*, session_tracks.name AS session_track');
		$this->db->from('user_agenda');
		$this->db->join('sessions', 'sessions.id = user_agenda.session_id');
		$this->db->join('session_tracks', 'session_tracks.id=sessions.track');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('user_agenda.user_id', $this->user->user_id);
		$this->db->where('user_agenda.project_id', $this->project->id);
		$this->db->order_by('sessions.start_date_time', 'ASC');$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		
		{
			foreach ($sessions->result() as $session)
			{
				$session->presenters = $this->Sessions_Model->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->Sessions_Model->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->Sessions_Model->getModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}

	function getItineraries($start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('user_agenda.id, user_agenda.session_id, sessions.name, user_agenda.added_datetime');
		$this->db->from('user_agenda');
		$this->db->join('sessions', 'sessions.id = user_agenda.session_id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('user_agenda.user_id', $this->user->user_id);
		$this->db->where('user_agenda.project_id', $this->project->id);

		if ($keyword)
		{
			$this->db->like('user_agenda.id', $keyword);
			$this->db->or_like('sessions.name', $keyword);
			$this->db->or_like('user_agenda.added_datetime', $keyword);
		}
     	$this->db->limit($length, $start);
	    $this->db->order_by($order_by, $order);
		$itinerary = $this->db->get();
		if ($itinerary->num_rows() > 0)
		{
			return $itinerary->result();
		}

		return new stdClass();
	}
}
