<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Logger_Model', 'logs');
		$this->load->model('Analytics_Model', 'analytics');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data['logs'] = $this->analytics->getAllProjectLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/logs", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function relaxation_zone()
	{
		$sidebar_data['user'] = $this->user;

		$data['logs'] = $this->analytics->getRelaxationZoneLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/relaxation_zone", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function scavenger_hunt_export($param)
	{
		if ($param != 'csv')
			return false;

		$file 		= fopen('php://output', 'w');
		$filename 	= 'Scavenger-Hunt-'.date('Y-m-d').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename = $filename");
		header("Content-Type: application/csv;");
		$header 		= array("User ID", "Name", "Surname", "Degree", "Email","City", "Last Collected Item", "Last Collected");
		fputcsv($file, $header);
		$data 			= $this->analytics->getScavengerHuntData();

		foreach ($data as $row) {

			$csv_data 	= array($row->id, $row->name, $row->surname, $row->credentials, $row->email, $row->city, $row->booth_name, $row->last_collected);
			fputcsv($file, $csv_data);
		}
		fclose($file);
		exit;
	}

	public function scavenger_hunt()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getScavengerHuntData();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/scavenger_hunt", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}
}
