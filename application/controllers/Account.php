<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Account_Model', 'account');
	}

	public function register()
	{
		echo json_encode($this->account->register());
	}
}
