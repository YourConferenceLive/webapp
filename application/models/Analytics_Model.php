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

	public function getSessionAttendeesDt()
	{
		$post = $this->input->post();

		$this->db->select('sessions.id AS session_id,
						   sessions.name AS session_name,
						   COUNT(DISTINCT logs.user_id) AS total_attendees')
				 ->from('sessions')
				 ->join('logs', 'sessions.id = logs.ref_1', 'left')
				 ->where('sessions.project_id', $this->project->id)
				 ->where('logs.info', 'Session Join')
				 ->where('sessions.session_type', 'zm')
				 ->group_by('sessions.id');

		// Get total number of rows without filtering
		$tempDbObj = clone $this->db;
		$total_results = $tempDbObj->count_all_results();

		// Column Search
		foreach ($post['columns'] as $column)
		{
			if ($column['search']['value']!='')
				$this->db->like($column['name'], $column['search']['value']);
		}

		$tempDbObj = clone $this->db;
		$total_filtered_results = $tempDbObj->count_all_results();

		// Filter for pagination and rows per page
		if (isset($post['start']) && isset($post['length']))
			$this->db->limit($post['length'], $post['start']);

		// Dynamic sort
		$this->db->order_by($post['columns'][$post['order'][0]['column']]['name'], $post['order'][0]['dir']);

		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			$response_array = array(
				"draw" => $post['draw'],
				"recordsTotal" => $total_results,
				"recordsFiltered" => $total_filtered_results,
				"data" => $result->result()
			);

			return json_encode($response_array);
		}

		$response_array = array(
			"draw" => $post['draw'],
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => new stdClass()
		);

		return json_encode($response_array);
	
	}

	public function getSessionQuestionsDt()
	{
		$post = $this->input->post();

		$this->db->select('sessions.id AS session_id,
						   sessions.name AS session_name,
						   COUNT(session_questions.id) AS total_questions')
				 ->from('sessions')
				 ->join('session_questions', 'sessions.id = session_questions.session_id', 'left')
				 ->where('sessions.project_id', $this->project->id)
				 ->where('sessions.session_type', 'gs')
				 ->group_by('sessions.id');

		// Get total number of rows without filtering
		$tempDbObj = clone $this->db;
		$total_results = $tempDbObj->count_all_results();

		// Column Search
		foreach ($post['columns'] as $column)
		{
			if ($column['search']['value']!='')
				$this->db->like($column['name'], $column['search']['value']);
		}

		$tempDbObj = clone $this->db;
		$total_filtered_results = $tempDbObj->count_all_results();

		// Filter for pagination and rows per page
		if (isset($post['start']) && isset($post['length']))
			$this->db->limit($post['length'], $post['start']);

		// Dynamic sort
		$this->db->order_by($post['columns'][$post['order'][0]['column']]['name'], $post['order'][0]['dir']);

		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			$response_array = array(
				"draw" => $post['draw'],
				"recordsTotal" => $total_results,
				"recordsFiltered" => $total_filtered_results,
				"data" => $result->result()
			);

			return json_encode($response_array);
		}

		$response_array = array(
			"draw" => $post['draw'],
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => new stdClass()
		);

		return json_encode($response_array);
	}

	public function getEpostersLogsDt()
	{
		$post = $this->input->post();

		$this->db->select('eposters.id,
						   CONCAT_WS(" ", user.name, user.surname, user.credentials) AS author,
						   eposters.title,
						   REPLACE(REPLACE(eposters.type, \'surgical_video\', \'Surgical Video\'), \'eposter\', \'ePoster\') as type,
						   COUNT(DISTINCT logs.user_id) AS total_vistors')
				 ->from('eposters')
				 ->join('eposter_authors', 'eposters.id = eposter_authors.eposter_id')
				 ->join('user', 'eposter_authors.user_id = user.id')
				 ->join('logs', 'eposters.id = logs.ref_1', 'left')
				 ->where('logs.info', 'ePoster View')
				 ->where('eposters.project_id', $this->project->id)
				 ->group_by('eposters.id');

		// Get total number of rows without filtering
		$tempDbObj = clone $this->db;
		$total_results = $tempDbObj->count_all_results();

		// Column Search
		foreach ($post['columns'] as $column)
		{
			if ($column['name'] == 'author' && $column['search']['value']!='') {
	    		$this->db->group_start();
				$this->db->like('user.name',$column['search']['value']);
				$this->db->or_like('user.surname',$column['search']['value']);
				$this->db->or_like('user.credentials',$column['search']['value']);
	    		$this->db->group_end();
			} elseif ($column['search']['value']!='')
				$this->db->like($column['name'], $column['search']['value']);
		}

		$tempDbObj = clone $this->db;
		$total_filtered_results = $tempDbObj->count_all_results();

		// Filter for pagination and rows per page
		if (isset($post['start']) && isset($post['length']))
			$this->db->limit($post['length'], $post['start']);

		// Dynamic sort
		$this->db->order_by($post['columns'][$post['order'][0]['column']]['name'], $post['order'][0]['dir']);

		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			$response_array = array(
				"draw" => $post['draw'],
				"recordsTotal" => $total_results,
				"recordsFiltered" => $total_filtered_results,
				"data" => $result->result()
			);

			return json_encode($response_array);
		}

		$response_array = array(
			"draw" => $post['draw'],
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => new stdClass()
		);

		return json_encode($response_array);
	}

	public function getLogsDt()
	{
		$post = $this->input->post();

		$this->db->select('logs.*,
						   user.name as user_fname, 
						   user.surname as user_surname, 
						   user.email,
						   user.city,
						   user.credentials,
						   sponsor_booth.name as company_name')
				 ->from('logs')
				 ->join('user','user.id = logs.user_id')
				 ->join('sponsor_booth_admin', 'logs.user_id = sponsor_booth_admin.user_id', 'left')
			     ->join('sponsor_booth', 'sponsor_booth_admin.booth_id = sponsor_booth.id', 'left')
				 ->where('logs.project_id', $this->project->id);

		if (isset($post['logPlace']) && $post['logPlace'] == 'Booth') // For booth analytics
			$this->db
				->select('booth.name as booth_name')
				->join('sponsor_booth as booth', 'logs.ref_1 = booth.id');

		if (isset($post['logPlace']) && $post['logPlace']!='')
			$this->db->where('logs.info', $post['logPlace']);

		if (isset($post['logType']) && $post['logType']!='')
			$this->db->where('logs.name', $post['logType']);

		if (isset($post['ref1']) && $post['ref1']!='')
			$this->db->where('logs.ref_1', $post['ref1']);

		// Get total number of rows without filtering
		$tempDbObj = clone $this->db;
		$total_results = $tempDbObj->count_all_results();

		// Days filter
		if (isset($post['logDays']) && $post['logDays']!='all' && DateTime::createFromFormat('Y-m-d', $post['logDays'])!=false)
			$this->db->like('logs.date_time', $post['logDays']);

		// Unique user filter
		if (isset($post['logUserUniqueness']) && $post['logUserUniqueness']=='unique')
			$this->db->group_by('logs.user_id');

		// Column Search
		foreach ($post['columns'] as $column)
		{
			if ($column['search']['value']!='')
				$this->db->like($column['name'], $column['search']['value']);
		}

		$tempDbObj = clone $this->db;
		$total_filtered_results = $tempDbObj->count_all_results();

		// Filter for pagination and rows per page
		if (isset($post['start']) && isset($post['length']))
			$this->db->limit($post['length'], $post['start']);

		// Dynamic sort
		$this->db->order_by($post['columns'][$post['order'][0]['column']]['name'], $post['order'][0]['dir']);

		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			$response_array = array(
				"draw" => $post['draw'],
				"recordsTotal" => $total_results,
				"recordsFiltered" => $total_filtered_results,
				"data" => $result->result()
			);

			return json_encode($response_array);
		}

		$response_array = array(
			"draw" => $post['draw'],
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => new stdClass()
		);

		return json_encode($response_array);
	}
}
