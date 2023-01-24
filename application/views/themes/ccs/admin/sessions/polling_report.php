<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php
//echo '<pre>';
//print_r($polls);
//print_r($session->id);
//exit;?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Sessions</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Sessions</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">All sessions</h3>
							<button class="add-session-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<input type="hidden" id="pollReportSessionNumber" value="<?= (isset($flash_report_list) && !empty($flash_report_list)) ? sizeof($flash_report_list) : "" ?>">
							<table id="pollingReportTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Identifier</th>
									<?php
									if (isset($polls) && !empty($polls)) {
										foreach ($polls as $val) {
//											print_r($val);
											?>
											<th><?= $val->poll_type .': ' .$val->poll_question?></th>
											<?php
										}
									}
									?>

								</tr>
								</thead>
								<tbody id="pollingReportTableBody">
								<?php
								if (isset($flash_report_list) && !empty($flash_report_list)) {
									foreach ($flash_report_list as $val) {
										?>
										<tr>
											<td><?= $val->name . ' ' . $val->surname ?></td>
											<td><?= $val->email ?></td>
											<td>Identifier ID</td>
											<?php
											if (isset($val->polling_answer) && !empty($val->polling_answer)) {
												foreach ($val->polling_answer as $vl) {
													?>
													<th><?= $vl ?></th>
													<?php
												}
											}
											?>
										</tr>
										<?php
									}
								}
								?>
								</tbody>
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
	$(document).ready(function () {
		var pollReportSessionNumber = $("#pollReportSessionNumber").val();
		$('#pollingReportTable').DataTable({
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'csv',
					title: 'Poll report session('+pollReportSessionNumber+')'
				},
				{
					extend: 'excel',
					text: '<i class="fa fa-table" aria-hidden="true"></i> Export Excel',
					attr: {class: 'btn btn-success'}
				},
				{
					text: '<i class="fa fa-pie-chart" aria-hidden="true"></i> Export Chart',
					attr: {class: 'export-charts btn btn-warning'}
				}

			],
			"initComplete": function( settings, json ) {
				$('.export-charts').on('click', function () {
					exportCharts(<?=$session->id?>);
				});
			}
		});
		$('.buttons-csv').text('Export CSV');
	});

	function exportCharts(session_id) {
		location.href = project_url+"/admin/sessions/poll_chart/"+session_id;
	}
</script>
