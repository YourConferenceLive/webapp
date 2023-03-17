<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Sessions_Model', 'sessions');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$create_modal['tracks'] = $this->sessions->getAllTracks();
		$create_modal['types'] = $this->sessions->getAllTypes();
		$create_modal['presenters'] = $this->sessions->getAllPresenters();
		$create_modal['moderators'] = $this->sessions->getAllModerators();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/list")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/ask-a-report-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/add-resources-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/add-session-modal", $create_modal)


			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function view($id)
	{

		$sidebar_data['user'] = $this->user;

		$session = $this->sessions->getById($id);

		$data["error_text"] = "No Slide Found";
		if (!isset($session->id))
			$data["error_text"] = "Session Not Found";


		$data["session"] = $session;
		$data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			//->view("{$this->themes_dir}/{$this->project->theme}/presenter/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllJson()
	{
		echo json_encode($this->sessions->getAll());
	}

	public function getByIdJson($session_id)
	{
		echo json_encode($this->sessions->getById($session_id));
	}

	public function add()
	{
		echo json_encode($this->sessions->add());
	}

	public function update()
	{
		echo json_encode($this->sessions->update());
	}

	public function remove($session_id)
	{
		echo json_encode($this->sessions->removeSession($session_id));
	}

	public function getHostChatsJson($session_id)
	{
		echo json_encode($this->sessions->getHostChat($session_id));
	}

	public function sendHostChat()
	{
		echo json_encode($this->sessions->sendHostChat($this->input->post()));
	}

	public function polls($session_id)
	{
		$sidebar_data['user'] = $this->user;
		$session = $this->sessions->getById($session_id);

		$data['session'] = $session;
		$data['polls'] = $this->sessions->getAllPolls($session_id);


		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/polls", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/add-poll-modal.php")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllPollsJson($session_id)
	{
		echo json_encode($this->sessions->getAllPolls($session_id));
	}

	public function getPollByIdJson($id)
	{
		echo json_encode($this->sessions->getPollById($id));
	}

	public function addPollJson($session_id)
	{
		echo json_encode($this->sessions->addPoll($session_id));
	}

	public function updatePollJson($session_id){
		echo json_encode($this->sessions->updatePoll($session_id));
	}
	
	public function generateQRCode($session_id){

		$this->load->library('ciqrcode');

		$params['data'] = $this->project_url.'/mobile/sessions/id/'.$session_id;
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = FCPATH.'/cms_uploads/projects/'.$this->project->id.'/qrcode/qr_'.$session_id.'.png';

		if($this->ciqrcode->generate($params)){
			echo 'success';
		}else{
			echo 'error';
		}

//        echo '<img src="'.base_url().'assets/qrcode/qrcode.png" />';
	}

	public function getQuestionsAjax($session_id)
	{
		echo json_encode($this->sessions->getQuestions($session_id));
	}


	public function attendee_question_direct_chat(){
		echo json_encode($this->sessions->getAttendee_question_direct_chat());
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

	public function hideSavedQuestionAjax(){
		echo json_encode($this->sessions->hideSavedQuestionAjax());
	}

	public function getSessionResources($session_id){
		echo json_encode($this->sessions->getSessionResources($session_id));
	}

	public function addSessionResources(){
		echo json_encode($this->sessions->addSessionResources());
	}

	public function updateSessionResource(){
		echo json_encode($this->sessions->updateSessionResource());
	}

	public function flash_report($session_id){
		$sidebar_data['user'] = $this->user;
		$session = $this->sessions->getById($session_id);

		$data['session'] = $session;
		$data['polls'] = $this->sessions->getAllPolls($session_id);
		$data['flash_report_list'] = $this->sessions->get_flash_report($session_id);
//		echo '<pre>';
//		print_r($data['flash_report_list']);exit;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/flash_report", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer");

	}

	public function polling_report($session_id) {
		$sidebar_data['user'] = $this->user;
		$session = $this->sessions->getById($session_id);

		$data['session'] = $session;
		$data['polls'] = $this->sessions->getAllPolls($session_id);
		$polls = $this->sessions->getPollList($session_id);
		$data['flash_report_list'] = $this->sessions->getPollingData($session_id, $polls);
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/sessions/polling_report", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer");
	}

	public function poll_chart($session_id){
		$chart = $this->sessions->createPollChart($session_id);
	}

	public function attendee_question_report($session_id){
		echo  $this->sessions->attendee_question_report($session_id);
		/*
		 * To enable emoji on excel it should be imported as csv and file origin select 65001
		 * In Excel, navigate to Data > Import External Data > Import Data/Import From Text and choose 65001 Unicode (UTF-8).
		*/
	}

	public function view_json($session_id){
		echo  $this->sessions->view_json($session_id);
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

	public function update_closed_poll($poll_id){
		echo  $this->sessions->update_closed_poll($poll_id);
	}

	public function askarepReport($session_id){
		echo  $this->sessions->askarepReport($session_id);
	}

	public function clearJson($session_id){
		echo  $this->sessions->clearJson($session_id);
	}
}
