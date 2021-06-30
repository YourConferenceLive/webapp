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
		$this->db->select('user.id as user_id, user.name as user_fname, user.surname as user_surname, user.email, user.city, user.credentials, logs.*')
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
		$this->db->select('user.id as user_id, user.name as user_fname, user.surname as user_surname, user.email, user.city, user.credentials, logs.*')
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

	public function getScavengerHuntData()
	{
		$this->db->select('user.id, 
						   user.name, 
						   user.surname, 
						   user.email,
						   user.city, 
						   user.credentials, 
						   sponsor_booth.name AS booth_name, 
						   scavenger_hunt_items.icon_name,
						   max(scavenger_hunt_items.date) as last_collected')
				 ->from('scavenger_hunt_items')
				 ->join('user','user.id = scavenger_hunt_items.user_id')
				 ->join('sponsor_booth','sponsor_booth.id = scavenger_hunt_items.booth_id')
				 ->where('scavenger_hunt_items.id IN (SELECT MAX(`id`)
				 									  FROM scavenger_hunt_items 
				 									  GROUP BY user_id
				 									  HAVING COUNT(user_id) >= 10
				 									  ORDER BY `date` DESC)')
				 ->where('sponsor_booth.project_id', $this->project->id)
				 ->group_by('scavenger_hunt_items.user_id')
				 ->order_by('scavenger_hunt_items.id', 'DESC');

		$result 	= $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result();

		return new stdClass();
	}

	public function getBoothLogs($booth_id)
	{
		$this->db->select('user.name as user_fname, user.surname as user_surname, user.email, user.city, user.credentials, logs.*')
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

	public function getSponsorResourcesInBackpack($booth_id)
	{
		$this->db->select('user.id as user_id, user.name as user_fname, user.surname as user_surname, user.email, user.city, user.credentials, 
		sponsor_bag.resource_name, sponsor_bag.date_time as added_date_time')
			->from('sponsor_bag')
			->join('user','user.id = sponsor_bag.user_id')
			->where('sponsor_bag.booth_id', $booth_id)
			->order_by('sponsor_bag.date_time', 'desc')
		;
		$result = $this->db->get();
		if ($result->num_rows() > 0)
			return $result->result();
		return new stdClass();
	}
}
