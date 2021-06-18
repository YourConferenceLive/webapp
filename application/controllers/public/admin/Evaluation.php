<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url() . $this->project->main_route . "/admin/login"); // Not logged-in

		$this->user =(object) $_SESSION['project_sessions']["project_{$this->project->id}"];

	}

	public function index(){
		$sidebar_data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/evaluation")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function get_evaluation_data(){
		$this->db->select('*')
			->from('evaluation ev')
			->where('ev.project_id', $this->project->id)
		;
		$evaluation =  $this->db->get();
			if($evaluation->num_rows() > 0 )
			{
				$evaluation_data = $evaluation->result();
				echo json_encode($evaluation_data);
			}else{
				echo json_encode('');
			}
	}

	public function evaluationToCSV($evaluation_id){
		$file = fopen('php://output', 'w');
		$filename = 'Evaluation_report'.date('Y-m-d').'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename = $filename");
		header("Content-Type: application/csv;");
		$header = array("Attendee Name", "Q1", "Q2A", "Q2B", "Q2C", "Q2D", "Q3", "Q4", "Total", "Q5", "Q6", "Q7", "Q8", "Q9", "Q10", "Q11");
		fputcsv($file, $header);
		$this->db->distinct()->select('user_id')
			->from('evaluation_answer')
			->where('evaluation_id', $evaluation_id)
		;
		$res = $this->db->get();
		$evaluation_array = array();
		$total=0;
		foreach ($res->result_array() as $user){
			$user['name'] = $this->get_attendee_name($user['user_id']);
			$user['answer'] = $this->get_answer($user['user_id']);
			$evaluation_array[]=$user;
		}
		$data_merge = array();
		foreach ($evaluation_array as $evaluations){
			foreach ($evaluations['name'] as $names){
				$data_merge = array_merge($data_merge, $names);
			}
			foreach ($evaluations['answer'] as $index=>$answers){
				$total = $total+ array_sum($answers);
				$data_merge= array_merge($data_merge, $answers);
				if( $index == 6){
					$data_merge= array_merge($data_merge, array('total_array'=>$total));
				}
			}
			fputcsv($file, $data_merge);
			$total=0;
		}
		fclose($file);
		exit;
	}

	public function get_answer ($user){
		$this->db->select('answer, question_order, eq.question_type')
			->from('evaluation_answer ea')
			->join('evaluation_question eq', 'ea.question_id= eq.id', 'left')
			->where('ea.user_id', $user)
			->where('ea.evaluation_id', '1')
			->where('eq.question_type !=','null')
		;
		$return = $this->db->get();
		if($return->num_rows()>0 ){
			$result_array= array();
			$total=0;
			foreach ($return->result_array() as $result){
				$result_array[] = array('question'.$result['question_order']=>$result['answer']);
			}
			$result_array = array_merge($result_array);
			return $result_array;
		}else{
			return '';
		}
	}

	function get_attendee_name($user_id){
		$this->db->select('CONCAT (name," ",surname) as attendee_name')
			->from('user')
			->where('id', $user_id);
			$user = $this->db->get();
			if($user->num_rows()>0){
				return $user->result_array();
			}else{
				return '';
			}
	}
}
