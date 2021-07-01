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
		let project_name = '{$CI->project->name}';
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

		$js_methods .= '
		let ajaxPrevExportAction = function (self, e, dt, button, config) {
			if (button[0].className.indexOf("buttons-excel") >= 0) {
				if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
					$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
				}
				else {
					$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
				}
			} else if (button[0].className.indexOf("buttons-print") >= 0) {
				$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
			}
		};
		';

		$js_methods .= '
		let ajaxExportAction = function (e, dt, button, config) {
			Swal.fire({
				title: "Please Wait",
				text: "We are preparing the file",
				imageUrl: "'.ycl_root.'/cms_uploads/projects/'.$CI->project->id.'/theme_assets/loading.gif",
				imageUrlOnError: "'.ycl_root.'/ycl_assets/ycl_anime_500kb.gif",
				imageAlt: "Loading...",
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});
			var self = this;
			var oldStart = dt.settings()[0]._iDisplayStart;
			dt.one("preXhr", function (e, s, data) {
				data.start = 0;
				data.length = 2147483647;
				dt.one("preDraw", function (e, settings) {
					ajaxPrevExportAction(self, e, dt, button, config);

					dt.one("preXhr", function (e, s, data) {
						settings._iDisplayStart = oldStart;
						data.start = oldStart;
					});
					setTimeout(dt.ajax.reload, 0);
					Swal.close();
					return false;
				});
			});
			dt.ajax.reload();
		};
		';

		$global_js = "$js_start_tag \n $js_variables \n $js_methods \n $js_end_tag";

		return $global_js;
	}
}
