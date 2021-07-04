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
		$this->db->select('logs.*, 
						   user.id as user_id, 
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email, 
						   user.city, 
						   user.credentials')
				 ->from('logs')
				 >join('user','user.id = logs.user_id')
				 ->where('logs.project_id', $this->project->id)
				 ->order_by('logs.date_time', 'desc')
				 ->limit(100);//For development purpose

		$result = $this->db->get();

		if ($result->num_rows() > 0)
			return $result->result();

		return new stdClass();
	}

	public function getRelaxationZoneLogs()
	{
		$this->db->select('logs.*,
						   user.id as user_id, 
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email, 
						   user.city, 
						   user.credentials')
				 ->from('logs')
				 ->join('user','user.id = logs.user_id')
				 ->where('logs.info', "Relaxation zone")
				 ->where('logs.project_id', $this->project->id)
				 ->order_by('logs.date_time', 'desc');

		$result = $this->db->get();

		if ($result->num_rows() > 0)
			return $result->result();

		return new stdClass();
	}

	public function getLogsUniquevisitors($name=null, $info=null)
	{
		$this->db->select('COUNT(`id`) as `unique_visitors`')
				 ->from('`logs`')
				 ->where('`project_id`', $this->project->id)
				 ->group_by('user_id');

		if ($name!=null)
			$this->db->where('`name`', $name);

		if ($info!=null)
			$this->db->where('`info`', $info);

		$result 	= $this->db->get();

		if ($result->num_rows() > 0)
			return $result->num_rows();

		return 0;
	}

	public function getLogsDateStats($name=null, $info=null)
	{
		$this->db->select('COUNT(`id`) as `total_rows`,
						   DATE_FORMAT(`date_time`, \'%Y-%m-%d\') as `date`')
				 ->from('`logs`')
				 ->where('`project_id`', $this->project->id)
				 ->group_by('EXTRACT(DAY FROM `date_time`)')
				 ->order_by('`date_time`', 'ASC');

		if ($name!=null)
			$this->db->where('`name`', $name);

		if ($info!=null)
			$this->db->where('`info`', $info);

		$result 	= $this->db->get();

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
		$this->db->select('logs.*,
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email, 
						   user.city, 
						   user.credentials')
				 ->from('logs')
				 ->join('user','user.id = logs.user_id')
				 ->where('logs.info', 'Booth')
				 ->where('logs.ref_1', $booth_id)
				 ->order_by('logs.date_time', 'desc');

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
				 ->where('logs.ref_1', $booth_id);

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
		$this->db->select('user.id as user_id, 
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email, user.city, 
						   user.credentials, 
						   sponsor_bag.resource_name, 
						   sponsor_bag.date_time as added_date_time')
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

	public function getAllSessionsCreditsCount($session_type, $keyword)
	{
		$this->db->join('sessions', 'sessions.id = user_credits.origin_type_id');
		$this->db->join('user', 'user.id = user_credits.user_id');
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->where('user.active', 1);
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('user_credits.origin_type', 'session');
		$this->db->where_in('sessions.session_type', (($session_type == 'stc') ? array($session_type) : array($session_type, 'zm') ) );

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('sessions.name', $keyword);
    		$this->db->group_end();
		}

		return $this->db->count_all_results('user_credits');
	}

	public function getAllSessionsCredits($session_type, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('user_credits.id, 
						   user_credits.origin_type_id, 
						   sessions.name AS session_name, 
						   sessions.session_type, 
						   sessions.start_date_time, 
						   user_credits.claimed_datetime, 
						   sessions.end_date_time, 
						   user_credits.credit, 
						   user.rcp_number, 
						   IF(`sessions`.`start_date_time`<`user_credits`.`claimed_datetime` AND `sessions`.`end_date_time`>`user_credits`.`claimed_datetime`, "Live&nbsp;Meeting&nbsp;Credit", "Post&nbsp;Meeting&nbsp;Credit") AS `credit_filter`, 
						   user.name,
						   user.surname');
		$this->db->from('user_credits');
		$this->db->join('sessions', 'sessions.id = user_credits.origin_type_id');
		$this->db->join('user', 'user.id = user_credits.user_id');
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->where('user.active', 1);
		$this->db->where('user_credits.origin_type', 'session');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where_in('sessions.session_type', (($session_type == 'stc') ? array($session_type) : array($session_type, 'zm') ) );

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user.rcp_number', $keyword);
			$this->db->or_like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('sessions.name', $keyword);
    		$this->db->group_end();
		}

		if ($length > 0)
	     	$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0) {
			return $sessions->result();
		}

		return new stdClass();
	}

	public function getAllEpostersCreditsCount($keyword)
	{
		$this->db->join('eposters', 'eposters.id = user_credits.origin_type_id');
		$this->db->join('user', 'user.id = user_credits.user_id');
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('user.active', 1);
		$this->db->where('eposters.status', 1);
		$this->db->where('user_credits.origin_type', 'eposter');

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('eposters.title', $keyword);
    		$this->db->group_end();
		}

		return $this->db->count_all_results('user_credits');
	}

	public function getAllEpostersCredits($start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('user_credits.id, 
						   user_credits.origin_type_id, 
						   user_credits.origin_type_id, 
						   eposters.title, 
						   eposters.type, 
						   user_credits.credit, 
						   user.rcp_number, 
						   IF(\'2021-06-24 00:00:00>\'<`user_credits`.`claimed_datetime` AND \'2021-06-27 23:59:59\'>`user_credits`.`claimed_datetime`, "Live&nbsp;Meeting&nbsp;Credit", "Post&nbsp;Meeting&nbsp;Credit") AS `credit_filter`, 
						   user.name, 
						   user.surname, 
						   user_credits.claimed_datetime');
		$this->db->from('user_credits');
		$this->db->join('eposters', 'eposters.id = user_credits.origin_type_id');
		$this->db->join('user', 'user.id = user_credits.user_id');
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('user_credits.origin_type', 'eposter');
		$this->db->where('eposters.status', 1);
		$this->db->where('user.active', 1);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user.rcp_number', $keyword);
			$this->db->or_like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('eposters.title', $keyword);
			$this->db->or_like('eposters.type', $keyword);
    		$this->db->group_end();
		}

		if ($length > 0)
	     	$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0) {
			return $eposters->result();
		}

		return new stdClass();
	}

	/**
	 * @param null|string $name - what
	 * @param null|string $info - where
	 * @param null|int $ref_id - either null or a item ID like session ID
	 * @param string $day - either 'all' or a particular day like 2021-06-24
	 * @param bool|int $unique_user - false for all, true for unique, user_id for a particular user
	 * @return object
	 */
	public function getLogs($name=null, $info=null, $ref_id=null, $day='all', $unique_user=false)
	{
		$this->db->select('logs.*,
						   user.id as user_id,
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email,
						   user.city,
						   user.credentials')
				 ->from('logs')
				 ->join('user','user.id = logs.user_id')
				 ->where('logs.project_id', $this->project->id)
				 ->order_by('logs.date_time', 'desc');

		if ($name!=null)
			$this->db->where('logs.name', $name);

		if ($info!=null)
			$this->db->where('logs.info', $info);

		if ($ref_id!=null)
			$this->db->where('logs.ref_1', $ref_id);

		if ($day!='all' && DateTime::createFromFormat('Y-m-d', $day)!=false)
			$this->db->like('logs.date_time', $day);

		if ($unique_user===true)
			$this->db->group_by('logs.user_id');

		if (is_numeric($unique_user))
			$this->db->where('logs.user_id', $unique_user);

		// $this->db->limit(100);//For development purpose

		$result = $this->db->get();

		return ($result->num_rows() > 0) ? $result->result() : new stdClass();
	}
}
