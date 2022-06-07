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
//		print_r($this->project->id);
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

		}else{
			echo json_encode(array('status'=>'Error','icon'=>'error', 'msg'=>'Email not found'));
		}

	}

	function mailPassword($user_email){
		$email_subject = "Password Reset";
		$email_body = "<p>Hello,<br><br>Please use below link to reset your account Password</p><br><br>" . $link . "<br><br>Best Regards,<br>Conference Team";

		if($user_email){
			if($this->common->sendSmtpEmail( array($user_email,'rexterdayuta@gmail.com'))){
				echo 'success';
			}else{
				echo 'error';
			}
		}
	}
}
