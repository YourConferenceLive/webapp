<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsors extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('admin/Sponsors_Model', 'sponsors');
		$this->load->model('Users_Model', 'users');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$createModal['exhibitors'] = $this->users->getAllExhibitors();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sponsors/list")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sponsors/create-sponsor-modal", $createModal)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllJson(){echo json_encode($this->sponsors->getAll());}

	public function getByIdJson($id){echo json_encode($this->sponsors->getById($id));}

	public function create()
	{
		if ($this->sponsors->create())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function update()
	{
		if ($this->sponsors->update())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function delete($id)
	{
		if ($this->sponsors->delete($id))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}
}
