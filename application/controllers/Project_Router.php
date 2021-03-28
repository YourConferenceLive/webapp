<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Project_Router
 *
 * This controller is used to route user request to individual projects(conference/webinar/client)
 */

class Project_Router extends CI_Controller
{
	private $themes_dir = 'themes/';
	private $theme;
	private $project;

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('global_js');
	}

	public function index($project_id = '1', $user = '', $path = 'landing_page', $param1 = '', $param2 = '', $param3 = '')
	{
		$project = $this->db->get_where('project', array("id" => $project_id))->row();

		if ($project->active == 0) // If project is suspended, show error
		{
			echo $project->name." project has been suspended!";
			die();
		}

		$this->project = $project;

		if ($path == 'logout')
		{
			$this->logout($project_id);
			return;
		}

		switch ($user)
		{
			case "attendee":
				$path = "attendee_{$path}";
				break;
			case "presenter":
				$path = "presenter_{$path}";
				break;
			case "admin":
				$path = "admin_{$path}";
				break;
			default:
				$path = "{$path}";
		}

		if(method_exists($this, $path)) // If the requested path exists, load the path, else show 404
		{
			date_default_timezone_set($project->timezone);

			$this->theme = $project->theme;

			$this->$path($project_id, $this->theme, $param1, $param2, $param3);

		}else{
			show_404();
		}
	}

	public function __destruct()
	{
		if (isset($this->theme) && $this->theme != '')
		{
			$contextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);
			$page_load_animation = file_get_contents(base_url()."theme_assets/$this->theme/page_loading_animation.php?ycl_root=".ycl_root, false, stream_context_create($contextOptions));
			print($page_load_animation);
		}

		echo global_js();
	}


	/**
	 * Attendee Paths
	 * @param $project
	 * @param $theme
	 * @param $param1
	 * @param $param2
	 * @param $param3
	 */

	public function attendee_landing_page($project, $theme, $param1, $param2, $param3)
	{
		$data['project'] = $this->project;

		if (isset($_SESSION['project_sessions']["project_$project"]) && $_SESSION['project_sessions']["project_$project"]['is_attendee'] == 1)
		{
			redirect(base_url().$this->project->main_route."/lobby");
			return;
		}

		$this->load->view("$this->themes_dir/$theme/attendee/common/header", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/landing_page", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/common/footer", $data);
	}

	public function attendee_login($project, $theme, $param1, $param2, $param3)
	{
		$data['project'] = $this->project;

		if (isset($_SESSION['project_sessions']["project_$project"]) && $_SESSION['project_sessions']["project_$project"]['is_attendee'] == 1)
		{
			redirect(base_url().$this->project->main_route."/lobby");
			return;
		}

		$this->load->view("$this->themes_dir/$theme/attendee/common/header", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/login", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/common/footer", $data);
	}

	public function attendee_register($project, $theme, $param1, $param2, $param3)
	{
		$data['project'] = $this->project;

		if (isset($_SESSION['project_sessions']["project_$project"]) && $_SESSION['project_sessions']["project_$project"]['is_attendee'] == 1)
		{
			redirect(base_url().$this->project->main_route."/lobby");
			return;
		}

		$this->load->view("$this->themes_dir/$theme/attendee/common/header", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/register", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/common/footer", $data);
	}


	public function attendee_lobby($project, $theme, $param1, $param2, $param3)
	{
		$data['project'] = $this->project;

		if (!isset($_SESSION['project_sessions']["project_$project"]) || $_SESSION['project_sessions']["project_$project"]['is_attendee'] != 1)
		{
			redirect(base_url().$this->project->main_route);
			return;
		}

		$this->load->view("$this->themes_dir/$theme/attendee/common/header", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/lobby", $data);
		$this->load->view("$this->themes_dir/$theme/attendee/common/footer", $data);
	}


	/**
	 * Presenter Paths
	 * @param $project
	 * @param $theme
	 * @param $param1
	 * @param $param2
	 * @param $param3
	 */

	public function presenter_login($project, $theme, $param1, $param2, $param3)
	{
		$this->load->view("$this->themes_dir/$theme/presenter/common/header");
		$this->load->view("$this->themes_dir/$theme/presenter/login");
		$this->load->view("$this->themes_dir/$theme/presenter/common/footer");
	}


	/**
	 * Admin Paths
	 * @param $project
	 * @param $theme
	 * @param $param1
	 * @param $param2
	 * @param $param3
	 */

	public function admin_login($project, $theme, $param1, $param2, $param3)
	{
		$this->load->view("$this->themes_dir/$theme/admin/common/header");
		$this->load->view("$this->themes_dir/$theme/admin/login");
		$this->load->view("$this->themes_dir/$theme/admin/common/footer");
	}

	public function admin_dashboard($project, $theme, $param1, $param2, $param3)
	{
		$this->load->view("$this->themes_dir/$theme/admin/common/header");
		$this->load->view("$this->themes_dir/$theme/admin/dashboard");
		$this->load->view("$this->themes_dir/$theme/admin/common/footer");
	}


	/**
	 * Common Paths
	 * @param $project_id
	 */

	public function logout($project_id)
	{
		unset($_SESSION['project_sessions']["project_$project_id"]);
		redirect(base_url().$this->project->main_route);
	}
}
