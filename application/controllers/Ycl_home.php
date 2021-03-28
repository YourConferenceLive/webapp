<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ycl_home extends CI_Controller {


	/**
	 * This is the default controller of YCL website
	 */
	public function index()
	{
		$this->load->view('ycl_website/coming_soon/home');
	}
}
