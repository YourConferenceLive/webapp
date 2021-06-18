<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

    public function getCount($eposter_id, $user_id)
    {
		$this->db->select("notes.id");
		$this->db->join('user', 'user.id = notes.user_id');
		$this->db->where('notes.origin_type_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('user.id', $user_id);
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);

		return $this->db->count_all_results('notes');
    }

	public function getAll($eposter_id, $user_id, $limit, $start)
	{
		$this->db->select('notes.id, notes.user_id, notes.note_text, notes.created_datetime');
		$this->db->from('notes');
		$this->db->join('user', 'user.id = notes.user_id');
		$this->db->where('notes.origin_type_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('user.id', $user_id);
		$this->db->where('notes.is_deleted', 0);
		$this->db->where('notes.status', 1);
		$this->db->order_by('notes.created_datetime', 'DESC');
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

	public function add()
	{		
		$post = $this->input->post();
		if ($post['notes'] != '' && $post['entity_type_id'] != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') {
			$data = array('project_id' 		=> $this->project->id,
						  'origin_type' 	=> 'eposter',
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
