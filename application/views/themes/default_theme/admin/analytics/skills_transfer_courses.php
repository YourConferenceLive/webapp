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
						<li class="breadcrumb-item active">Skills Transfer Courses</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
		<section class="content">
		<div class="container-fluid">
	        <!-- /.row -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Skills Transfer Courses</h3>
						</div>
						<!-- /.card-header -->
						<div id="logsTableCard" class="card-body">
							<table id="logsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Session ID</th>
										<th>Session Name</th>
										<th>Total Attendees</th>
										<th>Action</th>
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
		// Setup - add a text input to each footer cell
		$('#logsTable thead th').each(function() {
			if ($(this).text() != 'Action')
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
								"url": project_admin_url+"/analytics/stc_attendees",
								"type": "GET"
							},
					"columns":
							[
								{ "name": "sessions.id", "data": "session_id", "width": "105px" },
								{ "name": "sessions.name", "data": "session_name" },
								{ "name": "total_attendees", "data": "total_attendees" },
								{ "name": "action", "data": "session_id"}
							],
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": false,
					"responsive": false,
					"order": [[ 1, "desc" ]],
					buttons: [{
							extend: 'excel',
							text: '<i class="far fa-file-excel"></i> Export Excel',
							className: 'btn-success',
							attr:  {
								"data-toggle": 'tooltip',
								"data-placement": 'top',
								"title": 'Export will consider your filters and search',
							},
							title: 'skills_transfer_courses_export',
							action: ajaxExportAction
					}],
					columnDefs: [{
					        targets: [3],
					        render: function ( data, type, columns, meta ) {

			                if(type === 'display') {
			                    data = '<button class="viewAttendees btn btn-sm btn-success" session-id="'+ data +'"><i class="fas fa-search"></i> View</button>';
			                }

			                return data;
			            } 
					}],
					initComplete: function() {
						var api = this.api();
						// Apply the search
						api.columns().every(function() {
							var that = this;
							$('input', this.header()).on('keyup change', function() {
								if (that.search() !== this.value) {
									that.search(this.value).draw();
								}
							});
						});
						$('[data-toggle="tooltip"]').tooltip();
					}
				}
		);

		$('#logsTable').on('click', '.viewAttendees', function () {

			let session_id = $(this).attr('session-id');

			Swal.fire({
				title: 'Please Wait',
				text: 'Loading session attendees data...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			let attendeesDT = $('#attendeesTable').DataTable({
				"dom": "<'row'<'col-sm-12 col-md-8'l><'#attendeesTableBtns.col-sm-12 col-md-4 text-right'B>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

				"serverSide": true,
				"ajax":
						{
							"url": project_admin_url+"/analytics/session_attendees/"+session_id,
							"type": "GET"
						},
				"columns":
						[
							{ "name": "user.id", "data": "user_id", "width": "75px" },
							{ "name": "user.name", "data": "user_fname" },
							{ "name": "user.surname", "data": "user_surname" },
							{ "name": "user.credentials", "data": "credentials" },
							{ "name": "user.email", "data": "email" },
							{ "name": "user.city", "data": "city" },
							{ "name": "logs.date_time", "data": "date_time" }
						],
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"responsive": false,
				"order": [[ 6, "desc" ]],
				buttons: [{
						extend: 'excel',
						text: '<i class="far fa-file-excel"></i> Export Excel',
						className: 'btn-success',
						attr:  {
							"data-toggle": 'tooltip',
							"data-placement": 'top',
							"title": 'Export will consider your filters and search',
						},
						title: 'session_attendees_export',
						action: ajaxExportAction
				}],
				initComplete: function() {
					var api = this.api();
					// Apply the search
					api.columns().every(function() {
						var that = this;
						$('input', this.header()).on('keyup change', function() {
							if (that.search() !== this.value) {
								that.search(this.value).draw();
							}
						});
					});
				}
			});

			Swal.close();

			$('#sessionAttendeesModal').modal({
				backdrop: 'static',
				keyboard: false
			});
		});

		$("#sessionAttendeesModal").on('hide.bs.modal', function(){
			$('#attendeesTable').DataTable().destroy();
		});
	});
</script>
