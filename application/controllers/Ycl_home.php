<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ycl_home extends CI_Controller {


	/**
	 * This is the default controller of YCL website
	 */
	public function index()
	{
		$this->load->view('ycl_website/new_website/index');
	}

	public function contacts()
	{
		$this->load->view('ycl_website/new_website/contacts');
	}

	public function webinars()
	{
		$this->load->view('ycl_website/new_website/webinars');
	}

	public function ars()
	{
		$this->load->view('ycl_website/new_website/ars');
	}

	public function learning_module()
	{
		$this->load->view('ycl_website/new_website/learning_module');
	}

	public function abstracts()
	{
		$this->load->view('ycl_website/new_website/abstracts');
	}

	public function special()
	{
		$this->load->view('ycl_website/new_website/special');
	}

	public function virtual()
	{
		$this->load->view('ycl_website/new_website/virtual');
	}

	public function services()
	{
		$this->load->view('ycl_website/new_website/services');
	}

	public function hybrid()
	{
		$this->load->view('ycl_website/new_website/hybrid');
	}

	public function mishkaprofile()
	{
		$this->load->view('ycl_website/new_website/mishka-profile');
	}

	public function shannonprofile()
	{
		$this->load->view('ycl_website/new_website/shannon-profile');
	}

	public function markprofile()
	{
		$this->load->view('ycl_website/new_website/mark-profile');
	}



	function sendEmail() {
		$sendTo = trim($this->input->post('mailto'));
		$email_from = trim($this->input->post('email'));
		$name = trim($this->input->post('name'));
		$phone = trim($this->input->post('phone'));
		$message = trim($this->input->post('message'));

		$data['email'] = $email_from;
		$data['name'] = $name;
		$data['phone'] = $phone;
		$data['message'] = $message;

		$mail_template = ($this->load->view('ycl_website/new_website/mail_template', $data, true));

		if($email_from) {
			$from = "Yourconference.live";
			$config = array(
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($from, $name);
			$this->email->to($sendTo);
//			$this->email->subject('Contact');
			$this->email->message($mail_template);
			if ($this->email->send()) {
				return 1;
			} else {
				return 0;
			}
		}
	}

// To view the email template, For testing only
	public function mailtemp(){
		$this->load->view('ycl_website/new_website/mail_template.php');
	}

//Testing email localhost
	 function testSmtp(){

		$post = $this->input->post();
//		$siteKey = "6LdK7nEeAAAAAH4QB_UpWGDxvt53HxWz5MiWFHg6";
		$secretKey = "6LdK7nEeAAAAAH3KmJ1g4qvYR4LcDxz_CJrLj5YM";

		 if($post['g-recaptcha-response'])
			 $captcha=$post['g-recaptcha-response'];

		 if(!$captcha){
			 echo '<h2>Please check the the captcha form.</h2>';
			 exit;
		 }

		 $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
		 if($response['success'] == true)
		 {
			 $sendTo = trim($this->input->post('mailto'));

			 $email_from = trim($this->input->post('email'));
			 $name = trim($this->input->post('name'));
			 $phone = trim($this->input->post('phone'));
			 $message = trim($this->input->post('message'));

			 $data['email'] = $email_from;
			 $data['name'] = $name;
			 $data['phone'] = $phone;
			 $data['message'] = $message;

			 $mail_template = ($this->load->view('ycl_website/new_website/mail_template', $data, true));
			 if($email_from){
				 if($this->common->sendSmtpEmail( array($sendTo,'rexterdayuta@gmail.com'), $name, $mail_template)){
					 echo 'success';
				 }else{
					 echo 'error';
				 }
			 }
		 }
		 else
		 {
			 echo json_encode('error');
		 }

		 exit;
	}
}
