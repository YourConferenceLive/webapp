<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Logger_Model', 'logger');
		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];
//		print_r($this->user['user_id']);exit;
	}


	function get_evaluation_question($id){
		$this->db->select('*')
			->from('evaluation_question eq')
			->where('eq.evaluation_id', $id)
			->order_by('id', 'asc')
		;
		$result = $this->db->get();
		$answer_array = array();
		if($result->num_rows() > 0){
			foreach ($result->result() as $val){
				$val->answer = $this->get_evaluation_answer($val->evaluation_id, $val->id);
				$answer_array[] = $val;
			}
			return $answer_array;
		}else{
			return '';
		}
	}

	function get_evaluation($id){
		$this->db->select('*')
			->from('evaluation')
			->where('id', $id)
			->where('project_id', $this->project->id)
		;
		$response = $this->db->get();
		if($response->num_rows() > 0)
		{
			$evaluation = $response->result()[0];
			$evaluation->questions =  $this->get_evaluation_question($evaluation->id);

			return  $evaluation;
		}

		return new stdClass();
	}

	function get_evaluation_question_count($id){
		$this->db->select('COUNT(*) as count')
			->from('evaluation_question')
			->where('evaluation_id', $id)
;
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result()[0]->count;
		}else{
			return '';
		}
	}

	 function save_evaluation()
	{
		$post = $this->input->post();
		foreach ($post['answer'] as $item=>$answer){
			$fields_array = array(
				'user_id' => $this->user['user_id'],
				'question_id' =>$item,
				'answer' => "$answer",
				'project_id' => $this->project->id,
				'evaluation_id' => $post['evaluation_id']
			);
			if ($this->check_answer_exist($post['evaluation_id'], $item)) {
				$this->db->insert('evaluation_answer', $fields_array);
			}else{
				$this->db->where('evaluation_id', $post['evaluation_id']);
				$this->db->where('question_id', $item);
				$this->db->where('project_id', $this->project->id);
				$this->db->where('user_id', $this->user['user_id']);
				$this->db->update('evaluation_answer', array('answer'=>$answer));
			}
		}
		return 'success';
	}

	function check_answer_exist($evaluation_id, $question_id){
		$this->db->select('*')
			->from('evaluation_answer')
			->where('user_id', $this->user['user_id'])
			->where('evaluation_id', $evaluation_id)
			->where('question_id', $question_id)
			->where('project_id', $this->project->id)
		;
		$result = $this->db->get();
		if($result->num_rows() > 0 ){
			return false;
		}else{
			return true;
		}
	}

	function get_evaluation_answer($evaluation_id, $question_id){
		$this->db->select('*')
			->from('evaluation_answer')
			->where('evaluation_id', $evaluation_id)
			->where('question_id', $question_id)
			->where('user_id', $this->user['user_id'])
			;
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $result->result()[0]->answer;
		}else{
			return '';
		}
	}

}
