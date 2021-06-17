<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eposters extends CI_Controller
{
	/**
	 * @var mixed
	 */
	private $user;
	private $commentsPerPage = 1;

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] != 1)
			redirect(base_url().$this->project->main_route."/login"); // Not logged-in

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('attendee/Eposters_Model', 'eposter');
        $this->load->library("pagination");
        $this->load->helper('form');
	}

	public function index()
	{
		$this->logger->log_visit("ePosters Listing");

		$data['project'] 				= $this->project;
		$data['user'] 					= $_SESSION['project_sessions']["project_{$this->project->id}"];

		$data['track_id'] = $data['author_id'] = $data['type'] = $data['keyword'] = '';

        if ($this->input->get('track'))
        	$data['track_id'] 			= $this->input->get('track');

        if ($this->input->get('author'))
        	$data['author_id'] 			= $this->input->get('author');

        if ($this->input->get('type'))
        	$data['type'] 				= $this->input->get('type');

        if ($this->input->get('keyword'))
        	$data['keyword']			= $this->input->get('keyword');

		$config 						= array();
		$config["base_url"] 			= $this->project_url . "/eposters/index";
		$config["total_rows"] 			= $this->eposter->getCount($data['track_id'], $data['author_id'], $data['type'], $data['keyword']);

		$config["per_page"] 			= 10;

		$config['full_tag_open']        = '<ul class="pagination">';
		$config['full_tag_close']       = '</ul>';
		$config['num_tag_open']         = '<li class="page-item">';
		$config['num_tag_close']        = '</li>';
		$config['cur_tag_open']         = '<li class="page-item active"><li class="page-link"><a href="#">';
		$config['cur_tag_close']        = '<span class="sr-only"></span></a></li>';
		$config['next_tag_open']        = '<li class="page-item">';
		$config['next_tagl_close']      = '</li>';
		$config['prev_tag_open']        = '<li class="page-item">';
		$config['prev_tagl_close']      = '</li>';
		$config['first_tag_open']       = '<li class="page-item">';
		$config['first_tagl_close']     = '</li>';
		$config['last_tag_open']        = '<li class="page-item">';
		$config['last_tagl_close']      = '</li>';
		$config['attributes'] 			= array('class' => 'page-link');

		$config['page_query_string']    = true;
 		$config['query_string_segment'] = 'page';
 		$config['reuse_query_string']   = true;
 		$config['use_page_numbers']     = false;

		$this->pagination->initialize($config);

		$page = ($this->input->get('page'))? $this->input->get('page') : 0;

		$data["links"] 			= $this->pagination->create_links();

		$data['tracks'] 		= $this->eposter->getAllTracks();
		$data['authors'] 		= $this->eposter->getAllAuthors();

		$data['eposters'] 		= $this->eposter->getAll($config["per_page"], $page, $data['track_id'], $data['author_id'], $data['type'], $data['keyword']);

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

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/menu-bar", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/view", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/eposters/comments_modal", $data);
	}

	public function post_comments()
	{
		if ($this->eposter->postComments())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function comments($eposter_id)
	{
		$data['comments_count']		= $this->eposter->getEposterCommentsCount($eposter_id);
		$data['comments']['total'] 	= $data['comments_count'];
		$data['comments']['data'] 	= $this->eposter->getEposterComments($eposter_id);
		echo json_encode($data['comments']);
		exit;
	}
}
