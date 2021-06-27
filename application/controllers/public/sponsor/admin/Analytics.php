<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $booth_id;

	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_exhibitor'] != 1)
			redirect(base_url($this->project->main_route)."/sponsor/admin/login"); // Not logged-in

		$this->booth_id = $_SESSION['project_sessions']["project_{$this->project->id}"]['exhibitor_booth_id'];

		if ($this->booth_id == null) // No booth has been assigned to this account
			redirect(base_url($this->project->main_route)."/sponsor/admin/login");

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Analytics_Model', 'analytics');
		$this->load->helper('string');
		$this->load->model('sponsor/Sponsor_Model', 'sponsor');

		$this->load->model('Users_Model', 'users');
	}

	public function index()
	{
		$menu_data['user'] = (Object) $_SESSION['project_sessions']["project_{$this->project->id}"];

		$data['booth'] = $this->sponsor->getBoothData($this->booth_id);
		$data['logs'] = $this->analytics->getBoothLogs($this->booth_id);
		$data['total_visits'] = $this->analytics->getTotalBoothVisits($this->booth_id);
		$data['unique_visits'] = $this->analytics->getUniqueBoothVisits($this->booth_id);
		$data['returning_visits'] = $this->analytics->getReturningBoothVisits($this->booth_id);
		$data['total_resource_downloads'] = $this->analytics->getTotalResourceDownloads($this->booth_id);
		$data['resources_added_to_backpack'] = $this->analytics->getSponsorResourcesInBackpack($this->booth_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/menu-bar", $menu_data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/change-password-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/analytics", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/sponsor/common/footer")
		;

	}
}
