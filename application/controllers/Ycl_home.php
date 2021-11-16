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
	public function testSmtp(){

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
			if($this->common->sendSmtpEmail( $sendTo, $name, $mail_template)){
				echo 'success';
			}else{
				echo 'error';
			}
		}

	}
}
