<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		print_r($this->project); exit;
		$data['project'] = $this->project;

		if (isset($_SESSION['project_sessions']["project_$project"]) && $_SESSION['project_sessions']["project_$project"]['is_attendee'] == 1)
		{
			redirect(base_url().$this->project->main_route."/lobby");
			return;
		}

		$this->load->view("$this->themes_dir/$theme/attendee/common/header", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/login", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/common/footer", $data);
	}

	public function test()
	{
		echo 'yes';
	}
}
