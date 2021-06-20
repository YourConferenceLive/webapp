<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credits_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function add()
	{
		$post = $this->input->post();

		if ($post['origin_type_id'] != '' && $post['origin_type'] != '' && $post['credits'] != '' && $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] != '') :
			$data 	= array('origin_type'		=> $post['origin_type'],
						  	'origin_type_id'	=> strip_tags($post['origin_type_id']),
						  	'user_id' 			=> $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
						  	'credit' 			=> strip_tags($post['credits']),
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
