<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

    public function getCount($eposter_id)
    {
		$this->db->select("eposter_comments.idr");
		$this->db->join('user', 'user.id = eposter_comments.user_id');
		$this->db->where('eposter_comments.eposter_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('eposter_comments.is_deleted', 0);
		$this->db->where('eposter_comments.status', 1);

		return $this->db->count_all_results('eposter_comments');
    }

	public function getAll($eposter_id, $limit, $start)
	{
		// die($eposter_id.', '.$limit.', '.$start);
		$this->db->select('eposter_comments.id, eposter_comments.user_id, eposter_comments.comment, eposter_comments.created_datetime, CONCAT_WS(" ", user.credentials, user.name, user.surname) AS commenter, user.photo as avatar');
		$this->db->from('eposter_comments');
		$this->db->join('user', 'user.id = eposter_comments.user_id');
		$this->db->where('eposter_comments.eposter_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('eposter_comments.is_deleted', 0);
		$this->db->where('eposter_comments.status', 1);
		$this->db->order_by('eposter_comments.created_datetime', 'DESC');
		$this->db->limit($limit, $start);
		$eposters = $this->db->get();
		// echo $this->db->last_query();
		if ($eposters->num_rows() > 0) {
			foreach ($eposters->result() as $eposter) {
				$then 			= new DateTime($eposter->created_datetime);
				$now 			= new DateTime();
				$delta 			= $now->diff($then);
				$quantities 	= array('year' 	=> $delta->y,
										'month' => $delta->m,
										'day' 	=> $delta->d,
										'hour' 	=> $delta->h,
										'minute' => $delta->i);

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

				$eposter->time = $str == '' ? 'a moment ago' : substr($str, 0, -2).' ago';
			}
			return $eposters->result();
		}
		return new stdClass();
	}

	public function postComments()
	{		
		$post = $this->input->post();
		if ($post['comments'] != '' && $post['eposterId'] != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') {
			$data = array('project_id' 		=> $this->project->id,
						  'eposter_id' 		=> strip_tags($post['eposterId']),
						  'user_id' 		=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
						  'comment' 		=> strip_tags($post['comments']),
						  'is_deleted' 		=> 0,
						  'status' 			=> 1,
						  'created_datetime' => date('Y-m-d H:i:s'),
						  'updated_datetime' => date('Y-m-d H:i:s'));

			if ($this->db->insert('eposter_comments', $data)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
