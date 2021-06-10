<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $user;

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Sessions_Model', 'sessions');
	}

	public function index()
	{
		$this->logger->log_visit("Sessions Listing");

		$data['user'] = $this->user;
		$data['sessions'] = $this->sessions->getAll();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/listing", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function join($session_id)
	{
		$this->logger->log_visit("Session Join", $session_id);

		$data['user'] = $this->user;
		$data['session'] = $this->sessions->getById($session_id);
		$data['countdownSeconds'] = $this->countdownInSeconds($data['session']->start_date_time);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/join", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function view($session_id)
	{

		$this->logger->log_visit("Session View", $session_id);

		$data['user'] = $this->user;

		$data['session'] = $this->sessions->getById($session_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/poll_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/poll_result_modal")
			//->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	private function countdownInSeconds($countdown_to, $offset=900)
	{
		$now = new DateTime();
		$countdown_to = new DateTime(date("Y-m-d H:i:s", strtotime($countdown_to)));
		$difference = $countdown_to->getTimestamp() - $now->getTimestamp();
		if ($difference >= $offset)
			return $difference - $offset;
		return 0;
	}
}
