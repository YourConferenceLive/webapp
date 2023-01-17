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
		$this->load->model('Sessions_Model', 'sessions');
		$this->load->model('attendee/Notes_Model', 'note');
		$this->load->model('Credits_Model', 'credit');
		$this->load->model('Settings_Model', 'settings');

        $this->load->library("pagination");
        $this->load->helper('form');
	}

	public function index()
	{
		$this->logger->log_visit("Sessions Listing");

		$data['user'] = $this->user;
		$data['sessions'] = $this->sessions->getAllSessionWeek();
		foreach ($data['sessions'] as $session){
			if($session->time_zone === "EDT") {
				$session->start_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($session->start_date_time)));
				$session->end_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($session->end_date_time)));
			}
		}

		$data['all_sessions_week'] = $this->sessions->getSessionWeek();
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
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

		$this->claimCredit($session_id, $this->sessions->getCredits($session_id));

		$data['user'] = $this->user;
		$data['session'] = $this->sessions->getById($session_id);
			if($data['session']->time_zone === "EDT") {
				$data['session']->start_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($data['session']->start_date_time)));
				$data['session']->end_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($data['session']->end_date_time)));
		}

		$data['countdownSeconds'] = $this->countdownInSeconds($data['session']->start_date_time);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/join", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/user_biography_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function view($session_id)
	{
		$this->logger->log_visit("Session View", $session_id);

		$this->claimCredit($session_id, $this->sessions->getCredits($session_id));

		$session_data = $this->sessions->getById($session_id);
		if($session_data->time_zone === "EDT") {
			$session_data->start_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($session_data->start_date_time)));
			$session_data->end_date_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($session_data->end_date_time)));
		}
//		print_r($session_data);exit;

		if (date("Y-m-d H:i:s") > date("Y-m-d H:i:s", strtotime( $session_data->end_date_time)) ) {
			header("location:" . $this->project_url. "/sessions/session_end/".$session_id);
			die();
		}

		$data['user'] 		= $this->user;
		$data['session_id'] = $session_id;
		$data['session'] 	= $session_data;
		$data['notes'] 		= $this->note->getAll('session', $data['session_id'], $this->user['user_id']);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/poll_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/poll_result_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/note_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function claimCredit($session_id, $credit)
	{
		$this->credit->claim('session', $session_id, $credit);
	}

	private function countdownInSeconds($countdown_to, $offset=900)
	{
		$now 			= new DateTime();
		$countdown_to 	= new DateTime(date("Y-m-d H:i:s", strtotime($countdown_to)));
		$difference 	= $countdown_to->getTimestamp() - $now->getTimestamp();

		if ($difference >= $offset)
			return $difference - $offset;
		return 0;
	}

	public function day($day, $track_id = 'NaN', $keynote_id = 'NaN', $speaker_id = 'NaN', $keyword = 'NaN')
	{
		$data['user'] 				= $this->user;

		$data['track_id'] 			= (($track_id != ''  && $track_id != 'NaN') ? $track_id : '' );
		$data['keynote_id'] 		= (($keynote_id != '' && $keynote_id != 'NaN') ? $keynote_id : '' );
		$data['speaker_id'] 		= (($speaker_id != '' && $speaker_id != 'NaN') ? $speaker_id : '' );
		$data['keyword'] 			= (($keyword != '' && $keyword != 'NaN') ? urldecode($keyword) : '' );

		$data['tracks'] 			= $this->sessions->getAllTracks();
		$data['keynote_speakers'] 	= $this->sessions->getAllKeynoteSpeakers();
		$data['speakers'] 			= $this->sessions->getAllPresenters();

		$data['sessions'] 			= $this->sessions->getByDay($day, $data['track_id'], $data['keynote_id'], $data['speaker_id'], $data['keyword']);

		$data['all_sessions_week'] = $this->sessions->getSessionWeek();
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/listing", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/user_biography_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function askQuestionAjax()
	{
		$post = $this->input->post();
		echo json_encode($this->sessions->askQuestion($post['session_id'], $post['question']));
	}

	public function vote()
	{
		$this->sessions->vote();
		echo json_encode(array('status'=>'success'));
	}

	public function getPollResultAjax($poll_id)
	{
		echo json_encode($this->sessions->getPollResult($poll_id));
	}

	public function chatAdminajax(){
		echo json_encode($this->sessions->saveChatAdmin());
	}

	public function getAdminChatsAjax(){
		echo json_encode($this->sessions->getAdminChatsAjax());
	}

	public function session_end($session_id){
		$data['session'] = $this->sessions->getById($session_id);
		$data['user'] 		= $this->user;
		$data['session_id'] = $session_id;
		$data['notes'] 		= $this->note->getAll('session', $data['session_id'], $this->user['user_id']);
		$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/session_end", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data);
	}

	public function ask_a_rep(){
		$this->sessions->save_ask_a_rep();
	}

	public function saveTimeSpentOnSession($session_id, $user_id)
	{
		$this->sessions->saveTimeSpentOnSession($session_id, $user_id);
	}

	public function update_viewsessions_history_open($session_id){
		$this->sessions->update_viewsessions_history_open($session_id);
	}

	public function add_viewsessions_history_open(){
		$this->sessions->add_viewsessions_history_open();
	}

	public function getTimeSpentOnSession($session_id, $user_id){
		$this->sessions->getTimeSpentOnSession($session_id, $user_id);
	}
}
