<?php
if(!function_exists('global_js'))
{
	function global_js()
	{
		$CI =& get_instance();

		$js_methods = '';
		$js_variables = '';
		$js_start_tag = '
	<script>';
		$js_end_tag = '
	</script>'."\n\n";

		$js_variables .= "		let project_id = '{$CI->project->id}';
		let project_timezone = '{$CI->project_timezone}';
		let project_url = '{$CI->project_url}';
		let project_admin_url = '{$CI->project_url}/admin';
		let project_presenter_url = '{$CI->project_url}/presenter';
		let ycl_root = '".ycl_root."';

		let access_color_codes = {'admin':'#e60b2a', 'presenter':'#228893', 'moderator':'#b37f04', 'attendee':'#007bff', 'exhibitor':'#9409d2'};
		let access_icons = {'admin':'fas fa-user-shield', 'presenter':'fas fa-id-card', 'moderator':'fas fa-user-tie', 'attendee':'fas fa-user', 'exhibitor':'fas fa-child'};";


		/**
		 * Global JS Methods
		 *
		 *  Important: prepend method names with yc_global_
		 */

		$js_methods .= '
		function yc_global_sleep(milliseconds) {
			const date = Date.now();
			let currentDate = null;
			do {
				currentDate = Date.now();
			} while (currentDate - date < milliseconds);
		}'."\n";

		$js_methods .= '
		function pad(n) {
			return (n < 10 ? "0" + n : n);
		}';

		$global_js = "$js_start_tag \n $js_variables \n $js_methods \n $js_end_tag";

		return $global_js;
	}
}
