<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  project
 */
class Scavenger_Hunt_Items_Model extends CI_Model
{

	private $user_id;

	function __construct()
	{
		parent::__construct();
		$this->user_id=($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']);
	}

	function get_hunt_item($current_booth_id){
		$this->db->select('*')
			->from('scavenger_hunt_items')
			->where('user_id', $this->user_id)
			->where('booth_id', $current_booth_id);
		$result= $this->db->get();

		return $result;
	}

	function item_found(){
		$hunting_icon_id=$this->input->post('hunting_icon_id');
		$current_booth_id=$this->input->post('current_booth_id');

		if($this->get_hunt_item($current_booth_id)->num_rows() > 0){
			return false;
		}else{
			$data_field=array(
				'user_id'=>$this->user_id,
				'booth_id'=>$current_booth_id,
				'icon_name'=>$hunting_icon_id,
			);
			$this->db->insert('scavenger_hunt_items', $data_field);
			return true;
		}
	}
}
