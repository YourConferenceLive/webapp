<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<style>
	#sessionsTable_filter, #sessionsTable_paginate{float: right;}
</style>

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
							<input type="hidden" id="flash_report_session_number" value="<?= (isset($flash_report_list) && !empty($flash_report_list)) ? sizeof($flash_report_list) : "" ?>">
							<table id="flashReportTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>login_id</th>
									<th>name</th>
									<th>email</th>
									<th>identifier</th>
									<th>created_time</th>
									<th>total_time</th>
									<th>access</th>
<!--									<th>total_chat</th>-->
<!--									<th>total_polls</th>-->
									<th>total_questions</th>
<!--									<th>alertness</th>-->
									<th>MemberCentralType</th>
									<th>MemberCentral Sub Type</th>
<!--									<th>MemberCentral.City</th>-->
<!--									<th>MemberCentral.State</th>-->
<!--									<th>MemberCentral.Country</th>-->
								</tr>
								</thead>
								<tbody>
								<?php foreach ($flash_report_list as $list) :?>
								<?php $total_time = (strtotime($list->view_end_time) - strtotime($list->view_start_time)) ?>
								<tr>
									<td> <?=$list->id?></td>
									<td> <?=$list->name .' '. $list->surname?></td>
									<td> <?=$list->email?></td>
									<td> </td>
									<td> <?=$list->date_time?></td>
									<td> <?=$total_time?></td>
									<td> Attendee </td>
									<td> <?=$list->total_questions?> </td>
									<td> <?=$list->membership_type?> </td>
									<td> <?=$list->membership_sub_type?> </td>
								</tr>
								<?php endforeach ?>
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
		var flash_report_session_number = $("#flash_report_session_number").val();
		$('#flashReportTable').DataTable({
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csv',
				title: 'Flash report session('+flash_report_session_number+')'
			}
			]
		});
		$('.buttons-csv').text('Export CSV');
	});
</script>
