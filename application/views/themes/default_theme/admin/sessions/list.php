<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
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
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="sessionsTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Session ID</th>
									<th>Name</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($sessions as $session): ?>
									<tr>
										<td><?=$session->id?></td>
										<td><?=$session->name?></td>
									</tr>
								<?php endforeach; ?>
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
	$(function () {
		$('#sessionsTable').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
		});
	});
</script>
