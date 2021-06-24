<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credits_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
		$this->load->model('Logger_Model', 'logger');
	}

	public function getEposterCreditsCount($keyword)
	{
		$this->db->join('eposters', 'eposters.id = user_credits.origin_type_id');
		$this->db->where('eposters.status', 1);
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('user_credits.user_id', $this->user->user_id);
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

	public function getAllEposterCredits($start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('user_credits.id, user_credits.origin_type_id, eposters.title, eposters.type, user_credits.credit, user_credits.claimed_datetime');
		$this->db->from('user_credits');
		$this->db->join('eposters', 'eposters.id = user_credits.origin_type_id');
		$this->db->where('user_credits.user_id', $this->user->user_id);
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('user_credits.origin_type', 'eposter');
		$this->db->where('eposters.status', 1);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('eposters.title', $keyword);
			$this->db->or_like('eposters.type', $keyword);
    		$this->db->group_end();
		}

		if ($length > 0)
	     	$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
	    $this->db->group_by('user_credits.origin_type_id');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0) {
			return $eposters->result();
		}

		return new stdClass();
	}

	public function getSessionCreditsCount($session_type, $keyword)
	{
		$this->db->join('sessions', 'sessions.id = user_credits.origin_type_id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('user_credits.user_id', $this->user->user_id);
		$this->db->where('user_credits.origin_type', 'session');
		$this->db->where('sessions.session_type', $session_type);
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

	public function getAllSessionCredits($session_type, $start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('user_credits.id, user_credits.origin_type_id, sessions.name, sessions.session_type, user_credits.credit, user_credits.claimed_datetime');
		$this->db->from('user_credits');
		$this->db->join('sessions', 'sessions.id = user_credits.origin_type_id');
		$this->db->where('user_credits.user_id', $this->user->user_id);
		$this->db->where('user_credits.origin_type', 'session');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('sessions.session_type', $session_type);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('user_credits.id', $keyword);
			$this->db->or_like('user_credits.credit', $keyword);
			$this->db->or_like('user_credits.claimed_datetime', $keyword);
			$this->db->or_like('sessions.name', $keyword);
    		$this->db->group_end();
		}

		if ($length > 0)
	     	$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
	    $this->db->group_by('user_credits.origin_type_id');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0) {
			return $sessions->result();
		}

		return new stdClass();
	}

	public function getScavengerHuntItemsCount($keyword)
	{
		$this->db->join('sponsor_booth', 'sponsor_booth.id = scavenger_hunt_items.booth_id');
		$this->db->where('scavenger_hunt_items.user_id', $this->user->user_id);
		$this->db->where('sponsor_booth.project_id', $this->project->id);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('sponsor_booth.name', $keyword);
			$this->db->or_like('scavenger_hunt_items.date', $keyword);
    		$this->db->group_end();
		}

		return $this->db->count_all_results('scavenger_hunt_items');
	}

	public function getAllScavengerHuntItems($start, $length, $order_by, $order, $keyword)
	{
		$this->db->select('scavenger_hunt_items.id, sponsor_booth.name, scavenger_hunt_items.icon_name, scavenger_hunt_items.date');
		$this->db->from('scavenger_hunt_items');
		$this->db->join('sponsor_booth', 'sponsor_booth.id = scavenger_hunt_items.booth_id');
		$this->db->where('scavenger_hunt_items.user_id', $this->user->user_id);
		$this->db->where('sponsor_booth.project_id', $this->project->id);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('sponsor_booth.name', $keyword);
			$this->db->or_like('scavenger_hunt_items.date', $keyword);
    		$this->db->group_end();
		}

		if ($length > 0)
	     	$this->db->limit($length, $start);

	    $this->db->order_by($order_by, $order);
	    $this->db->group_by('sponsor_booth.id');
		$scavenger_hunt_item = $this->db->get();
		if ($scavenger_hunt_item->num_rows() > 0) {
			return $scavenger_hunt_item->result();
		}

		return new stdClass();
	}


	public function claim($origin_type, $origin_type_id, $credits)
	{
		if ($origin_type != '' && $origin_type_id != '' && $credits != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') :
			$data 	= array('origin_type'		=> $origin_type,
						  	'origin_type_id'	=> $origin_type_id,
						  	'user_id' 			=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
						  	'credit' 			=> $credits,
						  	'claimed_datetime'	=> date('Y-m-d H:i:s'));

			$insert 	= $this->db->insert_string('user_credits', $data);
			$insert 	= str_replace('INSERT INTO','INSERT IGNORE INTO',$insert);

			if ($this->db->query($insert)) :
				return true;
			else:
				return false;
			endif;
		else :
			return false;
		endif;
	}
}
