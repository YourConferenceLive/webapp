<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eposters_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

    public function getCount($track_id = '', $author_id = '', $type = '', $keyword = '')
    {
		if ($author_id) {
			$eposter_ids = $this->db->select('eposter_id')
								 ->where('user_id', $author_id)
								 ->group_by('eposter_id')
								 ->get_compiled_select('eposter_authors', true);

			$this->db->where('id IN ('.$eposter_ids.')');
		}

		$where = array('project_id' => $this->project->id, 'status' => 1);

		if ($track_id) {
			$where['track_id'] = $track_id;
		}

		if ($type) {
			$where['type'] = $type;
		}

		if ($keyword) {
			$this->db->like('control_number',$keyword);
			$this->db->or_like('title',$keyword);
			$this->db->or_like('prize',$keyword);
		}

		$this->db->where($where);

		return $this->db->count_all_results('eposters');
    }

	public function getAll($limit, $start, $track_id = '', $author_id = '', $type = '', $keyword = '')
	{
		if ($author_id) {
			$eposter_ids = $this->db->select('eposter_id')
									->where('user_id', $author_id)
								 	->group_by('eposter_id')
								 	->get_compiled_select('eposter_authors', true);

			$this->db->where('e.id IN ('.$eposter_ids.')');
		}

		$this->db->select('e.id, e.track_id, e.control_number, e.title, e.type, e.prize, e.eposter, e.video_url');
		
		$this->db->from('eposters e');

		$where = array('e.project_id' => $this->project->id, 'e.status' => 1);

		$this->db->order_by('e.id', 'DESC');

		if ($track_id) {
			$where['e.track_id'] = $track_id;
		}

		if ($type) {
			$where['type'] = $type;
		}

		if ($keyword) {
			$this->db->or_like('control_number',$keyword);
			$this->db->or_like('title',$keyword);
			$this->db->or_like('prize',$keyword);
		}

		$this->db->where($where);
		$this->db->limit($limit, $start);
		$this->db->order_by('e.id', 'DESC');

		$eposters = $this->db->get();

		if ($eposters->num_rows() > 0){
			foreach ($eposters->result() as $eposter) {
				$eposter->author = $this->getAuthorsPerEposter($eposter->id);
			}
			return $eposters->result();
		}

		return new stdClass();
	}

	public function getAuthorsPerEposter($eposter_id)
	{
		$this->db->select('u.id, CONCAT_WS(" ", u.credentials, u.name, u.surname) AS author, email, ea.contact');
		$this->db->from('eposter_authors ea');
		$this->db->join('user u', 'u.id=ea.user_id');
		$this->db->where('ea.eposter_id', $eposter_id);
		$authors = $this->db->get();
		if ($authors->num_rows() > 0)
			return $authors->result();

		return new stdClass();
	}

	public function getAllAuthors()
	{
		$this->db->distinct('u.id');
		$this->db->select('u.id, CONCAT_WS(" ", u.credentials, u.name, u.surname) AS author');
		$this->db->from('user u');
		$this->db->join('eposter_authors ea', 'u.id=ea.user_id');
		$this->db->where(array('u.active' => 1));
		$tracks = $this->db->get();
		if ($tracks->num_rows() > 0)
			return $tracks->result();

		return new stdClass();
	}

	public function getAllTracks()
	{
		$this->db->select('*');
		$this->db->from('eposter_tracks');
		$this->db->where(array('project_id' => $this->project->id, 'status' => 1));
		$tracks = $this->db->get();
		if ($tracks->num_rows() > 0)
			return $tracks->result();

		return new stdClass();
	}

	public function getEposterID($eposter_id, $pointer)
	{
		if ($pointer == 'next') {
			$this->db->select('MIN(`id`)');
			$this->db->where("`id` >", $eposter_id);
		} else {
			$this->db->select('MAX(`id`)');
			$this->db->where("`id` <", $eposter_id);
		}

		$this->db->from('eposters');
		$this->db->where('status', 1);
		$this->db->where('project_id', $this->project->id);
		$where 			= $this->db->get_compiled_select();

		$this->db->select('id');
		$this->db->from('eposters');
		$this->db->where("`id` IN ($where)", NULL, FALSE);
		$this->db->where('status', 1);
		$this->db->where('project_id', $this->project->id);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			return $eposters->result()[0];

		return new stdClass();
	}

	public function getById($eposter_id)
	{
		$this->db->select('*');
		$this->db->from('eposters');
		$this->db->where('id', $eposter_id);
		$this->db->where('status', 1);
		$this->db->where('project_id', $this->project->id);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			foreach ($eposters->result() as $eposter) {
				$eposter->author = $this->getAuthorsPerEposter($eposter->id);
			}
			return $eposters->result()[0];

		return new stdClass();
	}

	public function postComments()
	{		
		$post = $this->input->post();
		if ($post['comments'] != '' && $post['eposterId'] != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') {
			$data = array('project_id' 		=> $this->project->id,
						  'eposter_id' 		=> $post['eposterId'],
						  'user_id' 		=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
						  'comment' 		=> $post['comments'],
						  'is_deleted' 		=> 0,
						  'status' 			=> 1,
						  'created_datetime' => date('Y-m-d H:i:s'),
						  'updated_datetime' => date('Y-m-d H:i:s'));

			if ($this->db->insert('eposter_comments', $data)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function getEposterCommentsCount($eposter_id)
	{
		$this->db->select("eposter_comments.idr");
		$this->db->from('eposter_comments');
		$this->db->join('user', 'user.id = eposter_comments.user_id');
		$this->db->where('eposter_comments.eposter_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('eposter_comments.is_deleted', 0);
		$this->db->where('eposter_comments.status', 1);
		return $this->db->count_all_results();
	}

	public function getEposterComments($eposter_id)
	{
		$this->db->select("eposter_comments.id, eposter_comments.user_id, eposter_comments.comment, eposter_comments.created_datetime, CONCAT(user.name, ' ', user.surname) as commenter, user.photo as avatar");
		$this->db->from('eposter_comments');
		$this->db->join('user', 'user.id = eposter_comments.user_id');
		$this->db->where('eposter_comments.eposter_id', $eposter_id);
		$this->db->where('user.active', 1);
		$this->db->where('eposter_comments.is_deleted', 0);
		$this->db->where('eposter_comments.status', 1);
		$this->db->order_by('eposter_comments.created_datetime', 'DESC');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
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

		return new stdClass();
	}
}
