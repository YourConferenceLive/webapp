<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Users_Model', 'users');
		$this->load->model('Account_Model', 'account');
	}

	public function index()
	{
		$sidebar_data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/users/list")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/users/create-user-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllJson(){echo json_encode($this->users->getAll());}

	public function getByIdJson($id){echo json_encode($this->users->getById($id));}

	public function create()
	{
		if ($this->users->create())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function update()
	{
		if ($this->users->update())
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	// DO NOT USE - We only disables a user - not delete
	public function delete($id)
	{
		if ($this->users->delete($id))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function testing()
	{
		echo "<pre>";
		var_dump($this->users->checkEmailExists('athullive@gmail.com'));
		echo "</pre>";
	}

	public function emailExists($email, $print=true)
	{
		if ($print)
			echo ($this->users->emailExists($email))?'true':'false';
		return $this->users->emailExists($email);
	}

	public function resetPasswordsOfAll($access_level)
	{
		$this->account->resetPasswordsOfAll($access_level);
		echo 'done';
	}

	public function resetPasswordOf($user_id)
	{
		if ($this->account->resetPasswordsOf($user_id))
			echo json_encode(array('status'=>'success'));
		else
			echo json_encode(array('status'=>'failed'));
	}

	public function exhibitorsWithoutBooth()
	{
		$sidebar_data['user'] = $this->user;

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/users/exhibitors_without_booth")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/users/create-user-modal")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;
	}

	public function getAllExhibitorsWithoutBoothJson(){echo json_encode($this->users->getExhibitorsWithoutBooth());}
}
