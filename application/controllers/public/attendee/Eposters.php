<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eposters extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $user;
	private $commentsPerPage = 10;
	private $notesPerPage = 10;

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Eposters_Model', 'eposter');
		$this->load->model('attendee/Comments_Model', 'comment');
		$this->load->model('attendee/Notes_Model', 'note');
		$this->load->model('attendee/Sessions_Model', 'sessions_model');
        $this->load->library("pagination");
        $this->load->helper('form');
	}

	public function index($track_id = 'NaN', $author_id = 'NaN', $type = 'NaN', $keyword = 'NaN', $page = '')
	{
		$this->logger->log_visit("ePosters Listing");

		$data['project'] 				= $this->project;
		$data['user'] 					= $_SESSION['project_sessions']["project_{$this->project->id}"];

		$config 						= array();
		$config["base_url"] 			= $this->project_url . "/eposters/index/$track_id/$author_id/$type/$keyword";
		$config["per_page"] 			= 10;
		$config['full_tag_open']        = '<ul class="pagination justify-content-center">';
		$config['full_tag_close']       = '</ul>';
		$config['num_tag_open']         = '<li class="page-item">';
		$config['num_tag_close']        = '</li>';
		$config['cur_tag_open']         = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close']        = '</a></li>';
		$config['next_tag_open']        = '<li class="page-item">';
		$config['next_tagl_close']      = '</li>';
		$config['prev_tag_open']        = '<li class="page-item">';
		$config['prev_tagl_close']      = '</li>';
		$config['first_tag_open']       = '<li class="page-item">';
		$config['first_tagl_close']     = '</li>';
		$config['last_tag_open']        = '<li class="page-item">';
		$config['last_tagl_close']      = '</li>';
		$config['num_links'] 			= 3;
		$config['attributes'] 			= array('class' => 'page-link');

		$data['track_id'] 				= (($track_id != ''  && $track_id != 'NaN') ? $track_id : '' );
		$data['author_id'] 				= (($author_id != '' && $author_id != 'NaN') ? $author_id : '' );
		$data['type'] 					= (($type != '' && $type != 'NaN') ? $type : '' );
		$data['keyword'] 				= (($keyword != '' && $keyword != 'NaN') ? urldecode($keyword) : '' );

		$config["total_rows"] 			= $this->eposter->getCount($data['track_id'], $data['author_id'], $data['type'], $data['keyword']);

		$this->pagination->initialize($config);

		$page 							= (($page != '' && $page != 'NaN') ? $page : 0 );

		$data["links"] 					= $this->pagination->create_links();

		$data['tracks'] 				= $this->eposter->getAllTracks();
		$data['authors'] 				= $this->eposter->getAllAuthors();

		$data['eposters'] 				= $this->eposter->getAll($config["per_page"], $page, $data['track_id'], $data['author_id'], $data['type'], $data['keyword']);

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/listing", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer", $data);
	}

	public function view($eposter_id)
	{
		$this->logger->log_visit("ePoster View", $eposter_id);

		$data['user'] 				= $_SESSION['project_sessions']["project_{$this->project->id}"];
		$data['eposter'] 			= $this->eposter->getById($eposter_id);

		$data['next'] 				= $this->eposter->getEposterID($eposter_id, 'next');
		$data['previous'] 			= $this->eposter->getEposterID($eposter_id, 'previous');
		$data['comments_per_page']	= $this->commentsPerPage;
		$data['notes_per_page']		= $this->notesPerPage;
		$data['entitiy_type']		= 'eposter';

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/comments_modal", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/notes_modal", $data);
	}

	public function add_credits()
	{
		$this->logger->log_visit("Credits added on ePoster", $this->input->post('entity_type_id'));

		$this->load->model('Credits_Model', 'credit');

		$origin_type 				= $this->input->post('origin_type');
		$origin_type_id 			= $this->input->post('origin_type_id');
		$credits 					= $this->input->post('credits');

		if ($this->credit->claim($origin_type, $origin_type_id, $credits))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function add_notes($entitiy_type = 'eposter')
	{
		$this->logger->log_visit("Note added on ".$entitiy_type, $this->input->post('entity_type_id'));

		if ($this->note->add($entitiy_type))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function notes($entitiy_type, $entitiy_type_id, $page)
	{
		$this->logger->log_visit("View ".$entitiy_type." notes", $entitiy_type_id);

		$data['notes']['user']			= $_SESSION['project_sessions']["project_{$this->project->id}"];

		if ($entitiy_type == 'eposter')
			$data['notes']['eposter']	= $this->eposter->getById($entitiy_type_id);
		else
			$data['notes']['session']	= $this->sessions_model->getById($entitiy_type_id);

		$data['notes_count']			= $this->note->getCount($entitiy_type, $entitiy_type_id, $data['notes']['user']['user_id']);
		$page--;
		$offset 						= (($page)*$this->notesPerPage);

		$data['notes']['entitiy_type'] 	= $entitiy_type;
		$data['notes']['total'] 		= $data['notes_count'];
		$data['notes']['data'] 			= $this->note->getAll($entitiy_type, $entitiy_type_id, $data['notes']['user']['user_id'], $this->notesPerPage, $offset);

		echo json_encode($data['notes']);
		exit;
	}

	public function post_comments()
	{
		$this->logger->log_visit("Commented on ePoster", $this->input->post('eposter_id'));

		if ($this->comment->postComments())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function comments($eposter_id, $page)
	{
		$this->logger->log_visit("View comments", $eposter_id);

		$data['comments_count']		= $this->comment->getCount($eposter_id);
		$page--;
		$offset 					= (($page)*$this->commentsPerPage);

		$data['comments']['total'] 	= $data['comments_count'];
		$data['comments']['data'] 	= $this->comment->getAll($eposter_id, $this->commentsPerPage, $offset);

		echo json_encode($data['comments']);
		exit;
	}
}
