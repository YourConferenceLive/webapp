<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		print_r($this->project); exit;
	}
}
