<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();

		if( $this->uri->segment(4) == 'room'){
			$room_id = $this->uri->segment(5);
		}

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee'] != 1)
		{
			if($room_id)
			redirect($this->project_url."/authentication/mobile_login/".$room_id); // Not logged-in
			else{
				print_r("Missing Room");exit;
			}
		}
		// $current_user_token = $this->db->select('token')->from('user')->where('id', $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'] )->get()->result()[0]->token;
		// if($current_user_token !== $_SESSION['project_sessions']["project_{$this->project->id}"]['token']){
		// 	redirect(base_url().$this->project->main_route."/login/logout"); // multiple logged-in
		// }
		
		$this->load->model('mobile/Mobile_Sessions_Model', 'msessions');
		$this->load->model('Logger_Model', 'logger');
		$this->load->helper('string');
		$this->load->model('Settings_Model', 'settings');
		$this->load->model('Users_Model', 'users');
		$this->load->model('Sessions_Model', 'sessions');
	}


	public function index($session_id = null){
		$project_id = $this->project->id;
//		print_r( $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee']);exit;

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;
		$this->session->set_userdata($current_project_sessions);

		$data['sess_data'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);

//		print_r($data['sess_data']);exit;
		$data['session_id'] = $session_id;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/index", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function room($room_id){
		$user_id = $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'];
		
		$session_array = array();
		if($user_id){
			$data['user'] 				= $user_id;
			$sessions	= $this->msessions->getAllByRoom($room_id);
			$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id);

			foreach ($sessions as $key => $session) {
				
				if(date("Y-m-d H:i:s", strtotime($session->end_date_time)) > date('Y-m-d H:i:s')){
					$session_array[] = $session;
				}
				
			}
			$data['sessions'] = $session_array;

			$this->load
				->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
				->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/listing", $data)
				->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
			;
		}
	}

	public function id($session_id) {
		$project_id = $this->project->id;

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee'] !== 1) {
			redirect(base_url() . $this->project->main_route . "/mobile/login/id/$session_id"); // Not logged-in
			return;
		}

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;
		$this->session->set_userdata($current_project_sessions);

		$data['sess_data'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/index", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session_modals", $data);


	}

	public function view($session_id)
	{

		$project_id = $this->project->id;
		if (isset($_SESSION['project_sessions']["project_{$this->project->id}"]) && $_SESSION['project_sessions']["project_{$this->project->id}"]['is_mobile_attendee'] !== 1) {
			redirect(base_url() . $this->project->main_route . "/mobile/login/id/$session_id"); // Not logged-in
		}

		$current_project_sessions["project_$project_id"]['mobile_session_id'] = $session_id;

		$this->session->set_userdata($current_project_sessions);
//		print_r($_SESSION["project_$project_id"]['mobile_session_id']);exit;

//		$data['notes'] 		= $this->note->getAll('session', $data['session_id'], $this->user['user_id']);
		$data['session'] = $this->msessions->getSessionDetailsById($session_id);
		$data["session_resource"] = $this->msessions->get_session_resource($session_id);
		if($data['session']->attendee_settings_id != 0 && $data['session']->attendee_settings_id != '' && $data['session']->attendee_settings_id != null ){
			$data['view_settings']		= $this->settings->getSessionSettings($this->project->id, $data['session']->attendee_settings_id );
		}else{
			$data['view_settings']		= $this->settings->getAttendeeSettings($this->project->id, $session_id);
		}
		$data['session_id'] = $session_id;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/templates/menu-bar")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/view_session_modals", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/poll_modal", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/poll_result_modal", $data);
//			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer");
//		print_r('');

	}

	public function askQuestionAjax()
	{
		$post = $this->input->post();
//		print_r($post);exit;
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

	public function markLaunchedPoll($poll_id){
		$this->sessions->markLaunchedPoll($poll_id);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().$this->project->name.'/login');
	}

	// public function session_missing(){
	// 	$this->load
	// 		->view("{$this->themes_dir}/{$this->project->theme}/attendee/mobile/common/header" )
	// 		->view("{$this->themes_dir}/{$this->project->theme}/attendee/sessions/session_missing")
	// 		->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer");
	// }
}
