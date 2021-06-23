<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
	}

    public function getCount($entitiy_type, $origin_type_id, $user_id)
    {
		$this->db->select("notes.id");
		$this->db->join('user', 'user.id = notes.user_id');
		$this->db->where('notes.origin_type_id', $origin_type_id);
		$this->db->where('user.active', 1);
		$this->db->where('user.id', $user_id);
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);
		$this->db->where('notes.origin_type', $entitiy_type);

		return $this->db->count_all_results('notes');
    }

	public function getAll($entitiy_type, $origin_type_id, $user_id, $limit = '', $start = '')
	{
		$this->db->select('notes.id, notes.user_id, notes.note_text, notes.created_datetime');
		$this->db->from('notes');
		$this->db->join('user', 'user.id = notes.user_id');
		$this->db->where('notes.origin_type_id', $origin_type_id);
		$this->db->where('notes.origin_type', $entitiy_type);
		$this->db->where('user.active', 1);
		$this->db->where('user.id', $user_id);
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);
		$this->db->order_by('notes.created_datetime', 'DESC');

		if ($limit != '' || $start != '')
			$this->db->limit($limit, $start);

		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0) {
			foreach ($eposters->result() as $eposter) {
				$then 			= new DateTime($eposter->created_datetime);
				$now 			= new DateTime();
				$delta 			= $now->diff($then);
				$quantities 	= array('year' 	=> $delta->y,
										'month' => $delta->m,
										'day' 	=> $delta->d,
										'hour' 	=> $delta->h,
										'minute' => $delta->i,
										'second' => $delta->s);

				$str 			= '';
				foreach($quantities as $unit => $value) {
					if($value == 0)
						continue;

				    $str .= $value . ' ' . $unit;

				    if($value != 1) {
				    	$str .= 's';
				    }

					$str .=  ', ';
				}

				$str_array = explode(', ', $str);
				$eposter->time = (($str == '') ? 'a moment ago' : $str_array[0].' ago' );
			}
			return $eposters->result();
		}
		return new stdClass();
	}

    public function getUserEpostersNotesCount($keyword)
    {
    	$this->db->select('notes.id');
		$this->db->join('eposters', 'eposters.id = notes.origin_type_id');
		$this->db->where('eposters.status', 1);
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('notes.origin_type', 'eposter');
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);
		$this->db->where('notes.user_id', $this->user->user_id);
	    $this->db->group_by('notes.origin_type_id');

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('notes.id', $keyword);
			$this->db->or_like('notes.note_text', $keyword);
			$this->db->or_like('notes.created_datetime', $keyword);
			$this->db->or_like('eposters.title', $keyword);
    		$this->db->group_end();
		}

		return $this->db->get('notes')->num_rows();
    }

    public function getAllUserEpostersNotes($start, $length, $order_by, $order, $keyword)
    {
		$this->db->select('notes.id, notes.origin_type_id, eposters.title, eposters.type, notes.note_text, notes.created_datetime');
		$this->db->from('notes');
		$this->db->join('eposters', 'eposters.id = notes.origin_type_id');
		$this->db->where('eposters.status', 1);
		$this->db->where('eposters.project_id', $this->project->id);
		$this->db->where('notes.user_id', $this->user->user_id);
		$this->db->where('notes.origin_type', 'eposter');
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('notes.id', $keyword);
			$this->db->or_like('notes.note_text', $keyword);
			$this->db->or_like('notes.created_datetime', $keyword);
			$this->db->or_like('eposters.title', $keyword);
			$this->db->or_like('eposters.type', $keyword);
    		$this->db->group_end();
		}

     	$this->db->limit($length, $start);
	    $this->db->order_by($order_by, $order);
	    $this->db->group_by('notes.origin_type_id');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0) {
			return $eposters->result();
		}

		return new stdClass();
    }

    public function getUserSessionsNotesCount($keyword)
    {
    	$this->db->select('notes.id');
		$this->db->join('sessions', 'sessions.id = notes.origin_type_id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->where('notes.origin_type', 'session');
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);
		$this->db->where('notes.user_id', $this->user->user_id);
	    $this->db->group_by('notes.origin_type_id');

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('notes.id', $keyword);
			$this->db->or_like('notes.note_text', $keyword);
			$this->db->or_like('notes.created_datetime', $keyword);
			$this->db->or_like('sessions.name', $keyword);
    		$this->db->group_end();
		}

		return $this->db->get('notes')->num_rows();
    }

    public function getAllUserSessionsNotes($start, $length, $order_by, $order, $keyword)
    {
		$this->db->select('notes.id, notes.origin_type_id, sessions.name, notes.note_text, notes.created_datetime');
		$this->db->from('notes');
		$this->db->join('sessions', 'sessions.id = notes.origin_type_id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->where('notes.user_id', $this->user->user_id);
		$this->db->where('notes.origin_type', 'session');
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);

		if ($keyword)
		{
    		$this->db->group_start();
			$this->db->like('notes.id', $keyword);
			$this->db->or_like('notes.note_text', $keyword);
			$this->db->or_like('notes.created_datetime', $keyword);
			$this->db->or_like('sessions.name', $keyword);
    		$this->db->group_end();
		}

     	$this->db->limit($length, $start);
	    $this->db->order_by($order_by, $order);
	    $this->db->group_by('notes.origin_type_id');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0) {
			return $eposters->result();
		}

		return new stdClass();
    }

	public function add($entity_type)
	{
		$post = $this->input->post();
		if ($post['notes'] != '' && $entity_type != '' && $post['entity_type_id'] != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') {
			$data = array('project_id' 		=> $this->project->id,
						  'origin_type' 	=> strip_tags($entity_type),
						  'origin_type_id' 	=> strip_tags($post['entity_type_id']),
						  'user_id' 		=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
						  'note_text' 		=> strip_tags($post['notes']),
						  'is_deleted' 		=> 0,
						  'status' 			=> 1,
						  'created_datetime' => date('Y-m-d H:i:s'),
						  'updated_datetime' => date('Y-m-d H:i:s'));

			if ($this->db->insert('notes', $data)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
