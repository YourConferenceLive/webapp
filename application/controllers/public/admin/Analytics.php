<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Logger_Model', 'logs');
		$this->load->model('Analytics_Model', 'analytics');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$data['logs'] = $this->analytics->getAllProjectLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/logs", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function relaxation_zone()
	{
		$sidebar_data['user'] 		= $this->user;
		$data['logs']				= $this->analytics->getRelaxationZoneLogs();
		$data['unique_visitors']	= $this->analytics->getRelaxationZoneLogsUniqueVisitors();
		$data['stats'] 				= $this->analytics->getRelaxationZoneLogsDateStats();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/relaxation_zone", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function scavenger_hunt_export($param)
	{
		if ($param != 'csv')
			return false;

		$file 		= fopen('php://output', 'w');
		$filename 	= 'Scavenger-Hunt-'.date('Y-m-d').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename = $filename");
		header("Content-Type: application/csv;");
		$header 		= array("User ID", "Name", "Surname", "Degree", "Email","City", "Last Collected Item", "Last Collected");
		fputcsv($file, $header);
		$data 			= $this->analytics->getScavengerHuntData();

		foreach ($data as $row) {

			$csv_data 	= array($row->id, $row->name, $row->surname, $row->credentials, $row->email, $row->city, $row->booth_name, $row->last_collected);
			fputcsv($file, $csv_data);
		}
		fclose($file);
		exit;
	}

	public function scavenger_hunt()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getScavengerHuntData();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/scavenger_hunt", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function trivia_night()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/trivia_night", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function exhibition_hall()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/exhibition_hall", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function scientific_sessions()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/scientific_sessions", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function session_recordings()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/session_recordings", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function skills_transfer_courses()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/skills_transfer_courses", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function eposters()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/eposters", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function overall()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/overall", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function sessions()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/sessions", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function credits_report($section = 1)
	{
		$sidebar_data['user'] = $this->user;
		$data['section'] 	  = $section;
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/credits_report", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllSessionsCredits($session_type)
	{
		$this->logs->log_visit("Sessions credits report of $session_type");
		$post 					= $this->input->post();

		$draw 					= intval($this->input->post("draw"));
		$start 					= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 				= ((intval($this->input->post("length"))) ? $this->input->post("length") : 0 );

		if ($session_type == 'gs') {
			$columns_array 		= array('user.rcp_number', 'user_credits.id', 'credit_filter', 'sessions.name', 'user_credits.credit', 'user_credits.claimed_datetime');
		} else {
			$columns_array 		= array('user.rcp_number', 'user_credits.id', 'credit_filter', '', 'user_credits.credit', 'sessions.name', 'user_credits.claimed_datetime');
		}

		$column_index 			= $post['order'][0]['column'];
		$column_name 			= ((@$columns_array[$column_index]) ? $columns_array[$column_index] : 'user.rcp_number' );
		$column_sort_order 		= (($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'ASC' ); 
		$keyword 				= $post['search']['value'];
		$count 					= $this->analytics->getAllSessionsCreditsCount($session_type, $keyword);

		$query 					= $this->analytics->getAllSessionsCredits($session_type, $start, $length, $column_name, $column_sort_order, $keyword);

		$data 					= [];

		if ($session_type == 'gs') {
			foreach($query as $r) {
				$claimed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $r->claimed_datetime);

				$data[] = array($r->rcp_number,
								'20210624',
								(($r->credit_filter == 'Live&nbsp;Meeting') ? '<span class="badge badge-pill badge-success">'.$r->credit_filter.'</span>' : '<span class="badge badge-pill badge-secondary">'.$r->credit_filter.'</span>' ), 
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
								(($r->credit_filter == 'Live&nbsp;Meeting&nbsp;Credit') ? '<span class="badge badge-pill badge-success">'.$r->credit_filter.'</span>' : '<span class="badge badge-pill badge-secondary">'.$r->credit_filter.'</span>' ), 
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
		$this->logs->log_visit("ePosters credits report");
		$post 				= $this->input->post();

		$draw 				= intval($this->input->post("draw"));
		$start 				= ((intval($this->input->post("start"))) ? $this->input->post("start") : 0 );
		$length 			= ((intval($this->input->post("length"))) ? $this->input->post("length") : 5 );

		$columns_array 		= array('user_credits.id', 'eposters.title', 'credit_filter', 'eposters.type', 'user_credits.credit', 'user_credits.claimed_datetime');
		$column_index 		= $post['order'][0]['column'];
		$column_name 		= ((@$columns_array[$column_index]) ? $columns_array[$column_index] : 'user.rcp_number' );
		$column_sort_order 	= (($post['order'][0]['dir']) ? $post['order'][0]['dir'] : 'ASC' ); 
		$keyword 			= $post['search']['value'];
		$count 				= $this->analytics->getAllEpostersCreditsCount($keyword);

		$query 				= $this->analytics->getAllEpostersCredits($start, $length, $column_name, $column_sort_order, $keyword);

		$data 				= [];
		$table_count 		= 1;

		foreach($query as $r) {
			$claimed_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $r->claimed_datetime);
			$data[] = array($r->rcp_number, 
							'20210624',
							(($r->credit_filter == 'Live&nbsp;Meeting&nbsp;Credit') ? '<span class="badge badge-pill badge-success">'.$r->credit_filter.'</span>' : '<span class="badge badge-pill badge-secondary">'.$r->credit_filter.'</span>' ), 
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

	public function annual_general_meeting()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/annual_general_meeting", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function presidents_celebration()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/presidents_celebration", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function awards_ceremony()
	{
		$sidebar_data['user'] 	= $this->user;
		$data['logs'] 			= $this->analytics->getLogs();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/analytics/awards_ceremony", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function detail()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/staff_login")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer");
	}

}
