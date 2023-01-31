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
					<h1 class="m-0">Analytics</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/analytics'?>">Analytics</a></li>
						<li class="breadcrumb-item active">Scavenger Hunt</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content" style="width: fit-content;">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Scavenger Hunt <small>(People who found all 10 items)</small></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="logsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>User ID</th>
										<th>Name</th>
										<th>Surname</th>
										<th>Degree</th>
										<th>Email</th>
										<th>City</th>
										<th>Last Collected Item</th>
										<th>Last Collected</th>
									</tr>
								</thead>
								<tbody id="logsTableBody">
<?php
								foreach ($logs as $log):
									if ($log->id != ''):?>
									<tr>
										<td><?=$log->id?></td>
										<td><?=$log->name?></td>
										<td><?=$log->surname?></td>
										<td><?=$log->credentials?></td>
										<td><?=$log->email?></td>
										<td><?=$log->city?></td>
										<td align="center"><img src="<?=ycl_root?>/theme_assets/booth_game_icons/<?=$log->icon_name?>.png" width="30" title="<?php echo $log->booth_name;?>"></td>
										<td><?=$log->last_collected?></td>
									</tr>
<?php
									endif;
								endforeach;?>
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

		// Setup - add a text input to each footer cell
		$('#logsTable thead th').each(function() {
			$(this).html($(this).text()+'<br><input type="text" placeholder="Search '+$(this).text()+'" style="width: inherit;background: #31373d;color: white;border: 1px solid #666;"/>');
		});

		$('#logsTable').DataTable({"dom": "<'row'<'col-sm-12 col-md-8'l><'#logsTableBtns.col-sm-12 col-md-4 text-right'B>>" +
										  "<'row'<'col-sm-12'tr>>" +
										  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

								   buttons:[{ extend: 'excel', 
					   						  text: '<i class="far fa-file-excel"></i> Scavenger Hunt Export', 
					   						  className:'btn-success', 
					   						  title:'scavenger_hunt_export'
											}],
								   "paging": true,
								   "lengthChange": true,
								   "searching": true,
								   "ordering": true,
								   "info": true,
								   "autoWidth": false,
								   "responsive": false,
								   "order": [[ 7, "desc" ]]
		});
	});
</script>
