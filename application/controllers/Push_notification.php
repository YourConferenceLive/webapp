<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Push_notification extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Authentication_Model', 'auth');
		$this->load->model('Push_Notification_Model', 'm_push_notification');
	}

	public function getPushNotification(){
		echo json_encode($this->m_push_notification->getPushNotification());
	}
}
