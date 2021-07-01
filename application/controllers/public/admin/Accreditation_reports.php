<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accreditation_reports extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Logger_Model', 'logger');
		$this->load->model('Credits_Model', 'credit');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/credits-report")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllSessionsCredits($session_type)
	{
		$this->logger->log_visit("Sessions credits report of $session_type");
		$post 					= $this->input->post();

		$draw 					= intval($this->input->post("draw"));
		$start 					= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 				= ((intval($this->input->post("length"))) ? $this->input->post("length") : 0 );

		if ($session_type == 'gs') {
			$columns_array 		= array('user.rcp_number', 'user_credits.id', 'sessions.name', 'user_credits.credit', 'user_credits.claimed_datetime');
		} else {
			$columns_array 		= array('user.rcp_number', 'user_credits.id', '', 'user_credits.credit', 'sessions.name', 'user_credits.claimed_datetime');
		}

		$column_index 			= $post['order'][0]['column'];
		$column_name 			= ((@$columns_array[$column_index]) ? $columns_array[$column_index] : 'user.rcp_number' );
		$column_sort_order 		= (($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'ASC' ); 
		$keyword 				= $post['search']['value'];
		$count 					= $this->credit->getAllSessionsCreditsCount($session_type, $keyword);

		$query 					= $this->credit->getAllSessionsCredits($session_type, $start, $length, $column_name, $column_sort_order, $keyword);

		$data 					= [];

		if ($session_type == 'gs') {
			foreach($query as $r) {
				$claimed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $r->claimed_datetime);

				$data[] = array($r->rcp_number,
								'20210624',
								'Conference',
								'Yes',
								$r->credit,
								'2021 COS Annual Meeting and Exhibition',
								'',
								$claimed_datetime->format('Y-m-d'),
								'',
								'',
								'Canadian Ophthamological Society',
								'Canada',
								'',//'Please amend this question',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'');
			}
		} else {
			foreach($query as $r) {
				$claimed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $r->claimed_datetime);

				$data[] = array($r->rcp_number, 
								'20210624',
								'Practice Assessment',
								$r->credit, 
								$r->session_name,
								$claimed_datetime->format('Y-m-d'),
								'COS',
								'Canada',
								'Collaborator');

			}
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	}

	public function getAllEpostersCredits()
	{
		$this->logger->log_visit("ePosters credits report");
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 5 );

		$columns_array 		= array('user_credits.id', 'eposters.title', 'eposters.type', 'user_credits.credit', 'user_credits.claimed_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= ((@$columns_array[$column_index]) ? $columns_array[$column_index] : 'user.rcp_number' );
		$column_sort_order 	= (($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'ASC' ); 
		$keyword 			= $post['search']['value'];
		$count 				= $this->credit->getAllEpostersCreditsCount($keyword);

		$query 				= $this->credit->getAllEpostersCredits($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;

		foreach($query as $r) {
			$claimed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $r->claimed_datetime);
			$data[] = array($r->rcp_number, 
							'20210624',
							'Poster Viewing',
							$r->credit, 
							'Poster Viewing session at the COS conference',//$r->title,
							'',
							$claimed_datetime->format('Y-m-d'),
							'',
							'',
							'Canadian Ophthamological Society',
							'Canada',
							'',//'Please amend this question',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'',
							'');
		}

		$result 	= array("draw" 				=> $draw,
							"recordsTotal" 		=> $count,
		    	     		"recordsFiltered" 	=> $count,
			         		"data" 				=> $data);
      	echo json_encode($result);
    	exit();
	}

	public function detail()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/staff_login")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer");
	}
}
