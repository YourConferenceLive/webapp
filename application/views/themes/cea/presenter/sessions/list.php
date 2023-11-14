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
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/presenter/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">My Sessions</li>
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
							<h3 class="card-title">My Sessions</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="sessionsTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Session ID</th>
									<th>Day</th>
									<th>Start Time</th>
									<th>End Time</th>
									<!--<th>Duration</th>-->
									<th style="width:120px">Session Photo</th>
									<th style="width:400px">Session Title</th>
									<th>Presenter(s)</th>
									<th>Zoom</th>
									<th>Session Presentation</th>
									<th>Options</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($sessions as $session): ?>
									<tr>
										<td><?=$session->id?></td>
										<td><?=date("F jS (l)", strtotime($session->start_date_time))?></td>
										<td><?=date("g:iA", strtotime($session->start_date_time))?> EST</td>
										<td><?=date("g:iA", strtotime($session->end_date_time))?> EST</td>
										<!--<td><?/*=round(abs(strtotime($session->end_date_time) - strtotime($session->start_date_time)) / 60,2). " Minutes"*/?></td>-->
										<td style="padding-left:0; padding-right:0; "><img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session->thumbnail?>" style="width:120px; max-height: 200px; padding:0"></td>
										<td><?=$session->name?></td>
										<td>
											<?php foreach($session->presenters as $presenter): ?>
												<?=$presenter->name." ". $presenter->surname?><br>
											<?php endforeach ?>
										</td>
										<td>
											<a href="<?=$session->zoom_link?>" target="_blank" <?=($session->zoom_link == null || $session->zoom_link = '')?'onclick="toastr.warning(`Zoom is not configured yet.`); return false;"':''?>>
												<button class="btn btn-sm btn-info"><i class="fas fa-video"></i> Join Zoom</button>
											</a>
										</td>
										<td>
											<a href="<?=$this->project_url.'/presenter/sessions/view/'.$session->id?>">
												<button class="btn btn-sm btn-primary"><i class="fas fa-tv"></i> Join Session</button>
											</a>
											<!--<a href="<?/*=$this->project_url.'/presenter/sessions/view_without_slides/'.$session->id*/?>">
												<button class="btn btn-sm btn-primary"><i class="fas fa-tools"></i> Toolbox Only</button>
											</a>-->
										</td>
										<td><a href="" onclick="viewPollList(<?=$session->id?>)" class="btn btn-info btn-sm"> View Poll</a></td>
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
	$(function () {
		$('#sessionsTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,

			"order": [[ 1, "asc" ]]
		});
	});

	function viewPollList(session_id){
		window.open(project_presenter_url+'/sessions/polls/'+session_id,'_blank')
	}
</script>
