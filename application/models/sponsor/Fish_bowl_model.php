<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  project
 */
class Fish_bowl_model extends CI_Model
{

	private $booth_id;
	private $sponsor_id;


	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
		$this->sponsor_id = $this->session->userdata('sponsor_id');
		$this->booth_id = $this->session->userdata('booth_id');
	}

	function get_fish_bowl_data(){
		$this->db->select('fb.*,CONCAT(u.name," ",u.surname) as full_name, u.email')
			->from('sponsor_fishbowl fb')
			->join('user u', 'fb.user_id = u.id')
			->group_by('fb.user_id')
		;
		$result = $this->db->get();
		if($result->num_rows() > 0)
			return $result->result();

		else
			return '';
	}
}
