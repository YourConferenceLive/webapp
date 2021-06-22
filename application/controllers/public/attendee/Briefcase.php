<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Briefcase extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $user;
	private $notesPerPage = 10;

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Briefcase_Model', 'briefcase');
		$this->load->model('Credits_Model', 'credit');
		$this->load->model('attendee/Notes_Model', 'note');
	}

	public function index()
	{
		$this->logger->log_visit("Briefcase Listing", $this->user->user_id);
		$data['user'] 					= $this->user;
		$data['active_briefcase_tab'] 	= 'agenda';
		$data['active_credit_tab'] 		= 'session-credits';
		$data['active_note_tab']		= 'session-notes';
		$data['notes_per_page']			= $this->notesPerPage;

		//Default value for ePoster Notes Modal
		$data['eposter']				= new stdClass();
		$data['eposter']->id 			= null;

		$data['entitiy_type'] 			= 'session';
		$data['sessions'] 				= $this->briefcase->getAgenda();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/briefcase/listing", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/notes_modal", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data)
		;
	}

	public function add()
	{
		$this->logger->log_visit("Session added in Briefacse", $this->input->post('session_id'));
		if ($this->briefcase->add($this->input->post('session_id')))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function delete()
	{
		$this->logger->log_visit("Session remove from Briefacse", $this->input->post('session_id'));
		if ($this->briefcase->delete($this->input->post('session_id')))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function getItineraries()
	{
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 10 );

		$columns_array 		= array('user_agenda.id', 'sessions.name', 'user_agenda.added_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir']; 
		$keyword 			= $post['search']['value'];
		$count 				= $this->briefcase->getItinerariesCount($keyword);

		$query 				= $this->briefcase->getItineraries($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];

		foreach($query as $r) {
			$data[] = array($r->id, $r->name, $r->added_datetime);
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
  	}

	public function getSessionCredits($session_type)
	{
		$this->logger->log_visit("Session Credits", $session_type);
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 10 );

		$columns_array 		= array('user_credits.id', 'sessions.name', 'user_credits.credit', 'user_credits.claimed_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir']; 
		$keyword 			= $post['search']['value'];
		$count 				= $this->credit->getSessionCreditsCount($session_type, $keyword);

		$query 				= $this->credit->getAllSessionCredits($session_type, $start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;
		foreach($query as $r) {
			$data[] = array($table_count++, $r->name, $r->credit, $r->claimed_datetime);
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	}

	public function getEposterCredits()
	{
		$this->logger->log_visit("ePoster Credits in Briefcase");
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 10 );

		$columns_array 		= array('user_credits.id', 'eposters.title', 'eposters.type', 'user_credits.credit', 'user_credits.claimed_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir']; 
		$keyword 			= $post['search']['value'];
		$count 				= $this->credit->getEposterCreditsCount($keyword);

		$query 				= $this->credit->getAllEposterCredits($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;

		foreach($query as $r) {
			$data[] = array($table_count++, $r->title, str_replace(array('eposter', 'surgical_video'), array('ePoster', 'Surgical Video'), $r->type), $r->credit, $r->claimed_datetime);
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	}

	public function getEposterNotes()
	{
		$this->logger->log_visit("ePoster Notes in Briefcase");
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 10 );

		$columns_array 		= array('notes.id', 'eposters.title', 'eposters.type', 'notes.note_text', 'notes.created_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir']; 
		$keyword 			= $post['search']['value'];

		$count 				= $this->note->getUserEpostersNotesCount($keyword);

		$query 				= $this->note->getAllUserEpostersNotes($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;

		foreach($query as $r) {
			$data[] = array('id' 			=> $table_count++,
							'eposter_id' 	=> $r->origin_type_id,
							'eposter_name' 	=> $r->title,
							'eposter_type'	=> str_replace(array('eposter', 'surgical_video'), array('ePoster', 'Surgical Video'), $r->type),
							'action_link' 	=> 'View',
							'added_on' 		=> $r->created_datetime);
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	}

	public function getSessionNotes()
	{
		$this->logger->log_visit("Session Notes in Briefcase");
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 10 );

		$columns_array 		= array('notes.id', 'sessions.name', 'notes.note_text', 'notes.created_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= $columns_array[$column_index];
		$column_sort_order 	= $post['order'][0]['dir']; 
		$keyword 			= $post['search']['value'];

		$count 				= $this->note->getUserSessionsNotesCount($keyword);

		$query 				= $this->note->getAllUserSessionsNotes($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;

		foreach($query as $r) {
			$data[] = array('id' 			=> $table_count++,
							'session_id' 	=> $r->origin_type_id,
							'session_title'	=> $r->name,
							'action_link' 	=> 'View',
							'added_on' 		=> $r->created_datetime);
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	} 
}
