<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Authentication_Model', 'auth');
		$this->load->model('Users_Model', 'user_m');
		$this->load->model('Logger_Model', 'logger');
	}

	public function num()
	{
		$response = 123;
		echo json_encode($response);
		return;
	}
}
