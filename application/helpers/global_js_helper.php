<?php
if(!function_exists('global_js'))
{
	function global_js()
	{
		$CI =& get_instance();

		$js_methods = '';
		$js_variables = '';
		$js_start_tag = '<script>';
		$js_end_tag = '</script>';

		$js_variables .= "
			let project_url = '{$CI->project_url}';
			let ycl_root = '".ycl_root."';
		";


		/**
		 * Global JS Methods
		 *
		 *  Important: prepend method names with yc_global_
		 */

		$js_methods .= 'function yc_global_sleep(milliseconds) {
		const date = Date.now();
		let currentDate = null;
		do {
		currentDate = Date.now();
		} while (currentDate - date < milliseconds);
		}
		';






		$global_js = "$js_start_tag \n $js_variables \n $js_methods \n $js_end_tag";

		return $global_js;
	}
}
