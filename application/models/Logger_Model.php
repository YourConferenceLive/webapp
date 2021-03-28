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
}
