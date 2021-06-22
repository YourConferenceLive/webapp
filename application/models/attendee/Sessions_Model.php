<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('project_id', $this->project->id);
		$this->db->order_by('start_date_time');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getById($session_id)
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('id', $session_id);
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result()[0];

		return new stdClass();
	}
}
