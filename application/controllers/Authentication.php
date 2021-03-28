<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Authentication_Model', 'auth');
		$this->load->model('Logger_Model', 'logger');
	}

	public function login()
	{
		$project_id = $this->project->id;
		$username = $this->input->post()['email'];
		$password = $this->input->post()['password'];

		$access_level = $this->input->post()['access_level'];

		$verification = $this->auth->verifyLogin($project_id, $username, $password);

		if ($verification['status'])
		{
			if ($verification['user']->active)
			{
				if (in_array($access_level, $verification['user']->access_levels))
				{
					$current_project_sessions = $this->session->userdata('project_sessions');

					$current_project_sessions["project_$project_id"] = array(
						'user_id' => $verification['user']->id,
						'name' => $verification['user']->name,
						'surname' => $verification['user']->surname,
						'email' => $verification['user']->email,
						'is_attendee' => (in_array('attendee', $verification['user']->access_levels))?1:0,
						'is_moderator' => (in_array('moderator', $verification['user']->access_levels))?1:0,
						'is_presenter' => (in_array('presenter', $verification['user']->access_levels))?1:0,
						'is_admin' => (in_array('admin', $verification['user']->access_levels))?1:0
					);

					$this->session->set_userdata(array('project_sessions' => $current_project_sessions));

					$response = array('status'=>'success', 'msg'=>'Login successful');
					$this->logger->add($project_id, $verification['user']->id, 'Logged-in');
				}else{
					$this->logger->add($project_id, $verification['user']->id, 'Access denied', "No {$access_level} level access");
					$response = array('status'=>'error', 'msg'=>"You have no {$access_level} level access to this project");
				}

			}else{$this->logger->add($project_id, $verification['user']->id, 'Access denied', "Account has been suspended");

				$response = array('status'=>'error', 'msg'=>'Account has been suspended');
			}

		}else{
			// Errors are added to log record in the model
			$response = array('status'=>'error', 'msg'=>$verification['msg']);
		}

		echo json_encode($response);
	}

	public function logout()
	{
		$project_id = $this->project->id;
		$user_id = $_SESSION['project_sessions']["project_{$project_id}"]['user_id'];

		unset($_SESSION['project_sessions']["project_{$project_id}"]);
		$this->logger->add($project_id, $user_id, 'Logged-out');
		redirect(base_url().$this->project->main_route);
	}
}
