<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function index()
	{
		echo "Dashboard super</br>";
		echo ycl_base_url."Dashboard super</br>";
		echo rtrim(ycl_base_url, 'a/');
	}

	public function test()
	{
		echo "test";
	}

}
