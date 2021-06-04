<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsors_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('sponsor_booth');
		$this->db->where('project_id', $this->project->id);
		$this->db->order_by("id", "desc");
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getById($id)
	{
		$this->db->select('*');
		$this->db->from('sponsor_booth');
		$this->db->where('project_id', $this->project->id);
		$this->db->where('id', $id);
		$this->db->order_by("id", "desc");
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result()[0];

		return new stdClass();
	}

	public function create()
	{
		$post = $this->input->post();
		$logo_name = '';
		$banner_name = '';

		// Upload files if set
		if (isset($_FILES['logo']) && $_FILES['logo']['name'] != '')
		{
			$logo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$logo_config['file_name'] = $logo_name = rand().'_'.str_replace(' ', '_', $_FILES['logo']['name']);
			$logo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/';

			$this->load->library('upload', $logo_config);
			if ( ! $this->upload->do_upload('logo'))
				return false;
			//print_r($this->upload->display_errors());
		}

		if (isset($_FILES['banner']) && $_FILES['banner']['name'] != '')
		{
			$banner_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$banner_config['file_name'] = $banner_name = rand().'_'.str_replace(' ', '_', $_FILES['banner']['name']);
			$banner_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/';

			$this->upload->initialize($banner_config);
			if ( ! $this->upload->do_upload('banner'))
				return false;

			//print_r($this->upload->display_errors());
		}

		$data = array(
			'project_id' => $this->project->id,
			'name' => $post['sponsor_name'],
			'about_us' => $post['about_us'],
			'logo' => $logo_name,
			'cover_photo' => $banner_name

		);
		$this->db->insert('sponsor_booth', $data);

		return ($this->db->affected_rows() == 0) ? false : true;
	}

	public function update()
	{
		$post = $this->input->post();
		$data = array();

		// Upload files if set
		if (isset($_FILES['logo']) && $_FILES['logo']['name'] != '')
		{
			$logo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$logo_config['file_name'] = $logo_name = rand().'_'.str_replace(' ', '_', $_FILES['logo']['name']);
			$logo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/';

			$this->load->library('upload', $logo_config);
			if ( ! $this->upload->do_upload('logo'))
				return false;
			//print_r($this->upload->display_errors());

			$data['logo'] = $logo_name;
		}

		if (isset($_FILES['banner']) && $_FILES['banner']['name'] != '')
		{
			$banner_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$banner_config['file_name'] = $banner_name = rand().'_'.str_replace(' ', '_', $_FILES['banner']['name']);
			$banner_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/';

			$this->upload->initialize($banner_config);
			if ( ! $this->upload->do_upload('banner'))
				return false;

			//print_r($this->upload->display_errors());

			$data['cover_photo'] = $banner_name;
		}

		$data['project_id'] = $this->project->id;
		$data['name'] = $post['sponsor_name'];
		$data['about_us'] = $post['about_us'];

		$this->db->set($data);
		$this->db->where('id', $post['sponsorId']);
		$this->db->update('sponsor_booth');

		return ($this->db->affected_rows() == 0) ? false : true;
	}

	public function delete($id)
	{
		$this->db->delete('sponsor_group_chat', array('booth_id' => $id));
		$this->db->delete('sponsor_attendee_chat', array('booth_id' => $id));
		$this->db->delete('sponsor_resource_management', array('booth_id' => $id));
		$this->db->delete('sponsor_bag', array('booth_id' => $id));
		$this->db->delete('sponsor_fishbowl', array('booth_id' => $id));
		$this->db->delete('sponsor_meeting_availability', array('booth_id' => $id));
		$this->db->delete('sponsor_meeting_booking', array('booth_id' => $id));
		$this->db->delete('sponsor_booth_admin', array('booth_id' => $id));

		$this->db->delete('sponsor_booth', array('id' => $id));

		return true;
	}
}
