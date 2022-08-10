<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Users_Model', 'user_m');
		$this->load->model('Logger_Model', 'logger');
	}

	public function index(){
		print_r($this->project->id);
	}
	public function forgotPresenterPassword()
	{
		$post = $this->input->post();
		$result = $this->db->select('*')
			->from('user u')
			->join('user_project_access upa', 'u.id = upa.user_id')
			->where('u.email', $post['email'])
			->where('upa.project_id', $this->project->id)
			->where('upa.level', 'presenter')
			->get();

		if($result->num_rows()>0){
			if($this->mailPassword($post['email']) == true){
				echo json_encode(array('status'=>'Success','icon'=>'success', 'msg'=>'Email sent, Check your email address for password recovery'));
			}
			echo json_encode(array('status'=>'Error','icon'=>'error', 'msg'=>'Failed to send email'));
		}else{
			echo json_encode(array('status'=>'Error','icon'=>'error', 'msg'=>'Email not found'));
		}

	}

	function mailPassword($user_email){

			$result = $this->db->select('u.id')
			->from('user u')
			->join('user_project_access upa', 'u.id = upa.user_id')
			->where('upa.level','presenter')
			->where('u.email', $user_email)
			->where('upa.project_id', $this->project->id)
			->get();

		if($result->num_rows() > 0){
			$user = $result->row();

			$link = $this->project_url."/forgot_password/changePassword/" . base64_encode($user->id);

			$email_subject = "Password Reset";
			$email_body = "<p>Hello,<br><br>Please use below link to reset your account Password</p><br><br>".$link."<br><br>Best Regards,<br>Conference Team";

			if($this->common->sendSmtpEmail( $user_email, $email_subject, $email_body)){
				return true;
			}else{
				return false;
			}
		}
	}


	public function changePassword($base_64_user_id){
		$data['user_id'] = $base_64_user_id;
		$this->load
		->view("{$this->themes_dir}/{$this->project->theme}/common/change_password", $data);
	}



	public function updatePassword(){

		$user_id = base64_decode($this->input->post('user_id'));
		$result = $this->db->select('*')
			->from('user u')
			->join('user_project_access upa', 'u.id = upa.user_id')
			->where('u.id', $user_id)
			->where('upa.level','presenter')
			->where('u.id', $user_id)
			->where('upa.project_id', $this->project->id)
			->get();

		if($result->num_rows() > 0){
			$this->db->where('id', $user_id);
			$this->db->update('user', array('password'=>password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)));

			if($this->db->affected_rows() > 0){
				echo json_encode(array('status' => 'success', 'msg'=> 'Password updated successfully'));
			}else
				echo json_encode(array('status' => 'error', 'msg'=> 'Problem changing password'));
		}else{
			echo json_encode(array('status'=>'error', 'msg'=> 'User not found, contact administrator'));
		}

	}

}
