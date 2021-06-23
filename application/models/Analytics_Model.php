<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('user_agent');
	}

	public function getAllProjectLogs()
	{
		$this->db->select('user.id as user_id, user.name as user_fname, user.surname as user_surname, user.email, logs.*')
			->from('logs')
			->join('user','user.id = logs.user_id')
			->where('logs.project_id', $this->project->id)
			->order_by('logs.date_time', 'desc')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result();
		return new stdClass();
	}

	public function getRelaxationZoneLogs()
	{
		$this->db->select('user.id as user_id, user.name as user_fname, user.surname as user_surname, user.email, logs.*')
			->from('logs')
			->join('user','user.id = logs.user_id')
			->where('logs.info', "Relaxation zone")
			->where('logs.project_id', $this->project->id)
			->order_by('logs.date_time', 'desc')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result();
		return new stdClass();
	}
}
