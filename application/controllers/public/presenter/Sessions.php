<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if
		(
			!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) ||
			(
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] != 1 &&
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_moderator'] != 1
			)
		)redirect(base_url().$this->project->main_route."/presenter/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Sessions_Model', 'sessions');
		$this->load->model('Settings_Model', 'settings');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data["sessions"] = $this->sessions->getAllSessionsByPresenterModeratorKeynote($this->user->user_id);
		if($data['sessions']){
			$session_array = array();
			foreach($data['sessions'] as $session){
				$session->presenters = $this->sessions->getPresentersPerSession($session->id);
				$session_array[] = $session;
			}
			$data["sessions"] = $session_array;
		}


		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/list", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}

	public function view($id)
	{
		//$sidebar_data['user'] = $this->user;

		$session = $this->sessions->getById($id);

//		print_r($session);
		if(($session == new stdClass())){
			echo "Session Not found";
			exit;
		}

		$data["error_text"] = "No Slide Found";

		if (!isset($session->id))
			$data["error_text"] = "Session Not Found";

		if($session->attendee_settings_id != 0) {
			$data['settings'] = $this->settings->getSessionSettings($this->project->id, $session->attendee_settings_id)[0];
		}else{
			if($this->settings->presenterSettings($this->project->id)) {
				$data['settings'] = $this->settings->presenterSettings($this->project->id)[0];
			}
		}
		$data["session"] = $session;
		$data["user"] = $this->user;

		//$menu_data['host_chat_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_host_chat", '', true);
		//$menu_data['questions_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_questions.php", '', true);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_result_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}

	public function view_without_slides($id)
	{
		//$sidebar_data['user'] = $this->user;

		$session = $this->sessions->getById($id);

		$data["error_text"] = "No Slide Found";
		if (!isset($session->id))
			$data["error_text"] = "Session Not Found";


		$data["session"] = $session;
		$data["user"] = $this->user;

		//$menu_data['host_chat_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_host_chat", '', true);
		//$menu_data['questions_html'] = $this->load->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/session_questions.php", '', true);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/view-without-slides", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/poll_result_modal")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}

	public function getHostChatsJson($session_id)
	{
		echo json_encode($this->sessions->getHostChat($session_id));
	}

	public function sendHostChat()
	{
		echo json_encode($this->sessions->sendHostChat($this->input->post()));
	}

	public function getPollResultAjax($poll_id)
	{
		echo json_encode($this->sessions->getPollResult($poll_id));
	}

	public function getQuestionsAjax($session_id)
	{
		echo json_encode($this->sessions->getQuestions($session_id));
	}

	public function attendee_question_direct_chat(){
		echo json_encode($this->sessions->getAttendee_question_direct_chat());
	}

	public function save_presenter_attendee_chat(){
		echo json_encode($this->sessions->save_presenter_attendee_chat());
	}

	public function getAttendeeChatsAjax(){
		echo json_encode($this->sessions->getAttendeeChatsAjax());
	}

	public function saveQuestionAjax(){
		echo json_encode($this->sessions->saveQuestionAjax());
	}

	public function getSavedQuestions($session_id){
		echo json_encode($this->sessions->getSavedQuestions($session_id));
	}

	public function hideQuestionAjax(){
		echo json_encode($this->sessions->hideQuestionAjax());
	}

	public function view_poll($session_id){
		$sidebar_data['user'] = $this->user;
		$session = $this->sessions->getById($session_id);

		if($session == new stdClass()){
			print_r("session empty");exit;
		}
		$data['session'] = $session;
		$data['polls'] = $this->sessions->getAllPolls($session_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/view_poll", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/sessions/add-poll-modal.php")
			->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/footer")
		;
	}

	public function updateShowedResult($poll_id){
		echo  $this->sessions->updateShowedResult($poll_id);
	}

	public function redoPoll($poll_id){
		echo  $this->sessions->redoPoll($poll_id);
	}

	public function removePoll($poll_id){
		echo  $this->sessions->removePoll($poll_id);
	}

	public function addPollJson($session_id)
	{
		echo json_encode($this->sessions->addPoll($session_id));
	}

	public function updatePollJson($session_id){
		echo json_encode($this->sessions->updatePoll($session_id));
	}

	public function getAllPollsJson($session_id)
	{
		echo json_encode($this->sessions->getAllPolls($session_id));
	}

	public function getPollByIdJson($id)
	{
		echo json_encode($this->sessions->getPollById($id));
	}

}
