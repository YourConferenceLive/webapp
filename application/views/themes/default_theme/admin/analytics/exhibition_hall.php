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
						<li class="breadcrumb-item active">Exhibition Hall</li>
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
							<h3 class="card-title">Exhibition Hall</h3>
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
										<th>Booth</th>
										<th>City</th>
										<th>Time</th>
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
<?php 
	$booth_array = array();
	foreach ($booths as $booth) {
		$booth_array[] 	= array('id' => $booth->id, 'name' => $booth->name);
	}?>
<script>
	$(function ()
	{
		let booths = <?php echo json_encode($booth_array); ?>;

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
									data.logType = "Visit";
									data.logPlace = "Booth";
									data.logBooths = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_booth').val();
									data.logUserUniqueness = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_user').val();
									data.logDays = $('#logsTableCard > #logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_days').val();
								}
							},
					"columns":
							[
								{ "name": "user.id", "data": "user_id", "width": "105px" },
								{ "name": "user.name", "data": "user_fname" },
								{ "name": "user.surname", "data": "user_surname" },
								{ "name": "user.email", "data": "email" },
								{ "name": "booth.name", "data": "booth_name" },
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
							title: 'exhibition_hall_export',
							action: ajaxExportAction
						}],

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

						let boothDropdown =
								'<label class="ml-3">' +
								' Show <select id="logsTable_booth" name="logsTable_booth" aria-controls="logsTable" class="custom-select custom-select-sm form-control form-control-sm" data-toggle="tooltip" data-placement="top" title="Select booth to filter data">' +
								'  <option value="">All</option>';

						for (var key of Object.keys(booths)) {
						boothDropdown +=
								'  <option value="' + booths[key]['id'] + '">' + booths[key]['name'] + '</option>';
						}

						boothDropdown +=
								' </select> booth(s)' +
								'</label>';

						$("#logsTable_length").append(boothDropdown);

						let uniqueUserDropdown = '' +
								'<label class="ml-3">' +
								' Show <select id="logsTable_user" name="logsTable_user" aria-controls="logsTable" class="custom-select custom-select-sm form-control form-control-sm" data-toggle="tooltip" data-placement="top" title="Select unique to show only unique users">' +
								'  <option value="all">All</option>' +
								'  <option value="unique">Unique</option>' +
								' </select> users' +
								'</label>'
						$("#logsTable_length").append(uniqueUserDropdown);

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

		$('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_booth', function () {
			logsDt.ajax.reload();
		});

		$('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_days', function () {
			logsDt.ajax.reload();
		});

		$('#logsTableCard').on('change', '#logsTable_wrapper > div > div > #logsTable_length > label > #logsTable_user', function () {
			logsDt.ajax.reload();
		});

	});
</script>
