<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsors extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load->model('admin/Sponsors_Model', 'sponsors');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data["sponsors"] = $this->sponsors->getAll();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sponsors/list", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sponsors/create-sponsor-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function create()
	{
		if ($this->sponsors->create())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}
}
