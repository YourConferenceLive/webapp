<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Session Evaluations</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Analytics</a></li>
						<li class="breadcrumb-item active">Session Evaluations</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">All Sessions</h3>

						</div>
						<div class="card-body">
							<table class="table table-striped table-bordered" id="session-evaluation-table">
								<thead>
									<tr>
										<th>#</th>
										<th>
											Session Name
										</th>
										<th>
											Session Start Date
										</th>
										<th>
											Session Type
										</th>
										<th>
											Option
										</th>

									</tr>
								</thead>
								<tbody class="session-evaluation-table-body">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

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
	$(function(){
		getAllSessions();


		$('#session-evaluation-table').on('click', '#btnExport', function(){

			var session_id = $(this).attr('data-session_id');
			$.post(project_url+'/admin/analytics/evaluationExport',
					{
						'session_id':session_id
					}, function(result){
						console.log(result);
			})
		});
	})
	function getAllSessions() {
		$.post(project_url + '/admin/analytics/getAllSessions',
				function () {

				}).done(function (sessions) {
			$('.session-evaluation-table-body').html('');
			if ($.fn.DataTable.isDataTable('#session-evaluation-table')) {
				$('#session-evaluation-table').dataTable().fnClearTable();
				$('#session-evaluation-table').dataTable().fnDestroy();
			}
			sessions = JSON.parse(sessions);
			$.each(sessions, function (i, session) {

				var btnExport = '<a href="'+project_url+'/admin/analytics/evaluationExport/'+session.id+'" class="btn btn-success btn-sm" data-session_id="' + session.id + '" id="btnExport">CSV</a>'
				$('.session-evaluation-table-body').append('' +
						'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + session.name + '</td>' +
						'<td>' + session.start_date_time + '</td>' +
						'<td>' + session.session_type + '</td>' +
						'<td>' + btnExport + '</td>' +
						'</tr>' +
						'')
			})
			$('#session-evaluation-table').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true,
				"responsive": false,
				"order": [[0, "desc"]],
				"destroy": true
			});
		});

	}
</script>
