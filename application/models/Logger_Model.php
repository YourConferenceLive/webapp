<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('user_agent');
	}

	public function add($project_id, $user_id, $name, $info=null, $ref_1=null, $ref_2=null)
	{
		$log = array(
			'project_id' => $project_id,
			'user_id' => $user_id,
			'name' => $name,
			'info' => $info,
			'ref_1' => $ref_1,
			'ref_2' => $ref_2,
			'browser' => $this->agent->browser(),
			'browser_version' => $this->agent->version(),
			'os' => $this->agent->platform(),
			'ip' => $this->input->ip_address(),
			'date_time' => date('Y-m-d H:i:s')
		);

		$this->db->insert('logs', $log);

		if ($this->db->affected_rows() > 0)
			return true;
		return false;

	}

	public function log_visit($page_name, $ref_1=null)
	{
		$project_id = $this->project->id;
		$user_id = $_SESSION['project_sessions']["project_{$project_id}"]['user_id'];

		$log = array(
			'project_id' => $project_id,
			'user_id' => $user_id,
			'name' => 'Visit',
			'info' => $page_name,
			'ref_1' => $ref_1,
			'browser' => $this->agent->browser(),
			'browser_version' => $this->agent->version(),
			'os' => $this->agent->platform(),
			'ip' => $this->input->ip_address(),
			'date_time' => date('Y-m-d H:i:s')
		);

		$this->db->insert('logs', $log);

		if ($this->db->affected_rows() > 0)
			return true;
		return false;

	}

	public function app_event($project_id, $user_id, $name, $info=null, $ref_1=null, $ref_2=null)
	{
		$log = array(
			'project_id' => $project_id,
			'user_id' => $user_id,
			'name' => $name,
			'info' => $info,
			'ref_1' => $ref_1,
			'ref_2' => $ref_2,
			'browser' => $this->agent->browser(),
			'browser_version' => $this->agent->version(),
			'os' => $this->agent->platform(),
			'ip' => $this->input->ip_address(),
			'date_time' => date('Y-m-d H:i:s')
		);

		$this->db->insert('logs', $log);

		if ($this->db->affected_rows() > 0)
			return true;
		return false;

	}

	public function getBoothLogs($booth_id)
	{
		$this->db->select('user.name as user_fname, user.surname as user_surname, user.email, logs.*')
			->from('logs')
			->join('user','user.id = logs.user_id')
			->where('logs.info', 'Booth')
			->where('logs.ref_1', $booth_id)
			->order_by('logs.date_time', 'desc')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result();
		return new stdClass();
	}

	public function getTotalBoothVisits($booth_id)
	{
		$this->db->select('logs.*')
			->from('logs')
			->where('logs.info', 'Booth')
			->where('logs.name', 'Visit')
			->where('logs.ref_1', $booth_id)
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return sizeof($result->result());
		return 0;
	}

	public function getUniqueBoothVisits($booth_id)
	{
		$this->db->select('logs.*')
			->from('logs')
			->where('logs.info', 'Booth')
			->where('logs.name', 'Visit')
			->where('logs.ref_1', $booth_id)
			->group_by('logs.user_id')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return sizeof($result->result());
		return 0;
	}

	public function getReturningBoothVisits($booth_id)
	{
		$this->db->select('logs.user_id')
			->from('logs')
			->where('logs.info', 'Booth')
			->where('logs.name', 'Visit')
			->where('logs.ref_1', $booth_id)
			->group_by('logs.user_id')
			->having('COUNT(logs.user_id) > 1')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return sizeof($result->result());
		return 0;
	}

	public function getTotalResourceDownloads($booth_id)
	{
		$this->db->select('logs.*')
			->from('logs')
			->where('logs.info', 'Booth')
			->where('logs.name', 'Resource to briefcase')
			->where('logs.ref_1', $booth_id)
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return sizeof($result->result());
		return 0;
	}
}
