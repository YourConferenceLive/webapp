<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	#sessionsTable_filter, #sessionsTable_paginate{
		float: right;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Analytics</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Analytics</a></li>
						<li class="breadcrumb-item active">Overall Conference</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
		<section class="content" style="width: fit-content;">
		<div class="container-fluid">
	        <!-- /.row -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Overall Conference</h3>
						</div>
						<!-- /.card-header -->
						<div id="logsTableCard" class="card-body">
							<table id="logsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Name</th>
										<th>Surname</th>
										<th>Email</th>
										<th>Action</th>
										<th>Info</th>
										<th>Session</th>
										<th>Duration on the platform</th>
<!--										<th id="th_view" >View</th>-->
									</tr>
								</thead>
								<!-- Server Side DT -->
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
			<!-- /.row -->
		</div><!--/. container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- DataTables  & Plugins -->
<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
	$(function ()
	{
		var myCondition ='';
		// Setup - add a text input to each footer cell
		$('#logsTable thead th').each(function() {
			$(this).html($(this).text()+'<br><input type="text" placeholder="Search '+$(this).text()+'" style="width: inherit;background: #31373d;color: white;border: 1px solid #666;"/>');
		});
		let logsDt = $('#logsTable')
				.DataTable(
				{
					"dom": "<'row'<'col-sm-12 col-md-8'l><'#logsTableBtns.col-sm-12 col-md-4 text-right'B>>" +
							"<'row'<'col-sm-12'tr>>" +
							"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

					"serverSide": true,
					"ajax":
							{
								"url": project_admin_url+"/analytics/getLogsDt",
								"type": "POST",
								"data": function (data) {
									data.logUserUniqueness = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_user').val();;
									data.logDays = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_days').val();
									data.logSessionUniqueness = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_session').val();
								},
								// "success": function(info){
								// 	console.log(info);
								// }
							},
					"columns":
							[
								{ "name": "user.id", "data": "user_id", "width": "105px" },
								{ "name": "user.name", "data": "user_fname" },
								{ "name": "user.surname", "data": "user_surname" },
								{ "name": "user.email", "data": "email" },
								{ "name": "logs.name", "data": "name" },
								{ "name": "logs.info", "data": "info" },
								{ "name": "sessions.name", "data": "sessions_name" },
								{ "name": "logs.date_time", "data": "date_time" },
								// { "name": "action", "data": null, render: function(data, type, row, meta) {
								// 		return '<button class="viewAttendees btn btn-sm btn-success" data-session-name="'+row.sessions_name+'" data-session-id="'+ row.sessions_id +'" data-start-time="'+ row.start_time +'" data-end-time="'+ row.end_time +'"><i class="fas fa-search"></i> View</button>';
								// 	}
							],
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": false,
					"responsive": false,
					"order": [[ 6, "desc" ]],

					buttons: [
						{
							extend: 'excel',
							text: '<i class="far fa-file-excel"></i> Export Excel',
							className: 'btn-success',
							attr:  {
								"data-toggle": 'tooltip',
								"data-placement": 'top',
								"title": 'Export will consider your filters and search',
							},
							title: 'overall_conference_export',
							action: ajaxExportAction
						}],
					// columnDefs: [{
					// 	targets: [8],
					// 	orderable: false,
					// 	render: function ( data, type, columns, meta ) {
					//
					// 		if(type === 'display') {
					// 			data = '<button class="viewAttendees btn btn-sm btn-success" session-id="'+ data +'"><i class="fas fa-search"></i> View</button>';
					// 		}
					//
					// 		return data;
					// 	}
					// }],
					initComplete: function() {
						var api = this.api();
						// Apply the search
						api.columns().every(function() {
							var that = this;
							$('input', this.header()).on('keyup change', function() {
								if (that.search() !== this.value) {
									that
											.search(this.value)
											.draw();
								}
							});
						});

						let uniqueUserDropdown = '' +
								'<label class="ml-3">' +
								' Show <select id="logsTable_user" name="logsTable_user" aria-controls="logsTable" class="custom-select custom-select-sm form-control form-control-sm" data-toggle="tooltip" data-placement="top" title="Select unique to show only unique users">' +
								'  <option value="all">All</option>' +
								'  <option value="unique">Unique</option>' +
								' </select> users' +
								'</label>'
						$("#logsTable_length").append(uniqueUserDropdown);

						// let uniqueSessionDropdown = '' +
						// 		'<label class="ml-3">' +
						// 		' Show <select id="logsTable_session" name="logsTable_session" aria-controls="logsTable" class="custom-select custom-select-sm form-control form-control-sm" data-toggle="tooltip" data-placement="top" title="Select unique to show only unique session">' +
						// 		'  <option value="all">All</option>' +
						// 		'  <option value="unique">Unique</option>' +
						// 		' </select> sessions' +
						// 		'</label>'
						// $("#logsTable_length").append(uniqueSessionDropdown);

						let daysDropdown = '' +
								'<label class="ml-3">' +
								' Show <select id="logsTable_days" name="logsTable_days" aria-controls="logsTable" class="custom-select custom-select-sm form-control form-control-sm" data-toggle="tooltip" data-placement="top" title="Filter by a particular day">' +
								'  <option value="all">All</option>' +
								'  <option value="2021-06-24">2021-06-24</option>' +
								'  <option value="2021-06-25">2021-06-25</option>' +
								'  <option value="2021-06-26">2021-06-26</option>' +
								'  <option value="2021-06-27">2021-06-27</option>' +
								' </select> day(s)' +
								'</label>'
						$("#logsTable_length").append(daysDropdown);

						let filterInfo = '<i class="ml-3 fas fa-info-circle" style="font-size: 20px;color: #95f5ff;" data-toggle="tooltip" data-placement="top" data-html="true" title="You can combine filters. <br> eg; Unique users on 2021-06-24"></i>';
						$("#logsTable_length").append(filterInfo);
						
						$('[data-toggle="tooltip"]').tooltip();
					}
				}
		);

		$('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_days', function () {
			logsDt.ajax.reload();
		});

		$('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_user', function () {
			logsDt.ajax.reload();
		});

		// $('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_session', function () {
		//
		// 	logsDt.ajax.reload();
		// 	console.log(myCondition);
		// });

		//$('#logsTable').on('click', '.viewAttendees', function () {
		//
		//	let session_id 		= $(this).data('session-id');
		//	let start_time 		= $(this).data('start-time');
		//	let end_time 		= $(this).data('end-time');
		//	let session_name 		= $(this).data('session-name');
		//	console.log('[' + session_id + '-' + start_time + '-' + end_time + ']');
		//	Swal.fire({
		//		title: 'Please Wait',
		//		text: 'Loading session attendees data...',
		//		imageUrl: '<?//=ycl_root?>///cms_uploads/projects/<?//=$this->project->id?>///theme_assets/loading.gif',
		//		imageUrlOnError: '<?//=ycl_root?>///ycl_assets/ycl_anime_500kb.gif',
		//		imageAlt: 'Loading...',
		//		showCancelButton: false,
		//		showConfirmButton: false,
		//		allowOutsideClick: false
		//	});
		//
		//	let attendeesDT = $('#attendeesTable').DataTable({
		//		"dom": "<'row'<'col-sm-12 col-md-8'l><'#attendeesTableBtns.col-sm-12 col-md-4 text-right'B>>" +
		//				"<'row'<'col-sm-12'tr>>" +
		//				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
		//
		//		"serverSide": true,
		//		"ajax":
		//				{
		//					"url": project_admin_url+"/analytics/getLogsDt/",
		//					"type": "POST",
		//					"data": function (data) {
		//						data.logType = "Visit";
		//						data.logPlace = "Session View";
		//						data.ref1 = session_id;
		//						data.startTime = start_time;
		//						data.endTime = end_time;
		//						data.logUserUniqueness = 'unique';
		//						data.logDays = 'all';
		//					}
		//				},
		//		"columns":
		//				[
		//					{ "name": "user.id", "data": "user_id", "width": "75px" },
		//					{ "name": "user.name", "data": "user_fname" },
		//					{ "name": "user.surname", "data": "user_surname" },
		//					{ "name": "user.credentials", "data": "credentials" },
		//					{ "name": "user.email", "data": "email" },
		//					{ "name": "user.city", "data": "city" },
		//					{ "name": "logs.date_time", "data": "time_in_session" }
		//				],
		//		"paging": true,
		//		"lengthChange": true,
		//		"searching": true,
		//		"ordering": true,
		//		"info": true,
		//		"autoWidth": false,
		//		"responsive": false,
		//		"order": [[ 6, "desc" ]],
		//
		//		buttons: [{
		//			extend: 'excel',
		//			text: '<i class="far fa-file-excel"></i> Export Excel',
		//			className: 'btn-success',
		//			attr:  {
		//				"data-toggle": 'tooltip',
		//				"data-placement": 'top',
		//				"title": 'Export will consider your filters and search',
		//			},
		//			title: 'session_attendees_export_'+session_name,
		//			action: ajaxExportAction
		//		}],
		//		initComplete: function() {
		//			var api = this.api();
		//			// Apply the search
		//			api.columns().every(function() {
		//				var that = this;
		//				$('input', this.header()).on('keyup change', function() {
		//					if (that.search() !== this.value) {
		//						that.search(this.value).draw();
		//					}
		//				});
		//			});
		//		}
		//	});
		//
		//	Swal.close();
		//
		//	$('#sessionAttendeesModal').modal({
		//		backdrop: 'static',
		//		keyboard: false
		//	});
		//});
		//
		//
		//$("#sessionAttendeesModal").on('hide.bs.modal', function(){
		//	var dTable = $('#attendeesTable').dataTable();
		//	dTable.fnDestroy();
		//	dTable.fnDraw();
		//});

	});
</script>
