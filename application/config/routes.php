<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'ycl_home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['super_admin'] = 'super_admin/dashboard';

// DO NOT REMOVE
try {
	if (! @include_once('project_routes.php')) // @ - to suppress warnings
		throw new Exception;
	else
		require_once('project_routes.php');
}
catch(Exception $e) {
	$no_config_message = '
	<p style="text-align: center;">&nbsp;</p>
	<p style="text-align: center;">&nbsp;</p>
	<p style="text-align: center;">&nbsp;</p>
	<h2 style="text-align: center;"><span style="color: #993300;">You Don\'t Have </span> <span style="color: #ff0000;">Project Routes</span> <span style="color: #993300;">File</span></h2>
	<p style="text-align: center;">You need to add the project_routes.php file to your <i>root</i> directory</p>
	<p style="text-align: center;">Since this a \'enviroment-related\' file, this file is not version controlled.</p>
	<p style="text-align: center;"><strong>You can manually add empty <span style="color: #ff0000;">project_routes.php</span> file to your <i>root</i> directory</strong></p>
	<p style="text-align: center;">&nbsp;</p>
	<p style="text-align: center;">&nbsp;</p>
	<p style="text-align: center;"><strong>Your Conference Live &copy; - All Rights Reserved</strong></p>
	';
	echo $no_config_message;
	die();
}
