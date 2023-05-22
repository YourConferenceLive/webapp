<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Authentication_Model', 'auth');
		$this->load->model('Users_Model', 'user_m');
		$this->load->model('Logger_Model', 'logger');
	}

	public function login()
	{
		$project_id = $this->project->id;
		$username = $this->input->post()['email'];
		$password = $this->input->post()['password'];
		$access_level = $this->input->post()['access_level'];
//		print_r($username);exit;

//		$email_org = explode('@', $username);
//		if(ycl_env == 'production' && $access_level == 'attendee' && $email_org[1] != 'cos-sco.ca') // Only staff have access for now on prod
//		{
//			$response = array('status'=>'error', 'msg'=>"You are not a COS staff.");
//			echo json_encode($response);
//			return;
//		}

		$this->updateProfileFromCos($username);

		$verification = $this->auth->verifyLogin($project_id, $username, $password);

		if ($verification['status'])
		{
			if ($verification['user']->active)
			{
				if (in_array($access_level, $verification['user']->access_levels))
				{
					$token = $this->auth->update_user_token($verification['user']->id);
					$current_project_sessions = $this->session->userdata('project_sessions');

					$current_project_sessions["project_$project_id"] = array(
						'user_id' => $verification['user']->id,
						'name' => $verification['user']->name,
						'surname' => $verification['user']->surname,
						'email' => $verification['user']->email,
						'photo' => $verification['user']->photo,
						'homepage_redirect' => (isset($verification['homepage']->homepage_redirect) ? $verification['homepage']->homepage_redirect: 'lobby'),
						'is_attendee' => (in_array('attendee', $verification['user']->access_levels))?1:0,
						'is_moderator' => (in_array('moderator', $verification['user']->access_levels))?1:0,
						'is_presenter' => (in_array('presenter', $verification['user']->access_levels))?1:0,
						'is_admin' => (in_array('admin', $verification['user']->access_levels))?1:0,
						'is_exhibitor' => (in_array('exhibitor', $verification['user']->access_levels))?1:0,
						'is_mobile_attendee' => (in_array('mobile_attendee', $verification['user']->access_levels))?1:0,
						'token'=>$token,
					);

					if (in_array('exhibitor', $verification['user']->access_levels))
						$current_project_sessions["project_$project_id"]['exhibitor_booth_id'] = $this->auth->getBoothByUser($verification['user']->id);

					if
					(
						$access_level == 'exhibitor' &&
						in_array('exhibitor', $verification['user']->access_levels) &&
						$current_project_sessions["project_$project_id"]['exhibitor_booth_id'] == null
					)
					{
						$this->logger->add($project_id, $verification['user']->id, 'Booth management access denied', "Not assigned to any booths");
						$response = array('status'=>'error', 'msg'=>"You are registered as an exhibitor but no booth is assigned to you yet.");
						echo json_encode($response);
						return;
					}

					$this->session->set_userdata(array('project_sessions' => $current_project_sessions));
					$project_sessions = ($this->session->userdata('project_sessions')['project_' . $this->project->id]['homepage_redirect']);
					if($project_sessions){
						$data['homepage_redirect'] = $project_sessions;
					}else{
						$data['homepage_redirect'] ='lobby';
					}
					$response = array('status'=>'success', 'msg'=>'Login successful', 'data'=>$data);

					$this->logger->add($project_id, $verification['user']->id, 'Logged-in');
				}else{
					$this->logger->add($project_id, $verification['user']->id, 'Access denied', "No {$access_level} level access");
					$response = array('status'=>'error', 'msg'=>"You have no {$access_level} level access to this project");
				}

			}else{$this->logger->add($project_id, $verification['user']->id, 'Access denied', "Account has been suspended");

				$response = array('status'=>'error', 'msg'=>'Account has been suspended');
			}

		}else{

			$api_config = array(
				'api_url' => $this->project->api_url,
				'api_username' => $this->project->api_username,
				'api_password' => $this->project->api_password
			);

			if ($this->project->api_url == null)
			{
				$response = array('status'=>'error', 'msg'=>"Authentication API is not configured");
				echo json_encode($response);
				return false;
			}


			$this->load->library('CosApi', $api_config);

			$user_from_cos = $this->cosapi->getUserByEmail($username);

			if (!isset($user_from_cos->Count) || $user_from_cos->Count < 1)
			{
				$response = array('status'=>'error', 'msg'=>"We couldn't find you in the COS database.");
				echo json_encode($response);
				return false;
			}

			$user_from_cos = (array) $user_from_cos;
			$user_from_cos = (array) $user_from_cos['Items'];
			$user_from_cos = (array) $user_from_cos['$values'];
			$user_from_cos = (array) $user_from_cos[0];

			$isAttendee = 0;
			$isExhibitor = 0;
			$membership_info = $this->cosapi->getMembershipType($user_from_cos['PartyId']);

			$membership_sub_info = NULL;
			if ($membership_info == 'C') // "Contact" type members will have a Sub Category
			{
				$membership_sub_info = $this->cosapi->getMembershipSubType($user_from_cos['PartyId']);
			}

			$cos21VirtualRegCheck = $this->cosapi->cos21VirtualRegCheck($user_from_cos['PartyId']);
			if (!isset($cos21VirtualRegCheck->Count) || $cos21VirtualRegCheck->Count < 1)
			{
				if ($membership_info == 'C' && $membership_sub_info == 'IR')
				{
					$cosRepReg2021RegCheck = $this->cosapi->cosRepReg2021RegCheck($user_from_cos['PartyId']);
					if (!isset($cosRepReg2021RegCheck->Count) || $cosRepReg2021RegCheck->Count < 1)
					{
						$response = array('status'=>'error', 'msg'=>"You are not registered for the COS Virtual Event 2021.");
						echo json_encode($response);
						return false;
					}else{
						$isExhibitor = 1;
					}
				}

			}else{
				$isAttendee = 1;

				if ($membership_info == 'C' && $membership_sub_info == 'IR')
				{
					$cosRepReg2021RegCheck = $this->cosapi->cosRepReg2021RegCheck($user_from_cos['PartyId']);
					if (!isset($cosRepReg2021RegCheck->Count) || $cosRepReg2021RegCheck->Count < 1)
					{
						$isExhibitor = 0;
					}else{
						$isExhibitor = 1;
					}
				}
			}

			if ($password != 'COS2021')
			{
				$response = array('status'=>'error', 'msg'=>"Incorrect password.");
				echo json_encode($response);
				return;
			}


			$address_data = (array) $user_from_cos['Addresses'];
			$address_data = (array) $address_data['$values'];
			$address_data = (array) $address_data[0];
			$address_data = (array) $address_data['Address'];

			$email = (array) $user_from_cos['Emails'];
			$email = (array) $email['$values'];
			$email = (array) $email[0];
			$email = $email['Address'];

			$user_data = array(
				'isFromApi' => 1,
				'IdFromApi' => $user_from_cos['PartyId'],
				'email' => $email,
				'password' => password_hash('COS2021', PASSWORD_DEFAULT),
				'name' => $user_from_cos['PersonName']->FirstName,
				'surname' => $user_from_cos['PersonName']->LastName,
				'name_prefix' => $user_from_cos['PersonName']->NamePrefix,
				'credentials' => (isset($user_from_cos['PersonName']->Designation))?$user_from_cos['PersonName']->Designation:'',
				'city' => $address_data['CityName'],
				'country' => $address_data['CountryName'],
				'membership_type' => $membership_info,
				'membership_sub_type' => $membership_sub_info,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => 0,
			);

			$this->db->insert('user', $user_data);

			if ($this->db->affected_rows() > 0) {

				if ($membership_sub_info != 'IR')
				{
					$project_id = $this->project->id;
					$user_id = $this->db->insert_id();
					$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$project_id, 'level'=>'attendee'));
				}


				/********** Login API user *********/
				$current_project_sessions = $this->session->userdata('project_sessions');

				$current_project_sessions["project_$project_id"] = array(
					'user_id' => $user_id,
					'name' => $user_data['name'],
					'surname' => $user_data['surname'],
					'email' => $user_data['email'],
					'photo' => '',
					'is_attendee' => $isAttendee,
					'is_moderator' => 0,
					'is_presenter' => 0,
					'is_admin' => 0,
					'is_exhibitor' => $isExhibitor
				);

				if ($isExhibitor)
					$current_project_sessions["project_$project_id"]['exhibitor_booth_id'] = $this->auth->getBoothByUser($user_id);

				if
				(
					$isExhibitor &&
					$current_project_sessions["project_$project_id"]['exhibitor_booth_id'] == null
				)
				{
					$this->logger->add($project_id, $user_id, 'Booth management access denied', "Not assigned to any booths");
					$response = array('status'=>'error', 'msg'=>"You are registered as an exhibitor but no booth is assigned to you yet.");
					echo json_encode($response);
					return;
				}

				$this->session->set_userdata(array('project_sessions' => $current_project_sessions));

				$this->logger->add($project_id, $user_id, 'Logged-in');
				/******************* ./ Login API User *********************/


				// Errors are added to log record in the model
				$response = array('status'=>'success', 'msg'=>'Login successful, we are redirecting you.');
				echo json_encode($response);
				return false;

			}else{
				// Errors are added to log record in the model
				$response = array('status'=>'error', 'msg'=>'Unable to create an account for you');
				echo json_encode($response);
				return false;
			}

		}

		echo json_encode($response);
	}

	public function logout($where='')
	{
		$project_id = $this->project->id;
		$user_id = $_SESSION['project_sessions']["project_{$project_id}"]['user_id'];

		if ($where != '')
			$where = base64_decode($where);

		unset($_SESSION['project_sessions']["project_{$project_id}"]);
		$this->logger->add($project_id, $user_id, 'Logged-out');
		redirect(base_url().$this->project->main_route.'/'.$where);
	}

	public function updateProfileFromCos($username)
	{
		$api_config = array(
			'api_url' => $this->project->api_url,
			'api_username' => $this->project->api_username,
			'api_password' => $this->project->api_password
		);

		if ($this->project->api_url == null)
		{
			return array('status'=>'error', 'msg'=>"Authentication API is not configured");
		}


		$this->load->library('CosApi', $api_config);

		$user_from_cos = $this->cosapi->getUserByEmail($username);

		if (!isset($user_from_cos->Count) || $user_from_cos->Count < 1)
		{
			return array('status'=>'error', 'msg'=>"We couldn't find you in the COS database.");
		}

		$user_from_cos = (array) $user_from_cos;
		$user_from_cos = (array) $user_from_cos['Items'];
		$user_from_cos = (array) $user_from_cos['$values'];
		$user_from_cos = (array) $user_from_cos[0];

		$membership_info = $this->cosapi->getMembershipType($user_from_cos['PartyId']);

		$membership_sub_info = NULL;
		if ($membership_info == 'C') // "Contact" type members will have a Sub Category
		{
			$membership_sub_info = $this->cosapi->getMembershipSubType($user_from_cos['PartyId']);
		}

		$address_data = (array) $user_from_cos['Addresses'];
		$address_data = (array) $address_data['$values'];
		$address_data = (array) $address_data[0];
		$address_data = (array) $address_data['Address'];

		$email = (array) $user_from_cos['Emails'];
		$email = (array) $email['$values'];
		$email = (array) $email[0];
		$email = $email['Address'];

		$user_data = array(
			'name' => $user_from_cos['PersonName']->FirstName,
			'surname' => $user_from_cos['PersonName']->LastName,
			'name_prefix' => $user_from_cos['PersonName']->NamePrefix,
			'credentials' => (isset($user_from_cos['PersonName']->Designation))?$user_from_cos['PersonName']->Designation:'',
			'city' => $address_data['CityName'],
			'country' => $address_data['CountryName'],
			'membership_type' => $membership_info,
			'membership_sub_type' => $membership_sub_info,
			'updated_on' => date('Y-m-d H:i:s'),
			'updated_by' => 0,
		);

		$this->db->set($user_data);
		$this->db->where('IdFromApi', $user_from_cos['PartyId']);
		$this->db->update('user');

		if ($membership_info == 'C' && $membership_sub_info == 'IR')
		{

			$user_id = $this->user_m->getIdByApiId($user_from_cos['PartyId']);

			$this->db->where('project_id', $this->project->id);
			$this->db->where('user_id', $user_id);
			$this->db->delete('user_project_access');

			$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'attendee'));
			$this->db->insert('user_project_access', array('user_id'=>$user_id, 'project_id'=>$this->project->id, 'level'=>'exhibitor'));
		}

		return true;
	}

	function cco_authentication() {
		// print_r('test');exit;

		$token = $this->input->get('token');
		$project_id = $this->project->id;
		$response_array = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));
		// print_r($response_array);exit;

		if (isset($response_array) && !empty($response_array)) {

			$or_where = '(email = "' . $response_array->identity->email . '")';
			$this->db->where($or_where);
			$users = $this->db->get('user');
			if ($users->num_rows() > 0) {
				$user_details = $users->row();
				$set_update_array = array(
					'name' => $response_array->identity->firstname,
					'surname' => $response_array->identity->lastname,
					'email' => $response_array->identity->email,
					// 'bio' => $response_array->identity->degree,
					// 'credentials' => $user_details->bio	,
					// 'country' => $user_details->country,
//					'zipcode' => $user_details->zipcode,
					'identifier_id' => $response_array->identity->identifier,
					'api_session' => $response_array->session,
					'iat' => $response_array->iat,
					'aud' => json_encode($response_array->aud),
					'exp' => $response_array->exp,
					'jti' => $response_array->jti,
					'updated_on'=> date('Y-m-d H:i'),
				);

				$this->db->update("user", $set_update_array, array("id"  => $user_details->id));
				$token = $this->auth->update_user_token($user_details->id);
				$project_access = $this->auth->cco_auth_project_access($user_details->id);

				$current_project_sessions["project_$project_id"] = array(
					'user_id' => $user_details->id,
					'name' => $user_details->name,
					'surname' => $user_details->surname,
					'email' => $user_details->email,
					'photo' => '',
					'is_attendee' => 1,
					'is_moderator' => 0,
					'is_presenter' => 0,
					'is_admin' => 0,
					'is_exhibitor' => 0,
					'token' => $token,
				);

				$this->session->set_userdata(array('project_sessions' => $current_project_sessions));

				$sessions = $this->db->get_where('sessions', array('id' => $response_array->session));
				if ($sessions->num_rows() > 0) {
					redirect(base_url().$this->project->name.'/sessions/join/'.$sessions->result_array()[0]['id']);
				} else {
					redirect(base_url().$this->project->name.'/sessions/'.'session_missing');
				}
			} else {
				$this->db->order_by("id", "desc");
				$row_data = $this->db->get("user")->row();
//				if (!empty($row_data)) {
//					$reg_id = $row_data->cust_id;
//					$register_id = date("Y") . '-20' . $reg_id;
//				} else {
//					$register_id = date("Y") . '-200';
//				}
				$set = array(
//					"register_id" => $register_id,
					'name' => $response_array->identity->firstname,
					'surname' => $response_array->identity->lastname,
					'email' => $response_array->identity->email,
					'password' => password_hash('12345', PASSWORD_DEFAULT),
//					'specialty' => "",
					// 'bio' => $response_array->identity->degree,
					// 'country' => "",
					'identifier_id' => $response_array->identity->identifier,
					'api_session' => $response_array->session,
					'iat' => $response_array->iat,
					'exp' => $response_array->exp,
					'aud' => json_encode($response_array->aud),
					'jti' => $response_array->jti,
					// 'city' => "",
					'created_on' => date("Y-m-d h:i")
				);
				$this->db->insert("user", $set);
				$user_id = $this->db->insert_id();
				$user_details = $this->db->get_where("user", array("id" => $user_id))->row();
				if (!empty($user_details)) {
					$token = $this->auth->update_user_token($user_details->id);
					$project_access = $this->auth->cco_auth_project_access($user_details->id);

					$current_project_sessions["project_$project_id"] = array(
						'user_id' => $user_details->id,
						'name' => $user_details->name,
						'surname' => $user_details->surname,
						'email' => $user_details->email,
						'photo' => '',
						'is_attendee' => 1,
						'is_moderator' => 0,
						'is_presenter' => 0,
						'is_admin' => 0,
						'is_exhibitor' => 0,
						'token' => $token,
						'updated_on', date('Y-m-d H:i')
					);

					$this->session->set_userdata(array('project_sessions' => $current_project_sessions));
					$sessions = $this->db->get_where('sessions', array('id' => $response_array->session));
					if ($sessions->num_rows() > 0) {
						redirect(base_url().$this->project->name.'/sessions/join/'.$sessions->result_array()[0]['sessions_id']);
					} else {
						redirect(base_url().$this->project->name.'/sessions/'.'session_missing');
					}
				}
			}
		}
	}

	public function decode(){
		print_R(base64_decode('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjEzODY4OTkxMzEsImlzcyI6ImppcmE6MTU0ODk1OTUiLCJxc2giOiI4MDYzZmY0Y2ExZTQxZGY3YmM5MGM4YWI2ZDBmNjIwN2Q0OTFjZjZkYWQ3YzY2ZWE3OTdiNDYxNGI3MTkyMmU5IiwiaWF0IjoxMzg2ODk4OTUxfQ.uKqU9dTB6gKwG6jQCuXYAiMNdfNRw98Hw_IWuA5MaMo'));
	}

}
