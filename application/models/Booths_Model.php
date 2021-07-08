<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booths_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('sponsor_booth');
		$this->db->where('project_id', $this->project->id);
		$this->db->order_by('name', 'ASC');
		$booths = $this->db->get();

		if ($booths->num_rows() > 0)
			return $booths->result();

		return new stdClass();
	}
}
