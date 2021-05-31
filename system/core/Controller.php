<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

	/**
	 * @var object
	 */
	public $project;

	/**
	 * @var object
	 */
	public $themes_dir;
	/**
	 * @var string
	 */
	public $project_url;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}


		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();

		$project_route = explode("/", str_replace(ycl_base_url,"",current_url()), 2);
		$project_route = $project_route[0];

		$this->db->select('p.*');
		$this->db->from('project p');
		$this->db->join('project_routes r', 'r.project_id = p.id', 'left');
		$this->db->where('p.main_route', $project_route);
		$this->db->or_where('r.route', $project_route);
		$result = $this->db->get();
		if ($result->num_rows() > 0)
		{
			$this->project = $result->row();
			$this->themes_dir = 'themes';
			$this->project_url = base_url($this->project->main_route);

			date_default_timezone_set($this->project->timezone);

			if ($this->project->active == 0) // If project is suspended, show error
			{
				echo $this->load->view('errors/project/suspended', array('project_name'=>$this->project->name))
					->output
					->final_output;
				die();
			}
		}
		else
		{
			$this->project = false;

			if
			(
				$project_route != '' &&
				$project_route != 'super_admin' &&
				$project_route != 'project_api' &&
				$project_route != 'api'
			)
			{
				echo $this->load->view('errors/project/not_found', array('project_name'=>$project_route))
					->output
					->final_output;
				die();
			}
		}

		log_message('info', 'Controller Class Initialized');

	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

}
